<?php

namespace App\Http\Livewire;

use Livewire\Component;

use thiagoalessio\TesseractOCR\TesseractOCR; 

use Illuminate\Http\Request;
use Livewire\WithFileUploads;

use App\Models\Customers;
use App\Models\Vehicles;
use App\Models\CustomerVehicle;
use App\Models\Customertype;
use App\Models\Vehicletypes;
use App\Models\Services;
use App\Models\ServicesType;
use App\Models\ServicesGroup;
use App\Models\Customerjobs;
use App\Models\Customerjobservices;
use App\Models\Customerjoblogs;
use App\Models\StateList;
use App\Models\ServiceItemsPrice;
use App\Models\CustomerBasket;
use App\Models\ServiceChecklist;
use App\Models\JobcardChecklistEntries;
use App\Models\ServicesSectionsGroup;
use App\Models\ServiceMaster;
use App\Models\ServicesPrices;
use App\Models\Development;
use App\Models\Sections;
use App\Models\SectionServices;
use App\Models\CustomerServiceCart;
use App\Models\LaborItemMaster;
use App\Models\LaborCustomerGroup;
use App\Models\LaborSalesPrices;
use App\Models\CustomerDiscountGroup;
use App\Models\CustomerJobCards;
use App\Models\CustomerJobCardServices;
use App\Models\CustomerJobCardServiceLogs;
use App\Models\ServicePackage;
use App\Models\ServicePackageDetail;
use App\Models\TenantMasterCustomers;

use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\Http;
use LaravelPayfort\Facades\Payfort;
use Illuminate\Support\Facades\Hash;

use DB;



class Jobcard extends Component
{
    use WithFileUploads;
    public $searchby=true, $searchByMobileNumber=false, $searchByPlateNumber=false, $searchByChaisis=false, $searchByChaisisForm=false, $showForms=false, $showSearchButton=false, $showSearchByPlateNumberButton=false, $showSearchByChaisisButton=false, $showaddmorebtn=false, $showPackageList=false, $selectPackageMenu=false;
    public $editCustomerAndVehicle=false, $showCustomerForm=false, $showVehicleAvailable=false, $showSearchByPlateNumber=false;
    public $updateVehicleFormBtn = false, $otherVehicleDetailsForm=false, $selectedCustomerVehicle=false;
    public $showServiceGroup = false, $showSectionsList=false, $selectedSectionName;
    public $showDiscountGroup=false, $showDiscountGroupForm=false, $updateDiscountGroupFormDiv=false, $showSaveCustomerButton=false, $sisterCompanies=false, $listCustomerDiscontGroups;
    public $selectedVehicleInfo;

    //FormValues
    public $customer_id, $name, $email, $customer_type=23, $customer_id_image;
    public $mobile, $plate_state, $plate_code, $plate_number;
    public $plate_number_final, $vehicle_image,$listVehiclesMake, $vehicle_type, $make, $vehiclesModelList, $model, $chassis_number,$vehicle_km,$plate_number_image,$chaisis_image, $selected_vehicle_id, $propertyCode;

    //ListValues
    public $customers, $stateList, $customerTypeList, $vehicleTypesList, $servicesGroupList;

    //Service and itemms
    public $showServiceType = false, $showServicesitems = false, $selectServicesitems = false, $showServiceSectionsList=false;
    public $service_group_id, $service_group_name, $service_group_code, $sectionsLists, $sectionServiceLists=[], $station;
    public $service_sort=1;

    //Cart Details
    public $total, $tax, $grand_total, $paymentMethode, $job_number, $job_service_number, $cartItemCount=0, $cartItems = [], $quantity,$extra_note;
    public $showPayLaterCheckout=false, $successPage=false, $showCheckList=false, $showCheckout=false, $showFuelScratchCheckList=false, $showQLCheckList=false, $markCarScratch = false, $updateCustomerFormDiv = false;
    public $laborCustomerGroupLists=[], $selectedDiscountUnitId, $selectedDiscountCode, $selectedDiscountTitle, $selectedDiscountId,$discount_card_imgae, $discount_card_number, $discount_card_validity, $customerSelectedDiscountGroup, $customerDiscontGroupId, $customerDiscontGroupCode, $searchStaffId=false,$employeeId;

    public $checklistLabels = [], $checklistLabel = [], $fuel, $scratchesFound, $scratchesNotFound, $vImageR1, $vImageR2, $vImageF, $vImageB, $vImageL1, $vImageL2, $customerSignature;
    public $servicePackage, $packagePriceUpdate, $servicePackageAddon, $showPackageAddons=false;
    public $showCartSummary=false, $editCustomerVehicle=false, $addNewCustomerVehicle=false;
    public $edit_mobile, $edit_name, $edit_email, $edit_plate_number_image, $edit_plate_state, $edit_plate_code, $edit_plate_number, $edit_vehicle_image, $edit_vehicle_type, $edit_make, $edit_model, $edit_chaisis_image, $edit_chassis_number, $edit_vehicle_km;
    public $add_plate_number_image, $add_plate_state, $add_plate_code, $add_plate_number, $add_vehicle_image, $add_vehicle_type, $add_make, $add_model, $add_chaisis_image, $add_chassis_number, $add_vehicle_km;
    public $turn_key_on_check_for_fault_codes, $start_engine_observe_operation, $reset_the_service_reminder_alert, $stick_update_service_reminder_sticker_on_b_piller, $interior_cabin_inspection_comments, $check_power_steering_fluid_level, $check_power_steering_tank_cap_properly_fixed, $check_brake_fluid_level, $brake_fluid_tank_cap_properly_fixed, $check_engine_oil_level, $check_radiator_coolant_level, $check_radiator_cap_properly_fixed, $top_off_windshield_washer_fluid, $check_windshield_cap_properly_fixed, $underHoodInspectionComments, $check_for_oil_leaks_engine_steering, $check_for_oil_leak_oil_filtering, $check_drain_lug_fixed_properly, $check_oil_filter_fixed_properly, $ubi_comments;
    public $totalDiscount;
    public $selectedPackage, $selectedPackageItems;
    public $selectServiceItems;
    public $staffavailable;

    function mount( Request $request) {
        $vehicle_id = $request->vehicle_id;
        $customer_id = $request->customer_id;
        $job_number = $request->job_number;
        if($vehicle_id && $customer_id)
        {
            $this->openPendingVehicle($customer_id, $vehicle_id);

        }

        if($job_number)
        {
            $this->pendingPaymentClick($job_number);

        }

    }



