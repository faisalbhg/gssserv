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

use App\Models\StateList;
use App\Models\PlateCode;
use App\Models\PlateEmiratesCategory;
use App\Models\CustomerVehicle;
use App\Models\Vehicletypes;
use App\Models\VehicleModels;
use App\Models\VehicleMakes;
use App\Models\Country;

class VehicleSearchSave extends Component
{
    use WithFileUploads;
    public $searchByMobileNumber = true, $showSearchByMobileBtn=true, $searchByMobileNumberBtn=true,$searchByPlateBtn=false, $searchByChaisisBtn=false, $showSearchByPlateNumberButton=false, $showSearchByChaisisButton=false, $searchByChaisis=false, $showAddMakeModelNew=false;
    public $showForms=true, $showByMobileNumber=true, $showCustomerForm=false, $showPlateNumber=false, $otherVehicleDetailsForm=false, $searchByChaisisForm=false, $updateVehicleFormBtn = false, $addVehicleFormBtn=false, $cancelEdidAddFormBtn=false, $showSaveCustomerButton=false, $numberPlateRequired=true;
    public $mobile, $name, $email, $plate_number_image, $plate_country = 'AE', $plateStateCode=2, $plate_state='Dubai', $plate_category=2, $plate_code, $plate_number, $vehicle_image, $vehicle_type, $make, $model, $chaisis_image, $chassis_number, $vehicle_km;
    public $countryList = [], $stateList=[], $plateEmiratesCategories=[], $plateEmiratesCodes, $vehicleTypesList, $listVehiclesMake, $vehiclesModelList=[];
    public $editCustomerAndVehicle=false;
    public $customers=[];
    public $showVehicleAvailable=false;
    public $customer_id, $vehicle_id;
    public $new_make, $new_make_id, $makeSearchResult=[], $modelSearchResult=[], $showAddNewModel=false, $new_model;
    public $otherCountryPlateCode;

