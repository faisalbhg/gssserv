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
use App\Models\CustomerJobCards;

class CustomerReceive extends Component
{
    use WithFileUploads;
    public $showWalkingCustomerPanel = true, $showContractCustomerPanel=false;
    public $searchByCustomer=true, $searchByVehicle=false, $searchByContractCustomer=false;
    public $customerForm=true, $customerSearchBtn =true, $customerSaveBtn =false, $vehicleForm=false, $vehicleSearchForm = false, $vehicleSearchBtn=false, $vehicleSaveBtn=false, $vehicleDetailsForm = false, $showVehicleAvailable=false, $showSelectedCustomer=false, $updateCustomerDetails=false;
    public $mobile, $name, $email, $markGusestCustomer=false;
    public $plate_number_image, $plate_country='AE', $otherCountryPlateCode=true, $plateStateCode=2, $plate_state='Dubai', $plateStateCodeLetter='DXB', $plate_category=2, $plate_code, $plate_number, $numberPlateRequired=true;
    public $countryList=[], $stateList=[], $plateEmiratesCategories=[], $plateEmiratesCodes=[], $vehicleTypesList=[], $listVehiclesMake = [], $vehiclesModelList=[];
    public $vehicle_image, $vehicle_type, $make, $model, $chaisis_image, $chassis_number, $vehicle_km;
    public $customers, $customerVehicles=[];
    public $customer_id, $vehicle_id,$customer_code;
    public $new_make, $new_make_id, $makeSearchResult=[], $modelSearchResult=[], $showAddMakeModelNew=false, $showAddNewModel=false, $new_model;
    public $contract_customer_id, $contract_plate_code, $contract_plate_number, $contract_chassis_number;
    public $pendingExistingJobs=null, $showPendingJobList=false;
    public $contractCustomerForm=false,$contractCustomersList=[], $contract_plate_country, $showSelectedContractCustomer=false;
    public $confirmGuestCustSave;

    public $search_contract_contract = '';
    public $selectedContract = null;
    public $items = []; // Example data

    function mount( Request $request) {
        $this->clearFormData();
    }

