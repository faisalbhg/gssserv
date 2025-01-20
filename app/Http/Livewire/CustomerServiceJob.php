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

use App\Models\CustomerVehicle;
use App\Models\Development;

class CustomerServiceJob extends Component
{
    public $selectedCustomerVehicle=false, $selectPackageMenu=false, $showSectionsList=false, $showServiceSectionsList=false;
    public $showServiceGroup, $showCheckList, $showCheckout, $showPayLaterCheckout, $successPage;
    public $showByMobileNumber, $showCustomerForm, $showPlateNumber, $searchByChaisis, $showVehicleAvailable, $selectedVehicleInfo, $selected_vehicle_id, $customer_id, $mobile, $name, $email;
    public $servicesGroupList, $service_group_id, $service_group_name, $service_group_code, $station, $service_search;
    public $selectServiceItems;
    public $customerDiscontGroupCode;

    function mount( Request $request) {
        $customer_id = $request->customer_id;
        $vehicle_id = $request->vehicle_id;
        if($vehicle_id && $customer_id)
        {
            $this->selectVehicle($customer_id, $vehicle_id);

        }

    }


    public function render()
    {
        if($this->showServiceGroup){
            $this->servicesGroupList = Development::select('DevelopmentCode as department_code','DevelopmentName as department_name','id','LandlordCode as station_code')->where(['Operation'=>true,'LandlordCode'=>Session::get('user')->station_code])->get();
        }
        $this->openServiceGroup();
        return view('livewire.customer-service-job');
    }

    public function openServiceGroup(){
        $this->showServiceGroup=true;
        $this->showCheckList=false;
        $this->showCheckout=false;
        $this->showPayLaterCheckout=false;
        $this->successPage=false;
    }

    public function selectVehicle($customerId,$vehicleId){
        $customers = CustomerVehicle::with(['customerInfoMaster','makeInfo','modelInfo','customerDiscountLists'])->where(['is_active'=>1,'id'=>$vehicleId,'customer_id'=>$customerId])->first();
        
        $this->showByMobileNumber=false;
        $this->showCustomerForm=false;
        $this->showPlateNumber=false;
        $this->searchByChaisis=false;
        
        $this->selectedCustomerVehicle=true;
        $this->showServiceGroup = true;
        
        $this->showVehicleAvailable = false;
        $this->selectedVehicleInfo=$customers;

        $this->selected_vehicle_id = $customers->id;
        $this->customer_id = $customers->customer_id;
        $this->mobile = $customers->customerInfoMaster['Mobile'];
        $this->name = $customers->customerInfoMaster['TenantName'];
        $this->email = $customers->customerInfoMaster['Email'];
    }

    public function serviceGroupForm($service){
        $this->service_group_id = $service['id'];
        $this->service_group_name = $service['department_name'];
        $this->service_group_code = $service['department_code'];
        $this->station = $service['station_code'];
        $this->service_search='';

        $this->showSectionsList=true;
    }
}
