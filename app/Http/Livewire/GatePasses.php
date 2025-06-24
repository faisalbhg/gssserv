<?php

namespace App\Http\Livewire;

use Livewire\Component;

use thiagoalessio\TesseractOCR\TesseractOCR; 
use Illuminate\Http\Request;
use Livewire\WithFileUploads;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\Http;
use LaravelPayfort\Facades\Payfort;
use Illuminate\Support\Facades\Hash;
use DB;
use Livewire\WithPagination;

use App\Models\CustomerJobCards;
use App\Models\CustomerJobCardServices;
use App\Models\CustomerJobCardServiceLogs;



class GatePasses extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $filterTab='total', $filter = [0,1,2,3,4], $search_job_number = '', $search_job_date, $search_plate_number, $search_ct_number = '', $search_meter_number = '';

    public function render()
    {
        $jobsQuery = CustomerJobCards::with(['customerInfo','customerVehicle','makeInfo','modelInfo']);
        if($this->filter){
            $jobsQuery = $jobsQuery->whereIn('job_status', $this->filter);
        }
        if($this->search_job_number)
        {
            $jobsQuery = $jobsQuery->where('job_number', 'like', "%{$this->search_job_number}%");
        }
        if($this->search_job_date){
            $jobsQuery = $jobsQuery->whereBetween('job_date_time', [$this->search_job_date." 00:00:00",$this->search_job_date." 23:59:59"]);
        }
        if($this->search_plate_number)
        {
            $jobsQuery = $jobsQuery->where('plate_number', 'like',"%$this->search_plate_number%");
        }

        if($this->search_ct_number)
        {
            $jobsQuery = $jobsQuery->where('ct_number', 'like', "%{$this->search_ct_number}%");
        }
        if($this->search_meter_number)
        {
            $jobsQuery = $jobsQuery->where('meter_id', 'like', "%{$this->search_meter_number}%");
        }
        
        $data['jobsResults'] = $jobsQuery->where('job_status','=',3)->where(['station'=>auth()->user('user')['station_code']])->orderBy('id','ASC')->paginate(25);
        //dd($data);
        return view('livewire.gate-passes',$data);
    }

    public function filterJobListPage($statusFilter)
    {
        switch($statusFilter){
            case 'total': $this->filter = [0,1,2,3,4];break;
            case 'working_progress': $this->filter = [1];break;
            case 'work_finished': $this->filter = [2];break;
            case 'ready_to_deliver': $this->filter = [3];break;
            case 'delivered': $this->filter = [4];break;
        }
        $this->filterTab = $statusFilter;
        $this->dispatchBrowserEvent('filterTab',['tabName'=>$this->filterTab]);
    }


    public function updateQwService($job_number,$status,$customer_id)
    {
        //dd($customer_id);
        $this->job_status = $status;
        $this->job_departent = $status;
        
        $serviceJobUpdate = [
            'job_status'=>$this->job_status,
            'job_departent'=>$this->job_status,
        ];
        //dd($serviceJobUpdate);
        $serviceJobDetails = CustomerJobCardServices::where(['job_number'=>$job_number])->first();
        CustomerJobCardServices::where(['job_number'=>$job_number])->update($serviceJobUpdate);
        
        $serviceJobUpdateLog = [
            'job_number'=>$job_number,
            'customer_job__card_service_id'=>$serviceJobDetails->id,
            'job_status'=>$this->job_status,
            'job_departent'=>$this->job_status,
            'job_description'=>json_encode($this),
            'created_by'=>auth()->user('user')->id,
        ];
        CustomerJobCardServiceLogs::create($serviceJobUpdateLog);

        
        $mianJobUpdate = [
            'job_status'=>$this->job_status,
            'job_departent'=>$this->job_status,
        ];
        CustomerJobCards::where(['job_number'=>$job_number])->update($mianJobUpdate);
        
        
        if($this->job_status==4)
        {
            /*try {
                DB::select('EXEC [dbo].[CreateCashierFinancialEntries_2] @jobnumber = "'.$job_number.'", @doneby = "'.auth()->user('user')->id.'", @stationcode  = "'.auth()->user('user')->station_code.'", @paymentmode = "C", @customer_id = "'.$customer_id.'" ');
            } catch (\Exception $e) {
                //dd($e->getMessage());
                //return $e->getMessage();
            }*/

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
                $msgtext = urlencode('Dear '.$customerName.', your vehicle is out successfully!.we value your openion!, https://gsstations.ae/qr/'.$this->job_number.' for the feedback. Thank you for choosing GSS! . For assistance, call 800477823.');
                $response = Http::get(config('global.sms')[1]['sms_url']."&mobileno=".$mobileNumber."&msgtext=".$msgtext."&CountryCode=ALL");
            }*/

            
        }
    }
}
