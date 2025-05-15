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
use App\Models\TenantMasterCustomers;
use App\Models\CustomerServiceCart;

class VehicleSearchSave extends Component
{
    use WithFileUploads;
    public $showWalkingCustomerPanel = true, $showContractCustomerPanel=false;
    public $searchByMobileNumber = true, $showSearchByMobileBtn=true, $searchByMobileNumberBtn=true,$searchByPlateBtn=false, $searchByChaisisBtn=false, $showSearchByPlateNumberButton=false, $showSearchByChaisisButton=false, $searchByChaisis=false, $showAddMakeModelNew=false;
    public $showForms=true, $showByMobileNumber=true, $showCustomerForm=false, $showPlateNumber=false, $otherVehicleDetailsForm=false, $searchByChaisisForm=false, $updateVehicleFormBtn = false, $addVehicleFormBtn=false, $cancelEdidAddFormBtn=false, $showSaveCustomerButton=false, $numberPlateRequired=true, $searchByContractBtn=false, $showSearchContractCustomers=false, $showSaveContractCustomerVehicle=false, $showSaveCustomerVehicleOnly=false;
    public $mobile, $name, $email, $plate_number_image, $plate_country = 'AE', $plateStateCode=2, $plate_state='Dubai', $plate_category=2, $plate_code, $plate_number, $vehicle_image, $vehicle_type, $make, $model, $chaisis_image, $chassis_number, $vehicle_km, $contract_customer_id;
    public $countryList = [], $stateList=[], $plateEmiratesCategories=[], $plateEmiratesCodes, $vehicleTypesList, $listVehiclesMake, $vehiclesModelList=[], $contractCustomersList=[];
    public $editCustomerAndVehicle=false;
    public $customers=[];
    public $showVehicleAvailable=false;
    public $customer_id, $vehicle_id;
    public $new_make, $new_make_id, $makeSearchResult=[], $modelSearchResult=[], $showAddNewModel=false, $new_model;
    public $otherCountryPlateCode;
    //public $pendingCustomersCart;
    public $plateStateCodeLetter;

    public function render()
    {
        /*foreach(PlateCode::where(['plateEmiratesId'=>3,'is_active'=>1])->where('plateColorTitle','LIKE',"%SHJ%")->get() as $plateCode)
        {
            //dd($plateCode->plateColorTitle);
            $newPlateCOde = str_replace("SHJ ", "", $plateCode->plateColorTitle);
            //dd($newPlateCOde);
            PlateCode::where(['id'=>$plateCode->id])->update(['plateColorTitle'=>$newPlateCOde]);
        }*/
        /*dd(CustomerVehicle::where('plate_number_final','LIKE',"%Dubai%")->get());
        foreach(CustomerVehicle::where('plate_number_final','LIKE',"%Dubai%")->get() as $finalNumberPLate)
        {
            //dd($finalNumberPLate);
            $newFinalNumberPLate = str_replace("Dubai", "DXB", $finalNumberPLate->plate_number_final);
            //dd($newFinalNumberPLate);
            CustomerVehicle::where(['id'=>$finalNumberPLate->id])->update(['plate_number_final'=>$newFinalNumberPLate]);
        }*/
        /*$pendingCustomersCartQuery = CustomerServiceCart::with(['customerInfo','vehicleInfo']);
        $pendingCustomersCartQuery = $pendingCustomersCartQuery->where(['created_by'=>auth()->user('user')['id']]);
        $this->pendingCustomersCart =  $pendingCustomersCartQuery->get();*/

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
            $this->makeSearchResult = VehicleMakes::where('is_deleted','=',null)->where('vehicle_name','like',"%{$this->new_make}%")->get();
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
                //dd($this->plate_state);
                switch ($this->plate_state) {
                    case 'Abu Dhabi':
                        $this->plateStateCode = 1;
                        $this->plateStateCodeLetter = 'AD';
                        $this->plate_category = '242';
                        break;
                    case 'Dubai':
                        $this->plateStateCode = 2;
                        $this->plateStateCodeLetter = 'DXB';
                        $this->plate_category = '1';
                        break;
                    case 'Sharjah':
                        $this->plateStateCode = 3;
                        $this->plateStateCodeLetter = 'SHJ';
                        $this->plate_category = '103';
                        break;
                    case 'Ajman':
                        $this->plateStateCode = 4;
                        $this->plateStateCodeLetter = 'AJ';
                        $this->plate_category = '122';
                        break;
                    case 'Umm Al-Qaiwain':
                        $this->plateStateCode = 5;
                        $this->plateStateCodeLetter = 'UAQ';
                        $this->plate_category = '134';
                        break;
                    case 'Ras Al-Khaimah':
                        $this->plateStateCode = 6;
                        $this->plateStateCodeLetter = 'RAK';
                        $this->plate_category = '147';
                        break;
                    case 'Fujairah':
                        $this->plateStateCode = 7;
                        $this->plateStateCodeLetter = 'FJ';
                        $this->plate_category = '169';
                        break;
                    
                    default:
                        $this->plateStateCode = 2;
                        $this->plateStateCodeLetter = 'DXB';
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
            //dd(VehicleMakes::limit(1)->get());
            $this->vehicleTypesList = Vehicletypes::orderBy('type_name','ASC')->get();
            $this->listVehiclesMake = VehicleMakes::where('is_deleted','=',null)->get();
            if($this->make){
                //dd($this->make);
                $this->vehiclesModelList = VehicleModels::where(['vehicle_make_id'=>$this->make])->get();
            }
        }
        else
        {
            $this->vehicleTypesList=[];
            $this->listVehiclesMake = [];
            $this->vehiclesModelList = [];
        }


        
        /*if($this->showSearchContractCustomers)
        {
            if($this->contract_customer_id)
            {
                //$this->customer_id = $this->contract_customer_id;
                
                $this->getCustomerVehicleSearch('contract_customer_name');
                if(count($this->customers)>0)
                {
                    $this->showVehicleAvailable=true;
                }
            }
            
        }*/
        if($this->showSearchContractCustomers){
            $this->contractCustomersList = TenantMasterCustomers::where(['discountgroup'=>14])->orWhere(['Paymethod'=>2])->get();
        }
        if($this->contract_customer_id)
        {
            $this->showSaveContractCustomerVehicle=true; 
            //$this->getCustomerVehicleSearch('contract_customer_name');
        }
        
        
        //$this->dispatchBrowserEvent('imageUpload');
        $this->dispatchBrowserEvent('selectSearchEvent');
        $this->emit('chosenUpdated');
        return view('livewire.vehicle-search-save');
    }

