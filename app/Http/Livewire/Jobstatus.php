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
        if($this->job_number)
        {
            $this->customerJobDetails();
            $this->selectVehicle();
        }


    }


    
    public function render()
    {
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
}
