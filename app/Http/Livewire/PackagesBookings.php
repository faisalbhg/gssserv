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

use App\Models\ServicePackage;
use App\Models\ServicePackageDetail;
use App\Models\CustomerVehicle;
use App\Models\PackageBookings;
use App\Models\PackageBookingServices;

class PackagesBookings extends Component
{
    use WithFileUploads;
    public $selectedCustomerVehicle=true, $showCheckout=true, $successPage=false, $showCustomerSignature=false;
    public $package_number, $total, $totalDiscount, $grand_total, $tax;
    public $customer_id, $vehicle_id, $package_id, $selectedVehicleInfo, $mobile, $name, $email, $customerSignature, $packageDetails;

    function mount( Request $request) {
        $this->customer_id = $request->customer_id;
        $this->vehicle_id = $request->vehicle_id;
        $this->package_id = $request->package_id;
        if($this->vehicle_id && $this->customer_id)
        {
            $this->selectVehicle();
        }
        if($this->package_id)
        {
            $this->getPackageDetails();
        }

    }

    public function render()
    {
        return view('livewire.packages-bookings');
    }

    public function selectVehicle(){
        $customers = CustomerVehicle::with(['customerInfoMaster','makeInfo','modelInfo','customerDiscountLists'])->where(['is_active'=>1,'id'=>$this->vehicle_id,'customer_id'=>$this->customer_id])->first();
        $this->selectedVehicleInfo=$customers;

        $this->mobile = $customers->customerInfoMaster['Mobile'];
        $this->name = $customers->customerInfoMaster['TenantName'];
        $this->email = $customers->customerInfoMaster['Email'];
    }

    public function getPackageDetails()
    {
        $this->packageDetails = ServicePackage::with(['packageDetails'])->where(['Status'=>'A','Division'=>Session::get('user')['station_code'],'Id'=>$this->package_id])->first();
    }

    
}
