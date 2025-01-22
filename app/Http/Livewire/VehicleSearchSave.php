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

use App\Models\StateList;
use App\Models\PlateCode;
use App\Models\CustomerVehicle;
use App\Models\Vehicletypes;
use App\Models\VehicleModels;
use App\Models\VehicleMakes;

class VehicleSearchSave extends Component
{
    use WithFileUploads;
    public $searchByMobileNumber = true, $showSearchByMobileBtn=true, $searchByMobileNumberBtn=true,$searchByPlateBtn=false, $searchByChaisisBtn=false, $showSearchByPlateNumberButton=false, $showSearchByChaisisButton=false, $searchByChaisis=false;
    public $showForms=true, $showByMobileNumber=true, $showCustomerForm=false, $showPlateNumber=false, $otherVehicleDetailsForm=false, $searchByChaisisForm=false, $updateVehicleFormBtn = false, $addVehicleFormBtn=false, $cancelEdidAddFormBtn=false, $showSaveCustomerButton=false;
    public $mobile, $name, $email, $plate_number_image, $plate_country = 'AE', $plateStateCode=2, $plate_state='Dubai', $plate_category, $plate_code, $plate_number, $vehicle_image, $vehicle_type, $make, $model, $chaisis_image, $chassis_number, $vehicle_km;
    public $stateList, $plateEmiratesCodes, $vehicleTypesList, $listVehiclesMake, $vehiclesModelList=[];
    public $editCustomerAndVehicle=false;
    public $customers=[];
    public $showVehicleAvailable=false;
    public $customer_id;

    public function render()
    {
        if($this->showPlateNumber)
        {
            $this->stateList = StateList::where(['CountryCode'=>$this->plate_country])->get();
            if($this->plate_state){
                $this->plateEmiratesCodes = PlateCode::where(['plateEmiratesId'=>$this->plateStateCode,'is_active'=>1])->get();
            }
        }
        else
        {
            $this->stateList = null;
            $this->plateEmiratesCodes=null;
        }
        
        if($this->otherVehicleDetailsForm){
            $this->vehicleTypesList = Vehicletypes::orderBy('type_name','ASC')->get();
            $this->listVehiclesMake = VehicleMakes::get();
            if($this->make){
                $this->vehiclesModelList = VehicleModels::where(['vehicle_make_id'=>$this->make])->get();
            }
        }
        else
        {
            $this->vehicleTypesList=[];
            $this->listVehiclesMake = [];
            $this->vehiclesModelList = [];
        }
        $this->dispatchBrowserEvent('imageUpload');
        $this->dispatchBrowserEvent('selectSearchEvent');
        return view('livewire.vehicle-search-save');
    }

    public function clickSearchBy($searchId){
        $this->updateVehicleFormBtn=false;
        $this->addVehicleFormBtn=false;
        $this->cancelEdidAddFormBtn=false;
        $this->showSaveCustomerButton=false;
        switch ($searchId) {
            case '1':
                $this->searchByMobileNumberBtn=true;
                $this->searchByMobileNumber=true;
                $this->showByMobileNumber=true;
                $this->showCustomerForm=false;
                $this->searchByPlateBtn=false;
                $this->showPlateNumber=false;
                $this->showSearchByPlateNumberButton=false;
                $this->searchByChaisisBtn=false;
                $this->searchByChaisisForm=false;
                $this->showSearchByChaisisButton=false;
                break;
            case '2':
                $this->searchByMobileNumberBtn=false;
                $this->searchByMobileNumber=false;
                $this->showByMobileNumber=false;
                $this->showCustomerForm=false;
                $this->searchByPlateBtn=true;
                $this->showPlateNumber=true;
                $this->dispatchBrowserEvent('imageUpload');
                $this->showSearchByPlateNumberButton=true;
                $this->searchByChaisisBtn=false;
                $this->searchByChaisisForm=false;
                $this->showSearchByChaisisButton=false;
                break;
            case '3':
                $this->searchByMobileNumberBtn=false;
                $this->searchByMobileNumber=false;
                $this->showByMobileNumber=false;
                $this->showCustomerForm=false;
                $this->searchByPlateBtn=false;
                $this->showPlateNumber=false;
                $this->showSearchByPlateNumberButton=false;
                $this->searchByChaisisBtn=true;
                $this->searchByChaisisForm=true;
                $this->dispatchBrowserEvent('imageUpload');
                $this->showSearchByChaisisButton=true;
                break;
        }
    }



