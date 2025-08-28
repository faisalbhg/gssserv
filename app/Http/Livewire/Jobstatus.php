<?php

namespace App\Http\Livewire;

use Livewire\Component;

use Illuminate\Http\Request;
use Livewire\WithFileUploads;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\Http;
use LaravelPayfort\Facades\Payfort;
use Illuminate\Support\Facades\Hash;
use DB;
use Spatie\Image\Image;

use App\Models\CustomerJobCards;
use App\Models\CustomerJobCardServices;
use App\Models\CustomerJobCardServiceLogs;
use App\Models\CustomerVehicle;


class Jobstatus extends Component
{
    
    public $job_number, $jobDetails, $selectedVehicleInfo, $customer_id, $vehicle_id;

    function mount( Request $request) {
        $this->job_number = $request->job_number;
        


    }


    
    public function render()
    {
        if($this->job_number)
        {
            $this->customerJobDetails();
            $this->selectVehicle();
        }
        //dd($this->jobDetails->payment_status);
        return view('livewire.jobstatus');
    }
    public function customerJobDetails(){
        $this->jobDetails = CustomerJobCards::with(['customerInfo','customerJobServices','checklistInfo','makeInfo','modelInfo','tempServiceCart','checklistInfo'])->where(['job_number'=>$this->job_number])->first();
        $this->customer_id = $this->jobDetails->customer_id;
        $this->vehicle_id = $this->jobDetails->vehicle_id;
    }

    public function selectVehicle(){
        $customers = CustomerVehicle::with(['customerInfoMaster','makeInfo','modelInfo','customerDiscountLists'])->where(['is_active'=>1,'id'=>$this->jobDetails->vehicle_id,'customer_id'=>$this->jobDetails->customer_id])->first();
        $this->selectedVehicleInfo=$customers;
    }

    public function updateQwService($services)
    {
        $this->job_status = $services['job_status']+1;
        $this->job_departent = $services['job_departent']+1;
        
        $serviceJobUpdate = [
            'job_status'=>$services['job_status']+1,
            'job_departent'=>$services['job_status']+1,
            'updated_by'=>auth()->user('user')->id,
        ];
        foreach(CustomerJobCardServices::where(['job_number'=>$this->job_number])->get() as $customerJobCardServices){
            CustomerJobCardServices::where(['id'=>$customerJobCardServices->id])->update($serviceJobUpdate);
            $serviceJobUpdateLog = [
                'job_number'=>$services['job_number'],
                'customer_job__card_service_id'=>$customerJobCardServices->id,
                'job_status'=>$services['job_status']+1,
                'job_departent'=>$services['job_departent']+1,
                'job_description'=>json_encode($this),
                'created_by'=>auth()->user('user')->id,
            ];
            CustomerJobCardServiceLogs::create($serviceJobUpdateLog);
        }

        $mianJobUpdate = [
            'job_status'=>4,
            'job_departent'=>4,
            'updated_by'=>auth()->user('user')->id,
        ];
        CustomerJobCards::where(['job_number'=>$services['job_number']])->update($mianJobUpdate);

        try {
            //DB::select('EXEC [dbo].[CreateCashierFinancialEntries_2] @jobnumber = "'.$this->job_number.'", @doneby = "'.auth()->user('user')->id.'", @stationcode  = "'.auth()->user('user')->station_code.'", @paymentmode = "C", @customer_id = "'.$this->customer_id.'" ');

            DB::select('EXEC [dbo].[RevenueBookingJob] @JobCardNo = "'.$this->job_number.'", @DoneBy ="'.auth()->user('user')->id.'", @StationCode = "'.auth()->user('user')->station_code.'", @paymentmode = "C", @customercode = "'.$this->jobDetails->customerInfo['TenantCode'].'" ');

        } catch (\Exception $e) {
            //dd($e->getMessage());
            //return $e->getMessage();
        }
        /*$getJobDetails = CustomerJobCards::where(['job_number'=>$services['job_number']])->first();

        if(auth()->user('user')->stationName['StationID']==4){
            $mobileNumber = isset($getJobDetails->customer_mobile)?'971'.substr($getJobDetails->customer_mobile, -9):null;
        }
        else
        {
            $mobileNumber = isset(auth()->user('user')->phone)?'971'.substr(auth()->user('user')->phone, -9):null;
        }
        
        $customerName = isset($getJobDetails->customer_name)?$getJobDetails->customer_name:null;
        if($mobileNumber!=''){
            //if($mobileNumber=='971566993709'){
                $msgtext = urlencode('Dear '.$customerName.', your vehicle '.$getJobDetails->plate_number.' is ready for pickup at '.auth()->user('user')->stationName['CorporateName'].'. Please collect your car within 1 hour from now , or a parking charge of AED 30 per hour will be applied separately, https://gsstations.ae/qr/'.$this->job_number.' for the updates. Thank you for choosing GSS! . For assistance, call 800477823.');
                $response = Http::get(config('global.sms')[1]['sms_url']."&mobileno=".$mobileNumber."&msgtext=".$msgtext."&CountryCode=ALL");
            //}
        }*/
    }
}
