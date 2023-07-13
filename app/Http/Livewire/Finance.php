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
        $job = Customerjobs::select('customerjobs.*','customers.name','customers.email','customers.mobile','customertypes.customer_type as customerType')
            ->join('customers','customers.id','=','customerjobs.customer_id')
            ->join('customertypes','customertypes.id','=','customerjobs.customer_type')
            ->orderBy('customerjobs.id','DESC')
            ->where(['customerjobs.job_number'=>$job_number])
            ->first();
        //dd($job);
        $this->dispatchBrowserEvent('showInvoiceView');
    }

    public function downloadInvoice()
    {
        $data = [];
        $pdf = Pdf::loadView('pdf.invoice', $data);
        return $pdf->download('invoice.pdf');

    }
}