    public function render(){

        /*dd(TenantMasterCustomers::get());
        CustomerDiscountGroup::query()->delete();
        CustomerJobCardServiceLogs::query()->delete();
        CustomerJobCardServices::query()->delete();
        CustomerJobCards::query()->delete();*/
        
        
        //Get all state List
        $this->stateList = StateList::all();

        //Get all veicle type list
        $this->vehicleTypesList = Vehicletypes::orderBy('type_name','ASC')->get();

        //Get Vehicle Make List
        $this->listVehiclesMake = Vehicles::select('vehicle_name AS vehicle_make')->get();

        $this->vehiclesModel=[];
        if($this->make){
            $vehicleResponse = Http::get("https://public.opendatasoft.com/api/explore/v2.1/catalog/datasets/all-vehicles-model/records?select=model,make&where=make%20like%20%22".$this->make."%22&limit=100");
            $vehicleResponse = $vehicleResponse->body();
            $vehicleResponse = json_decode($vehicleResponse);
            $this->vehiclesModel = (array)$vehicleResponse->results;
        }

        if($this->edit_make){
            $vehicleResponse = Http::get("https://public.opendatasoft.com/api/explore/v2.1/catalog/datasets/all-vehicles-model/records?select=model,make&where=make%20like%20%22".$this->edit_make."%22&limit=100");
            $vehicleResponse = $vehicleResponse->body();
            $vehicleResponse = json_decode($vehicleResponse);
            $this->vehiclesModel = (array)$vehicleResponse->results;
        }

        if($this->add_make){
            $vehicleResponse = Http::get("https://public.opendatasoft.com/api/explore/v2.1/catalog/datasets/all-vehicles-model/records?select=model,make&where=make%20like%20%22".$this->add_make."%22&limit=100");
            $vehicleResponse = $vehicleResponse->body();
            $vehicleResponse = json_decode($vehicleResponse);
            $this->vehiclesModel = (array)$vehicleResponse->results;
        }

        $this->servicesGroupList = Development::select('DevelopmentCode as department_code','DevelopmentName as department_name','id','LandlordCode as station_code')->where(['Operation'=>true,'LandlordCode'=>Session::get('user')->station_code])->get();

        //Get Service Group
        if($this->selected_vehicle_id && $this->service_group_code)
        {
            //$this->showSectionsList=true;
            $this->sectionsLists = Sections::select('id','PropertyCode','DevelopmentCode','PropertyNo','PropertyName','Operation')->where(['DevelopmentCode'=>$this->service_group_code])->get();
            /*$servicesTypesListQuery = ServicesPrices::with(['serviceInfo'])->where(['station_id'=>$this->station,'customer_type'=>$this->customer_type]);
            $servicesTypesListQuery = $servicesTypesListQuery->where(function ($query) {
                $query->whereRelation('serviceInfo', 'service_group_id', '=', $this->service_group_id);
            });

            switch($this->service_sort)
            {
                case 1:$servicesTypesListQuery = $servicesTypesListQuery->orderBy('id','DESC');break;
                case 2:$servicesTypesListQuery = $servicesTypesListQuery->orderBy('id','ASC');break;
                case 3:$servicesTypesListQuery = $servicesTypesListQuery->orderBy('sale_price','ASC');break;
                case 4:$servicesTypesListQuery = $servicesTypesListQuery->orderBy('sale_price','DESC');break;
            }
            $this->servicesTypesList = $servicesTypesListQuery->get();*/
            
        }

        


        //Get Service List Prices
        if($this->propertyCode){
            
            if($this->customerDiscontGroupCode){

                $sectionServiceLists = LaborItemMaster::where(['Labor.ItemMaster.SectionCode'=>$this->propertyCode])->get();
                $sectionServicePriceLists = [];
                foreach($sectionServiceLists as $key => $sectionServiceList)
                {
                    $sectionServicePriceLists[$key]['priceDetails'] = $sectionServiceList;
                    $sectionServicePriceLists[$key]['discountDetails'] = LaborSalesPrices::where(['ServiceItemId'=>$sectionServiceList->ItemId,'CustomerGroupCode'=>$this->customerDiscontGroupCode])->first();
                    //dd($sectionServicePriceLists[$key]);
                }
                $this->sectionServiceLists = $sectionServicePriceLists;
                //dd($this->sectionServiceLists);

                /*$this->sectionServiceLists = LaborItemMaster::join('Labor.SalesPrice as lsp', 'lsp.ServiceItemId', '=', 'Labor.ItemMaster.ItemId')->where(['Labor.ItemMaster.SectionCode'=>$this->propertyCode,'lsp.CustomerGroupCode'=>$this->customerDiscontGroupCode])->get();*/
                
            }
            else{
                $sectionServiceLists = LaborItemMaster::where(['Labor.ItemMaster.SectionCode'=>$this->propertyCode])->get();
                $sectionServicePriceLists = [];
                foreach($sectionServiceLists as $key => $sectionServiceList)
                {
                    $sectionServicePriceLists[$key]['priceDetails'] = $sectionServiceList;
                    $sectionServicePriceLists[$key]['discountDetails']=null;
                }
                $this->sectionServiceLists = $sectionServicePriceLists;
                
            }
            //dd($this->sectionServiceLists);
        }
        //dd($this->selectedVehicleInfo);

        if($this->sisterCompanies)
        {
            $this->laborCustomerGroupLists = LaborCustomerGroup::where(['GroupType'=>5])->get();
            //dd($this->laborCustomerGroupLists);
        }
        else
        {
            $this->laborCustomerGroupLists = LaborCustomerGroup::get();
        }
        if($this->customer_id)
        {
            $this->listCustomerDiscontGroups = CustomerDiscountGroup::where(['customer_id'=>$this->customer_id,'is_active'=>1])->get();
        }
        $this->servicePackage = ServicePackage::with(['packageDetails'])->get();
        $this->dispatchBrowserEvent('loadServiceGroups');
        return view('livewire.jobcard');
    }

    public function openPendingVehicle($customer_id, $vehicle_id){

        $this->selectVehicle($customer_id, $vehicle_id);
    }

    public function pendingPaymentClick($job_number){
        $this->successPage=false;
        
        $this->showSearchModelView=false;
        $this->dispatchBrowserEvent('selectSearchEvent'); 
        $this->dispatchBrowserEvent('show-searchNewVehicle');

        $this->showCustomerSearch=false;
        $this->showPayLaterCheckout=true;

        
        $pendingjob = CustomerJobCards::with(['customerInfo','customerVehicle'])->where(['job_create_status'=>0,'created_by'=>Session::get('user')->id,'job_number'=>$job_number])->first();
        if($pendingjob)
        {
            $this->job_number = $pendingjob->job_number;
            $this->totalPL = number_format($pendingjob->total_price,2);
            $this->taxPL = number_format($pendingjob->vat,2);
            $this->grand_totalPL = number_format($pendingjob->grand_total,2);
        }
        //$this->openPendingVehicle($pendingjob->customer_id, $pendingjob->vehicle_id);
        //dd($this);
    }

    public function clickSearchBy($searchId){
        $this->searchByMobileNumber=false;
        $this->showByMobileNumber=false;
        $this->searchByPlateNumber=false;
        $this->searchByChaisis=false;
        $this->showForms=true;
        $this->showCustomerForm=false;
        $this->otherVehicleDetailsForm=false;
        $this->searchByChaisisForm=false;
        $this->showVehicleAvailable=false;
        $this->showSearchByPlateNumberButton=false;
        $this->showSearchByChaisisButton=false;
        $this->selectedCustomerVehicle=false;
        $this->showServiceGroup=false;
        $this->showCheckList=false;
        $this->showCheckout=false;
        $this->showPayLaterCheckout=false;
        $this->successPage=false;
        $this->showSaveCustomerButton=false;
        $this->addNewCustomerVehicle=false;
        $this->editCustomerVehicle=false;
        switch ($searchId) {
            case '1':
                $this->searchByMobileNumber=true;
                $this->showByMobileNumber=true;
                $this->showSearchByMobileNumber=true;
                $this->showSearchByPlateNumber=false;
                break;
            case '2':
                $this->searchByPlateNumber=true;
                $this->showSearchByMobileNumber=false;
                $this->showSearchByPlateNumber=true;
                $this->showSearchByPlateNumberButton=true;
                break;
            case '3':
                $this->searchByChaisis=true;
                $this->searchByChaisisForm=true;
                $this->showSearchByMobileNumber=false;
                $this->showSearchByPlateNumber=false;
                $this->showSearchByChaisisButton=true;
                break;
            
            default:
                $this->searchByMobileNumber=false;
                $this->searchByPlateNumber=false;
                $this->searchByChaisis=false;
                break;
        }
    }