    public function customerPanelTab($tab)
    {
        switch ($tab) {
            case '1':
                $this->showWalkingCustomerPanel = true;
                $this->showContractCustomerPanel = false;

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
                $this->searchByContractBtn=false;
                $this->showSearchContractCustomers=false;
                
                break;
            
            case '2':
                $this->showWalkingCustomerPanel = false;
                $this->showContractCustomerPanel = true;

                $this->searchByMobileNumberBtn=false;
                $this->searchByMobileNumber=false;
                $this->showByMobileNumber=false;
                $this->showCustomerForm=false;
                $this->searchByPlateBtn=false;
                $this->showPlateNumber=false;
                $this->showSearchByPlateNumberButton=false;
                $this->searchByChaisisBtn=false;
                $this->searchByChaisisForm=false;
                $this->showSearchByChaisisButton=false;
                $this->otherVehicleDetailsForm=false;
                $this->searchByContractBtn=true;
                $this->showSearchContractCustomers=true;

                break;

            default:
                $this->showWalkingCustomerPanel = true;
                $this->showContractCustomerPanel = false;
                break;
        }

    }

    public function clickSearchBy($searchId)
    {
        $this->updateVehicleFormBtn=false;
        $this->addVehicleFormBtn=false;
        $this->cancelEdidAddFormBtn=false;
        $this->showSaveCustomerButton=false;
        $this->showSaveCustomerVehicleOnly=false;
        $this->showVehicleAvailable=false;
        $this->customers=[];
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
                $this->searchByContractBtn=false;
                $this->showSearchContractCustomers=false;
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
                $this->searchByContractBtn=false;
                $this->showSearchContractCustomers=false;
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
                $this->searchByContractBtn=false;
                $this->showSearchContractCustomers=false;
                break;
            case '4':
                $this->searchByMobileNumberBtn=false;
                $this->searchByMobileNumber=false;
                $this->showByMobileNumber=false;
                $this->showCustomerForm=false;
                $this->searchByPlateBtn=false;
                $this->showPlateNumber=false;
                $this->showSearchByPlateNumberButton=false;
                $this->searchByChaisisBtn=false;
                $this->searchByChaisisForm=false;
                $this->showSearchByChaisisButton=false;
                $this->otherVehicleDetailsForm=false;
                $this->searchByContractBtn=true;
                $this->showSearchContractCustomers=true;
                
                break;
        }
    }

    public function searchResult(){
        $this->getCustomerVehicleSearch('mobile');
        if(count($this->customers)>0)
        {
            $this->showVehicleAvailable=true;
            //$this->showForms=false;
            $this->showCustomerForm=false;
            $this->showPlateNumber=false;
            $this->searchByChaisisForm=false;
            $this->otherVehicleDetailsForm=false;
            $this->showSaveCustomerButton=false;
            $this->showSearchContractCustomers=false;
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
        $searchCustomerVehicleQuery = CustomerVehicle::with(['customerInfoMaster','makeInfo','modelInfo']);
        if($serachBy=='mobile'){
            $validatedData = $this->validate([
                'mobile'=> 'required',
            ]);
            if($this->mobile[0]=='0'){
                $this->mobile = ltrim($this->mobile, $this->mobile[0]);
            }
            $searchCustomerVehicleQuery = $searchCustomerVehicleQuery->where(function ($query) {
                $query->whereRelation('customerInfoMaster', 'Mobile', 'like', "%$this->mobile%");
            });
        }
        if($serachBy=='plate'){
            $searchCustomerVehicleQuery = $searchCustomerVehicleQuery->where('plate_code', 'like', "%{$this->plate_code}%")->where('plate_number', 'like', "%{$this->plate_number}%");
        }
        if($serachBy=='chaisis'){
            $searchCustomerVehicleQuery = $searchCustomerVehicleQuery->where('chassis_number', 'like', "%{$this->chassis_number}%");
        }
        if($serachBy=='contract_customer_name')
        {
            $validatedData = $this->validate([
                'contract_customer_id'=> 'required',
            ]);
            
            $searchCustomerVehicleQuery = $searchCustomerVehicleQuery->where('customer_id', '=', $this->contract_customer_id);
        }
        $this->customers = $searchCustomerVehicleQuery->where('customer_vehicles.is_active','=',1)->limit(10)->get();
    }












    public function selectPendingVehicle($customer_id,$vehicle_id){
        return redirect()->to('/customer-service-job/'.$customer_id.'/'.$vehicle_id);
    }


    public function searchContractCustomerVehicle(){
        $this->getCustomerVehicleSearch('contract_customer_name');
        if(count($this->customers)>0)
        {
            $this->showVehicleAvailable=true;
        }
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
        //dd($this->chassis_number);
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

    

    public function saveContractVehicle(){

        //
        $this->showVehicleAvailable=false;
        $this->showForms=true;
        $this->showPlateNumber=true;
        $this->searchByChaisisForm=true;
        $this->otherVehicleDetailsForm=true;
        $this->saveContractCustomerVehicle=true;
        $this->showSaveCustomerVehicleOnly=true;


        /*$this->showVehicleAvailable=false;
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
        $this->showSaveCustomerButton=true;*/
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
        
        

        //Save Customer
        $insertCustmoerData['Mobile']=isset($this->mobile)?$this->mobile:'';
        $insertCustmoerData['TenantName']=isset($this->name)?$this->name:'Walk-In';
        if($this->email!=null)
        {
            $validateSaveVehicle['email'] = 'required|email';
            

        }
        $validatedData = $this->validate($validateSaveVehicle);
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
        $completePlateNumber = $this->plateStateCodeLetter.' '.$this->plate_code.' '.$this->plate_number;
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


        /*if (is_file($this->vehicle_image)) {
            $filename = uniqid() . '.' . $this->vehicle_image->getClientOriginalExtension();
            $this->vehicle_image->storeAs('public/uploads', $filename);

            // Optional: Save path to DB or emit event
            session()->flash('message', 'Image uploaded successfully!');
        } else {
            session()->flash('error', 'Invalid file.');
        }*/

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

    public function saveContractCustomerVehicle(){
        if($this->numberPlateRequired)
        {
            $validateSaveVehicle['plate_country']='required';
            $validateSaveVehicle['plate_number']='required';
            if($this->plate_country=='AE'){
                $validateSaveVehicle['plate_code']='required';
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

        $this->customer_id = $this->contract_customer_id;

        
        //dd($this->customer_id);

        //Save Customer Vehicle
        $customerVehicleData['customer_id']=$this->customer_id;
        $customerVehicleData['vehicle_type']=$this->vehicle_type;
        $customerVehicleData['make']=$this->make;
        $customerVehicleData['model']=$this->model;
        $customerVehicleData['plate_country']=$this->plate_country;
        $customerVehicleData['plate_state']=isset($this->plate_state)?$this->plate_state:'';
        $customerVehicleData['plate_category']=$this->plate_category;
        $customerVehicleData['plate_code']=$this->plate_code;
        $customerVehicleData['plate_number']=$this->plate_number;
        $completePlateNumber = $this->plateStateCodeLetter.' '.$this->plate_code.' '.$this->plate_number;
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