    public function render()
    {
        $this->countryList = Country::get();
        if($this->plate_country=='AE'){
            $this->otherCountryPlateCode=false;
        }
        else
        {
            $this->otherCountryPlateCode=true;  
        }

        
        $this->stateList = StateList::where(['CountryCode'=>$this->plate_country])->get();
           
        if($this->plate_state){
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
        }

        $this->vehicleTypesList = Vehicletypes::orderBy('type_name','ASC')->get();
        $this->listVehiclesMake = VehicleMakes::where('is_deleted','=',null)->get();
        if($this->make){
            //dd($this->make);
            $this->vehiclesModelList = VehicleModels::where(['vehicle_make_id'=>$this->make])->get();
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
        
        

        if(!$this->markGusestCustomer)
        {
            $this->notConfirmSaveAsGuest();
        }

        $this->contractCustomersList = TenantMasterCustomers::where(['discountgroup'=>14])->orWhere(['Paymethod'=>2])->get();
        $filteredItems = collect($this->contractCustomersList)->filter(function ($item) {
            return stripos($item, $this->search_contract_contract) !== false;
        });
        if($this->markGusestCustomer)
        {
            $this->customerSaveBtn=true;
        }

        $this->dispatchBrowserEvent('selectSearchEvent');
        $this->dispatchBrowserEvent('imageUpload');
        $this->emit('chosenUpdated');
        return view('livewire.customer-receive', [
            'filteredItems' => $filteredItems,
        ]);
    }

    public function selectItem($item)
    {
        $this->contract_customer_id = $item;
        $contractCustomerResult = TenantMasterCustomers::where(['TenantId'=>$this->contract_customer_id])->first();
        $this->customer_id=$contractCustomerResult->TenantId;
        $this->customer_code=$contractCustomerResult->TenantCode;
        $this->mobile=$contractCustomerResult->Mobile;
        $this->email=$contractCustomerResult->Email;
        $this->name=$contractCustomerResult->TenantName;

        $this->selectedContract = $contractCustomerResult->TenantName;
        $this->search_contract_contract = $item; // Display selected item in the input
        //$this->searchContractVehicle();
        $this->reset('search_contract_contract'); // Clear search to hide dropdown
    }

    

    public function customerPanelTab($tab)
    {
        $this->customer_id = null;
        $this->customer_code = null;
        $this->vehicle_id = null;
        switch ($tab) {
            case '1':
                $this->showWalkingCustomerPanel = true;
                $this->showContractCustomerPanel = false;

                
                
                break;
            
            case '2':
                $this->showWalkingCustomerPanel = false;
                $this->showContractCustomerPanel = true;

                

                break;

            default:
                $this->showWalkingCustomerPanel = true;
                $this->showContractCustomerPanel = false;
                break;
        }
    }

    public function clearFormData(){
        $this->customer_id = null;
        $this->customer_code = null;
        $this->vehicle_id = null;
        $this->mobile=null;
        $this->name=null;
        $this->email=null;
        $this->plate_code=null;
        $this->plate_number=null;
        $this->chassis_number=null;
        $this->showSelectedCustomer=false;
        $this->updateCustomerDetails = false;
        $this->contract_customer_id=null;
        $this->contract_plate_code=null;
        $this->contract_plate_number=null;
        $this->contract_chassis_number=null;
        $this->markGusestCustomer=false;
        $this->search_contract_contract=null;
        $this->selectedContract=null;
        $this->showSelectedContractCustomer=false;
        $this->customerVehicles=[];
    }

    public function clickSearchBy($searchId)
    {
        $this->clearFormData();
        switch ($searchId) {
            case '1':
                $this->searchByCustomer=true;

                $this->searchByVehicle=false;
                $this->customerForm=true;
                $this->customerSearchBtn =true;
                $this->customerSaveBtn =false;
                $this->vehicleForm=false;

                $this->searchByContractCustomer=false;
                $this->contractCustomerForm=false;
                
                break;

            case '2':
                $this->searchByCustomer=false;
                
                $this->searchByVehicle=true;
                $this->customerForm=false;
                $this->vehicleForm=true;
                $this->vehicleSearchForm=true;
                $this->vehicleSearchBtn=true;
                $this->vehicleSaveBtn=false;
                $this->vehicleDetailsForm=false;
                
                $this->searchByContractCustomer=false;
                $this->contractCustomerForm=false;
                
                $this->dispatchBrowserEvent('imageUpload');
                break;

            case '3':
                $this->searchByCustomer=false;
                
                $this->searchByVehicle=false;
                $this->customerForm=false;
                $this->vehicleForm=false;
                
                $this->searchByContractCustomer=true;
                $this->contractCustomerForm=true;
                
                $this->dispatchBrowserEvent('imageUpload');
                break;
        }
    }

    public function searchCustomer(){
        $this->customer_id = null;
        $this->customer_code = null;
        $this->vehicle_id = null;
        $customerSearchModel = TenantMasterCustomers::where(['Active'=>true]);
        $validatedData = $this->validate([
            'mobile'=> 'required|min:9|max:10',
        ]);
        if($this->mobile)
        {
            if($this->mobile[0]=='0'){
                $this->mobile = ltrim($this->mobile, $this->mobile[0]);
            }
            $customerSearchModel = $customerSearchModel->where('Mobile','LIKE',"%$this->mobile%");
        }
        if($customerSearchModel->exists()){
            $customerResult = $customerSearchModel->orderBy('TenantId','desc')->first();
            $this->customer_id=$customerResult->TenantId;
            $this->customer_code=$customerResult->TenantCode;
            $this->mobile=$customerResult->Mobile;
            $this->email=$customerResult->Email;
            $this->name=$customerResult->TenantName;
            $this->showSelectedCustomer=true;
            $this->customerSaveBtn =false;
            $this->getCustomerVehicles();
            
        }
        else
        {
            $this->customerSaveBtn =true;

            session()->flash('error', 'Customer not available, save customer & continue.');
            $this->customers = null;
            $this->customerVehicles=[];
        }
    }

    public function searchVehicle(){
        if($this->numberPlateRequired)
        {
            $validateSaveVehicle['plate_number']='required';
            
            if($this->plate_country=='AE'){
                $validateSaveVehicle['plate_code']='required';
                $validateSaveVehicle['plate_state']='required';
            }
        }
        else
        {
            $validateSaveVehicle['chassis_number']='required';
        }
        $validatedData = $this->validate($validateSaveVehicle);
        if(!$this->getCustomerVehicles())
        {
            $this->customerForm=true;
        }
    }

    public function getCustomerVehicles(){
        $searchCustomerVehicleQuery = CustomerVehicle::with(['customerInfoMaster','makeInfo','modelInfo']);
        if($this->mobile){
            $validatedData = $this->validate([
                'mobile'=> 'required|min:9|max:10',
            ]);
            if($this->mobile[0]=='0'){
                $this->mobile = ltrim($this->mobile, $this->mobile[0]);
            }
            $searchCustomerVehicleQuery = $searchCustomerVehicleQuery->where(['customer_id'=>$this->customer_id]);
        }
        if($this->plate_code || $this->plate_number){
            if($this->plate_code){
                $searchCustomerVehicleQuery = $searchCustomerVehicleQuery->where('plate_code', '=', $this->plate_code);
            }
            if($this->plate_number){
                $searchCustomerVehicleQuery = $searchCustomerVehicleQuery->where('plate_number', '=', $this->plate_number);
            }
            
        }
        if($this->chassis_number){
            $searchCustomerVehicleQuery = $searchCustomerVehicleQuery->where('chassis_number', 'like', "%{$this->chassis_number}%");
        }
        //Search Contract Customer
        if($this->contract_customer_id)
        {
            $searchCustomerVehicleQuery = $searchCustomerVehicleQuery->where('customer_id', '=', $this->contract_customer_id);
            if($this->contract_plate_code)
            {
                $searchCustomerVehicleQuery = $searchCustomerVehicleQuery->where('plate_code', '=', $this->contract_plate_code);
            }
            if($this->contract_plate_number)
            {
                $searchCustomerVehicleQuery = $searchCustomerVehicleQuery->where('plate_number', '=', $this->contract_plate_number);
            }
            if($this->contract_chassis_number)
            {
                $searchCustomerVehicleQuery = $searchCustomerVehicleQuery->where('chassis_number', 'like', "%{$this->contract_chassis_number}%");
            }
        }
        $searchCustomerVehicleResult = $searchCustomerVehicleQuery->where('customer_vehicles.is_active','=',1);
        
        
        if($searchCustomerVehicleResult->exists()){
            $this->customerVehicles = $searchCustomerVehicleResult->get();
            $this->dispatchBrowserEvent('scrollto', [
                'scrollToId' => 'customerSearchVehicleList',
            ]);
        }
        else
        {
            $this->addCustomerVehicle();
            session()->flash('error', 'Customer Vehicle is missing for job creation, please create vehicle details..!');  
            $this->customerVehicles = [];
        }

        return $searchCustomerVehicleResult->exists();
        
    }

    /**
     * Save Customer
     * */
    public function saveCustomer(){
        if(!$this->customer_id){
            if($this->markGusestCustomer){
                $this->confirmGuestCustSave = true;
            }
            else{

                $validateSaveVehicle['mobile'] = 'required';
                if($this->mobile!=null)
                {
                    if($this->mobile[0]=='0'){
                        $this->mobile = ltrim($this->mobile, $this->mobile[0]);
                    }
                    $validateSaveVehicle['mobile'] = 'required|min:9|max:10';
                }

                if($this->email!=null)
                {
                    $validateSaveVehicle['email'] = 'required|email';
                }
                $validatedData = $this->validate($validateSaveVehicle);
                if(TenantMasterCustomers::where('Mobile','LIKE',$this->mobile)->exists())
                {
                    $selectCustommer = TenantMasterCustomers::where('Mobile','LIKE',$this->mobile)->first();
                    $this->getCustomerDetailsMobile($selectCustommer->TenantId);
                    $this->getCustomerVehicles();
                    //session()->flash('success', 'Customer available, Pleae enter the vehicle details and continue..!');  
                }
                else
                {
                    $this->saveEntryForCustomer();  
                }
            }

        }else{
            $this->getCustomerDetailsMobile($this->customer_id);
            $this->showSelectedCustomer=true;
            session()->flash('error', $this->customer_id.' Customer Available,please contact IT..!');  
        }
    }

    public function notConfirmSaveAsGuest(){
        $this->confirmGuestCustSave=null;
    }
    public function confirmSaveAsGuest(){
        $this->saveEntryForCustomer();
    }

    public function saveEntryForCustomer(){
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
    
        $tenantcode = $this->customer_code;
        
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
        $this->customer_id = $customerId;
        $this->getCustomerDetailsMobile($this->customer_id);
        session()->flash('success', 'Customer created, Pleae enter the vehicle details and continue..!');
        $this->addCustomerVehicle();
    }

    public function getCustomerDetailsMobile($customerId){
        if($customerId){
            $availableCUstomer = TenantMasterCustomers::where('TenantId','LIKE',$this->customer_id)->orderBy('TenantId','DESC')->first();
        }
        else if($this->mobile){
            $availableCUstomer = TenantMasterCustomers::where('Mobile','LIKE',$this->mobile)->orderBy('TenantId','DESC')->first();
        }
        $this->customer_id=$availableCUstomer->TenantId;
        $this->customer_code=$availableCUstomer->TenantCode;
        $this->mobile=$availableCUstomer->Mobile;
        $this->email=$availableCUstomer->Email;
        $this->name=$availableCUstomer->TenantName;
        $this->showSelectedCustomer=true;
    }

    public function editCustomerDetails(){
        $this->showSelectedCustomer=false;
        $this->updateCustomerDetails = true;
    }

    public function updateCustomer()
    {
        if($this->customer_id){
            $tenantcode = $this->customer_id;
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
                
            //Call Procedure for Customer Edit
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
            session()->flash('success', 'Customer Updated, Pleae select vehicle and continue..!');  
            $this->showSelectedCustomer=true;
            $this->updateCustomerDetails = false;
        }
    }

    public function addCustomerVehicle(){
        $this->vehicleForm=true;
        $this->vehicleSearchForm=true;
        $this->vehicleDetailsForm=true;
        $this->vehicleSearchBtn=false;
        $this->vehicleSaveBtn=true;
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

    public function saveVehicle(){
        if($this->customer_id)
        {
            $this->validateVehicleSave();
            $this->customerVehicleSaveEntry();            
        }
        else
        {
            session()->flash('error', 'Customer not available, save customer & continue.');
            $this->customers = null;
            $this->customerVehicles=[];

           /* $this->validateVehicleSave();
            if(!$this->getCustomerVehicles()){
                $this->customerVehicleSaveEntry();
            }
            else
            {
                
            }*/
            //$this->customerForm=true;
            //session()->flash('error', 'Select customer and save vehicle..!');  
        }
    }
    public function validateVehicleSave(){
        if($this->numberPlateRequired)
        {
            $validateSaveVehicle['plate_country']='required';
            $validateSaveVehicle['plate_number']='required';
            
            if($this->plate_country=='AE'){
                $validateSaveVehicle['plate_code']='required';
                $validateSaveVehicle['plate_state']='required';
            }
            //$validateSaveVehicle['vehicle_image'] = 'required|image|mimes:jpg,jpeg,png,svg,gif,webp|max:10048';
            $validateSaveVehicle['vehicle_type'] = 'required';
            $validateSaveVehicle['make'] = 'required';
            $validateSaveVehicle['model'] = 'required';
        }
        else
        {
            //$validateSaveVehicle['vehicle_image'] = 'required|image|mimes:jpg,jpeg,png,svg,gif,webp|max:10048';
            $validateSaveVehicle['vehicle_type'] = 'required';
            $validateSaveVehicle['make'] = 'required';
            $validateSaveVehicle['model'] = 'required';
            $validateSaveVehicle['chassis_number'] = 'required';
        }
        $validatedData = $this->validate($validateSaveVehicle);
    }

    public function customerVehicleSaveEntry(){
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
            //$customerVehicleData['vehicle_image_base64']=base64_encode(file_get_contents($this->vehicle_image->getRealPath()));
        }

        if($this->plate_number_image){
            $customerVehicleData['plate_number_image'] = $this->plate_number_image->store('plate_number', 'public');
            //$customerVehicleData['plate_number_image_base64']=base64_encode(file_get_contents($this->plate_number_image->getRealPath()));
        }

        if($this->chaisis_image){
            $customerVehicleData['chaisis_image'] = $this->chaisis_image->store('chaisis_image', 'public');
            //$customerVehicleData['chaisis_image_base64']=base64_encode(file_get_contents($this->chaisis_image->getRealPath()));
        }

        $customerVehicleDetails = CustomerVehicle::create($customerVehicleData);
        $this->vehicle_id = $customerVehicleDetails->id;
        $this->vehicleForm=false;
        session()->flash('success', 'New vehicle added..!');  
        $this->getCustomerVehicles();
    }

    public function selectVehicleProceed($customer_id, $vehicle_id){
        $existingJobs = CustomerJobCards::with(['makeInfo','modelInfo','customerJobServices'])->where([
            'vehicle_id'=>$vehicle_id,
            'customer_id'=>$customer_id,
            'station'=>auth()->user('user')['station_code'],
        ])
        ->where('payment_status','!=',1)->where('job_status','!=',4)->where('job_status','!=',5);
        if($existingJobs->exists())
        {
            $this->showPendingJobList=true;
            $this->pendingExistingJobs = $existingJobs->get();
            $this->dispatchBrowserEvent('openPendingJobListModal');
        }
        else{
            return redirect()->to('customer-service-job/'.$customer_id.'/'.$vehicle_id);
        }
    }

    public function searchContractVehicle(){
        $validatedData = $this->validate([
            'contract_customer_id'=> 'required',
        ]);
        
        $searchCustomerVehicleQuery = CustomerVehicle::with(['customerInfoMaster','makeInfo','modelInfo']);
        
        //Search Contract Customer
        if($this->contract_customer_id)
        {
            $searchCustomerVehicleQuery = $searchCustomerVehicleQuery->where('customer_id', '=', $this->contract_customer_id);
        }
        if($this->contract_plate_code)
        {
            $searchCustomerVehicleQuery = $searchCustomerVehicleQuery->where('plate_code', '=', $this->contract_plate_code);
        }
        if($this->contract_plate_number)
        {
            $searchCustomerVehicleQuery = $searchCustomerVehicleQuery->where('plate_number', '=', $this->contract_plate_number);
        }
        if($this->contract_chassis_number)
        {
            $searchCustomerVehicleQuery = $searchCustomerVehicleQuery->where('chassis_number', 'like', "%{$this->contract_chassis_number}%");
        }
        $searchCustomerVehicleResult = $searchCustomerVehicleQuery->where('customer_vehicles.is_active','=',1);
        
        if($searchCustomerVehicleResult->exists()){
            $this->customerVehicles = $searchCustomerVehicleResult->get();
            $this->dispatchBrowserEvent('scrollto', [
                'scrollToId' => 'customerSearchVehicleList',
            ]);
        }
        else
        {
            $this->addCustomerVehicle();
            session()->flash('error', 'Customer Vehicle is missing for job creation, please create vehicle details..!');  
            $this->customerVehicles = [];
        }

        
        $this->showSelectedContractCustomer=true;
        
    }

    public function addNewContractCustomerVehicle(){
        $this->vehicleForm=true;
        $this->vehicleSearchForm=true;
        $this->vehicleDetailsForm=true;
        $this->vehicleSearchBtn=false;
        $this->vehicleSaveBtn=true;
    }



}
