<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Carbon\Carbon;
use Session;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

use App\Models\CustomerJobCards;
use App\Models\CustomerJobCardServices;
use App\Models\CustomerJobCardServiceLogs;
use App\Models\CustomerVehicle;

class UpdateJobCards extends Component
{

    public $jobDetails, $selectedVehicleInfo;
    public $customerDiscontGroupId, $customerDiscontGroupCode;
    function mount( Request $request) {
        $job_number = $request->job_number;
        if($job_number)
        {
            $this->customerJobDetails($job_number);
            $this->selectVehicle();
        }

    }

    public function render()
    {
        return view('livewire.update-job-cards');
    }

    public function customerJobDetails($job_number){
        $this->jobDetails = CustomerJobCards::with(['customerInfo','customerJobServices','checklistInfo','makeInfo','modelInfo'])->where(['job_number'=>$job_number])->first();
    }

    public function selectVehicle(){
        $customers = CustomerVehicle::with(['customerInfoMaster','makeInfo','modelInfo','customerDiscountLists'])->where(['is_active'=>1,'id'=>$this->jobDetails->vehicle_id,'customer_id'=>$this->jobDetails->customer_id])->first();
        $this->selectedVehicleInfo=$customers;
    }
}