    public function searchResult(){
        $this->getCustomerVehicleSearch('mobile');
        if(count($this->customers)>0)
        {
            $this->showVehicleAvailable=true;
        }
        else
        {
            $this->showVehicleAvailable=false;

            $this->showForms=true;
            $this->searchByMobileNumber=true;
            $this->showByMobileNumber=true;
            $this->showCustomerForm=true;
            $this->showPlateNumber=true;
            $this->showSearchByPlateNumberButton=false;
            $this->searchByChaisisForm=true;
            $this->showSearchByChaisisButton=false;
            $this->otherVehicleDetailsForm=true;
            $this->updateVehicleFormBtn=false;
            $this->addVehicleFormBtn=false;
            $this->cancelEdidAddFormBtn=false;
            $this->showSaveCustomerButton=true;
        }
        $this->dispatchBrowserEvent('imageUpload');
        $this->dispatchBrowserEvent('selectSearchEvent'); 
    }

    public function clickSearchByPlateNumber(){
        $this->mobile=null;
        $validatedData = $this->validate([
            'plate_state' => 'required',
            'plate_code' => 'required',
            'plate_number' => 'required',
        ]);

        $this->getCustomerVehicleSearch('plate');
        if(count($this->customers)>0)
        {
            $this->showVehicleAvailable=true;
        }
        else
        {
            $this->showVehicleAvailable=false;

            $this->showForms=true;
            $this->searchByMobileNumber=true;
            $this->showByMobileNumber=true;
            $this->showCustomerForm=true;
            $this->showPlateNumber=true;
            $this->showSearchByPlateNumberButton=false;
            $this->searchByChaisisForm=true;
            $this->showSearchByChaisisButton=false;
            $this->otherVehicleDetailsForm=true;
            $this->updateVehicleFormBtn=false;
            $this->addVehicleFormBtn=false;
            $this->cancelEdidAddFormBtn=false;
            $this->showSaveCustomerButton=true;
        }
        $this->dispatchBrowserEvent('imageUpload');
        $this->dispatchBrowserEvent('selectSearchEvent');
        
    }

    public function clickSearchByChaisisNumber(){
        $this->mobile=null;
        $validatedData = $this->validate([
            'chassis_number' => 'required',
        ]);

        $this->getCustomerVehicleSearch('chaisis');
        if(count($this->customers)>0)
        {
            $this->showVehicleAvailable=true;
        }
        else
        {
            $this->showVehicleAvailable=false;

            $this->showForms=true;
            $this->searchByMobileNumber=true;
            $this->showByMobileNumber=true;
            $this->showCustomerForm=true;
            $this->showPlateNumber=true;
            $this->showSearchByPlateNumberButton=false;
            $this->searchByChaisisForm=true;
            $this->showSearchByChaisisButton=false;
            $this->otherVehicleDetailsForm=true;
            $this->updateVehicleFormBtn=false;
            $this->addVehicleFormBtn=false;
            $this->cancelEdidAddFormBtn=false;
            $this->showSaveCustomerButton=true;
        }
        $this->dispatchBrowserEvent('imageUpload');
        $this->dispatchBrowserEvent('selectSearchEvent');
        
    }

    public function getCustomerVehicleSearch($serachBy){
        $ssearchCustomerVehicleQuery = CustomerVehicle::with(['customerInfoMaster','makeInfo','modelInfo']);
        if($serachBy=='mobile'){
            if($this->mobile[0]=='0'){
                $this->mobile = ltrim($this->mobile, $this->mobile[0]);
            }
            $ssearchCustomerVehicleQuery = $ssearchCustomerVehicleQuery->where(function ($query) {
                $query->whereRelation('customerInfoMaster', 'mobile', 'like', "%$this->mobile%");
            });
        }
        if($serachBy=='plate'){
            $ssearchCustomerVehicleQuery = $ssearchCustomerVehicleQuery->where('plate_code', 'like', "%{$this->plate_code}%")->where('plate_number', 'like', "%{$this->plate_number}%");
        }
        if($serachBy=='chaisis'){
            $ssearchCustomerVehicleQuery = $ssearchCustomerVehicleQuery->where('chassis_number', 'like', "%{$this->chassis_number}%");
        }
        $this->customers = $ssearchCustomerVehicleQuery->where('customer_vehicles.is_active','=',1)->get();
    }