    public function render()
    {
        //dd(CustomerVehicle::with(['vehicleJobs'])->limit(2)->get());
        $this->countryList = Country::get();
        if($this->plate_country!='AE'){
            $this->otherCountryPlateCode=true;
        }
        else
        {
            $this->otherCountryPlateCode=false;
        }

        if($this->new_make)
        {
            $this->makeSearchResult = VehicleMakes::where('vehicle_name','like',"%{$this->new_make}%")->get();
            //dd($this->makeSearchResult);
            if($this->showAddNewModel && $this->new_model)
            {
                $this->modelSearchResult = VehicleModels::where('vehicle_make_name','=',$this->new_make)->where('vehicle_model_name','like',"%{$this->new_model}%")->get();
                //dd($this->modelSearchResult);

            }
        }
        else
        {
            $this->showAddNewModel=false;
        }
        
        if($this->showPlateNumber)
        {
            $this->stateList = StateList::where(['CountryCode'=>$this->plate_country])->get();
            if($this->plate_state){
                
                switch ($this->plate_state) {
                    case 'Abu Dhabi':
                        $this->plateStateCode = 1;
                        $this->plate_category = '242';
                        break;
                    case 'Dubai':
                        $this->plateStateCode = 2;
                        $this->plate_category = '1';
                        break;
                    case 'Sharjah':
                        $this->plateStateCode = 3;
                        $this->plate_category = '103';
                        break;
                    case 'Ajman':
                        $plateStateCode = 4;
                        $this->plate_category = '122';
                        break;
                    case 'Umm Al-Qaiwain':
                        $this->plateStateCode = 5;
                        $this->plate_category = '134';
                        break;
                    case 'Ras Al-Khaimah':
                        $this->plateStateCode = 6;
                        $this->plate_category = '147';
                        break;
                    case 'Fujairah':
                        $this->plateStateCode = 7;
                        $this->plate_category = '169';
                        break;
                    
                    default:
                        $this->plateStateCode = 2;
                        $this->plate_category = '1';
                        break;
                }
                //$this->plateEmiratesCategories = PlateEmiratesCategory::where(['plateEmiratesId'=>$this->plateStateCode])->get();
                
                $this->plateEmiratesCodes = PlateCode::where(['plateEmiratesId'=>$this->plateStateCode,'is_active'=>1])->get();
                
                
                //dd($this->plateEmiratesCodes);
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
        //$this->dispatchBrowserEvent('imageUpload');
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
                $this->otherVehicleDetailsForm=false;
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
                $this->otherVehicleDetailsForm=false;
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
                $this->otherVehicleDetailsForm=false;
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
        if($this->plate_country=='AE'){
            $validatedData = $this->validate([
                'plate_state' => 'required',
                //'plate_code' => 'required',
                'plate_number' => 'required',
            ]);
        }
        else
        {
            $validatedData = $this->validate([
                //'plate_code' => 'required',
                'plate_number' => 'required',
            ]);

        }

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
            $validatedData = $this->validate([
                'mobile'=> 'required',
            ]);
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
        if($this->numberPlateRequired)
        {
            $validateSaveVehicle['plate_country']='required';
            $validateSaveVehicle['plate_number']='required';
            $validateSaveVehicle['plate_code']='required';
            if($this->plate_country=='AE'){
                $validateSaveVehicle['plate_state']='required';
            }
            $validateSaveVehicle['vehicle_image'] = 'required|image|mimes:jpg,jpeg,png,svg,gif,webp|max:10048';
            $validateSaveVehicle['vehicle_type'] = 'required';
            $validateSaveVehicle['make'] = 'required';
            $validateSaveVehicle['model'] = 'required';
        }
        else
        {
            $validateSaveVehicle['vehicle_image'] = 'required|image|mimes:jpg,jpeg,png,svg,gif,webp|max:10048';
            $validateSaveVehicle['vehicle_type'] = 'required';
            $validateSaveVehicle['make'] = 'required';
            $validateSaveVehicle['model'] = 'required';
        }
        $validatedData = $this->validate($validateSaveVehicle);

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
        //dd($customerSaveResult); 
        $customerId = $customerSaveResult['TenantId'];
        //dd($customerId);
        //$customerInsert = TenantMasterCustomers::create($insertCustmoerData);
        $this->customer_id = $customerId;

        //Save Customer Vehicle
        $customerVehicleData['customer_id']=$customerId;
        $customerVehicleData['vehicle_type']=$this->vehicle_type;
        $customerVehicleData['make']=$this->make;
        $customerVehicleData['model']=$this->model;
        $customerVehicleData['plate_country']=$this->plate_country;
        $customerVehicleData['plate_state']=isset($this->plate_state)?$this->plate_state:'';
        $customerVehicleData['plate_category']=$this->plate_category;
        $customerVehicleData['plate_code']=$this->plate_code;
        $customerVehicleData['plate_number']=$this->plate_number;
        $completePlateNumber = $this->plate_state.' '.$this->plate_code.' '.$this->plate_number;
        if($this->plate_country!='AE')
        {
            $plateNumberCode = Country::where(['CountryCode'=>$this->plate_country])->first();
            $completePlateNumber = $plateNumberCode->NumberPlate.' '.$this->plate_code.' '.$this->plate_number;
        }
        $customerVehicleData['plate_number_final']=$completePlateNumber;
        $customerVehicleData['chassis_number']=isset($this->chassis_number)?$this->chassis_number:'';
        $customerVehicleData['vehicle_km']=isset($this->vehicle_km)?$this->vehicle_km:'';
        $customerVehicleData['is_active']=1;
        $customerVehicleData['created_by']=auth()->user('user')->id;

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
        $this->vehicle_id = $customerVehicleDetails->id;
        
        return redirect()->to('customer-service-job/'.$this->customer_id.'/'.$this->vehicle_id);

        
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

    public function addMakeModel(){
        $this->showAddMakeModelNew=true;
        $this->dispatchBrowserEvent('openAddMakeModel');
    }

    public function saveMakeInfo(){
        $validatedData = $this->validate([
            'new_make' => 'required',
        ]);
        $newMakeSave = VehicleMakes::create([
            "vehicle_name" => $this->new_make
        ]);
        $this->new_make_id = $newMakeSave->id;
        $this->showAddNewModel=true;
    }
    public function selectMakeInfoSave($makeInfo){
        $makeInfo = json_decode($makeInfo,true);
        $this->new_make_id = $makeInfo['id'];
        $this->new_make = $makeInfo['vehicle_name'];
        $this->showAddNewModel=true;
    }

    public function saveModelInfo()
    {
        $validatedData = $this->validate([
            'new_make' => 'required',
            'new_model' => 'required',
        ]);
        $newMakeSave = VehicleModels::create([
            'vehicle_make_id'=>$this->new_make_id,
            'vehicle_make_name'=>$this->new_make,
            'vehicle_model_name'=>$this->new_model,
        ]);
        $this->dispatchBrowserEvent('closeAddMakeModel');
    }

    public function nothing($id)
    {
            //nothing happen here
    }

}
