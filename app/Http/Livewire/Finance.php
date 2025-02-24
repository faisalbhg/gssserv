<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\Customerjobs;
use App\Models\Customerjobservices;
use App\Models\Customerjoblogs;

use Carbon\Carbon;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;



class Finance extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $searchjobnumber = '';
    public $customerDetails = false;
    public $job_number, $job_date_time, $vehicle_image, $make, $model, $plate_number, $chassis_number, $vehicle_km, $name, $email, $mobile, $customerType, $payment_status=0, $payment_type=0, $job_status, $job_departent, $total_price, $vat, $grand_total;
    public $customerjobservices =array();
    public $customerjoblogs = array();

    public $filter = [0,1,2,3];

    public $showUpdateModel = false;
    public $paymentFilterTab;
    public $jobInvoiceDetails =[], $showInvoiceModel=false;


    function mount( Request $request) {
        $job_number = $request->job_number;
        $filter = $request->filter;
        if($job_number)
        {
            $this->showUpdateModel=true;
            $this->jobPaymentUpdate($job_number);
        }
        else if($filter)
        {
            $this->paymentFilterTab = $filter;
            $this->filterPaymentList($filter);
        }
    }

    public function render()
    {
        $customerjobs = Customerjobs::
            select('customerjobs.*','customers.name','customers.email','customers.mobile','customertypes.customer_type as customerType')
            
            ->join('customers','customers.id','=','customerjobs.customer_id')
            ->join('customertypes','customertypes.id','=','customerjobs.customer_type')
            ->orderBy('customerjobs.id','DESC')
            ->where('customerjobs.job_number', 'like', "%{$this->searchjobnumber}%")
            ->whereIn('customerjobs.payment_status', $this->filter)
            ->paginate(10);
        $data['customerjobs']=$customerjobs;

        $getCountPaymentStatus = Customerjobs::select(
            array(
                \DB::raw('count(DISTINCT(customer_id)) customers'),
                \DB::raw('count(job_number) jobs'),
                \DB::raw('count(case when payment_status = 0 then payment_status end) pending'),
                \DB::raw('count(case when payment_status = 1 then payment_status end) paid'),
                \DB::raw('count(case when payment_status = 2 then payment_status end) failed'),
                \DB::raw('count(case when payment_status = 3 then payment_status end) cancelled'),
                \DB::raw('count(case when payment_status in (0,1,2,3) then payment_status end) total'),
                \DB::raw('SUM(grand_total) as saletotal'),
            )
        )->first();
        $data['getCountPaymentStatus'] = $getCountPaymentStatus;

        return view('livewire.finance',$data);
    }

    public function filterPaymentList($statusFilter)
    {
        switch($statusFilter){
            case 'all': $this->filter = [0,1,2,3];break;
            case 'paid': $this->filter = [1];break;
            case 'pending': $this->filter = [0];break;
            case 'failed': $this->filter = [2,3];break;
        }
        $this->dispatchBrowserEvent('paymentFilterTab',['tabName'=>$statusFilter]);

    }

    public function resendPaymentLink($job_number){
        $customerjobs = Customerjobs::
            select('customerjobs.*','customers.name','customers.email','customers.mobile','customertypes.customer_type as customerType')
            ->join('customers','customers.id','=','customerjobs.customer_id')
            ->join('customertypes','customertypes.id','=','customerjobs.customer_type')
            ->where(['customerjobs.job_number'=>$job_number])
            ->take(5)->first();
        $response = Http::withBasicAuth('20092622', 'buhaleeba@123')->post("https://mshastra.com/sendurlcomma.aspx?user=20092622&pwd=buhaleeba@123&senderid=BuhaleebaRE&mobileno=971566993709&msgtext=".urlencode('Job Id #'.$customerjobs->job_number.' is processing, Please click complete payment '.$customerjobs->payment_link)."&CountryCode=ALL");
    }

    public function updatePayment($job_number, $payment_status)
    {
        $this->payment_status = $payment_status;
        Customerjobs::where(['job_number'=>$job_number])->update(['payment_status'=>$payment_status]);
    }

    public function updatePaymentMethode($job_number, $payment_type)
    {
        if($payment_type==1)
        {
            $customerjobs = Customerjobs::with(['customerInfo'])->where(['job_number'=>$job_number])->first();
            $paymentLink = $this->sendPaymentLink($customerjobs);
            $paymentResponse = (array)json_decode($paymentLink->data);
            $mobileNumber = '971'.substr($customerjobs->customerInfo['mobile'], -9);
            if(array_key_exists('payment_link', $paymentResponse))
            {
                $response = Http::withBasicAuth('20092622', 'buhaleeba@123')->post("https://mshastra.com/sendurlcomma.aspx?user=20092622&pwd=buhaleeba@123&senderid=BuhaleebaRE&mobileno=".$mobileNumber."&msgtext=".urlencode('Job Id #'.$job_number.' is processing, Please click complete payment '.$paymentResponse['payment_link'])."&CountryCode=ALL");


                $customerjobId = Customerjobs::where(['job_number'=>$job_number])->update(['payment_type'=>1,'payment_link'=>$paymentResponse['payment_link'],'payment_response'=>json_encode($paymentResponse),'payment_request'=>'link_send','job_create_status'=>1]);
                session()->flash('success', "Successfully send payment link..! ");
                
            }
            else
            {
                session()->flash('error', $paymentResponse['response_message']);

            }
        }

        Customerjobs::where(['job_number'=>$job_number])->update(['payment_type'=>$payment_type]);
    }

    public function updateService($services)
    {
        $services = json_decode($services);

        $jobServiceId = $services->id;
        $this->job_status = $services->job_status+1;
        $this->job_departent = $services->job_departent+1;
        
        $serviceJobUpdate = [
            'job_status'=>3,
            'job_departent'=>3,
        ];
        Customerjobservices::where(['id'=>$jobServiceId])->update($serviceJobUpdate);

        $serviceJobUpdateLog = [
            'job_number'=>$services->job_number,
            'customer_job_service_id'=>$jobServiceId,
            'job_status'=>3,
            'job_departent'=>3,
            'job_description'=>json_encode($this),
        ];
        Customerjoblogs::create($serviceJobUpdateLog);
        
        $customerJobServiceDetails = Customerjobservices::where(['job_number'=>$services->job_number])->get();
        $mainJobStatus=true;
        foreach($customerJobServiceDetails as $service)
        {
            if($service->job_status==1)
            {
                $mainJobStatus=false;
                break;
            }
            else
            {
                $mainJobStatus = true;
            }
        }
        if($mainJobStatus==true){
            Customerjobs::where(['job_number'=>$services->job_number])->update($serviceJobUpdate);
        }
        $this->customerjobservices = Customerjobservices::where(['job_number'=>$services->job_number])->get();
        
    }

    public function dashCustomerJobUpdate($job_number)
    {
        return redirect()->to('/customer-job-update/'.$job_number);
    }

    public function jobPaymentUpdate($job_number)
    {
        $job = Customerjobs::select('customerjobs.*','customers.name','customers.email','customers.mobile','customertypes.customer_type as customerType')
            ->join('customers','customers.id','=','customerjobs.customer_id')
            ->join('customertypes','customertypes.id','=','customerjobs.customer_type')
            ->orderBy('customerjobs.id','DESC')
            ->where(['customerjobs.job_number'=>$job_number])
            ->first();
        $this->job_number = $job->job_number;
        $this->job_date_time = $job->job_date_time;
        $this->customerDetails = true;
        $this->vehicle_image = $job->vehicle_image;
        $this->make = $job->make;
        $this->model = $job->model;
        $this->plate_number = $job->plate_number;
        $this->chassis_number = $job->chassis_number;
        $this->vehicle_km = $job->vehicle_km;
        $this->name = $job->name;
        $this->email = $job->email;
        $this->mobile = $job->mobile;
        $this->customerType = $job->customerType;
        $this->payment_status = $job->payment_status;
        $this->payment_type = $job->payment_type;
        $this->job_status = $job->job_status;
        $this->job_departent = $job->job_departent;
        $this->total_price = $job->total_price;
        $this->vat = $job->vat;
        $this->grand_total = $job->grand_total;

        $this->customerjobservices = Customerjobservices::where(['job_number'=>$job->job_number])->get();
        $this->customerjoblogs = Customerjoblogs::where(['job_number'=>$job->job_number])->orderBy('id','DESC')->get();
        $this->dispatchBrowserEvent('showServiceUpdate');
    }



    public function checkPaymentStatus($job_number)
    {
        $arrData['order_number'] = $job_number;
        $response = Http::withBasicAuth('onlinewebtutor', 'admin123')->post('http://172.23.25.95/gssapi/api/check-payment-status',$arrData);
        if(json_decode($response)->payment_status!=0)
        {
            Customerjobs::where(['job_number'=>$job_number])->update(['payment_status'=>json_decode($response)->payment_status]);
            session()->flash('paymentLinkStatusSuccess', 'Payment Link is not yet paid..!');
        }
        else
        {
            session()->flash('paymentLinkStatusError', 'Payment Link is not yet paid..!');
        }
        
    }

    public function viewInvoice($job_number)
    {
        $this->jobInvoiceDetails = Customerjobs::select('customerjobs.*')
            ->with(['customerInfo','customerVehicle','customerJobServices'])
            ->orderBy('customerjobs.id','DESC')
            ->where(['customerjobs.job_number'=>$job_number])
            ->first();
        //dd($this->jobInvoiceDetails);
        $this->showInvoiceModel=true;
        $this->dispatchBrowserEvent('showInvoiceView');
    }

    public function downloadInvoice()
    {
        $data = [];
        $pdf = Pdf::loadView('pdf.invoice', $data);
        return $pdf->download('invoice.pdf');

    }

    public function sendPaymentLink($customerjobs)
    {
        $exp_date = Carbon::now('+10:00')->format('Y-m-d\TH:i:s\Z');
        $order_billing_name = $customerjobs->customerInfo['name'];
        $order_billing_phone = $customerjobs->customerInfo['mobile'];
        $order_billing_email = $customerjobs->customerInfo['email']; 
        $total = custom_round(($customerjobs->grand_total * 100));
        $merchant_reference = $customerjobs->job_number;
        $order_billing_phone = str_replace(' ', '', $order_billing_phone);
        if($order_billing_phone[0] != 0 and $order_billing_phone[1] != 0)
        {
            if($order_billing_phone[0] == '+')
            {
                $order_billing_phone = substr_replace($order_billing_phone, '00', 0, 1);
            }
            else
            {
               $order_billing_phone = preg_replace('/0/', '00971', $order_billing_phone, 1);
            }
        }

        $arrData    = [
            'service_command'=>'PAYMENT_LINK',
            'access_code'=>'CIjX6aY6Yc0FgGktyo4I',
            'merchant_identifier'=>'WQNoWgPx',
            'merchant_reference'=>$merchant_reference,
            'amount'=>$total,
            'currency'=>'AED',
            'language'=>'en',
            'customer_email'=>$order_billing_email,
            'request_expiry_date'=>$exp_date,
            'notification_type'=>'EMAIL,SMS',
            'order_description'=>'GSS Service #'.$merchant_reference,
            'customer_name'=>$order_billing_name,
            'customer_phone'=>$order_billing_phone,
            'return_url'=>url('order-response'),
        ];

        
        $response = Http::withBasicAuth('onlinewebtutor', 'admin123')->post('http://172.23.25.95/gssapi/api/new-payment-link',$arrData);
        return json_decode($response);
    }
}