    public function saveVehicleCustomer(){
        $validatedData = $this->validate([
            'vehicle_image' => 'required|image|mimes:jpg,jpeg,png,svg,gif,webp|max:10048',
            'vehicle_type' => 'required',
            'make' => 'required',
            'model'=> 'required',
            'plate_state'=> 'required',
            'plate_code'=> 'required',
            'plate_number'=> 'required',
        ]);

        //Save Customer
        $insertCustmoerData['Mobile']=isset($this->mobile)?$this->mobile:'';
        $insertCustmoerData['TenantName']=isset($this->name)?$this->name:'Walk-In';
        $insertCustmoerData['Email']=isset($this->email)?$this->email:'';
        $insertCustmoerData['Active']=1;
        
        $tenantcode = null;
        $tenantType = 'T';
        $category = 'I';
        $tenantName = isset($this->name)?$this->name:'Walk-In';
        $shortName = isset($this->name)?$this->name:'Walk-In';
        $mobile = isset($this->mobile)?$this->mobile:'';
        $email = isset($this->email)?$this->email:'';
        $active=1;
        $categoryI=1;
        $categoryC=1;
        $paymethod=1;
        $tenantCode_out= null ;

        //Call Procedure for Customer Save
        $customerSaveResult = DB::select('EXEC CustomerManage @tenantcode = ?, @tenantType = ?, @category = ?, @tenantName = ?, @shortName = ?, @mobile = ?, @email = ?, @active = ?, @paymethod = ?, @tenantCode_out = ?', [
            $tenantcode,
            $tenantType,
            $category,
            $tenantName,
            $shortName,
            $mobile,
            $email,
            $active,
            $paymethod,
            $tenantCode_out,
        ]); 
        $customerSaveResult = (array)$customerSaveResult[0];
        $customerId = $customerSaveResult['TenantId'];
        //$customerInsert = TenantMasterCustomers::create($insertCustmoerData);
        $this->customer_id = $customerId;

        //Save Customer Vehicle
        $customerVehicleData['customer_id']=$customerId;
        $customerVehicleData['vehicle_type']=$this->vehicle_type;
        $customerVehicleData['make']=$this->make;
        $customerVehicleData['model']=$this->model;
        $customerVehicleData['plate_country']=$this->plate_country;
        $customerVehicleData['plate_state']=$this->plate_state;
        $customerVehicleData['plate_category']=$this->plate_category;
        $customerVehicleData['plate_code']=$this->plate_code;
        $customerVehicleData['plate_number']=$this->plate_number;
        $customerVehicleData['plate_number_final']=$this->plate_state.' '.$this->plate_code.' '.$this->plate_number;
        $customerVehicleData['chassis_number']=isset($this->chassis_number)?$this->chassis_number:'';
        $customerVehicleData['vehicle_km']=isset($this->vehicle_km)?$this->vehicle_km:'';
        $customerVehicleData['is_active']=1;
        $customerVehicleData['created_by']=Session::get('user')->id;

        if($this->vehicle_image){

            $customerVehicleData['vehicle_image'] = $this->vehicle_image->store('vehicle', 'public');
        }

        if($this->plate_number_image){
            $customerVehicleData['plate_number_image'] = $this->plate_number_image->store('plate_number', 'public');
        }

        if($this->chaisis_image){
            $customerVehicleData['chaisis_image'] = $this->chaisis_image->store('chaisis_image', 'public');
        }
        $customerVehicleDetails = CustomerVehicle::create($customerVehicleData);
        
        return redirect()->to('customer-service-job/'.$customer_id.'/'.$vehicle_id);

        dd($customerVehicleDetails);

        if($this->mobile){
            $this->searchResult();
        }
        else
        {
            $this->showPlateNumber=true;
            $this->showVehicleAvailable=true;
            $this->getCustomerVehicleSearch('plate');
            $this->dispatchBrowserEvent('scrollToSearchVehicle'); 
        }
        session()->flash('success', 'Vehicle is Added  Successfully !');        
    }

    public function saveByPlateNumber(){
        $this->showVehicleAvailable=false;
        $this->showForms=true;
        $this->searchByMobileNumber=true;
        $this->showByMobileNumber=true;
        $this->showCustomerForm=true;
        $this->showPlateNumber=true;
        $this->showSearchByPlateNumberButton=false;
        $this->searchByChaisisForm=true;
        $this->showSearchByChaisisButton=false;
        $this->otherVehicleDetailsForm=true;
        $this->updateVehicleFormBtn=false;
        $this->addVehicleFormBtn=false;
        $this->cancelEdidAddFormBtn=false;
        $this->showSaveCustomerButton=true;
        $this->dispatchBrowserEvent('imageUpload');
        $this->dispatchBrowserEvent('selectSearchEvent');
    }

}