    public function searchResult(){

        $this->getCustomerVehicleSearch('mobile');
        if(count($this->customers)>0)
        {
            $this->showVehicleAvailable=true;

            $this->showSearchByPlateNumber=false;
            $this->showByMobileNumber=true;
            $this->showCustomerForm=false;
            $this->numberPlateAddForm=false;
            $this->searchByChaisisForm=false;
            $this->otherVehicleDetailsForm=true;
            $this->showSearchByPlateNumberButton=false;
            $this->showSaveCustomerButton=false;
        }
        else
        {
            $this->showSearchByPlateNumber=true;
            $this->showVehicleAvailable=false;
            $this->showByMobileNumber=true;
            $this->showCustomerForm=true;
            $this->numberPlateAddForm=true;
            $this->searchByChaisisForm=true;
            $this->otherVehicleDetailsForm=true;
            $this->showSearchByPlateNumberButton=false;
            $this->showSaveCustomerButton=true;
        }

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
            $this->showSearchByPlateNumber=true;
            $this->showVehicleAvailable=true;
        }
        else
        {
            $this->showSearchByPlateNumber=true;
            $this->showVehicleAvailable=false;
            $this->showByMobileNumber=true;
            $this->showCustomerForm=true;
            $this->numberPlateAddForm=true;
            $this->searchByChaisisForm=true;
            $this->otherVehicleDetailsForm=true;
            $this->showSearchByPlateNumberButton=false;
            $this->showSaveCustomerButton=true;
        }
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
            $this->showSearchByPlateNumber=true;
            $this->showVehicleAvailable=false;
            $this->showByMobileNumber=true;
            $this->showCustomerForm=true;
            $this->numberPlateAddForm=true;
            $this->searchByChaisisForm=true;
            $this->otherVehicleDetailsForm=true;
            $this->showSearchByChaisisButton=false;
            $this->showSaveCustomerButton=true;
        }
        $this->dispatchBrowserEvent('selectSearchEvent'); 
        
    }

    public function saveVehicleCustomer(){
        $validatedData = $this->validate([
            'customer_type' => 'required',
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
        $insertCustmoerData['TenantName']=isset($this->name)?$this->name:'';
        $insertCustmoerData['Email']=isset($this->email)?$this->email:'';
        //$insertCustmoerData['customer_type']=isset($this->customer_type)?$this->customer_type:'';
        $insertCustmoerData['Active']=1;
        //dd($insertCustmoerData);

        $tenantcode = null;
        $tenantType = 'T';
        $category = 'I';
        $tenantName = isset($this->name)?$this->name:'';
        $shortName = isset($this->name)?$this->name:'';
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
        $customerVehicleData['plate_state']=$this->plate_state;
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
        CustomerVehicle::create($customerVehicleData);

        //$this->selectedCustomerVehicle=true;
        //$this->newcustomeoperation=false;
        //$this->showVehicleAvailable=true;

        //$this->getVehicleCustomer();
        $this->searchResult();
        session()->flash('success', 'Vehicle is Added  Successfully !');        
    }


    public function getCustomerVehicleSearch($serachBy){

        //dd(CustomerVehicle::join('TenantMaster','TenantMaster.TenantId','=','customer_vehicles.customer_id')->where('mobile','like',"%{$this->mobile}%")->where('customer_vehicles.is_active','=',1)->get());
        /*dd(CustomerVehicle::with(['customerInfoMaster'=> function($q) {
            //$q->where('isDefault', '=', 0);
            $q->where('mobile', 'like', "%{$this->mobile}%");
        }])->get());*/

        /*dd(CustomerVehicle::with(['customerInfoMaster'=> function($q) {
            //$q->where('isDefault', '=', 0);
            $q->where('Mobile', 'like', "%{$this->mobile}%");
        }])->get());*/
        //dd(CustomerVehicle::with('customerInfoMaster')->get());

        $customerSearch = CustomerVehicle::with('customerInfoMaster');
        if($serachBy=='mobile'){
            /*$customerSearch = $customerSearch->where(function ($query) {
                $query->whereRelation('customerInfoMaster', 'Mobile', 'like', "%{$this->mobile}%");
            });*/

            $this->customers = CustomerVehicle::join('TenantMaster','TenantMaster.TenantId','=','customer_vehicles.customer_id')->where('mobile','like',"%{$this->mobile}%")->where('customer_vehicles.is_active','=',1)->get();
        }
        if($serachBy=='plate'){
            /*$customerSearch =  $customerSearch->where('plate_state', 'like', "%{$this->plate_state}%")
            ->where('plate_code', 'like', "%{$this->plate_code}%")
            ->where('plate_number', 'like', "%{$this->plate_number}%");*/
            $this->customers = CustomerVehicle::join('TenantMaster','TenantMaster.TenantId','=','customer_vehicles.customer_id')->where('plate_code', 'like', "%{$this->plate_code}%")->where('plate_number', 'like', "%{$this->plate_number}%")->where('customer_vehicles.is_active','=',1)->get();
        }
        if($serachBy=='chaisis'){
            /*$customerSearch =  $customerSearch->where('chassis_number', 'like', "%{$this->chassis_number}%");*/
            $this->customers = CustomerVehicle::join('TenantMaster','TenantMaster.TenantId','=','customer_vehicles.customer_id')->where('chassis_number', 'like', "%{$this->chassis_number}%")->where('customer_vehicles.is_active','=',1)->get();
        }
        //dd($this->customers);
        /*$this->customers = $customerSearch->where('is_active','=',1)->get();
        dd($this->customers);*/
    }

    public function selectVehicle($customerId,$vehicleId){

        $customers = CustomerVehicle::with('customerInfoMaster')->where(['is_active'=>1,'id'=>$vehicleId,'customer_id'=>$customerId])->first();
        //dd($customers);

        $this->showForms=false;
        $this->selectedCustomerVehicle=true;
        $this->showServiceGroup = true;
        
        $this->showCustomerSearch=false;
        $this->showVehicleAvailable = false;
        $this->selectedVehicleInfo=$customers;
        //dd($this->selectedVehicleInfo);
        $this->selected_vehicle_id = $customers->id;
        $this->customer_id = $customers->customer_id;
        $this->mobile = $customers->customerInfoMaster['Mobile'];
        $this->name = $customers->customerInfoMaster['TenantName'];
        $this->email = $customers->customerInfoMaster['Email'];
        $this->cartItems = CustomerServiceCart::where(['customer_id'=>$customerId,'vehicle_id'=>$vehicleId])->get();
        $this->cartItemCount = count($this->cartItems); 
        if(count($this->cartItems)>0)
        {
            $this->cardShow=true;
        }
        else
        {
            $this->cardShow=false;
        }
        $pendingjob = Customerjobs::where(['job_create_status'=>0,'customer_id'=>$this->customer_id,'vehicle_id'=>$this->selected_vehicle_id])->first();
        if($pendingjob)
        {
            $this->job_number = $pendingjob->job_number;
            $this->total_price = $pendingjob->total_price;
            $this->vat = $pendingjob->vat;
            $this->grand_total = $pendingjob->grand_total;
            $this->showCheckList=false;
            $this->showCheckout =false;
        }
    }

    public function showNumberplate(){
        $this->dispatchBrowserEvent('opennumberPlateModal');
    }

    public function serviceGroupForm($service){
        //dd($service);
        $this->service_group_id = $service['id'];
        $this->service_group_name = $service['department_name'];
        $this->service_group_code = $service['department_code'];
        $this->station = $service['station_code'];
        $this->service_search='';

        $this->showVehicleDiv = false;
        $this->showSearchByPlateNumberDiv=false;
        $this->newVehicleAdd=false;
        $this->showCustomerFormDiv=false;
        $this->selectedCustomerVehicle=true;
        //dd($this);
        //$this->selectedCustomerVehivleDetails($this->selected_vehicle_id);

        $this->customer_id = $this->customer_id;
        $this->vehicle_id = $this->selected_vehicle_id;
        $this->customer_type = $this->customer_type;
        $this->mobile = $this->mobile;
        $this->name = $this->name;
        $this->email = $this->email;
        $this->showServiceType=false;
        $this->selectServicesitems=false;
        $this->showServicesitems=true; 

        $this->showPackageList=false;
        $this->showSectionsList=true;
        $this->selectPackageMenu=false;
        $this->selectServiceItems=false;
        $this->dispatchBrowserEvent('scrolltop');
    }

    public function getSectionServices($section)
    {
        $this->propertyCode=$section['PropertyCode'];
        $this->selectedSectionName = $section['PropertyName'];
        
        /*foreach($this->sectionServiceLists as $sectionServiceLists)
        {
            dd($sectionServiceLists);
        }*/
        $this->showServiceSectionsList=true;
        $this->dispatchBrowserEvent('openServicesListModal');
    }


    public function editCustomer(){
        $this->selectedCustomerVehicle=false;
        $this->editCustomerVehicle=true;
        $this->edit_mobile = $this->mobile;
        $this->edit_name = $this->name;
        $this->edit_email = $this->email;
        $this->plate_number_image = $this->selectedVehicleInfo['plate_number_image'];
        //$this->edit_plate_number_image = $this->selectedVehicleInfo['plate_number_image'];
        $this->edit_plate_state = $this->selectedVehicleInfo['plate_state'];
        $this->edit_plate_code = $this->selectedVehicleInfo['plate_code'];
        $this->edit_plate_number = $this->selectedVehicleInfo['plate_number'];
        $this->vehicle_image = $this->selectedVehicleInfo['vehicle_image'];
        $this->edit_vehicle_type = $this->selectedVehicleInfo['vehicle_type'];
        $this->edit_make = $this->selectedVehicleInfo['make'];
        $this->edit_model = $this->selectedVehicleInfo['model'];
        //$this->edit_chaisis_image = $this->selectedVehicleInfo['chaisis_image'];
        $this->edit_chassis_number = $this->selectedVehicleInfo['chassis_number'];
        $this->edit_vehicle_km = $this->selectedVehicleInfo['vehicle_km'];
    }

    public function updateVehicleCustomer(){

        

        $validatedData = $this->validate([
            'edit_mobile' => 'required',
            'edit_name' => 'required',
            'edit_email' => 'required',
            //'edit_plate_number_image' => 'required|image|mimes:jpg,jpeg,png,svg,gif|max:10048',
            'edit_plate_state'=>'required',
            'edit_plate_code'=>'required',
            'edit_plate_number'=>'required',
            //'edit_vehicle_image' => 'required|image|mimes:jpg,jpeg,png,svg,gif|max:10048',
            'edit_vehicle_type' => 'required',
            'edit_make' => 'required',
            'edit_model'=> 'required',
        ]);

        $customerUpdateData['mobile'] = $this->edit_mobile;
        $customerUpdateData['name'] = $this->edit_name;
        $customerUpdateData['email'] = $this->edit_email;
        Customers::where(['id'=>$this->customer_id])->update($customerUpdateData);

        $imagename['edit_vehicle_image']='';
        if($this->edit_vehicle_image)
        {
            $imagename['edit_vehicle_image'] = $this->edit_vehicle_image->store('vehicle', 'public');
            $customerVehicleUpdate['vehicle_image']=$imagename['edit_vehicle_image'];
        }

        $imagename['edit_plate_number_image']='';
        if($this->edit_plate_number_image)
        {
            $imagename['edit_plate_number_image'] = $this->edit_plate_number_image->store('plate_number', 'public');
            $customerVehicleUpdate['plate_number_image']=$imagename['edit_plate_number_image'];
        }

        $imagename['edit_chaisis_image']='';
        if($this->edit_chaisis_image)
        {
            $imagename['edit_chaisis_image'] = $this->edit_chaisis_image->store('chaisis_image', 'public');
            $customerVehicleUpdate['chaisis_image']=$imagename['edit_chaisis_image'];
        }

        if($this->customer_id)
        {
            $customerId = $this->customer_id;
        }
        

        $customerVehicleUpdate['customer_id']=$customerId;
        $customerVehicleUpdate['vehicle_type']=$this->edit_vehicle_type;
        $customerVehicleUpdate['make']=$this->edit_make;
        $customerVehicleUpdate['model']=$this->edit_model;
        $customerVehicleUpdate['plate_state']=$this->edit_plate_state;
        $customerVehicleUpdate['plate_code']=$this->edit_plate_code;
        $customerVehicleUpdate['plate_number']=$this->edit_plate_number;
        $customerVehicleUpdate['plate_number_final']=$this->edit_plate_state.' '.$this->edit_plate_code.' '.$this->edit_plate_number;
        $customerVehicleUpdate['chassis_number']=isset($this->edit_chassis_number)?$this->edit_chassis_number:'';
        $customerVehicleUpdate['vehicle_km']=isset($this->edit_vehicle_km)?$this->edit_vehicle_km:'';
        $customerVehicleUpdate['created_by']=Session::get('user')->id;
        //dd($customerVehicleUpdate);
        CustomerVehicle::where(['id'=>$this->selected_vehicle_id])->update($customerVehicleUpdate);

        /*$this->selectedCustomerVehicle=true;
        $this->newcustomeoperation=false;*/

        $this->selectedCustomerVehicle=true;
        $this->editCustomerVehicle=false;
        session()->flash('success', 'Customer vehicle details updated Successfully !');
    }

    public function closeUpdateVehicleCustomer(){
        $this->selectedCustomerVehicle=true;
        $this->editCustomerVehicle=false;
    }

    public function addNewVehicle(){
        $this->selectedCustomerVehicle=false;
        $this->addNewCustomerVehicle=true;
    }
    public function closeAddNewVehicleCustomer(){
        $this->selectedCustomerVehicle=true;
        $this->addNewCustomerVehicle=false;
    }

    public function saveAddNewVehicleCustomer(){
        //d($this);

        $validatedData = $this->validate([
            //'edit_plate_number_image' => 'required|image|mimes:jpg,jpeg,png,svg,gif|max:10048',
            'add_plate_state'=>'required',
            'add_plate_code'=>'required',
            'add_plate_number'=>'required',
            'add_vehicle_image' => 'required|image|mimes:jpg,jpeg,png,svg,gif|max:10048',
            'add_vehicle_type' => 'required',
            'add_make' => 'required',
            'add_model'=> 'required',
        ]);

        
        if($this->add_vehicle_image)
        {
            $customerVehicleInsert['vehicle_image'] = $this->add_vehicle_image->store('vehicle', 'public');
        }
        if($this->add_plate_number_image)
        {
            $customerVehicleInsert['plate_number_image'] = $this->add_plate_number_image->store('plate_number', 'public');
        }
        if($this->add_chaisis_image)
        {
            $customerVehicleInsert['chaisis_image'] = $this->add_chaisis_image->store('chaisis_image', 'public');
        }

        $customerVehicleInsert['customer_id']=$this->customer_id;
        $customerVehicleInsert['vehicle_type']=$this->add_vehicle_type;
        $customerVehicleInsert['make']=$this->add_make;
        $customerVehicleInsert['model']=$this->add_model;
        $customerVehicleInsert['plate_state']=$this->add_plate_state;
        $customerVehicleInsert['plate_code']=$this->add_plate_code;
        $customerVehicleInsert['plate_number']=$this->add_plate_number;
        $customerVehicleInsert['plate_number_final']=$this->add_plate_state.' '.$this->add_plate_code.' '.$this->edit_plate_number;
        $customerVehicleInsert['chassis_number']=isset($this->add_chassis_number)?$this->add_chassis_number:'';
        $customerVehicleInsert['vehicle_km']=isset($this->add_vehicle_km)?$this->add_vehicle_km:'';
        $customerVehicleInsert['created_by']=Session::get('user')->id;
        //dd($customerVehicleInsert);
        CustomerVehicle::create($customerVehicleInsert);
        //$this->selectedCustomerVehicle=true;
        $this->addNewCustomerVehicle=false;
        $this->searchResult();
        session()->flash('success', 'New Customer vehicle added Successfully !');
    }

    public function addtoCart($servicePrice,$discount)
    {
        $servicePrice = json_decode($servicePrice);
        $discountPrice = json_decode($discount);
        $customerBasketCheck = CustomerServiceCart::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->selected_vehicle_id,'item_id'=>$servicePrice->ItemId]);
        if($customerBasketCheck->count())
        {
            $customerBasketCheck->increment('quantity', 1);
        }
        else
        {
            $cartInsert = [
                'customer_id'=>$this->customer_id,
                'vehicle_id'=>$this->selected_vehicle_id,
                'item_id'=>$servicePrice->ItemId,
                'item_code'=>$servicePrice->ItemCode,
                'company_code'=>$servicePrice->CompanyCode,
                'category_id'=>$servicePrice->CategoryId,
                'sub_category_id'=>$servicePrice->SubCategoryId,
                'brand_id'=>$servicePrice->BrandId,
                'bar_code'=>$servicePrice->BarCode,
                'item_name'=>$servicePrice->ItemName,
                'description'=>$servicePrice->Description,
                'division_code'=>$servicePrice->DivisionCode,
                'department_code'=>$servicePrice->DepartmentCode,
                'section_code'=>$servicePrice->SectionCode,
                'unit_price'=>$servicePrice->UnitPrice,
                'quantity'=>1,
                'created_by'=>Session::get('user')->id,
                'created_at'=>Carbon::now(),
            ];
            if($this->extra_note!=null){
               $cartInsert['extra_note']=isset($this->extra_note[$serviceId])?$this->extra_note[$serviceId]:null; 
            }
            if($discountPrice!=null){
                $cartInsert['price_id']=$discountPrice->PriceID;
                $cartInsert['customer_group_id']=$discountPrice->CustomerGroupId;
                $cartInsert['customer_group_code']=$discountPrice->CustomerGroupCode;
                $cartInsert['min_price']=$discountPrice->MinPrice;
                $cartInsert['max_price']=$discountPrice->MaxPrice;
                $cartInsert['start_date']=$discountPrice->StartDate;
                $cartInsert['end_date']=$discountPrice->EndDate;
                $cartInsert['discount_perc']=$discountPrice->DiscountPerc;
            }
            CustomerServiceCart::insert($cartInsert);
        }
        $this->cartItems = CustomerServiceCart::where(['customer_id'=>$this->customer_id, 'vehicle_id'=>$this->selected_vehicle_id])->get();
        $this->cartItemCount = count($this->cartItems); 
        if(count($this->cartItems))
        {
            $this->cardShow=true;
            $this->showCartSummary=true;
        }
        else
        {
            $this->cardShow=false;
        }



        

        //dd($this->sectionServiceLists);
        /*$this->dispatchBrowserEvent('swal:modal', [
            'type' => 'success',
            'message' => 'Added to Cart Successfully',
            'text' => 'service added..!',
            'cartitemcount'=>\Cart::getTotalQuantity()
        ]);*/
        session()->flash('cartsuccess', 'Service is Added to Cart Successfully !');
    }

    public function removeCart($id)
    {
        CustomerServiceCart::find($id)->delete();
        $this->cartItems = CustomerServiceCart::where(['customer_id'=>$this->customer_id, 'vehicle_id'=>$this->selected_vehicle_id])->get();
        $this->cartItemCount = count($this->cartItems); 
        if($this->cartItemCount>0)
        {
            $this->cardShow=true;
        }
        else
        {
            $this->cardShow=false;
            $this->showCheckout=false;
            $this->showCheckList=false;
        }
    }

    public function clearAllCart()
    {
        CustomerServiceCart::where(['customer_id'=>$this->customer_id, 'vehicle_id'=>$this->selected_vehicle_id])->delete();
        $this->cartItems = CustomerServiceCart::where(['customer_id'=>$this->customer_id, 'vehicle_id'=>$this->selected_vehicle_id])->get();
        $this->cartItemCount = count($this->cartItems); 
        
        /*$this->dispatchBrowserEvent('swal:modal', [
            'type' => 'success',
            'message' => 'All Service Cart Clear Successfully !',
            'text' => 'service added..!',
            'cartitemcount'=>\Cart::getTotalQuantity()
        ]);*/
        $this->cardShow=false;
        if($this->cartItemCount>0)
        {
            $this->showCheckout=true;
        }
        else
        {

            $this->showCheckout=false;
            $this->showCheckList=false;

        }
        //session()->flash('cartsuccess', 'All Service Cart Clear Successfully !');
    }

    public function clickDiscountGroup(){
        
        $this->dispatchBrowserEvent('openDiscountGroupModal');

    }

    public function discountGroupFilter($filter){
        if($filter=='all'){
            $this->sisterCompanies = false;
        }

        if($filter=='sister'){
            $this->sisterCompanies = true;
        }

    }

    public function selectDiscountGroup($discountGroup){
        $this->selectedDiscountUnitId = $discountGroup['UnitId'];
        $this->selectedDiscountCode = $discountGroup['Code'];
        $this->selectedDiscountTitle = $discountGroup['Title'];
        $this->selectedDiscountId = $discountGroup['Id'];
        if($discountGroup['Id']==8 || $discountGroup['Id']==9){
            $this->searchStaffId=true;
        }
        else
        {
            $this->searchStaffId=false;
        }
        //$this->dispatchBrowserEvent('closeDiscountGroupModal');
    }

    public function checkStaffDiscountGroup(){
        $proceeddisctount=false;
        $validatedData = $this->validate([
             'employeeId' => 'required',
        ]);
        //Call Procedure for Customer Staff ID Check
        $customerStaffIdCheck = DB::select('EXEC GetEmployee @employee_code = "'.$this->employeeId.'"', [
            $this->employeeId,
        ]); 
        
        if($customerStaffIdCheck)
        {
            $customerStaffIdResult = (array)$customerStaffIdCheck[0];
            $customerDiscontGroupInfo = [
                'customer_id'=>$this->customer_id,
                'vehicle_id'=>$this->selected_vehicle_id,
                'discount_id'=>$this->selectedDiscountId,
                'discount_unit_id'=>$this->selectedDiscountUnitId,
                'discount_code'=>$this->selectedDiscountCode,
                'discount_title'=>$this->selectedDiscountTitle,
                'discount_card_number'=>$this->discount_card_number,
                'discount_card_validity'=>$this->discount_card_validity,
                'is_active'=>1,
                'is_default'=>1,
                'created_at'=>Carbon::now(),
            ];
            
            if($this->discount_card_imgae)
            {
                $customerDiscontGroupInfo['discount_card_imgae'] = $this->discount_card_imgae->store('discount_group', 'public');
            }
            $customerDiscontGroup = CustomerDiscountGroup::create($customerDiscontGroupInfo);
            $this->customerSelectedDiscountGroup = $customerDiscontGroup;
            $this->customerDiscontGroupId = $customerDiscontGroup->id;
            $this->customerDiscontGroupCode = $customerDiscontGroup->discount_code;
            $this->dispatchBrowserEvent('closeDiscountGroupModal');
        }
        else
        {
            $this->staffavailable="Employee does not exist..!";
        }

    }

    public function saveSelectedDiscountGroup(){
        $proceeddisctount=false;
        if($this->searchStaffId==false){
            $validatedData = $this->validate([
                'discount_card_imgae' => 'required',
                'discount_card_number' => 'required',
                'discount_card_validity' => 'required',
                'selectedDiscountId'=>'required',
            ]);
            $proceeddisctount=true;
        }
        else{
            $validatedData = $this->validate([
                'employeeId' => 'required',
            ]);
            //Call Procedure for Customer Staff ID Check
            $customerStaffIdCheck = DB::select('EXEC GetEmployee @employee_code = "'.$this->employeeId.'"', [
                $this->employeeId,
            ]); 
            $customerStaffIdResult = (array)$customerStaffIdCheck[0];
            dd($customerStaffIdResult);
            $proceeddisctount=true;
        }

        
        if($proceeddisctount===true){
            $customerDiscontGroupInfo = [
                'customer_id'=>$this->customer_id,
                'vehicle_id'=>$this->selected_vehicle_id,
                'discount_id'=>$this->selectedDiscountId,
                'discount_unit_id'=>$this->selectedDiscountUnitId,
                'discount_code'=>$this->selectedDiscountCode,
                'discount_title'=>$this->selectedDiscountTitle,
                'discount_card_number'=>$this->discount_card_number,
                'discount_card_validity'=>$this->discount_card_validity,
                'is_active'=>1,
                'is_default'=>1,
                'created_at'=>Carbon::now(),
            ];
            
            if($this->discount_card_imgae)
            {
                $customerDiscontGroupInfo['discount_card_imgae'] = $this->discount_card_imgae->store('discount_group', 'public');
            }
            $customerDiscontGroup = CustomerDiscountGroup::create($customerDiscontGroupInfo);
            $this->customerSelectedDiscountGroup = $customerDiscontGroup;
            $this->customerDiscontGroupId = $customerDiscontGroup->id;
            $this->customerDiscontGroupCode = $customerDiscontGroup->discount_code;
            $this->dispatchBrowserEvent('closeDiscountGroupModal');
        }
    }

    public function selectAvailableCustDiscountGroup($discountGroup){
        $this->customerSelectedDiscountGroup = CustomerDiscountGroup::find($discountGroup);
        $this->customerDiscontGroupId = $this->customerSelectedDiscountGroup['id'];
        $this->customerDiscontGroupCode = $this->customerSelectedDiscountGroup['discount_code'];
    }

    public function removeDiscount(){
        $this->customerDiscontGroupId=null;
        $this->customerDiscontGroupCode=null;

        foreach($this->cartItems as $items)
        {
            $discountSalePrice = LaborItemMaster::join('Labor.SalesPrice as lsp', 'lsp.ServiceItemId', '=', 'Labor.ItemMaster.ItemId')->where(['Labor.ItemMaster.SectionCode'=>$items['section_code'],'lsp.CustomerGroupCode'=>$this->customerDiscontGroupCode])->where('lsp.StartDate', '<=', Carbon::now())->where('lsp.EndDate','=',null)->first();
            
            $cartUpdate['price_id']=null;
            $cartUpdate['customer_group_id']=null;
            $cartUpdate['customer_group_code']=null;
            $cartUpdate['min_price']=null;
            $cartUpdate['max_price']=null;
            $cartUpdate['start_date']=null;
            $cartUpdate['end_date']=null;
            $cartUpdate['discount_perc']=null;
            CustomerServiceCart::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->selected_vehicle_id,'id'=>$items->id])->update($cartUpdate);
        }

        $this->cartItems = CustomerServiceCart::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->selected_vehicle_id])->get();
    }

    public function applyDiscountGroup(){
        foreach($this->cartItems as $items)
        {
            $discountSalePrice = LaborItemMaster::join('Labor.SalesPrice as lsp', 'lsp.ServiceItemId', '=', 'Labor.ItemMaster.ItemId')->where(['Labor.ItemMaster.SectionCode'=>$items['section_code'],'lsp.CustomerGroupCode'=>$this->customerDiscontGroupCode])->where('lsp.StartDate', '<=', Carbon::now())->where('lsp.EndDate','=',null)->first();
            //dd($discountSalePrice);
            if($discountSalePrice){
                $cartUpdate['price_id']=$discountSalePrice->PriceID;
                $cartUpdate['customer_group_id']=$discountSalePrice->CustomerGroupId;
                $cartUpdate['customer_group_code']=$discountSalePrice->CustomerGroupCode;
                $cartUpdate['min_price']=$discountSalePrice->MinPrice;
                $cartUpdate['max_price']=$discountSalePrice->MaxPrice;
                $cartUpdate['start_date']=$discountSalePrice->StartDate;
                $cartUpdate['end_date']=$discountSalePrice->EndDate;
                $cartUpdate['discount_perc']=$discountSalePrice->DiscountPerc;
                CustomerServiceCart::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->selected_vehicle_id,'id'=>$items->id])->update($cartUpdate);
            }
        }

        $this->cartItems = CustomerServiceCart::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->selected_vehicle_id])->get();
    }

    public function openServiceGroup(){
        $this->showServiceGroup=true;
        $this->showCheckList=false;
        $this->showCheckout=false;
        $this->showPayLaterCheckout=false;
        $this->successPage=false;
    }

    public function submitService(){
        
        //$this->showaddmorebtn = true;
        $cartDetails = $this->cartItems;
        $this->cartItemCount = count($this->cartItems); 
        $this->total=0;
        
        $generalservice=false;
        $quicklubeservice=false;
        $showchecklist=false;
        foreach($this->cartItems as $items)
        {
            if($this->station==null){
                $this->station = $items->division_code;
            }

            if($items->department_code=='PP/00036' && $generalservice==false){
                $generalservice=true;
                $showchecklist=true;
            }
            else if($items->department_code=='PP/00037' && $quicklubeservice==false){
                $quicklubeservice=true;
                $showchecklist=true;
            }
            $this->total = $this->total+($items->quantity*$items->price);
        }
        
        if($showchecklist==true)
        {
            $this->showCheckList=true;
            $this->showFuelScratchCheckList=true;
            $this->showServiceGroup=false;
            $this->cardShow=false;
            $this->showCheckout=false;
            $this->checklistLabels = ServiceChecklist::get();
            if($quicklubeservice==true)
            {
                $this->showQLCheckList=true;
            }
            else
            {
                $this->showQLCheckList=false;
            }
        }
        else
        {
            $this->showCheckList=false;
            $this->showFuelScratchCheckList=false;
            $this->showServiceGroup=false;
            $this->cardShow=false;
            //$this->createJob();
            $this->showCheckout=true;
        }

        //dd($this->showQLCheckList);

        

            
        $this->tax = $this->total * (config('global.TAX_PERCENT') / 100);
        $this->grand_total = $this->total  * ((100 + config('global.TAX_PERCENT')) / 100);


        $this->dispatchBrowserEvent('imageUpload');
        //$this->dispatchBrowserEvent('showSignature'); 
        
        //$this->dispatchBrowserEvent('showSignature'); 
        /*$this->showServiceGroup=false;
        $this->cardShow=false;
        $this->showCheckout=true;*/
        //dd($this->cartItems);
    }

    public function clickShowSignature()
    {
        $this->dispatchBrowserEvent('showSignature');

    }

    public function clearSignature(){
        $this->dispatchBrowserEvent('clearSignature'); 
    }

    public function saveSignature(){
        $this->showaddmorebtn = false;
        $this->dispatchBrowserEvent('saveSignature'); 
    }

    public function useSignature(){
        $this->dispatchBrowserEvent('saveSignature'); 
    }

    

    public function createJob(){
        //dd($this->customerSignature);
        //save checklist
        

        //$this->job_number = Session::get('user')->stationName['station_code'].'-PSOF-'.Carbon::now()->format('y').Carbon::now()->format('m').Carbon::now()->format('d').'-'.$this->service_group_code.'123';
        
        $cartDetails = $this->cartItems;
        $this->cartItemCount = count($this->cartItems); 
        $customerVehicleId = $this->selected_vehicle_id;
        $customerId = $this->customer_id;
        
        $total=0;
        $serviceIncludeArray=[];
        $gsQlIn = false;
        foreach($cartDetails as $item)
        {
            $total = $total+($item->quantity*$item->unit_price);
            if($item->department_code=='PP/00036'  || $item->department_code=='PP/00037')
            {
                $gsQlIn=true;
            }
        }
        if($gsQlIn==true)
        {
            $validatedData = $this->validate([
                'fuel' => 'required',
                'scratchesFound' => 'required',
                'scratchesNotFound' => 'required',
                /*'vImageR1' => 'required',
                'vImageR2' => 'required',
                'vImageF' => 'required',
                'vImageB' => 'required',
                'vImageL1' => 'required',
                'vImageL2' => 'required',*/
            ]);

            //$checkListEntryInsert = JobcardChecklistEntries::create($checkListEntryData);

            $this->showCheckList=false;
            $this->showCheckout =true;
        }


        
        $this->tax = $total * (config('global.TAX_PERCENT') / 100);
        $this->grand_total = $total  * ((100 + config('global.TAX_PERCENT')) / 100);
        $customerjobData = [
            'job_number'=>$this->service_group_code.Carbon::now()->format('y').Carbon::now()->format('m').Carbon::now()->format('d').rand(1,1000),
            'job_date_time'=>Carbon::now(),
            'customer_id'=>$this->customer_id,
            //'customer_type'=>$this->customer_type,
            'vehicle_id'=>$this->selectedVehicleInfo['id'],
            'vehicle_type'=>isset($this->selectedVehicleInfo['vehicle_type'])?$this->selectedVehicleInfo['vehicle_type']:0,
            'make'=>$this->selectedVehicleInfo['make'],
            'vehicle_image'=>$this->selectedVehicleInfo['vehicle_image'],
            'model'=>$this->selectedVehicleInfo['model'],
            'plate_number'=>$this->selectedVehicleInfo['plate_number_final'],
            'chassis_number'=>$this->selectedVehicleInfo['chassis_number'],
            'vehicle_km'=>$this->selectedVehicleInfo['vehicle_km'],
            'station'=>$this->station,
            /*'customer_discount_id'=>$this->station,
            'discount_id',
            'discount_unit_id',
            'discount_code',
            'discount_title',
            'discount_percentage',
            'discount_amount',
            'coupon_used',
            'coupon_type',
            'coupon_code',
            'coupon_amount',*/
            'total_price'=>$total,
            'vat'=>$this->tax,
            'grand_total'=>$this->grand_total,
            'job_status'=>1,
            'job_departent'=>1,
            'payment_status'=>0,
            'created_by'=>Session::get('user')->id,
            'payment_updated_by'=>Session::get('user')->id,
        ];
        if($this->customerDiscontGroupCode)
        {
            $customerjobData['customer_discount_id']=$this->customerSelectedDiscountGroup->id;
            $customerjobData['discount_id']=$this->customerSelectedDiscountGroup->discount_id;
            $customerjobData['discount_unit_id']=$this->customerSelectedDiscountGroup->discount_unit_id;
            $customerjobData['discount_code']=$this->customerSelectedDiscountGroup->discount_code;
            $customerjobData['discount_title']=$this->customerSelectedDiscountGroup->discount_title;
            /*'discount_percentage',
            'discount_amount'*/
        }
        $customerjobId = CustomerJobCards::create($customerjobData);
        $this->job_number = str_replace("/","",$this->station).'-PSOF-'.Carbon::now()->format('y').Carbon::now()->format('m').Carbon::now()->format('d').'-'.str_replace("/","",$this->service_group_code).$customerjobId->id;
        CustomerJobCards::where(['id'=>$customerjobId->id])->update(['job_number'=>$this->job_number]);

        //dd($cartDetails);
        foreach($cartDetails as $cartData)
        {
            $serviceItemTax = $cartData->unit_price * (config('global.TAX_PERCENT') / 100);
            $serviceItemTotal = $cartData->unit_price  * $cartData->quantity;
            $customerJobServiceData = [
                'job_number'=>$this->job_number,
                'job_id'=>$customerjobId->id,
                'total_price'=>$cartData->unit_price,
                'quantity'=>$cartData->quantity,
                'vat'=>$serviceItemTax,
                'grand_total'=>($serviceItemTotal*$cartData->quantity)+$serviceItemTax,
                'job_status'=>1,
                'job_departent'=>1,
                'is_added'=>0,
                'is_removed'=>0,
                'created_by'=>Session::get('user')->id,
            ];
            
            
            $customerJobServiceData['item_id']=$cartData->item_id;
            $customerJobServiceData['item_code']=$cartData->item_code;
            $customerJobServiceData['company_code']=$cartData->company_code;
            $customerJobServiceData['category_id']=$cartData->category_id;
            $customerJobServiceData['sub_category_id']=$cartData->sub_category_id;
            $customerJobServiceData['brand_id']=$cartData->brand_id;
            $customerJobServiceData['bar_code']=$cartData->bar_code;
            $customerJobServiceData['item_name']=$cartData->item_name;
            $customerJobServiceData['description']=$cartData->description;
            $customerJobServiceData['division_code']=$cartData->division_code;
            $customerJobServiceData['department_code']=$cartData->department_code;
            $customerJobServiceData['section_code']=$cartData->section_code;
            $customerJobServiceData['station']=$this->station;
            $customerJobServiceData['extra_note']=$cartData->extra_note;
            //dd($customerJobServiceData);

            if($this->customerDiscontGroupCode)
            {
                $customerJobServiceData['customer_discount_id']=$this->customerSelectedDiscountGroup->id;
                $customerJobServiceData['discount_id']=$this->customerSelectedDiscountGroup->discount_id;
                $customerJobServiceData['discount_unit_id']=$this->customerSelectedDiscountGroup->discount_unit_id;
                $customerJobServiceData['discount_code']=$this->customerSelectedDiscountGroup->discount_code;
                $customerJobServiceData['discount_title']=$this->customerSelectedDiscountGroup->discount_title;
                $customerJobServiceData['discount_percentage'] = $cartData->discount_perc;
                $customerJobServiceData['discount_amount'] = round((($cartData->discount_perc/100)*$cartData->unit_price),2);
            }
            
            $customerJobServiceId = CustomerJobCardServices::create($customerJobServiceData);
            //$customerJobServiceId = Customerjobservices::create($customerJobServiceData);

            CustomerJobCardServiceLogs::create([
                'job_number'=>$this->job_number,
                'job_status'=>1,
                'job_departent'=>1,
                'job_description'=>json_encode($customerJobServiceData),
                'customer_job__card_service_id'=>$customerJobServiceId->id,
                'created_by'=>Session::get('user')->id,
                'created_at'=>Carbon::now(),
            ]);

        }

        $vehicle_image=[];
        //dd($vehicle_image);
        if(!empty($this->checklistLabel))
        {
            $vehicle_image = [
                'vImageR1'=>isset($this->vImageR1)?$this->vImageR1->store('car_image', 'public'):null,
                'vImageR2'=>isset($this->vImageR2)?$this->vImageR2->store('car_image', 'public'):null,
                'vImageF'=>isset($this->vImageF)?$this->vImageF->store('car_image', 'public'):null,
                'vImageB'=>isset($this->vImageB)?$this->vImageB->store('car_image', 'public'):null,
                'vImageL1'=>isset($this->vImageL1)?$this->vImageL1->store('car_image', 'public'):null,
                'vImageL2'=>isset($this->vImageL2)?$this->vImageL2->store('car_image', 'public'):null,
            ];
            

            $checkListEntryData = [
                'job_number'=>$this->job_number,
                'job_id'=>$customerjobId->id,
                'checklist'=>json_encode($this->checklistLabel),
                'fuel'=>$this->fuel,
                'scratches_found'=>$this->scratchesFound,
                'scratches_notfound'=>$this->scratchesNotFound,
                'vehicle_image'=>json_encode($vehicle_image),
                'signature'=>$this->customerSignature,
                'turn_key_on_check_for_fault_codes'=>$this->turn_key_on_check_for_fault_codes,
                'start_engine_observe_operation'=>$this->start_engine_observe_operation,
                'reset_the_service_reminder_alert'=>$this->reset_the_service_reminder_alert,
                'stick_update_service_reminder_sticker_on_b_piller'=>$this->stick_update_service_reminder_sticker_on_b_piller,
                'interior_cabin_inspection_comments'=>$this->interior_cabin_inspection_comments,
                'check_power_steering_fluid_level'=>$this->check_power_steering_fluid_level,
                'check_power_steering_tank_cap_properly_fixed'=>$this->check_power_steering_tank_cap_properly_fixed,
                'check_brake_fluid_level'=>$this->check_brake_fluid_level,
                'brake_fluid_tank_cap_properly_fixed'=>$this->brake_fluid_tank_cap_properly_fixed,
                'check_engine_oil_level'=>$this->check_engine_oil_level,
                'check_radiator_coolant_level'=>$this->check_radiator_coolant_level,
                'check_radiator_cap_properly_fixed'=>$this->check_radiator_cap_properly_fixed,
                'top_off_windshield_washer_fluid'=>$this->top_off_windshield_washer_fluid,
                'check_windshield_cap_properly_fixed'=>$this->check_windshield_cap_properly_fixed,
                'underHoodInspectionComments'=>$this->underHoodInspectionComments,
                'check_for_oil_leaks_engine_steering'=>$this->check_for_oil_leaks_engine_steering,
                'check_for_oil_leak_oil_filtering'=>$this->check_for_oil_leak_oil_filtering,
                'check_drain_lug_fixed_properly'=>$this->check_drain_lug_fixed_properly,
                'check_oil_filter_fixed_properly'=>$this->check_oil_filter_fixed_properly,
                'ubi_comments'=>$this->ubi_comments,
                'created_by'=>Session::get('user')->id,
            ];
            $checkListEntryInsert = JobcardChecklistEntries::create($checkListEntryData);
        }

        //dd($this);
        /**/

        /**/
        //;

        $this->showCheckList=false;
        $this->showCheckout =true;


    }


    public function completePaymnet($mode){
        $this->successPage=false;
        if($this->job_number==Null){
            $this->createJob();
        }
        $job_number = $this->job_number;
        
        $customerjobs = CustomerJobCards::with(['customerInfo','customerVehicle'])->where(['job_number'=>$this->job_number])->first();
        /*$customerjobs = Customerjobs::
        select('customerjobs.*','customers.name','customers.email','customers.mobile','customertypes.customer_type as customerType')
        ->join('customers','customers.id','=','customerjobs.customer_id')
        ->join('customertypes','customertypes.id','=','customerjobs.customer_type')
        ->where(['customerjobs.job_number'=>$job_number])
        ->take(5)->first();*/
        
        $mobileNumber = '971'.substr($customerjobs->customerInfo['mobile'], -9);
        //$mobileNumber = substr($customerjobs->mobile, -9);
        if($mode=='link')
        {
            //dd($customerjobs);
            $paymentLink = $this->sendPaymentLink($customerjobs);
            $paymentResponse = json_decode((string) $paymentLink->getBody()->getContents(), true);
            $merchant_reference = $paymentResponse['merchant_reference'];
            
            if(array_key_exists('payment_redirect_link', $paymentResponse))
            {
                //dd(SMS_URL."?user=".SMS_PROFILE_ID."&pwd=".SMS_PASSWORD."&senderid=".SMS_SENDER_ID."&CountryCode=971&mobileno=".$mobileNumber."&msgtext=".urlencode('Job Id #'.$job_number.' is processing, Please click complete payment '.$paymentResponse['payment_redirect_link']));
                //"http://mshastra.com/sendurlcomma.aspx?user=profileid&pwd=xxxx&senderid=ABC&CountryCode=91&mobileno=9911111111&msgtext=Hello"
                $response = Http::withBasicAuth(env('SMS_PROFILE_ID'), env('SMS_PASSWORD'))->post(env('SMS_URL')."?user=".env('SMS_PROFILE_ID')."&pwd=".env('SMS_PASSWORD')."&senderid=".env('SMS_SENDER_ID')."&mobileno=".$mobileNumber."&msgtext=".urlencode('Job Id #'.$job_number.' is processing, Please click complete payment '.$paymentResponse['payment_redirect_link'])."&CountryCode=ALL");


                $customerjobId = CustomerJobCards::where(['job_number'=>$job_number])->update(['payment_type'=>1,'payment_link'=>$paymentResponse['payment_redirect_link'],'payment_response'=>json_encode($paymentResponse),'payment_request'=>'link_send','job_create_status'=>1]);

                CustomerServiceCart::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->selected_vehicle_id])->delete();

                $this->successPage=true;
                $this->showCheckout =false;
                $this->cardShow=false;
                $this->showServiceGroup=false;
                $this->showPayLaterCheckout=false;
                $this->selectedCustomerVehicle=false;
                
            }
            else
            {
                session()->flash('error', $paymentResponse['response_message']);

            }
            
        }
        else if($mode=='card')
        {
            $customerjobId = CustomerJobCards::where(['job_number'=>$job_number])->update(['payment_type'=>2,'payment_request'=>'card payment','job_create_status'=>1]);

            $response = Http::withBasicAuth(env('SMS_PROFILE_ID'), env('SMS_PASSWORD'))->post(env('SMS_URL')."?user=".env('SMS_PROFILE_ID')."&pwd=".env('SMS_PASSWORD')."&senderid=".env('SMS_SENDER_ID')."&mobileno=".$mobileNumber."&msgtext=".urlencode('Job Id #'.$job_number.' is processing, Complete your payment and proceed. Visit '.url('qr/'.$job_number).' for the updates and gate pass')."&CountryCode=ALL");

            CustomerServiceCart::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->selected_vehicle_id])->delete();

            $this->successPage=true;
            $this->showCheckout =false;
            $this->cardShow=false;
            $this->showServiceGroup=false;
            $this->showPayLaterCheckout=false;
            $this->selectedCustomerVehicle=false;
            
        }
        else if($mode=='cash')
        {
            $customerjobId = CustomerJobCards::where(['job_number'=>$job_number])->update(['payment_type'=>3,'payment_request'=>'cash payment','job_create_status'=>1]);
            
            $response = Http::withBasicAuth(env('SMS_PROFILE_ID'), env('SMS_PASSWORD'))->post(env('SMS_URL')."?user=".env('SMS_PROFILE_ID')."&pwd=".env('SMS_PASSWORD')."&senderid=".env('SMS_SENDER_ID')."&mobileno=".$mobileNumber."&msgtext=".urlencode('Job Id #'.$job_number.' is processing, Visit '.url('qr/'.$job_number).' for the updates and gate pass')."&CountryCode=ALL");
            
            CustomerServiceCart::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->selected_vehicle_id])->delete();

            $this->successPage=true;
            $this->showCheckout =false;
            $this->cardShow=false;
            $this->showServiceGroup=false;
            $this->showPayLaterCheckout=false;
            $this->selectedCustomerVehicle=false;
        }
    }

    public function sendPaymentLink($customerjobs)
    {
        //dd($customerjobs);
        $exp_date = Carbon::now('+10:00')->format('Y-m-d\TH:i:s\Z');
        $order_billing_name = $customerjobs->customerInfo['TenantName'];
        $order_billing_phone = $customerjobs->customerInfo['Mobile'];
        $order_billing_email = $customerjobs->customerInfo['Email']; 
        $total = round(($customerjobs->grand_total * 100),2);
        $merchant_reference = $customerjobs->job_number;
        $order_billing_phone = str_replace(' ', '', $order_billing_phone);
        if($order_billing_phone[0] != 0 and $order_billing_phone[1] != 0)
        {
            if($order_billing_phone[0] == '+')
            {
                $order_billing_phone = substr_replace($order_billing_phone, '00', 0, 1);
            }
            else
            {
               $order_billing_phone = preg_replace('/0/', '00971', $order_billing_phone, 1);
            }
        }

        /*$arrData    = [
            'service_command'=>'PAYMENT_LINK',
            'access_code'=>'CIjX6aY6Yc0FgGktyo4I',
            'merchant_identifier'=>'WQNoWgPx',
            'merchant_reference'=>$merchant_reference,
            'amount'=>$total,
            'currency'=>'AED',
            'language'=>'en',
            'customer_email'=>$order_billing_email,
            'request_expiry_date'=>$exp_date,
            'notification_type'=>'EMAIL,SMS',
            'order_description'=>'GSS Service #'.$merchant_reference,
            'customer_name'=>$order_billing_name,
            'customer_phone'=>$order_billing_phone,
            'return_url'=>url('order-response'),
        ];*/

        $arrData = [
                "paymnet_link_expiry"=>Carbon::now()->addDays(1)->format('Y-m-d H:i:s'),
                //"amount"=>$total,
                "amount"=>1,
                "emailAddress"=>$order_billing_email,
                "firstName"=>$order_billing_name,
                "customer_mobile"=>$order_billing_phone,
                "lastName"=>$order_billing_name,
                "address1"=>"Dubai",
                "city"=>"Bur Dubai",
                "countryCode"=>"UAE",
                "orderReference"=>$merchant_reference,
                "description"=>"GSS Service #".$merchant_reference
            ];
            dd($arrData);
        $response = Http::withBasicAuth('onlinewebtutor', 'admin123')->post(config('global.paymenkLink_payment_url'),$arrData);
        return $response;
    }

    public function payLater()
    {
        if($this->job_number==Null){
            $this->createJob();
        }
        Customerjobs::where(['job_number'=>$this->job_number])->update(['job_create_status'=>0]);
        CustomerBasket::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->selected_vehicle_id])->delete();
        $this->successPage=true;
        $this->showCheckout =false;
        $this->cardShow=false;
        $this->showServiceGroup=false;
    }

    public function openPackages(){
        $this->showSectionsList=false;
        $this->showServiceSectionsList=false;
        $this->showPackageList=true;
        $this->selectPackageMenu=true;
        $this->selectServiceItems=false;
        //dd($this->showSectionsList);

        $this->service_group_id = null;
        $this->service_group_name = null;
        $this->service_group_code = null;

        
        $this->dispatchBrowserEvent('scrolltop');
        //dd($this->servicePackage);
    }

    public function packageAddOnFrom($id)
    {
        $this->servicePackageAddon = ServicePackage::with(['packageDetails'=> function($q) {
            //$q->where('isDefault', '=', 0);
            $q->orderBy('isDefault','DESC');
        }])->where(['Id'=>$id])->first();
        
        //dd($this->servicePackageAddon);
        $this->showPackageAddons=true;
        $this->dispatchBrowserEvent('openPckageAddOnsModal');
    }

    public function dashCustomerJobUpdate($job_number)
    {

        return redirect()->to('/customer-job-update/'.$job_number);
    }

    public function packageAddOnContinue($package){
        $this->selectedPackage = $package;
        $this->selectedPackageItems = [];
        foreach($package['package_details'] as $packageItem)
        {
            if($packageItem['ItemType']=='S'){
                $this->selectedPackageItems[]=$packageItem;
            }
        }
        //dd($this->selectedPackageItems);
        $this->showPackageAddons=true;
        $this->dispatchBrowserEvent('openPckageAddOnsModal');
        //dd($this->selectedPackageItems);
    }

    public function openServiceItems(){
        $this->selectServiceItems=true;
        $this->selectPackageMenu=false;
        $this->service_group_id = null;
        $this->service_group_name = null;
        $this->service_group_code = null;
        $this->showSectionsList=false;
        $this->showServiceSectionsList=false;
        $this->showPackageList=false;
    }
    
}