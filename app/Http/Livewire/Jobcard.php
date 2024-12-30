<?php

namespace App\Http\Livewire;

use Livewire\Component;

use thiagoalessio\TesseractOCR\TesseractOCR; 

use Illuminate\Http\Request;
use Livewire\WithFileUploads;

use App\Models\CustomerVehicle;
use App\Models\Vehicletypes;
use App\Models\StateList;
use App\Models\ServiceChecklist;
use App\Models\JobcardChecklistEntries;
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
use App\Models\WorkOrderJob;
use App\Models\Landlord;
use App\Models\InventoryItemMaster;
use App\Models\InventorySalesPrices;
use App\Models\Country;
use App\Models\PlateCategories;
use App\Models\PlateEmiratesCategory;
use App\Models\PlateCode;
use App\Models\ItemCategories;
use App\Models\InventorySubCategory;
use App\Models\InventoryBrand;
use App\Models\MaterialRequest;
use App\Models\VehicleMakes;
use App\Models\VehicleModels;
use App\Models\ItemMakeModel;

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
    public $editCustomerAndVehicle=false, $showCustomerForm=false, $showVehicleAvailable=false, $showPlateNumber=false;
    public $updateVehicleFormBtn = false, $addVehicleFormBtn=false, $cancelEdidAddFormBtn=false, $otherVehicleDetailsForm=false, $selectedCustomerVehicle=false;
    public $showServiceGroup = false, $showSectionsList=false, $selectedSectionName;
    public $showDiscountGroup=false, $showDiscountGroupForm=false, $updateDiscountGroupFormDiv=false, $showSaveCustomerButton=false, $sisterCompanies=false, $listCustomerDiscontGroups;
    public $selectedVehicleInfo;

    //FormValues
    public $customer_id, $customer_code, $name, $email, $customer_type=23, $customer_id_image;
    public $mobile, $plate_country = 'AE', $plate_state=2, $plateEmiratesCategories=[], $editPlateEmiratesCategories=[], $addPlateEmiratesCategories = [], $plateEmiratesCodes=[], $editplateEmiratesCodes=[], $addplateEmiratesCodes=[], $plate_category, $plate_code, $plate_number;
    public $plate_number_final, $vehicle_image,$listVehiclesMake, $vehicle_type, $make, $vehiclesModelList=[], $model, $chassis_number,$vehicle_km,$plate_number_image,$chaisis_image, $selected_vehicle_id, $propertyCode;

    //ListValues
    public $customers, $countryLists, $stateList, $customerTypeList, $vehicleTypesList, $servicesGroupList;

    //Service and itemms
    public $showServiceType = false, $showServicesitems = false, $selectServicesitems = false, $showServiceSectionsList=false;
    public $service_group_id, $service_group_name, $service_group_code, $sectionsLists, $sectionServiceLists=[], $station;
    public $service_sort=1;

    //Cart Details
    public $total, $tax, $grand_total, $paymentMethode, $job_number, $job_service_number, $cartItemCount=0, $cartItems = [], $quantity,$extra_note,$cartItemQty;
    public $showPayLaterCheckout=false, $successPage=false, $showCheckList=false, $showCheckout=false, $showFuelScratchCheckList=false, $showQLCheckList=false, $markCarScratch = false, $updateCustomerFormDiv = false;
    public $laborCustomerGroupLists=[], $selectedDiscountUnitId, $selectedDiscountCode, $selectedDiscountTitle, $selectedDiscountId,$discount_card_imgae, $discount_card_number, $discount_card_validity, $customerSelectedDiscountGroup, $customerDiscontGroupId, $customerDiscontGroupCode, $searchStaffId=false,$employeeId;

    public $checklistLabels = [], $checklistLabel = [], $fuel, $scratchesFound, $scratchesNotFound, $vImageR1, $vImageR2, $vImageF, $vImageB, $vImageL1, $vImageL2, $customerSignature;
    public $servicePackage, $packagePriceUpdate, $servicePackageAddon, $showPackageAddons=false;
    public $showCartSummary=false, $editCustomerVehicle=false, $addNewCustomerVehicle=false;
    public $edit_mobile, $edit_name, $edit_email, $edit_plate_number_image, $edit_plate_country, $edit_plate_state, $edit_plate_category, $edit_plate_code, $edit_plate_number, $edit_vehicle_image, $edit_vehicle_type, $edit_make, $edit_model, $edit_chaisis_image, $edit_chassis_number, $edit_vehicle_km;
    public $add_plate_number_image, $add_plate_country = 'AE', $add_plate_state, $add_plate_category, $add_plate_code, $add_plate_number, $add_vehicle_image, $add_vehicle_type, $add_make, $add_model, $add_chaisis_image, $add_chassis_number, $add_vehicle_km;
    public $turn_key_on_check_for_fault_codes, $start_engine_observe_operation, $reset_the_service_reminder_alert, $stick_update_service_reminder_sticker_on_b_piller, $interior_cabin_inspection_comments, $check_power_steering_fluid_level, $check_power_steering_tank_cap_properly_fixed, $check_brake_fluid_level, $brake_fluid_tank_cap_properly_fixed, $check_engine_oil_level, $check_radiator_coolant_level, $check_radiator_cap_properly_fixed, $top_off_windshield_washer_fluid, $check_windshield_cap_properly_fixed, $underHoodInspectionComments, $check_for_oil_leaks_engine_steering, $check_for_oil_leak_oil_filtering, $check_drain_lug_fixed_properly, $check_oil_filter_fixed_properly, $ubi_comments;
    public $totalDiscount;
    public $selectedPackage, $selectedPackageItems;
    public $selectServiceItems;
    public $staffavailable,$discountApplyMessage;

    public $quickLubeItemsList=[],$serviceItemsList=[], $quickLubeItemSearch='', $qlFilterOpen=false, $showQlItems=false, $showQlEngineOilItems=false, $showQlCategoryFilterItems=false, $itemQlCategories=[],  $ql_search_category, $ql_search_subcategory, $qlBrandsLists=[], $ql_search_brand, $ql_km_range;
    public $item_search_category, $itemCategories=[], $item_search_subcategory, $itemSubCategories =[], $item_search_brand, $itemBrandsLists=[], $itemSearchName, $ql_item_qty;
    public $editTenantCode, $discountCardApplyForm=false, $discountForm=false, $discountSearch=false;
    public $searchByMobileNumberBtn=false,$searchByPlateBtn=false, $searchByChaisisBtn=false, $shoe_discound_popup_image;

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
        //CustomerDiscountGroup::truncate();
        if($this->showPlateNumber)
        {
            //Get all state List
            $this->stateList = StateList::where(['CountryCode'=>$this->plate_country])->get();
            //dd($this->plate_state);
            if($this->plate_state)
            {
                switch ($this->plate_state) {
                    case 'Abu Dhabi':
                        $plateStateCode = 1;
                        $this->plate_category = '242';
                        break;
                    case 'Dubai':
                        $plateStateCode = 2;
                        $this->plate_category = '1';
                        break;
                    case 'Sharjah':
                        $plateStateCode = 3;
                        $this->plate_category = '103';
                        break;
                    case 'Ajman':
                        $plateStateCode = 4;
                        $this->plate_category = '122';
                        break;
                    case 'Umm Al-Qaiwain':
                        $plateStateCode = 5;
                        $this->plate_category = '134';
                        break;
                    case 'Ras Al-Khaimah':
                        $plateStateCode = 6;
                        $this->plate_category = '147';
                        break;
                    case 'Fujairah':
                        $plateStateCode = 7;
                        $this->plate_category = '169';
                        break;
                    
                    default:
                        $plateStateCode = 1;
                        $this->plate_category = '242';
                        break;
                }
                
                $this->plateEmiratesCategories = PlateEmiratesCategory::where([
                        'plateEmiratesId'=>$plateStateCode,'is_active'=>1,
                    ])->get();
                //dd($plateStateCode);
                if($this->plate_category){
                    $this->plateEmiratesCodes = PlateCode::where([
                        'plateEmiratesId'=>$plateStateCode,'plateCategoryId'=>$this->plate_category,'is_active'=>1,
                    ])->get();
                }
            }
            //Get all veicle type list
            $this->vehicleTypesList = Vehicletypes::orderBy('type_name','ASC')->get();
            //Get Vehicle Make List
            $this->listVehiclesMake = VehicleMakes::get();
            if($this->make){
                $this->vehiclesModelList = VehicleModels::where(['vehicle_make_id'=>$this->make])->get();
            }
        }
        else
        {
            $this->stateList = Null;
            $this->vehicleTypesList = Null;
            $this->listVehiclesMake = Null;
            $this->plateEmiratesCategories=[];
            $this->plateEmiratesCodes=[];
        }

        if($this->selectedCustomerVehicle)
        {
            $this->servicesGroupList = Development::select('DevelopmentCode as department_code','DevelopmentName as department_name','id','LandlordCode as station_code')->where(['Operation'=>true,'LandlordCode'=>Session::get('user')->station_code])->get();
        }
        else
        {
            $this->servicesGroupList = null;
        }

        if($this->selected_vehicle_id && $this->service_group_code)
        {
            $this->sectionsLists = Sections::select('id','PropertyCode','DevelopmentCode','PropertyNo','PropertyName','Operation')->where(['DevelopmentCode'=>$this->service_group_code])->get();
        }
        else
        {
            $this->sectionsLists = null;
        }

        //Get Service List Prices
        if($this->propertyCode)
        {
            $sectionServiceLists = LaborItemMaster::where(['Labor.ItemMaster.SectionCode'=>$this->propertyCode]);
            $sectionServiceLists = $sectionServiceLists->get();
            $sectionServicePriceLists = [];
            foreach($sectionServiceLists as $key => $sectionServiceList)
            {
                //dd($sectionServiceList);
                $sectionServicePriceLists[$key]['priceDetails'] = $sectionServiceList;
                if($this->customerDiscontGroupCode){
                    $sectionServicePriceLists[$key]['discountDetails'] = LaborSalesPrices::where(['ServiceItemId'=>$sectionServiceList->ItemId,'CustomerGroupCode'=>$this->customerDiscontGroupCode])->first();
                }
                else
                {
                    $sectionServicePriceLists[$key]['discountDetails']=null;
                }
            }
            $this->sectionServiceLists = $sectionServicePriceLists;
        }


        if($this->service_group_id==37 || $this->selectServiceItems)
        {
            $this->qlFilterOpen=true;
            $this->itemQlCategories = ItemCategories::where(['show_in'=>'q'])->get();
            
            $this->qlBrandsLists = InventoryBrand::where(['Active'=>1])->get();
            $this->dispatchBrowserEvent('selectSearchEvent'); 
        }
        else
        {
            $this->qlFilterOpen=false;
            $this->itemQlCategories = [];
            $this->qlBrandsLists = [];
        }

        if($this->showQlItems)
        {
            if($this->showQlCategoryFilterItems)
            {
                $qlMakeModelCategoryItems = ItemMakeModel::with(['itemInformation' => function ($query) {
                        $query->where('CategoryId', '=', $this->ql_search_category);
                    }])->where(['makeid'=>$this->selectedVehicleInfo->make,'modelid'=>$this->selectedVehicleInfo->model])->get();

                $qlMakeModelCatItmDetails = [];
                foreach($qlMakeModelCategoryItems as $key => $qlItemMakeModelItem){
                    
                    foreach($qlItemMakeModelItem->itemInformation as $qlMakeModelCatItm)
                    {
                        $qlMakeModelCatItmDetails[$key]['priceDetails'] = $qlMakeModelCatItm;
                        if($this->customerDiscontGroupCode){
                            $qlMakeModelCatItmDetails[$key]['discountDetails'] = InventorySalesPrices::where(['ServiceItemId'=>$qlMakeModelCatItm->ItemId,'CustomerGroupCode'=>$this->customerDiscontGroupCode])->first();
                        }
                        else
                        {
                            $qlMakeModelCatItmDetails[$key]['discountDetails']=null;
                        }
                        //dd($sectionServicePriceLists[$key]);
                    }
                }
                //dd($qlMakeModelCatItmDetails);
                $this->quickLubeItemsList = $qlMakeModelCatItmDetails;
            }
            else{
                $quickLubeItemsNormalList = InventoryItemMaster::whereIn("InventoryPosting",['1','7'])->where('Active','=',1);
                if($this->showQlEngineOilItems){
                    $quickLubeItemsNormalList = $quickLubeItemsNormalList->where(['KM'=>$this->ql_km_range,'BrandId'=>$this->ql_search_brand]);
                }
                if($this->quickLubeItemSearch){
                    $quickLubeItemsNormalList = $quickLubeItemsNormalList->where('ItemName','like',"%{$this->quickLubeItemSearch}%");
                }
                $quickLubeItemsNormalList=$quickLubeItemsNormalList->get();
                $qlItemPriceLists = [];
                foreach($quickLubeItemsNormalList as $key => $qlItemsList)
                {
                    $qlItemPriceLists[$key]['priceDetails'] = $qlItemsList;
                    if($this->customerDiscontGroupCode){
                        $qlItemPriceLists[$key]['discountDetails'] = InventorySalesPrices::where(['ServiceItemId'=>$qlItemsList->ItemId,'CustomerGroupCode'=>$this->customerDiscontGroupCode])->first();
                    }
                    else
                    {
                        $qlItemPriceLists[$key]['discountDetails']=null;
                    }
                    //dd($sectionServicePriceLists[$key]);
                }
                $this->quickLubeItemsList = $qlItemPriceLists;
            }

        }
        else
        {
            $this->quickLubeItemsList=[];
        }



        
        
        


        

        if($this->customer_id && $this->selected_vehicle_id){
            $this->cartItems = CustomerServiceCart::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->selected_vehicle_id])->get();

            $this->cartItemCount = count($this->cartItems); 
            if(count($this->cartItems)>0)
            {
                $this->cardShow=true;
            }
            else
            {
                $this->cardShow=false;
            }
        }

        $this->dispatchBrowserEvent('selectSearchEvent'); 

        return view('livewire.jobcard');
    }

    public function searchQuickLubeItem(){
        $validatedData = $this->validate([
            'quickLubeItemSearch' => 'required',
        ]);

        $this->showQlItems=true;
        $this->showQlCategoryFilterItems=false;
        
    }

    public function qlItemkmRange($kmRange)
    {
        $validatedData = $this->validate([
            'ql_search_brand' => 'required',
        ]);
        $this->ql_km_range=$kmRange;
        $this->showQlItems=true;
        $this->showQlEngineOilItems=true;
        $this->showQlCategoryFilterItems=false;
        
        $this->dispatchBrowserEvent('scrolltopQl');
    }

    public function qlCategorySelect(){
        $this->showQlItems=true;
        $this->showQlCategoryFilterItems=true;
        $this->dispatchBrowserEvent('scrolltopQl');
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
        
        $this->selected_vehicle_id=null;
        $this->service_group_code=null;
        $this->propertyCode=null;
        $this->customerDiscontGroupId=null;
        $this->customerDiscontGroupCode=null;

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
                $this->showPlateNumber=false;
                $this->searchByMobileNumberBtn=true;
                $this->searchByPlateBtn=false;
                $this->searchByChaisisBtn=false;
                break;
            case '2':
                $this->searchByPlateNumber=true;
                $this->showSearchByMobileNumber=false;
                $this->showPlateNumber=true;
                $this->showSearchByPlateNumberButton=true;
                $this->searchByMobileNumberBtn=false;
                $this->searchByPlateBtn=true;
                $this->searchByChaisisBtn=false;
                break;
            case '3':
                $this->searchByChaisis=true;
                $this->searchByChaisisForm=true;
                $this->showSearchByMobileNumber=false;
                $this->showPlateNumber=false;
                $this->showSearchByChaisisButton=true;
                $this->searchByMobileNumberBtn=false;
                $this->searchByPlateBtn=false;
                $this->searchByChaisisBtn=true;
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

            $this->showPlateNumber=false;
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
            $this->showPlateNumber=true;
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
            $this->showPlateNumber=true;
            $this->showVehicleAvailable=true;
        }
        else
        {
            $this->showPlateNumber=true;
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
            $this->showPlateNumber=true;
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

            if (substr($this->mobile, 0, 1) == '0') {
                $this->mobile = mb_substr($this->mobile, 1);
            }

            

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
        $this->customers=null;
        $customers = CustomerVehicle::with(['customerInfoMaster','makeInfo','modelInfo','customerDiscountLists'])->where(['is_active'=>1,'id'=>$vehicleId,'customer_id'=>$customerId])->first();

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

        
        $pendingjob = CustomerJobCards::where(['job_create_status'=>0,'customer_id'=>$this->customer_id,'vehicle_id'=>$this->selected_vehicle_id])->first();
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

        if($this->service_group_id !=37 || $this->showQlItems == true)
        {
            $this->showQlItems=false;
        }

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
        $this->showQlItems=false;

        
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
        $this->showServiceGroup=false;
        $this->showCheckList=false;
        $this->showCheckout=false;
        $this->showPayLaterCheckout=false;
        $this->successPage=false;
        $this->showSaveCustomerButton=false;

        $this->mobile = $this->selectedVehicleInfo->customerInfoMaster['Mobile'];
        $this->name = $this->selectedVehicleInfo->customerInfoMaster['TenantName'];
        $this->email = $this->selectedVehicleInfo->customerInfoMaster['Email'];
        $this->customer_id = $this->selectedVehicleInfo->customerInfoMaster['TenantId'];
        $this->customer_code = $this->selectedVehicleInfo->customerInfoMaster['TenantCode'];
        $this->plate_country = $this->selectedVehicleInfo->plate_country;
        $this->plate_state = $this->selectedVehicleInfo->plate_state;
        $this->plate_category = $this->selectedVehicleInfo->plate_category;
        $this->plate_code = $this->selectedVehicleInfo->plate_code;
        $this->plate_number = $this->selectedVehicleInfo->plate_number;
        $this->vehicle_type = $this->selectedVehicleInfo->vehicle_type;
        $this->make = $this->selectedVehicleInfo->make;
        $this->model = $this->selectedVehicleInfo->model;
        $this->chassis_number = $this->selectedVehicleInfo->chassis_number;
        $this->vehicle_km = $this->selectedVehicleInfo->vehicle_km;
        //dd($this->selectedVehicleInfo);

        $this->showForms=true;
        $this->showByMobileNumber=true;
        $this->showCustomerForm=true;
        $this->showPlateNumber=true;
        $this->searchByChaisis=true;
        $this->searchByChaisisForm=true;
        $this->otherVehicleDetailsForm=true;
        $this->updateVehicleFormBtn=true;
        $this->cancelEdidAddFormBtn=true;
    }

    public function updateVehicleCustomer(){
        $validatedData = $this->validate([
            //'edit_mobile' => 'required',
            //'edit_name' => 'required',
            //'edit_email' => 'required',
            //'edit_plate_number_image' => 'required|image|mimes:jpg,jpeg,png,svg,gif|max:10048',
            'plate_country'=>'required',
            'plate_state'=>'required',
            'plate_code'=>'required',
            'plate_number'=>'required',
            //'edit_vehicle_image' => 'required|image|mimes:jpg,jpeg,png,svg,gif|max:10048',
            'vehicle_type' => 'required',
            'make' => 'required',
            'model'=> 'required',
        ]);

        /*$customerUpdateData['mobile'] = $this->edit_mobile;
        $customerUpdateData['name'] = $this->edit_name;
        $customerUpdateData['email'] = $this->edit_email;
        Customers::where(['id'=>$this->customer_id])->update($customerUpdateData);



        $customerUpdateData['Mobile']=isset($this->edit_mobile)?$this->edit_mobile:'';
        $customerUpdateData['TenantName']=isset($this->edit_name)?$this->edit_name:'';
        $customerUpdateData['Email']=isset($this->edit_email)?$this->edit_email:'';
        //$insertCustmoerData['customer_type']=isset($this->customer_type)?$this->customer_type:'';
        $customerUpdateData['Active']=1;
        //dd($insertCustmoerData);*/
        if($this->customer_code){
            $tenantcode = $this->customer_code;
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
        }
        if($this->selected_vehicle_id){

            $imagename['vehicle_image']='';
            if($this->vehicle_image)
            {
                $customerVehicleUpdate['vehicle_image']=$this->edit_vehicle_image->store('vehicle', 'public');
            }

            $imagename['plate_number_image']='';
            if($this->plate_number_image)
            {
                $customerVehicleUpdate['plate_number_image'] = $this->plate_number_image->store('plate_number', 'public');
            }

            $imagename['chaisis_image']='';
            if($this->chaisis_image)
            {
                $customerVehicleUpdate['chaisis_image'] = $this->chaisis_image->store('chaisis_image', 'public');
            }

            if($this->customer_id)
            {
                $customerId = $this->customer_id;
            }
            

            $customerVehicleUpdate['customer_id']=$customerId;
            $customerVehicleUpdate['vehicle_type']=$this->vehicle_type;
            $customerVehicleUpdate['make']=$this->make;
            $customerVehicleUpdate['model']=$this->model;
            $customerVehicleUpdate['plate_country']=$this->plate_country;
            $customerVehicleUpdate['plate_state']=$this->plate_state;
            $customerVehicleUpdate['plate_code']=$this->plate_code;
            $customerVehicleUpdate['plate_number']=$this->plate_number;
            $customerVehicleUpdate['plate_number_final']=$this->plate_state.' '.$this->plate_code.' '.$this->plate_number;
            $customerVehicleUpdate['chassis_number']=isset($this->chassis_number)?$this->chassis_number:'';
            $customerVehicleUpdate['vehicle_km']=isset($this->vehicle_km)?$this->vehicle_km:'';
            $customerVehicleUpdate['created_by']=Session::get('user')->id;
            //dd($customerVehicleUpdate);
            CustomerVehicle::where(['id'=>$this->selected_vehicle_id])->update($customerVehicleUpdate);
        }

        $this->selectVehicle($customerId,$this->selected_vehicle_id);

        $this->selectedCustomerVehicle=true;
        $this->editCustomerVehicle=false;
        session()->flash('success', 'Customer vehicle details updated Successfully !');
    }

    public function closeUpdateVehicleCustomer(){
        $this->selectVehicle($this->customer_id,$this->selected_vehicle_id);
    }

    public function addNewVehicle(){
        
        $this->selectedCustomerVehicle=false;
        $this->showServiceGroup=false;
        $this->showCheckList=false;
        $this->showCheckout=false;
        $this->showPayLaterCheckout=false;
        $this->successPage=false;
        $this->showSaveCustomerButton=false;
        $this->showByMobileNumber=false;
        $this->updateVehicleFormBtn=false;
        $this->showCustomerForm=false;

        $this->mobile = $this->selectedVehicleInfo->customerInfoMaster['Mobile'];
        $this->name = $this->selectedVehicleInfo->customerInfoMaster['TenantName'];
        $this->email = $this->selectedVehicleInfo->customerInfoMaster['Email'];
        $this->customer_id = $this->selectedVehicleInfo->customerInfoMaster['TenantId'];
        $this->customer_code = $this->selectedVehicleInfo->customerInfoMaster['TenantCode'];
        $this->plate_country = 'AE';
        $this->plate_state = null;
        $this->plate_category = null;
        $this->plate_code = null;
        $this->plate_number = null;
        $this->vehicle_type = null;
        $this->make = null;
        $this->model = null;
        $this->chassis_number = null;
        $this->vehicle_km = null;
        //dd($this->selectedVehicleInfo);

        $this->showForms=true;
        $this->showPlateNumber=true;
        $this->searchByChaisis=true;
        $this->searchByChaisisForm=true;
        $this->otherVehicleDetailsForm=true;
        $this->addVehicleFormBtn=true;
        $this->cancelEdidAddFormBtn=true;


    }
    public function closeAddNewVehicleCustomer(){
        $this->selectedCustomerVehicle=true;
        $this->addNewCustomerVehicle=false;
    }

    public function addNewCustomerVehicle(){
        
        $validatedData = $this->validate([
            //'edit_plate_number_image' => 'required|image|mimes:jpg,jpeg,png,svg,gif|max:10048',
            'plate_country'=>'required',
            'plate_state'=>'required',
            'plate_code'=>'required',
            'plate_number'=>'required',
            //'vehicle_image' => 'required|image|mimes:jpg,jpeg,png,svg,gif|max:10048',
            'vehicle_type' => 'required',
            'make' => 'required',
            'model'=> 'required',
        ]);

        
        if($this->vehicle_image)
        {
            $customerVehicleInsert['vehicle_image'] = $this->vehicle_image->store('vehicle', 'public');
        }
        if($this->add_plate_number_image)
        {
            $customerVehicleInsert['plate_number_image'] = $this->plate_number_image->store('plate_number', 'public');
        }
        if($this->add_chaisis_image)
        {
            $customerVehicleInsert['chaisis_image'] = $this->chaisis_image->store('chaisis_image', 'public');
        }

        $customerVehicleInsert['customer_id']=$this->customer_id;
        $customerVehicleInsert['vehicle_type']=$this->vehicle_type;
        $customerVehicleInsert['make']=$this->make;
        $customerVehicleInsert['model']=$this->model;
        $customerVehicleInsert['plate_country']=$this->plate_country;
        $customerVehicleInsert['plate_state']=$this->plate_state;
        $customerVehicleInsert['plate_code']=$this->plate_code;
        $customerVehicleInsert['plate_number']=$this->plate_number;
        $customerVehicleInsert['plate_number_final']=$this->plate_state.' '.$this->plate_code.' '.$this->plate_number;
        $customerVehicleInsert['chassis_number']=isset($this->chassis_number)?$this->chassis_number:'';
        $customerVehicleInsert['vehicle_km']=isset($this->vehicle_km)?$this->vehicle_km:'';
        $customerVehicleInsert['created_by']=Session::get('user')->id;
        $customerVehicleInsert['is_active']=1;
        

        //dd($customerVehicleInsert);
        $newcustomer = CustomerVehicle::create($customerVehicleInsert);
        //dd($newcustomer->id);
        //dd($this->customer_id.'-'.$newcustomer->id);
        $this->selectVehicle($this->customer_id,$newcustomer->id);
        //$this->selectedCustomerVehicle=true;
        $this->addNewCustomerVehicle=false;
        //$this->searchResult();
        session()->flash('success', 'New Customer vehicle added Successfully !');
    }

    public function addtoCart($servicePrice,$discount)
    {
        //dd($discount);
        $servicePrice = json_decode($servicePrice);
        $discountPrice = json_decode($discount);
        $customerBasketCheck = CustomerServiceCart::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->selected_vehicle_id,'item_id'=>$servicePrice->ItemId]);
        if($customerBasketCheck->count())
        {

            $customerBasketCheck->increment('quantity', 1);
            if($discountPrice!=null){
                $cartUpdate['price_id']=$discountPrice->PriceID;
                $cartUpdate['customer_group_id']=$discountPrice->CustomerGroupId;
                $cartUpdate['customer_group_code']=$discountPrice->CustomerGroupCode;
                $cartUpdate['min_price']=$discountPrice->MinPrice;
                $cartUpdate['max_price']=$discountPrice->MaxPrice;
                $cartUpdate['start_date']=$discountPrice->StartDate;
                $cartUpdate['end_date']=$discountPrice->EndDate;
                $cartUpdate['discount_perc']=$discountPrice->DiscountPerc;
            }
            $customerBasketResult =  $customerBasketCheck->first();
            CustomerServiceCart::find($customerBasketResult->id)->update($cartUpdate);
        }
        else
        {
            $cartInsert = [
                'customer_id'=>$this->customer_id,
                'vehicle_id'=>$this->selected_vehicle_id,
                'item_id'=>$servicePrice->ItemId,
                'item_code'=>$servicePrice->ItemCode,
                'cart_item_type'=>1,
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
               $cartInsert['extra_note']=isset($this->extra_note[$servicePrice->ItemId])?$this->extra_note[$servicePrice->ItemId]:null; 
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
        



        $this->dispatchBrowserEvent('closeServicesListModal');

        //dd($this->sectionServiceLists);
        /*$this->dispatchBrowserEvent('swal:modal', [
            'type' => 'success',
            'message' => 'Added to Cart Successfully',
            'text' => 'service added..!',
            'cartitemcount'=>\Cart::getTotalQuantity()
        ]);*/
        session()->flash('cartsuccess', 'Service is Added to Cart Successfully !');
    }


    public function addtoCartItem($items,$discount)
    {
        $items = json_decode($items,true);
        //dd($items);
        $discountPrice = json_decode($discount,true);
        $customerBasketCheck = CustomerServiceCart::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->selected_vehicle_id,'item_id'=>$items['ItemId']]);
        if($customerBasketCheck->count())
        {
            $customerBasketCheck->increment('quantity', 1);
        }
        else
        {
            $cartInsert = [
                'customer_id'=>$this->customer_id,
                'vehicle_id'=>$this->selected_vehicle_id,
                'item_id'=>$items['ItemId'],
                'item_code'=>$items['ItemCode'],
                'company_code'=>$items['CompanyCode'],
                'category_id'=>$items['CategoryId'],
                'sub_category_id'=>$items['SubCategoryId'],
                'brand_id'=>$items['BrandId'],
                'bar_code'=>$items['BarCode'],
                'item_name'=>$items['ItemName'],
                'cart_item_type'=>2,
                'description'=>$items['Description'],
                'division_code'=>"LL/00004",
                'department_code'=>"PP/00037",
                'section_code'=>"U-000225",
                'unit_price'=>$items['UnitPrice'],
                'quantity'=>isset($this->ql_item_qty[$items['ItemId']])?$this->ql_item_qty[$items['ItemId']]:1,
                'created_by'=>Session::get('user')->id,
                'created_at'=>Carbon::now(),
            ];
            if($this->extra_note!=null){
               $cartInsert['extra_note']=isset($this->extra_note[$items['ItemId']])?$this->extra_note[$items['ItemId']]:null; 
            }
            if($discountPrice!=null){
                $cartInsert['price_id']=$discountPrice['PriceID'];
                $cartInsert['customer_group_id']=$discountPrice['CustomerGroupId'];
                $cartInsert['customer_group_code']=$discountPrice['CustomerGroupCode'];
                $cartInsert['min_price']=$discountPrice['MinPrice'];
                $cartInsert['max_price']=$discountPrice['MaxPrice'];
                $cartInsert['start_date']=$discountPrice['StartDate'];
                $cartInsert['end_date']=$discountPrice['EndDate'];
                $cartInsert['discount_perc']=$discountPrice['DiscountPerc'];
            }
            CustomerServiceCart::insert($cartInsert);
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
    }

    public function cartSetDownQty($cartId){
        CustomerServiceCart::find($cartId)->decrement('quantity');
    }
    public function cartSetUpQty($cartId){
        CustomerServiceCart::find($cartId)->increment('quantity');
    }

    public function clearAllCart()
    {
        CustomerServiceCart::where(['customer_id'=>$this->customer_id, 'vehicle_id'=>$this->selected_vehicle_id])->delete();
        
        session()->flash('cartsuccess', 'All Service Cart Clear Successfully !');
    }

    public function clickDiscountGroup(){
        
        $this->discountSearch=true;
        $this->discountForm=false;
        $this->laborCustomerGroupLists = LaborCustomerGroup::get();
        //dd($this->laborCustomerGroupLists);

        if($this->customer_id)
        {
            $this->listCustomerDiscontGroups = CustomerDiscountGroup::where(['customer_id'=>$this->customer_id,'is_active'=>1])->get();
        }
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
        //dd($discountGroup);
        $this->selectedDiscountUnitId = $discountGroup['UnitId'];
        $this->selectedDiscountCode = $discountGroup['Code'];
        $this->selectedDiscountTitle = $discountGroup['Title'];
        $this->selectedDiscountId = $discountGroup['Id'];

        if($discountGroup['GroupType']==2)
        {
            $this->discountCardApplyForm=false;
            $this->discountForm=false;
            
            $customerDiscontGroupInfo = [
                'customer_id'=>$this->customer_id,
                'vehicle_id'=>$this->selected_vehicle_id,
                'discount_id'=>$this->selectedDiscountId,
                'discount_unit_id'=>$this->selectedDiscountUnitId,
                'discount_code'=>$this->selectedDiscountCode,
                'discount_title'=>$this->selectedDiscountTitle,
                //'discount_card_number'=>$this->discount_card_number,
                //'discount_card_validity'=>$this->discount_card_validity,
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
            $this->discountSearch=false;
            $this->discountForm=true;
            
            if($discountGroup['Id']==8 || $discountGroup['Id']==9){
                //dd($this->searchStaffId);
                $this->searchStaffId=true;
                $this->discountCardApplyForm=false;
            }
            else
            {
                $this->discountCardApplyForm=true;
                $this->searchStaffId=false;
            }
        }
        //$this->dispatchBrowserEvent('closeDiscountGroupModal');
    }

    public function checkStaffDiscountGroup(){
        $proceeddisctount=false;
        $validatedData = $this->validate([
             'employeeId' => 'required',
        ]);
        $this->employeeId = sprintf('%06d', $this->employeeId);
        
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
                'employee_code'=>$customerStaffIdResult['employee_code'],
                'employee_name'=>$customerStaffIdResult['Name'],
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
            $this->selectVehicle($this->customer_id,$this->selected_vehicle_id);
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
            //dd($customerStaffIdResult);
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

    public function applyDiscountGroup($discountGroup){
        $discountapplied=false;
        if($discountGroup['discount_id']==8 || $discountGroup['discount_id']==9)
        {
            $employee_code = sprintf('%06d', $discountGroup['employee_code']);
        
            //Call Procedure for Customer Staff ID Check
            $customerStaffIdCheck = DB::select('EXEC GetEmployee @employee_code = "'.$employee_code.'"', [
                $employee_code,
            ]);
            if($customerStaffIdCheck)
            {
                $this->customerSelectedDiscountGroup = $discountGroup;
                $this->customerDiscontGroupId = $discountGroup['discount_id'];
                $this->customerDiscontGroupCode = $discountGroup['discount_code'];
                $discountapplied=true;
            }
            else
            {
                $this->discountApplyMessage="Employee does not exist..!";
                $this->customerSelectedDiscountGroup = null;
                $this->customerDiscontGroupId = null;
                $this->customerDiscontGroupCode = null;
            }
        }
        else
        {
            //dd($discountGroup);
            $end = Carbon::parse($discountGroup['discount_card_validity']);
            if(Carbon::now()->diffInDays($end)<0){
                $this->discountApplyMessage="Employee does not exist..!";
            }
            else
            {
                $this->customerSelectedDiscountGroup = $discountGroup;
                $this->customerDiscontGroupId = $discountGroup['discount_id'];
                $this->customerDiscontGroupCode = $discountGroup['discount_code'];
                $discountapplied=true;    
            }
            
        }

        if($discountapplied==true)
        {
            foreach($this->cartItems as $items)
            {
                if($items->cart_item_type==1){
                    
                    $discountSalePriceQuery = LaborItemMaster::with(['discountServicePrice' => function ($query) {
                        $query->where('CustomerGroupCode', '=', $this->customerDiscontGroupCode);
                        //$query->where('StartDate', '<=', Carbon::now());
                        //$query->where('EndDate', '=', null);
                    }])->where(['ItemId'=>$items->item_id])->first();
                    $discountSalePrice= $discountSalePriceQuery->discountServicePrice;

                }
                else if($items->cart_item_type==2)
                {
                    $discountSalePriceQuery = InventoryItemMaster::with(['discountItemPrice' => function ($query) {
                        $query->where('CustomerGroupCode', '=', $this->customerDiscontGroupCode);
                        //$query->where('StartDate', '<=', Carbon::now());
                        //$query->where('EndDate', '=', null);
                    }])->where(['ItemId'=>$items->item_id])->first();
                    $discountSalePrice= $discountSalePriceQuery->discountItemPrice;
                }

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
    }

    public function popUpDiscountImage($image){
        if($image){
            $this->dispatchBrowserEvent('showPopUpDiscountImage');
            $this->shoe_discound_popup_image = $image;
        }
    }

    public function openServiceGroup(){
        $this->showServiceGroup=true;
        $this->showCheckList=false;
        $this->showCheckout=false;
        $this->showPayLaterCheckout=false;
        $this->successPage=false;
    }

    public function checkOutProceed($customer_id, $vehicle_id)
    {
        return redirect()->to('/chustomer-checkout/'.$customer_id.'/'.$vehicle_id);
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

        
        //save checklist
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
        if($this->showQLCheckList==true){
            $customerjobData['ql_km_range']=$this->ql_km_range;
        }
        //dd($this->customerSelectedDiscountGroup);
        if($this->customerSelectedDiscountGroup)
        {
            $customerjobData['customer_discount_id']=$this->customerSelectedDiscountGroup['id'];
            $customerjobData['discount_id']=$this->customerSelectedDiscountGroup['discount_id'];
            $customerjobData['discount_unit_id']=$this->customerSelectedDiscountGroup['discount_unit_id'];
            $customerjobData['discount_code']=$this->customerSelectedDiscountGroup['discount_code'];
            $customerjobData['discount_title']=$this->customerSelectedDiscountGroup['discount_title'];
            /*'discount_percentage',
            'discount_amount'*/
        }
        $customerjobId = CustomerJobCards::create($customerjobData);
            $this->job_number = 'JOB-'.Session::get('user')->stationName['Abbreviation'].'-'.sprintf('%08d', $customerjobId->id);


        CustomerJobCards::where(['id'=>$customerjobId->id])->update(['job_number'=>$this->job_number]);

        //dd($cartDetails);
        $meterialRequestItems=[];
        $passmetrialRequest = false;
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
            $customerJobServiceData['service_item_type']=$cartData->cart_item_type;
            //dd($customerJobServiceData);

            if($this->customerSelectedDiscountGroup)
            {
                $customerJobServiceData['customer_discount_id']=$this->customerSelectedDiscountGroup['id'];
                $customerJobServiceData['discount_id']=$this->customerSelectedDiscountGroup['discount_id'];
                $customerJobServiceData['discount_unit_id']=$this->customerSelectedDiscountGroup['discount_unit_id'];
                $customerJobServiceData['discount_code']=$this->customerSelectedDiscountGroup['discount_code'];
                $customerJobServiceData['discount_title']=$this->customerSelectedDiscountGroup['discount_title'];
                $customerJobServiceData['discount_percentage'] = $cartData->discount_perc;
                $customerJobServiceData['discount_amount'] = round((($cartData->discount_perc/100)*$cartData->unit_price),2);
            }
            
            $customerJobServiceId = CustomerJobCardServices::create($customerJobServiceData);
            
            CustomerJobCardServiceLogs::create([
                'job_number'=>$this->job_number,
                'job_status'=>1,
                'job_departent'=>1,
                'job_description'=>json_encode($customerJobServiceData),
                'customer_job__card_service_id'=>$customerJobServiceId->id,
                'created_by'=>Session::get('user')->id,
                'created_at'=>Carbon::now(),
            ]);
            
            if($cartData->cart_item_type==2){

                $passmetrialRequest = true;
                //$meterialRequestItems= '';
                $meterialRequestItems = MaterialRequest::create([
                    'sessionId'=>$this->job_number,
                    'ItemCode'=>$cartData->item_code,
                    'ItemName'=>$cartData->item_name,
                    'QuantityRequested'=>$cartData->quantity,
                    'Activity2Code'=>Session::get('user')->station_code
                ]);
            }
            

        }

        WorkOrderJob::create(
                [
                    "DocumentCode"=>$this->job_number,
                    "DocumentDate"=>$customerjobData['job_date_time'],
                    "Status"=>"A",
                    "LandlordCode"=>Session::get('user')->station_code,
                ]
            );

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

        if($passmetrialRequest==true)
        {
            try {
                DB::select("EXEC [Inventory].[MaterialRequisition.Update] @companyCode = 'PF/00001', @documentCode = null, @documentDate = '".$customerjobData['job_date_time']."', @SessionId = '".$this->job_number."', @sourceType = 'J', @sourceCode = '".$this->job_number."', @locationId = '0', @referenceNo = '".$this->job_number."', @LandlordCode = '".Session::get('user')->station_code."', @propertyCode = 'PP/00037', @UnitCode = 'U-000225', @IsApprove = '1', @doneby = 'admin', @documentCode_out = null ");

                /*'division_code'=>"LL/00004",
                'department_code'=>"PP/00037",
                'section_code'=>"U-000225",*/


            } catch (\Exception $e) {
                //return $e->getMessage();
            }
        }


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

        $mobileNumber = '971'.substr($customerjobs->customerInfo['Mobile'], -9);
        //$mobileNumber = substr($customerjobs->mobile, -9);
        $paymentmode = null;
        if($mode=='link')
        {
            $paymentmode = "O";
            $paymentLink = $this->sendPaymentLink($customerjobs);
            $paymentResponse = json_decode((string) $paymentLink->getBody()->getContents(), true);
            $merchant_reference = $paymentResponse['merchant_reference'];
            //dd($merchant_reference);
            if(array_key_exists('payment_redirect_link', $paymentResponse))
            {
                //dd(SMS_URL."?user=".SMS_PROFILE_ID."&pwd=".SMS_PASSWORD."&senderid=".SMS_SENDER_ID."&CountryCode=971&mobileno=".$mobileNumber."&msgtext=".urlencode('Job Id #'.$job_number.' is processing, Please click complete payment '.$paymentResponse['payment_redirect_link']));
                
                $response = Http::get("https://mshastra.com/sendurlcomma.aspx?user=20092622&pwd=buhaleeba@123&senderid=BuhaleebaRE&mobileno=".$mobileNumber."&msgtext=".urlencode('Job Id #'.$job_number.' is processing, Please click complete payment '.$paymentResponse['payment_redirect_link'])."&CountryCode=ALL");

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
            $paymentmode = "O";
            $customerjobId = CustomerJobCards::where(['job_number'=>$job_number])->update(['payment_type'=>2,'payment_request'=>'card payment','job_create_status'=>1]);

            $response = Http::get("https://mshastra.com/sendurlcomma.aspx?user=20092622&pwd=buhaleeba@123&senderid=BuhaleebaRE&mobileno=".$mobileNumber."&msgtext=".urlencode('Job Id #'.$job_number.' is processing, Complete your payment and proceed. Visit '.url('qr/'.$job_number).' for the updates and gate pass')."&CountryCode=ALL");

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
            $paymentmode = "C";
            $customerjobId = CustomerJobCards::where(['job_number'=>$job_number])->update(['payment_type'=>3,'payment_request'=>'cash payment','job_create_status'=>1]);

            $response = Http::get("https://mshastra.com/sendurlcomma.aspx?user=20092622&pwd=buhaleeba@123&senderid=BuhaleebaRE&mobileno=".$mobileNumber."&msgtext=".urlencode('Job Id #'.$job_number.' is processing, Visit '.url('qr/'.$job_number).' for the updates and gate pass')."&CountryCode=ALL");

            CustomerServiceCart::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->selected_vehicle_id])->delete();

            $this->successPage=true;
            $this->showCheckout =false;
            $this->cardShow=false;
            $this->showServiceGroup=false;
            $this->showPayLaterCheckout=false;
            $this->selectedCustomerVehicle=false;
        }
        try {
            //DB::select('EXEC [dbo].[CreateFinancialEntries_Operation] @jobnumber = "'.$job_number.'", @doneby = "'.Session::get('user')->id.'", @stationcode  = "'.Session::get('user')->station_code.'", @paymentmode = "'.$paymentmode.'", @customer_id = "'.$customerjobs->customer_id.'" ');
        } catch (\Exception $e) {
            //return $e->getMessage();
        }


    }

    public function sendPaymentLink($customerjobs)
    {
        //dd($customerjobs);
        $exp_date = Carbon::now('+10:00')->format('Y-m-d\TH:i:s\Z');
        $order_billing_name = $customerjobs->customerInfo['TenantName'];
        $order_billing_phone = $customerjobs->customerInfo['Mobile'];
        $order_billing_email = $customerjobs->customerInfo['Email']; 
        $total = round(($customerjobs->grand_total),2);
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
                "amount"=>$total,
                //"amount"=>1,
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
            //dd(config('global.paymenkLink_payment_url'));
        $response = Http::withBasicAuth('onlinewebtutor', 'admin123')->post(config('global.paymenkLink_payment_url'),$arrData);
        //dd($response);
        return $response;
    }

    public function payLater()
    {
        if($this->job_number==Null){
            $this->createJob();
        }
        CustomerJobCards::where(['job_number'=>$this->job_number])->update(['job_create_status'=>0]);
        CustomerServiceCart::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->selected_vehicle_id])->delete();
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
        $this->showQlItems=false;
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
        $this->showQlItems=false;
    }

    public function dearchServiceItems(){
        $validatedData = $this->validate([
            'item_search_category' => 'required',
            'item_search_subcategory' => 'required',
        ]);
        $inventoryItemMasterLists = InventoryItemMaster::whereIn("InventoryPosting",['1','7'])->where('Active','=',1);
        if($this->item_search_category){
            $inventoryItemMasterLists = $inventoryItemMasterLists->where(['CategoryId'=>$this->item_search_category]);
        }
        if($this->item_search_subcategory){
            $inventoryItemMasterLists = $inventoryItemMasterLists->where(['SubCategoryId'=>$this->item_search_subcategory]);
        }
        if($this->item_search_brand){
            $inventoryItemMasterLists = $inventoryItemMasterLists->where(['BrandId'=>$this->item_search_brand]);
        }
        if($this->itemSearch){
            $inventoryItemMasterLists = $inventoryItemMasterLists->where('ItemName','like',"%{$this->itemSearchName}%");
        }
        $inventoryItemMasterLists=$inventoryItemMasterLists->get();
        $itemPriceLists = [];
        foreach($inventoryItemMasterLists as $key => $itemMasterList)
        {
            $itemPriceLists[$key]['priceDetails'] = $itemMasterList;
            if($this->customerDiscontGroupCode){
                $qlItemPriceLists[$key]['discountDetails'] = InventorySalesPrices::where(['ServiceItemId'=>$itemMasterList->ItemId,'CustomerGroupCode'=>$this->customerDiscontGroupCode])->first();
            }
            else
            {
                $itemPriceLists[$key]['discountDetails']=null;
            }
            //dd($sectionServicePriceLists[$key]);
        }
        $this->serviceItemsList = $itemPriceLists;
    }

    
    
}
