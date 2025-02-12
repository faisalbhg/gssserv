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
    }
}
