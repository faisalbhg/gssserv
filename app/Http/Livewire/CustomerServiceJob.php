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


use App\Models\CustomerVehicle;
use App\Models\Development;
use App\Models\Sections;
use App\Models\LaborItemMaster;
use App\Models\LaborSalesPrices;
use App\Models\CustomerServiceCart;
use App\Models\ItemCategories;
use App\Models\InventorySubCategory;
use App\Models\InventoryBrand;
use App\Models\InventoryItemMaster;
use App\Models\InventorySalesPrices;
use App\Models\ItemMakeModel;
use App\Models\LaborCustomerGroup;
use App\Models\CustomerDiscountGroup;
use App\Models\StateList;
use App\Models\PlateCode;
use App\Models\Vehicletypes;
use App\Models\VehicleModels;
use App\Models\VehicleMakes;
use App\Models\ServicePackage;
use App\Models\ServicePackageDetail;
use App\Models\PackageBookings;
use App\Models\PackageBookingServices;
use App\Models\PackageBookingServiceLogs;
use App\Models\CustomerJobCards;
use App\Models\CustomerJobCardServices;
use App\Models\ServiceBundleType;
use App\Models\ServiceBundle;
use App\Models\ServiceBundleDiscountedPrice;
use App\Models\Landlord;


class CustomerServiceJob extends Component
{
    use WithFileUploads;
    public $selectedCustomerVehicle=false, $showSectionsList=false, $showServiceSectionsList=false, $showServiceItems=false, $showItemsSearchResults=false, $showQlItemSearch=false, $showQlEngineOilItems=false, $showQlItemsOnly=false, $showQlItemsList=false, $showPackageList=false, $selectPackageMenu=false, $showPackageServiceSectionsList=false, $showAddMakeModelNew=false;
    public $showServiceGroup=true, $showCheckout;
    public $showVehicleAvailable, $selectedVehicleInfo, $selected_vehicle_id, $customer_id;
    public $servicesGroupList, $service_group_id, $service_group_name, $service_group_code, $station, $section_service_search, $propertyCode, $selectedSectionName;
    public $selectServiceItems, $sectionsLists;
    public $serviceAddedMessgae=[],$cartItems = [], $cardShow=false, $ql_item_qty;
    public $itemCategories=[], $itemSubCategories=[], $itemBrandsLists=[], $item_search_category, $item_search_subcategory, $item_search_brand, $item_search_name, $serviceItemsList=[];
    public $quickLubeItemsList = [], $qlBrandsLists=[], $ql_search_brand, $ql_km_range, $ql_search_category, $itemQlCategories=[], $quickLubeItemSearch;
    public $customerGroupLists;
    public $selectedDiscount, $appliedDiscount=[], $showDiscountDroup=false, $discountSearch=true;
    public $discount_card_imgae, $discount_card_number, $discount_card_validity;
    public $discountCardApplyForm=false, $engineOilDiscountForm=false, $discountForm=false;
    public $customerSelectedDiscountGroup, $employeeId, $searchStaffId, $staffavailable;

    public $editCUstomerInformation=false, $addNewVehicleInformation=false, $showForms=false, $searchByMobileNumber = false, $editCustomerAndVehicle=false, $showByMobileNumber=true, $showCustomerForm=false, $showPlateNumber=false, $otherVehicleDetailsForm=false, $searchByChaisisForm=false, $updateVehicleFormBtn = false, $addVehicleFormBtn=false, $cancelEdidAddFormBtn=false, $showSaveCustomerButton=false, $showSearchByPlateNumberButton=false, $showSearchByChaisisButton=false;
    public $mobile, $name, $email, $customer_code, $plate_number_image, $plate_country = 'AE', $plateStateCode=2, $plate_state='Dubai', $plate_category, $plate_code, $plate_number, $vehicle_image, $vehicle_type, $make, $model, $chaisis_image, $chassis_number, $vehicle_km;
    public $stateList, $plateEmiratesCodes, $vehicleTypesList, $listVehiclesMake, $vehiclesModelList=[];
    public $servicePackages, $showPackageAddons=false;
    public $package_number, $package_code, $showPackageOtpVerify=false, $package_otp, $package_otp_message, $customerBookedPackages=[], $showOpenPackageDetails=false, $sectionPackageServiceLists=[];
    public $customize_price=-1, $customise_service_item_price;
    public $showTempCart=false,$jobDetails, $tempCartItems, $tempCartItemCount;
    public $confirming;
    public $customizedErrorMessage=[];
    public $new_make, $new_make_id, $makeSearchResult=[], $modelSearchResult=[], $showAddNewModel=false, $new_model;
    public $showBundleList=false, $selectBundleMenu=false, $bundlleLists, $selectedBundles, $showBundleServiceSectionsList, $bundleServiceLists=[];

    function mount( Request $request) {
        $this->customer_id = $request->customer_id;
        $this->vehicle_id = $request->vehicle_id;
        $this->job_number = $request->job_number;
        if($this->vehicle_id && $this->customer_id)
        {
            $this->selectVehicle();
            //$this->checkExistingJobs();
        }
        if($this->job_number)
        {
            $this->customerJobDetails();
        }

    }


    public function render()
    {
        if($this->new_make)
        {
            $this->makeSearchResult = VehicleMakes::where('vehicle_name','like',"%{$this->new_make}%")->where('is_deleted','=',null)->get();
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
        //dd($this->propertyCode);
        if($this->editCUstomerInformation || $this->addNewVehicleInformation)
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

            $this->vehicleTypesList = Vehicletypes::orderBy('type_name','ASC')->get();
            $this->listVehiclesMake = VehicleMakes::where('is_deleted','=',null)->get();
            if($this->make){
                $this->vehiclesModelList = VehicleModels::where(['vehicle_make_id'=>$this->make])->get();
            }
        }
        else
        {
            $this->stateList = null;
            $this->plateEmiratesCodes=null;
            $this->vehicleTypesList=[];
            $this->listVehiclesMake = [];
            $this->vehiclesModelList = [];
        }



        if($this->showServiceGroup){
            $this->servicesGroupList = Development::select('DevelopmentCode as department_code','DevelopmentName as department_name','id','LandlordCode as station_code')->where(['Operation'=>true,'LandlordCode'=>auth()->user('user')['station_code']])->get();
        }
        if($this->showSectionsList){
            $this->sectionsLists = Sections::select('id','PropertyCode','DevelopmentCode','PropertyNo','PropertyName','Operation')
                ->where([
                    'DevelopmentCode'=>$this->service_group_code,
                    'Operation'=>true
                ])
                ->orderBy('SortIndex','ASC')
                ->get();

            //dd($this->sectionsLists);
        }


        if($this->showServiceSectionsList)
        {
            $sectionServiceLists = LaborItemMaster::where([
                'SectionCode'=>$this->propertyCode,
                'DivisionCode'=>auth()->user('user')['station_code'],
                'Active'=>1,
            ]);
            if($this->section_service_search){
                $sectionServiceLists = $sectionServiceLists->where('ItemName','like',"%$this->section_service_search%");
            }
            $sectionServiceLists = $sectionServiceLists->orderBy('SortIndex','ASC')->get();
            $sectionServicePriceLists = [];
            foreach($sectionServiceLists as $key => $sectionServiceList)
            {
                $sectionServicePriceLists[$key]['priceDetails'] = $sectionServiceList;
                if(!empty($this->appliedDiscount)){
                    $discountLaborSalesPrices = LaborSalesPrices::where(['ServiceItemId'=>$sectionServiceList->ItemId,'CustomerGroupCode'=>$this->appliedDiscount['code']]);
                    $discountLaborSalesPrices = $discountLaborSalesPrices->where('StartDate', '<=', Carbon::now());
                    if($this->appliedDiscount['groupType']==1)
                    {
                        $discountLaborSalesPrices = $discountLaborSalesPrices->where('EndDate', '=', null );
                    }
                    else if($this->appliedDiscount['groupType']==2)
                    {
                        $discountLaborSalesPrices = $discountLaborSalesPrices->where('EndDate', '>=', Carbon::now() );
                    }
                    $sectionServicePriceLists[$key]['discountDetails'] = $discountLaborSalesPrices->first();
                    
                }
                else if($this->selectedVehicleInfo->customerInfoMaster['discountgroup']==14)
                {
                    $discountLaborSalesPrices = LaborSalesPrices::where([
                        'ServiceItemId'=>$sectionServiceList->ItemId,
                        'CustomerGroupCode'=>$this->selectedVehicleInfo->customerInfoMaster['TenantCode']
                    ]);
                    $discountLaborSalesPrices = $discountLaborSalesPrices->where('StartDate', '<=', Carbon::now());
                    //$discountLaborSalesPrices = $discountLaborSalesPrices->where('EndDate', '>=', Carbon::now() );
                    $sectionServicePriceLists[$key]['discountDetails'] = $discountLaborSalesPrices->first();
                }
                else
                {
                    $sectionServicePriceLists[$key]['discountDetails']=null;
                }
            }
            $this->sectionServiceLists = $sectionServicePriceLists;
        }
        else
        {
            $this->sectionServiceLists=[];/*
            $this->showPackageList=false;
            $this->customerBookedPackages=[];
            $this->servicePackages=[];
            $this->sectionPackageServiceLists=[];*/
        }

        

        if($this->showOpenPackageDetails){

            $packageBookingServicesQuery = PackageBookingServices::with(['labourItemDetails'])->where([
                'package_number'=>$this->package_number,
                //'package_status'=>2
            ])->get();
            $sectionServicePriceLists = [];
            foreach($packageBookingServicesQuery as $key => $packageServices)
            {
                $sectionServicePriceLists[$key]['package_quantity'] = $packageServices->quantity;
                $sectionServicePriceLists[$key]['package_quantity_used'] = $packageServices->package_service_use_count;
                $sectionServicePriceLists[$key]['priceDetails'] = $packageServices->labourItemDetails;
                $packageServices['DiscountPerc']=100;
                $sectionServicePriceLists[$key]['discountDetails']=$packageServices;
                
            }
            $this->sectionPackageServiceLists=$sectionServicePriceLists;
            //dd($this->sectionServiceLists);
        }

        if($this->showServiceItems){
            $this->itemCategories = ItemCategories::where(['Active'=>1])->get();
            if($this->item_search_category){
                $this->itemSubCategories = InventorySubCategory::where(['CategoryId'=>$this->item_search_category])->get();
            }
            $this->qlBrandsLists = InventoryBrand::where(['Active'=>1,'show_engine_oil'=>1])->get();
            if($this->showItemsSearchResults)
            {
                $inventoryItemMasterLists = InventoryItemMaster::where('Active','=',1)->where('UnitPrice','!=',0);
                if($this->item_search_category){
                    $inventoryItemMasterLists = $inventoryItemMasterLists->where(['CategoryId'=>$this->item_search_category]);
                }
                if($this->item_search_subcategory){
                    $inventoryItemMasterLists = $inventoryItemMasterLists->where(['SubCategoryId'=>$this->item_search_subcategory]);
                }
                if($this->item_search_brand){
                    $inventoryItemMasterLists = $inventoryItemMasterLists->where(['BrandId'=>$this->item_search_brand]);
                }
                if($this->item_search_name){
                    $inventoryItemMasterLists = $inventoryItemMasterLists->where('ItemName','like',"%{$this->item_search_name}%");
                }
                $inventoryItemMasterLists=$inventoryItemMasterLists->get();
                $itemPriceLists = [];
                foreach($inventoryItemMasterLists as $key => $itemMasterList)
                {
                    $itemPriceLists[$key]['priceDetails'] = $itemMasterList;
                    if(!empty($this->appliedDiscount)){
                        $qlInventorySalesPricesQuery = InventorySalesPrices::where([
                                'ServiceItemId'=>$itemMasterList->ItemId,
                                'CustomerGroupCode'=>$this->appliedDiscount['code'],
                                'DivisionCode'=>auth()->user('user')['station_code'],
                            ]);
                        if($this->appliedDiscount['groupType']==1)
                        {
                            //$qlInventorySalesPricesQuery = $qlInventorySalesPricesQuery;

                        }else if($this->appliedDiscount['groupType']==2)
                        {
                            $qlInventorySalesPricesQuery = $qlInventorySalesPricesQuery->where('StartDate', '<=', Carbon::now())->where('EndDate', '>=', Carbon::now() );
                        }
                        $qlInventorySalesPricesQuery = $qlInventorySalesPricesQuery->first();
                        $qlItemPriceLists[$key]['discountDetails'] = $qlInventorySalesPricesQuery;
                    }
                    else if($this->selectedVehicleInfo->customerInfoMaster['discountgroup']==14)
                    {
                        $qlInventorySalesPricesQuery = InventorySalesPrices::where([
                            'ServiceItemId'=>$itemMasterList->ItemId,
                            'CustomerGroupCode'=>$this->selectedVehicleInfo->customerInfoMaster['TenantCode'],
                            'DivisionCode'=>auth()->user('user')['station_code']
                        ]);
                        $qlInventorySalesPricesQuery = $qlInventorySalesPricesQuery->where('StartDate', '<=', Carbon::now());
                        //$qlInventorySalesPricesQuery = $qlInventorySalesPricesQuery->where('EndDate', '>=', Carbon::now() );
                        $itemPriceLists[$key]['discountDetails'] = $qlInventorySalesPricesQuery->first();
                    }
                    else
                    {
                        $itemPriceLists[$key]['discountDetails']=null;
                    }
                }
                $this->serviceItemsList = $itemPriceLists;

            }
            else
            {
                $this->serviceItemsList=[];
            }
        }
        else
        {
            $this->serviceItemsList=[];
            $this->itemCategories=[];
            $this->itemSubCategories=[];
            $this->itemBrandsLists=[];
            $this->showItemsSearchResults=false;
        }
        if($this->showQlItemSearch)
        {
            $this->qlBrandsLists = InventoryBrand::where(['Active'=>1,'show_engine_oil'=>1])->get();
            $this->itemQlCategories = ItemCategories::where(['show_in'=>'q'])->get();
            if($this->showQlItemsList)
            {
                
                if($this->showQlEngineOilItems)
                {
                    $quickLubeItemsNormalList = InventoryItemMaster::whereIn("InventoryPosting",['1','7'])->where('Active','=',1);
                    if($this->ql_search_brand){
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
                        //dd($this->appliedDiscount);
                        if(!empty($this->appliedDiscount)){
                            $qlKMInventorySalesPricesQuery = InventorySalesPrices::where([
                                    'ServiceItemId'=>$qlItemsList->ItemId,
                                    'CustomerGroupCode'=>$this->appliedDiscount['code'],
                                    'DivisionCode'=>auth()->user('user')['station_code'],
                                ]);
                            if($this->appliedDiscount['groupType']==1)
                            {
                                //$qlKMInventorySalesPricesQuery = $qlKMInventorySalesPricesQuery->first();

                            }else if($this->appliedDiscount['groupType']==2)
                            {
                                $qlKMInventorySalesPricesQuery = $qlKMInventorySalesPricesQuery->where('StartDate', '<=', Carbon::now())->where('EndDate', '>=', Carbon::now());
                            }
                            $qlItemPriceLists[$key]['discountDetails'] =  $qlKMInventorySalesPricesQuery->first();
                            
                        }
                        else if($this->selectedVehicleInfo->customerInfoMaster['discountgroup']==14)
                        {
                            $qlKMInventorySalesPricesQuery = InventorySalesPrices::where([
                                'ServiceItemId'=>$qlItemsList->ItemId,
                                'CustomerGroupCode'=>$this->selectedVehicleInfo->customerInfoMaster['TenantCode'],
                                'DivisionCode'=>auth()->user('user')['station_code']
                            ]);
                            $qlKMInventorySalesPricesQuery = $qlKMInventorySalesPricesQuery->where('StartDate', '<=', Carbon::now());
                            //$qlKMInventorySalesPricesQuery = $qlKMInventorySalesPricesQuery->where('EndDate', '>=', Carbon::now() );
                            $qlItemPriceLists[$key]['discountDetails'] = $qlKMInventorySalesPricesQuery->first();
                        }
                        else
                        {
                            $qlItemPriceLists[$key]['discountDetails']=null;
                        }
                        
                        //dd($sectionServicePriceLists[$key]);
                    }
                    $this->quickLubeItemsList = $qlItemPriceLists;

                }

                if($this->showQlItemsOnly)
                {
                    if($this->ql_search_category==40 || $this->ql_search_category==43)
                    {

                        $qlMakeModelCategoryItems = InventoryItemMaster::whereIn("InventoryPosting",['1','7'])->where('Active','=',1);
                        $qlMakeModelCategoryItems = $qlMakeModelCategoryItems->where('CategoryId','=',$this->ql_search_category);
                        $qlMakeModelCategoryItems=$qlMakeModelCategoryItems->get();
                        
                        $qlMakeModelCatItmDetails = [];
                        foreach($qlMakeModelCategoryItems as $key => $qlItemMakeModelItem)
                        {
                            $qlMakeModelCatItm = $qlItemMakeModelItem;
                            $qlMakeModelCatItmDetails[$key]['priceDetails'] = $qlMakeModelCatItm;
                            if(!empty($this->appliedDiscount)){
                            
                                if($this->appliedDiscount['groupType']==1)
                                {

                                    $qlMakeModelCatItmDetails[$key]['discountDetails'] = InventorySalesPrices::where([
                                        'ServiceItemId'=>$qlMakeModelCatItm->ItemId,
                                        'CustomerGroupCode'=>$this->appliedDiscount['code'],
                                        'DivisionCode'=>auth()->user('user')['station_code'],
                                    ])->first();

                                }else if($this->appliedDiscount['groupType']==2)
                                {
                                    
                                    $qlMakeModelCatItmDetails[$key]['discountDetails'] = InventorySalesPrices::where([
                                        'ServiceItemId'=>$qlMakeModelCatItm->ItemId,
                                        'CustomerGroupCode'=>$this->appliedDiscount['code'],
                                        'DivisionCode'=>auth()->user('user')['station_code'],
                                    ])->where('StartDate', '<=', Carbon::now())->where('EndDate', '>=', Carbon::now() )->first();
                                }
                                else
                                {
                                    $qlMakeModelCatItmDetails[$key]['discountDetails']=null;
                                }
                                
                            }
                            else if($this->selectedVehicleInfo->customerInfoMaster['discountgroup']==14)
                            {
                                $qlMakeModelCatItmDetails[$key]['discountDetails'] = InventorySalesPrices::where([
                                        'ServiceItemId'=>$qlMakeModelCatItm->ItemId,
                                        'CustomerGroupCode'=>$this->selectedVehicleInfo->customerInfoMaster['TenantCode'],
                                    ])->where('StartDate', '<=', Carbon::now())
                                //->where('EndDate', '>=', Carbon::now() )
                                ->first();
                            }
                            else
                            {
                                $qlMakeModelCatItmDetails[$key]['discountDetails']=null;
                            }
                        }

                    }
                    else
                    {
                        $qlMakeModelCategoryItems = ItemMakeModel::with(['itemDetails'])->where(function ($query) {
                            $query->whereRelation('itemDetails', 'CategoryId', '=', $this->ql_search_category);
                        })->where(['makeid'=>$this->selectedVehicleInfo->make,'modelid'=>$this->selectedVehicleInfo->model])->get();

                        $qlMakeModelCatItmDetails = [];
                        foreach($qlMakeModelCategoryItems as $key => $qlItemMakeModelItem){
                            $qlMakeModelCatItm = $qlItemMakeModelItem->itemDetails;
                            $qlMakeModelCatItmDetails[$key]['priceDetails'] = $qlMakeModelCatItm;
                            if(!empty($this->appliedDiscount)){
                            
                                if($this->appliedDiscount['groupType']==1)
                                {

                                    $qlMakeModelCatItmDetails[$key]['discountDetails'] = InventorySalesPrices::where([
                                        'ServiceItemId'=>$qlMakeModelCatItm->ItemId,
                                        'CustomerGroupCode'=>$this->appliedDiscount['code'],
                                        'DivisionCode'=>auth()->user('user')['station_code'],
                                    ])->first();

                                }else if($this->appliedDiscount['groupType']==2)
                                {
                                    
                                    $qlMakeModelCatItmDetails[$key]['discountDetails'] = InventorySalesPrices::where([
                                        'ServiceItemId'=>$qlMakeModelCatItm->ItemId,
                                        'CustomerGroupCode'=>$this->appliedDiscount['code'],
                                        'DivisionCode'=>auth()->user('user')['station_code'],
                                    ])->where('StartDate', '<=', Carbon::now())->where('EndDate', '>=', Carbon::now() )->first();
                                }
                                else
                                {
                                    $qlMakeModelCatItmDetails[$key]['discountDetails']=null;
                                }
                                
                            }
                            else
                            {
                                $qlMakeModelCatItmDetails[$key]['discountDetails']=null;
                            }

                        }
                    }
                    $this->quickLubeItemsList = $qlMakeModelCatItmDetails;
                }
            }
            else
            {
                $this->quickLubeItemsList=[];
            }
        }
        else
        {
            $this->showQlItemsList=false;
            $this->showQlItemSearch = false;
            $this->showQlEngineOilItems=false;
            $this->showQlItemsOnly=false;

            $this->qlBrandsLists=[];
            $this->quickLubeItemsList=[];
            $this->itemQlCategories=[];
        }

        
        if($this->showPackageList)
        {
            $this->customerBookedPackages = PackageBookings::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->vehicle_id])->get();
            $this->servicePackages = ServicePackage::with(['packageDetails','packageTypes'])->where(['Status'=>'A','Division'=>auth()->user('user')['station_code']])->get();
            //$this->showPackageAddons=false;
            //dd($this->servicePackages);
        }
        else{
            $this->customerBookedPackages=null;
            $this->servicePackages=null;
        }

        if($this->showBundleList)
        {
            $this->bundlleLists = ServiceBundleType::with(['bundleDiscountedPrice'])->where(['Active'=>1])->get();
            //dd($this->bundlleLists);
        }
        else
        {
            $this->bundlleLists=null;
        }


        //$this->openServiceGroup();
        $this->getCartInfo();
        $this->dispatchBrowserEvent('selectSearchEvent');
        $this->emit('chosenUpdated');
        return view('livewire.customer-service-job');
    }

    public function openPackageDetails($packBookd){
        //dd($packBookd);
        $this->package_number= $packBookd['package_number'];
        $this->package_code= $packBookd['package_code'];
        $mobileNumber = isset($packBookd['customer_mobile'])?'971'.substr($packBookd['customer_mobile'], -9):null;
        $customerName = isset($packBookd['customer_name'])?$packBookd['customer_name']:null;
        $otpPack = fake()->randomNumber(6);
        PackageBookings::where(['package_number'=>$packBookd['package_number']])->update(['otp_code'=>$otpPack,'otp_verify'=>0]);
        if($mobileNumber!=''){
            //if($mobileNumber=='971566993709'){
                $msgtext = urlencode('Dear '.$customerName.', to confirm your GSS Service Contract creation, please use the OTP '.$otpPack.'. This OTP is valid for 10 minutes. Do not share it with anyone. For assistance, call 800477823.');
                $response = Http::get(config('global.sms')[1]['sms_url']."&mobileno=".$mobileNumber."&msgtext=".$msgtext."&CountryCode=ALL");
            //}
        }
        $this->showPackageOtpVerify=true;
        session()->flash('package_success', 'Package is valid, '.$otpPack.' please enter the OTP shared in the registered mobile number..!');


        /*$this->showOpenPackageDetails=true;
        $this->package_number= $packBookd['package_number'];
        $this->showPackageServiceSectionsList=true;
        $this->dispatchBrowserEvent('openServicesPackageListModal');*/
    }

    public function checkExistingJobs(){
        $existingJobs = CustomerJobCards::where(['vehicle_id'=>$this->vehicle_id,'customer_id'=>$this->customer_id,'payment_status'=>0])->where('job_status','!=',4);
        if($existingJobs->exists())
        {
            $existingJobs = $existingJobs->first();
            //dd($existingJobs);
            
            return redirect()->to('update_jobcard/'.$existingJobs->job_number);
        }
    }

    public function getCartInfo($value='')
    {
        $this->cartItems = CustomerServiceCart::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->vehicle_id])->get();
        //dd($this->cartItems);
        $this->cartItemCount = count($this->cartItems); 
        if($this->cartItemCount>0)
        {
            $this->cardShow=true;
        }
        else
        {
            $this->cardShow=false;
        }


    }

    public function openServiceGroup(){
        $this->showServiceGroup=true;
        $this->dispatchBrowserEvent('scrollto', [
            'scrollToId' => 'servceGroup',
        ]);
    }

    public function getSectionServices($section)
    {
        $this->propertyCode=$section['PropertyCode'];
        $this->selectedSectionName = $section['PropertyName'];
        $this->showServiceSectionsList=true;
        $this->showServiceItems = false;
        $this->dispatchBrowserEvent('openServicesListModal');
        
    }

    public function selectVehicle(){
        $customers = CustomerVehicle::with(['customerInfoMaster','makeInfo','modelInfo','customerDiscountLists'])->where(['is_active'=>1,'id'=>$this->vehicle_id,'customer_id'=>$this->customer_id])->first();
        
        
        $this->selectedCustomerVehicle=true;

        $this->showServiceGroup = true;
        
        $this->showVehicleAvailable = false;
        $this->selectedVehicleInfo=$customers;
        //dd($this->selectedVehicleInfo);

        $this->mobile = $customers->customerInfoMaster['Mobile'];
        $this->name = $customers->customerInfoMaster['TenantName'];
        $this->email = $customers->customerInfoMaster['Email'];
    }

    public function serviceGroupForm($service){
        $this->service_group_id = $service['id'];
        $this->service_group_name = $service['department_name'];
        $this->service_group_code = $service['department_code'];
        $this->station = $service['station_code'];
        $this->section_service_search='';
        if($this->service_group_name =='Quick Lube')
        {
            $this->showQlItemSearch = true;
            $qlSectionsLists = Sections::select('id','PropertyCode','DevelopmentCode','PropertyNo','PropertyName','Operation')
                ->where([
                    'DevelopmentCode'=>$this->service_group_code,
                    'Operation'=>true,
                    'PropertyName'=>'Quick Lube',
                ])->first();
                //dd($qlSectionsLists);
            $this->propertyCode=$qlSectionsLists->PropertyCode;
            $this->selectedSectionName = $qlSectionsLists->PropertyName;
        }
        else
        {
            $this->showQlItemSearch = false;
            $this->showQlItemsList = false;
            $this->showQlEngineOilItems=false;
            $this->showQlItemsOnly=false;
        }

        $this->showSectionsList=true;

        $this->showServiceItems = false;
        $this->showItemsSearchResults=false;

        $this->showPackageList=false;
        $this->selectPackageMenu=false;

        $this->showBundleList=false;
        $this->selectBundleMenu=false;

        $this->dispatchBrowserEvent('scrollto', [
            'scrollToId' => 'servceSectionsList',
        ]);
    }

    public function qlItemkmRange($kmRange)
    {
        $validatedData = $this->validate([
            'ql_search_brand' => 'required',
        ]);
        $this->ql_km_range=$kmRange;
        $this->quickLubeItemSearch=null;
        $this->showQlItemSearch = true;
        $this->showQlItemsList = true;
        $this->showQlEngineOilItems=true;
        $this->showQlItemsOnly=false;

        $this->dispatchBrowserEvent('scrolltopQl');
    }

    public function qlCategorySelect(){
        $this->ql_search_brand=null;
        $this->showQlItemSearch = true;
        $this->showQlItemsList = true;
        $this->showQlEngineOilItems=false;
        $this->showQlItemsOnly=true;
        $this->dispatchBrowserEvent('scrolltopQl');
    }

    public function searchQuickLubeItem(){
        $validatedData = $this->validate([
            'quickLubeItemSearch' => 'required',
        ]);
        $this->ql_search_brand=null;
        $this->ql_km_range=null;
        $this->ql_search_category=null;
        $this->showQlItemSearch = true;
        $this->showQlItemsList = true;
        $this->showQlEngineOilItems=true;
        $this->showQlItemsOnly=false;

        
    }
    public function addToCartCP($servicePrice,$discount,$customize_price){
        $validatedData = $this->validate([
            'customise_service_item_price' => 'required',
        ]);
        //dd($this->customise_service_item_price);
    }
    public function addtoCart($servicePrice,$discount)
    {
        $addtoCartAllowed=false;
        $servicePrice = json_decode($servicePrice,true);
        $discountPrice = json_decode($discount,true);
        if($servicePrice['CustomizePrice']==1)
        {
            if(($this->customise_service_item_price[$servicePrice['ItemId']] >= $servicePrice['MinPrice']) && ($this->customise_service_item_price[$servicePrice['ItemId']] <= $servicePrice['MaxPrice'])){
                $servicePrice['UnitPrice'] = $this->customise_service_item_price[$servicePrice['ItemId']];
                $this->customizedErrorMessage[$servicePrice['ItemId']] = false;
                $addtoCartAllowed = true;
            }
            else
            {
                $addtoCartAllowed = false;
                $this->customizedErrorMessage[$servicePrice['ItemId']] = true;
            }
        }
        else{
            $addtoCartAllowed = true;
        }

        if($addtoCartAllowed==true){

            $customerBasketCheck = CustomerServiceCart::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->vehicle_id,'item_id'=>$servicePrice['ItemId']]);
            if($customerBasketCheck->count())
            {
                $customerBasketCheck->increment('quantity', 1);
                if($discountPrice!=null){
                    $cartUpdate['price_id']=$discountPrice['PriceID'];
                    $cartUpdate['customer_group_id']=$discountPrice['CustomerGroupId'];
                    $cartUpdate['customer_group_code']=$discountPrice['CustomerGroupCode'];
                    $cartUpdate['min_price']=$discountPrice['MinPrice'];
                    $cartUpdate['max_price']=$discountPrice['MaxPrice'];
                    $cartUpdate['start_date']=$discountPrice['StartDate'];
                    $cartUpdate['end_date']=$discountPrice['EndDate'];
                    $cartUpdate['discount_perc']=$discountPrice['DiscountPerc'];
                    CustomerServiceCart::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->vehicle_id,'item_id'=>$servicePrice['ItemId']])->update($cartUpdate);
                }
                
            }
            else
            {
                $cartInsert = [
                    'customer_id'=>$this->customer_id,
                    'vehicle_id'=>$this->vehicle_id,
                    'item_id'=>$servicePrice['ItemId'],
                    'item_code'=>$servicePrice['ItemCode'],
                    'cart_item_type'=>1,
                    'company_code'=>$servicePrice['CompanyCode'],
                    'category_id'=>$servicePrice['CategoryId'],
                    'sub_category_id'=>$servicePrice['SubCategoryId'],
                    'brand_id'=>$servicePrice['BrandId'],
                    'bar_code'=>$servicePrice['BarCode'],
                    'item_name'=>$servicePrice['ItemName'],
                    'description'=>$servicePrice['Description'],
                    'division_code'=>$servicePrice['DivisionCode'],
                    'department_code'=>$servicePrice['DepartmentCode'],
                    'section_name'=>$this->selectedSectionName,
                    'department_name'=>$this->service_group_name,
                    'section_code'=>$servicePrice['SectionCode'],
                    'unit_price'=>$servicePrice['UnitPrice'],
                    'quantity'=>1,
                    'created_by'=>auth()->user('user')['id'],
                    'created_at'=>Carbon::now(),
                ];
                
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
                if($this->job_number)
                {
                    $cartInsert['job_number']=$this->job_number;
                }
                
                CustomerServiceCart::insert($cartInsert);
            }
            $this->serviceAddedMessgae[$servicePrice['ItemCode']]=true;
        }
        
        //$this->dispatchBrowserEvent('closeServicesListModal');

        //dd($this->sectionServiceLists);
        /*$this->dispatchBrowserEvent('swal:modal', [
            'type' => 'success',
            'message' => 'Added to Cart Successfully',
            'text' => 'service added..!',
            'cartitemcount'=>\Cart::getTotalQuantity()
        ]);*/
        //session()->flash('cartsuccess', 'Service is Added to Cart Successfully !');
    }

    public function addtoCartItem($ItemCode,$discount)
    {
        $items = InventoryItemMaster::where(['ItemCode'=>$ItemCode])->first();

        $discountPrice = json_decode($discount,true);
        $customerBasketCheck = CustomerServiceCart::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->vehicle_id,'item_id'=>$items->ItemId]);
        if($customerBasketCheck->count())
        {
            $customerBasketCheck->increment('quantity', 1);
            if($discountPrice!=null){
                $cartUpdate['price_id']=$discountPrice['PriceID'];
                $cartUpdate['customer_group_id']=$discountPrice['CustomerGroupId'];
                $cartUpdate['customer_group_code']=$discountPrice['CustomerGroupCode'];
                $cartUpdate['min_price']=$discountPrice['MinPrice'];
                $cartUpdate['max_price']=$discountPrice['MaxPrice'];
                $cartUpdate['start_date']=$discountPrice['StartDate'];
                $cartUpdate['end_date']=$discountPrice['EndDate'];
                $cartUpdate['discount_perc']=$discountPrice['DiscountPerc'];
                CustomerServiceCart::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->vehicle_id,'item_id'=>$items->ItemId])->update($cartUpdate);
            }
            
        }
        else
        {
            $cartInsert = [
                'customer_id'=>$this->customer_id,
                'vehicle_id'=>$this->vehicle_id,
                'item_id'=>$items->ItemId,
                'item_code'=>$items->ItemCode,
                'company_code'=>$items->CompanyCode,
                'category_id'=>$items->CategoryId,
                'sub_category_id'=>$items->SubCategoryId,
                'brand_id'=>$items->BrandId,
                'bar_code'=>$items->BarCode,
                'item_name'=>$items->ItemName,
                'cart_item_type'=>2,
                'description'=>$items->Description,
                'division_code'=>$this->station,
                'department_code'=>$this->service_group_code,
                'department_name'=>$this->service_group_name,
                'section_code'=>$this->propertyCode,
                'section_name'=>$this->selectedSectionName,
                'unit_price'=>$items->UnitPrice,
                'quantity'=>isset($this->ql_item_qty[$items->ItemId])?$this->ql_item_qty[$items->ItemId]:1,
                'created_by'=>auth()->user('user')['id'],
                'created_at'=>Carbon::now(),
            ];
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
            if($this->job_number)
            {
                $cartInsert['job_number']=$this->job_number;
            }
            CustomerServiceCart::insert($cartInsert);
        }
        $this->serviceAddedMessgae[$items->ItemCode]=true;
        //dd($this->sectionServiceLists);
        /*$this->dispatchBrowserEvent('swal:modal', [
            'type' => 'success',
            'message' => 'Added to Cart Successfully',
            'text' => 'service added..!',
            'cartitemcount'=>\Cart::getTotalQuantity()
        ]);*/
        session()->flash('cartsuccess', 'Service is Added to Cart Successfully !');
    }

     public function addtoCartPackage($servicePrice,$discount)
    {
        $servicePrice = json_decode($servicePrice,true);
        $discountPrice = json_decode($discount,true);
        //dd($discountPrice);
        $customerBasketCheck = CustomerServiceCart::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->vehicle_id,'item_id'=>$servicePrice['ItemId']]);
        if($customerBasketCheck->count())
        {
            $customerBasketCheck->increment('quantity', 1);
            if($discountPrice!=null){
                $cartUpdate['price_id']=$discountPrice['id'];
                $cartUpdate['customer_group_id']=$discountPrice['package_id'];
                $cartUpdate['customer_group_code']=$discountPrice['package_code'];
                $cartUpdate['min_price']=$discountPrice['unit_price'];
                $cartUpdate['max_price']=$discountPrice['unit_price'];
                //$cartUpdate['start_date']=$discountPrice['created_at'];
                //$cartUpdate['end_date']=$discountPrice['EndDate'];
                $cartUpdate['discount_perc']=100;
                CustomerServiceCart::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->vehicle_id,'item_id'=>$servicePrice['ItemId']])->update($cartUpdate);
            }
            
        }
        else
        {
            $cartInsert = [
                'customer_id'=>$this->customer_id,
                'vehicle_id'=>$this->vehicle_id,
                'item_id'=>$servicePrice['ItemId'],
                'item_code'=>$servicePrice['ItemCode'],
                'cart_item_type'=>3,
                'company_code'=>$servicePrice['CompanyCode'],
                'category_id'=>$servicePrice['CategoryId'],
                'sub_category_id'=>$servicePrice['SubCategoryId'],
                'brand_id'=>$servicePrice['BrandId'],
                'bar_code'=>$servicePrice['BarCode'],
                'item_name'=>$servicePrice['ItemName'],
                'description'=>$servicePrice['Description'],
                'division_code'=>$servicePrice['DivisionCode'],
                'department_code'=>$servicePrice['DepartmentCode'],
                'section_name'=>$this->selectedSectionName,
                'department_name'=>$this->service_group_name,
                'section_code'=>$servicePrice['SectionCode'],
                'is_package'=>1,
                'package_code'=>$this->package_number,
                'package_number'=>$this->package_code,
                'unit_price'=>$servicePrice['UnitPrice'],
                'quantity'=>1,
                'created_by'=>auth()->user('user')['id'],
                'created_at'=>Carbon::now(),
            ];
            
            if($discountPrice!=null){
                $cartInsert['price_id']=$discountPrice['id'];
                $cartInsert['customer_group_id']=$discountPrice['package_id'];
                $cartInsert['customer_group_code']=$discountPrice['package_code'];
                $cartInsert['min_price']=$discountPrice['unit_price'];
                $cartInsert['max_price']=$discountPrice['unit_price'];
                //$cartInsert['start_date']=$discountPrice['created_at'];
                //$cartInsert['end_date']=$discountPrice['EndDate'];
                $cartInsert['discount_perc']=100;
            }
            if($this->job_number)
            {
                $cartInsert['job_number']=$this->job_number;
            }
            
            CustomerServiceCart::insert($cartInsert);
        }
        $this->serviceAddedMessgae[$servicePrice['ItemCode']]=true;
        //$this->dispatchBrowserEvent('closeServicesListModal');

        //dd($this->sectionServiceLists);
        /*$this->dispatchBrowserEvent('swal:modal', [
            'type' => 'success',
            'message' => 'Added to Cart Successfully',
            'text' => 'service added..!',
            'cartitemcount'=>\Cart::getTotalQuantity()
        ]);*/
        //session()->flash('cartsuccess', 'Service is Added to Cart Successfully !');
    }


    public function cartSetDownQty($cartId){
        CustomerServiceCart::find($cartId)->decrement('quantity');
    }
    public function cartSetUpQty($cartId){
        CustomerServiceCart::find($cartId)->increment('quantity');
    }

    public function removeCart($id)
    {
        CustomerServiceCart::find($id)->delete();
    }

    public function clearAllCart()
    {
        CustomerServiceCart::where(['customer_id'=>$this->customer_id, 'vehicle_id'=>$this->vehicle_id])->delete();
        
        session()->flash('cartsuccess', 'All Service Cart Clear Successfully !');
    }

    public function openServiceItems(){
        
        $this->showServiceItems = true;

        $this->service_group_id = null;
        $this->service_group_name = null;
        $this->service_group_code = null;
        $this->station = null;
        $this->section_service_search='';

        $this->propertyCode=null;
        $this->selectedSectionName = null;
        $this->showSectionsList=false;
        $this->showServiceSectionsList=false;
        
        $this->showPackageList=false;
        $this->selectPackageMenu=false;

        $this->showQlItemSearch = false;
        $this->showQlItemsList = false;
        $this->showQlEngineOilItems=false;
        $this->showQlItemsOnly=false;

        $this->showBundleList=false;
        $this->selectBundleMenu=false;
        $this->dispatchBrowserEvent('scrollto', [
            'scrollToId' => 'serviceItemsListDiv',
        ]);
    }

    public function searchServiceItems(){
        
        $validatedData = $this->validate([
            'item_search_category' => 'required',
            //'item_search_subcategory' => 'required',
        ]);
        $this->showItemsSearchResults=true;
    }

    public function clickDiscountGroup(){
        $this->discountSearch=true;
        $this->showDiscountDroup=true;
        $this->customerGroupLists = LaborCustomerGroup::where('GroupType','!=',5)->where('GroupType','!=',4)->where(['Active'=>true])->get();
        $this->dispatchBrowserEvent('openDiscountGroupModal');
    }


    public function selectDiscountGroup($discountGroup){
        $this->selectedDiscount = [
            'unitId'=>isset($discountGroup['UnitId'])?$discountGroup['UnitId']:null,
            'code'=>$discountGroup['Code'],
            'title'=>$discountGroup['Title'],
            'id'=>$discountGroup['Id'],
            'groupType'=>$discountGroup['GroupType'],
        ];
        if($discountGroup['GroupType']==2 || $discountGroup['GroupType']==6 )
        {

            $this->discountCardApplyForm=false;
            $this->discountForm=false;
            $this->appliedDiscount = $this->selectedDiscount;
            //$this->applyDiscountOnCart();
            //$this->applyItemToTempCart();
            $this->dispatchBrowserEvent('closeDiscountGroupModal');
        }
        else
        {
            $this->discountSearch=false;
            $this->discountForm=true;
            
            if($discountGroup['Id']==8 || $discountGroup['Id']==9){
                $this->searchStaffId=true;
                $this->discountCardApplyForm=false;
                $this->engineOilDiscountForm=false;
            }
            else if($discountGroup['Id']==41)
            {
                if(auth()->user('user')['station_id']!=1){
                    $this->engineOilDiscountForm=true;
                    $this->discountCardApplyForm=false;
                    $this->searchStaffId=false;
                }
                else
                {
                    $this->staffavailable="Discount Not Available..!";
                }
            }
            else
            {
                $this->discountCardApplyForm=true;
                $this->searchStaffId=false;
                $this->engineOilDiscountForm=false;
            }
        }
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
            if (!CustomerDiscountGroup::where([
                'customer_id'=>$this->customer_id,
                'vehicle_id'=>$this->vehicle_id,
                'discount_id'=>$this->selectedDiscount['id'],
            ])->exists())
            {
                $customerStaffIdResult = (array)$customerStaffIdCheck[0];
                $customerDiscontGroupInfo = [
                    'customer_id'=>$this->customer_id,
                    'vehicle_id'=>$this->vehicle_id,
                    'discount_id'=>$this->selectedDiscount['id'],
                    'discount_unit_id'=>$this->selectedDiscount['unitId'],
                    'discount_code'=>$this->selectedDiscount['code'],
                    'discount_title'=>$this->selectedDiscount['title'],
                    'employee_code'=>$customerStaffIdResult['employee_code'],
                    'employee_name'=>$customerStaffIdResult['Name'],
                    'groupType'=>$this->selectedDiscount['groupType'],
                    'is_active'=>1,
                    'is_default'=>1,
                    'created_at'=>Carbon::now(),
                ];
                
                $customerDiscontGroup = CustomerDiscountGroup::create($customerDiscontGroupInfo);
            }
            else
            {

                $customerDiscontGroup = CustomerDiscountGroup::where([
                    'customer_id'=>$this->customer_id,
                    'vehicle_id'=>$this->vehicle_id,
                    'discount_id'=>$this->selectedDiscount['id']
                ])->first();
            }
            
            
            $this->appliedDiscount = $this->selectedDiscount;
            //$this->applyDiscountOnCart();
            $this->dispatchBrowserEvent('closeDiscountGroupModal');
        }
        else
        {
            $this->staffavailable="Employee does not exist..!";
        }

    }

    public function selectEngineOilDiscount($percentage){
        
        $this->discountCardApplyForm=false;
        $this->discountForm=false;
        $this->appliedDiscount = $this->selectedDiscount;

        $this->engineOilDiscountPercentage=$percentage;
        $this->customerDiscontGroupId = $this->selectedDiscount['id'];
        $this->customerDiscontGroupCode = $this->selectedDiscount['code'];
        $this->applyEngineOilDiscount();
        
        $this->dispatchBrowserEvent('closeDiscountGroupModal');
    }

    public function savedCustomerDiscountGroup($savedCustDiscount){
        //dd($savedCustDiscount);
        $getSavedCustDiscount = LaborCustomerGroup::find($savedCustDiscount['discount_id']);
        $this->selectedDiscount = [
            'unitId'=>$getSavedCustDiscount->UnitId,
            'code'=>$getSavedCustDiscount->Code,
            'title'=>$getSavedCustDiscount->Title,
            'id'=>$getSavedCustDiscount->Id,
            'groupType'=>$getSavedCustDiscount->GroupType,
        ];
        $this->appliedDiscount = $this->selectedDiscount;
        //$this->applyDiscountOnCart();
        $this->dispatchBrowserEvent('closeDiscountGroupModal');
    }

    public function applyEngineOilDiscount(){

        foreach($this->cartItems as $items)
        {
            if($items->cart_item_type==1){
                if(in_array($items->item_code,config('global.engine_oil_discount_voucher')['services']))
                {
                    $discountSalePrice= $this->engineOilDiscountPercentage;
                }
                else
                {
                    $discountSalePrice= null;
                }
                

            }
            else if($items->cart_item_type==2)
            {
                if(in_array($items->item_code,config('global.engine_oil_discount_voucher')['items']))
                {
                    $discountSalePrice= $this->engineOilDiscountPercentage;
                }
                else
                {
                    $discountSalePrice= null;
                }
            }

            if($discountSalePrice){
                //$cartUpdate['price_id']=$discountSalePrice->PriceID;
                $cartUpdate['customer_group_id']=$this->customerDiscontGroupId;
                $cartUpdate['customer_group_code']=$this->customerDiscontGroupCode;
                //$cartUpdate['min_price']=$discountSalePrice->MinPrice;
                //$cartUpdate['max_price']=$discountSalePrice->MaxPrice;
                //$cartUpdate['start_date']=$discountSalePrice->StartDate;
                //$cartUpdate['end_date']=$discountSalePrice->EndDate;
                $cartUpdate['discount_perc']=$discountSalePrice;
                CustomerServiceCart::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->vehicle_id,'id'=>$items->id])->update($cartUpdate);
            }
        }

    }

    

    public function saveSelectedDiscountGroup(){
        $proceeddisctount=false;
        $validatedData = $this->validate([
            //'discount_card_imgae' => 'required',
            'discount_card_number' => 'required',
            'discount_card_validity' => 'required',
        ]);
        $customerDiscountGroupQuery = CustomerDiscountGroup::where([
                'customer_id'=>$this->customer_id,
                'vehicle_id'=>$this->vehicle_id,
                'discount_id'=>$this->selectedDiscount['id'],
                'discount_card_number'=>$this->discount_card_number,
                'is_active'=>1
            ]);
        if (!$customerDiscountGroupQuery->exists())
        {
        
            $customerDiscontGroupInfo = [
                'customer_id'=>$this->customer_id,
                'vehicle_id'=>$this->vehicle_id,
                'discount_id'=>$this->selectedDiscount['id'],
                'discount_unit_id'=>$this->selectedDiscount['unitId'],
                'discount_code'=>$this->selectedDiscount['code'],
                'discount_title'=>$this->selectedDiscount['title'],
                'discount_card_number'=>$this->discount_card_number,
                'discount_card_validity'=>$this->discount_card_validity,
                'groupType'=>$this->selectedDiscount['groupType'],
                'is_active'=>1,
                'is_default'=>1,
                'created_at'=>Carbon::now(),
            ];
            
            if($this->discount_card_imgae)
            {
                $customerDiscontGroupInfo['discount_card_imgae'] = $this->discount_card_imgae->store('discount_group', 'public');
            }
            $customerDiscontGroup = CustomerDiscountGroup::create($customerDiscontGroupInfo);
        }
        else{
            $customerDiscountGroupQuery->update([
                'discount_card_validity'=>$this->discount_card_validity,
                'groupType'=>$this->selectedDiscount['groupType']
            ]);
            
        }

        $this->appliedDiscount = $this->selectedDiscount;
        //$this->applyDiscountOnCart();
        $this->dispatchBrowserEvent('closeDiscountGroupModal');

    }

    public function removeLineDiscount($serviceId){
        $cartUpdate['price_id']=null;
        $cartUpdate['customer_group_id']=null;
        $cartUpdate['customer_group_code']=null;
        $cartUpdate['min_price']=null;
        $cartUpdate['max_price']=null;
        $cartUpdate['start_date']=null;
        $cartUpdate['end_date']=null;
        $cartUpdate['discount_perc']=null;
        CustomerServiceCart::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->vehicle_id,'id'=>$serviceId])->update($cartUpdate);
    }

    public function removeDiscount(){

        $this->selectedDiscount=null;
        $this->appliedDiscount = null;
        //dd($this->cartItems);
        /*foreach($this->cartItems as $items)
        {
            $cartUpdate['price_id']=null;
            $cartUpdate['customer_group_id']=null;
            $cartUpdate['customer_group_code']=null;
            $cartUpdate['min_price']=null;
            $cartUpdate['max_price']=null;
            $cartUpdate['start_date']=null;
            $cartUpdate['end_date']=null;
            $cartUpdate['discount_perc']=null;
            CustomerServiceCart::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->vehicle_id,'id'=>$items->id])->update($cartUpdate);
        }*/
    }

    public function applyDiscountOnCart(){
        foreach($this->cartItems as $items)
        {
            if($items->cart_item_type==1){
                $discountCartServicePrices = LaborSalesPrices::where(['ServiceItemId'=>$items->item_id,'CustomerGroupCode'=>$this->appliedDiscount['code']])->where('StartDate', '<=', Carbon::now());
                if($this->appliedDiscount['groupType']==1)
                {
                    $discountCartServicePrices = $discountCartServicePrices->where('EndDate', '=', null );
                }
                else if($this->appliedDiscount['groupType']==2)
                {
                    $discountCartServicePrices = $discountCartServicePrices->where('EndDate', '>=', Carbon::now() );
                }
                if($discountCartServicePrices->exists())
                {
                    $serviceCartDiscountSalePrice = $discountCartServicePrices->first();
                    
                    $cartUpdate = [
                        'price_id'=>$serviceCartDiscountSalePrice->PriceID,
                        'customer_group_id'=>$this->appliedDiscount['id'],
                        'customer_group_code'=>$this->appliedDiscount['code'],
                        'min_price'=>$serviceCartDiscountSalePrice->MinPrice,
                        'max_price'=>$serviceCartDiscountSalePrice->MaxPrice,
                        'start_date'=>$serviceCartDiscountSalePrice->StartDate,
                        'end_date'=>$serviceCartDiscountSalePrice->EndDate,
                        'discount_perc'=>$serviceCartDiscountSalePrice->DiscountPerc,
                    ];
                    CustomerServiceCart::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->vehicle_id,'id'=>$items->id])->update($cartUpdate);
                }

            }
            else if($items->cart_item_type==2){
                $discountCartServiceItemPrices = InventorySalesPrices::where([
                    'ServiceItemId'=>$items->item_id,
                    'CustomerGroupCode'=>$this->appliedDiscount['code'],
                    'DivisionCode'=>auth()->user('user')['station_code'],
                ]);
                if($this->appliedDiscount['groupType']==1)
                {
                    //$discountCartServiceItemPrices = $discountCartServiceItemPrices;

                }else if($this->appliedDiscount['groupType']==2)
                {
                    $discountCartServiceItemPrices = $discountCartServiceItemPrices->where('StartDate', '<=', Carbon::now())->where('EndDate', '>=', Carbon::now() );
                }
                //$discountCartServiceItemPrices = $discountCartServiceItemPrices->first();
                if($discountCartServiceItemPrices->exists())
                {
                    $serviceCartDiscountSalePrice = $discountCartServiceItemPrices->first();
                    
                    $cartUpdate = [
                        'price_id'=>$serviceCartDiscountSalePrice->PriceID,
                        'customer_group_id'=>$this->appliedDiscount['id'],
                        'customer_group_code'=>$this->appliedDiscount['code'],
                        'min_price'=>$serviceCartDiscountSalePrice->MinPrice,
                        'max_price'=>$serviceCartDiscountSalePrice->MaxPrice,
                        'start_date'=>$serviceCartDiscountSalePrice->StartDate,
                        'end_date'=>$serviceCartDiscountSalePrice->EndDate,
                        'discount_perc'=>$serviceCartDiscountSalePrice->DiscountPerc,
                    ];
                    CustomerServiceCart::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->vehicle_id,'id'=>$items->id])->update($cartUpdate);
                }
                //dd($discountCartServiceItemPrices);
            }
        }
    }

    public function editCustomer(){
        $this->selectedCustomerVehicle=false;
        //$this->showServiceGroup=false;
        $this->showServiceSectionsList=false;
        $this->showServiceItems=false;
        $this->showDiscountDroup=false;

        $this->editCUstomerInformation=true;
        $this->showForms=true;
        $this->searchByMobileNumber=true;
        $this->showByMobileNumber=true;
        $this->editCustomerAndVehicle=true;
        $this->showCustomerForm=true;
        $this->showPlateNumber=true;
        $this->otherVehicleDetailsForm=true;
        $this->searchByChaisisForm=true;
        $this->updateVehicleFormBtn=true;
        $this->cancelEdidAddFormBtn=true;

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
    }
    public function updateVehicleCustomer(){
        $validatedData = $this->validate([
            'plate_country'=>'required',
            'plate_state'=>'required',
            'plate_code'=>'required',
            'plate_number'=>'required',
            'vehicle_type' => 'required',
            'make' => 'required',
            'model'=> 'required',
        ]);

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
        if($this->vehicle_id){
            $customerVehicleUpdate=[];
            if($this->vehicle_image)
            {
                $customerVehicleUpdate['vehicle_image']=$this->vehicle_image->store('vehicle', 'public');
            }

            if($this->plate_number_image)
            {
                $customerVehicleUpdate['plate_number_image'] = $this->plate_number_image->store('plate_number', 'public');
            }

            if($this->chaisis_image)
            {
                $customerVehicleUpdate['chaisis_image'] = $this->chaisis_image->store('chaisis_image', 'public');
            }

            if($this->customer_id)
            {
                $customerId = $this->customer_id;
            }
            

            $customerVehicleUpdate['customer_id']=$this->customer_id;
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
            $customerVehicleUpdate['created_by']=auth()->user('user')['id'];
            //dd($customerVehicleUpdate);
            CustomerVehicle::where(['id'=>$this->vehicle_id,'customer_id'=>$this->customer_id])->update($customerVehicleUpdate);
        }
        $this->selectedCustomerVehicle=true;
        $this->editCUstomerInformation=false;
        $this->updateVehicleFormBtn=false;
        $this->showForms=false;
        $this->dispatchBrowserEvent('refreshPage');
        session()->flash('success', 'Customer vehicle details updated Successfully !');
    }
    public function addNewVehicle(){
        $this->selectedCustomerVehicle=false;
        //$this->showServiceGroup=false;
        $this->showServiceSectionsList=false;
        $this->showServiceItems=false;
        $this->showDiscountDroup=false;

        $this->addNewVehicleInformation=true;
        $this->showForms=true;
        $this->searchByMobileNumber=false;
        $this->showByMobileNumber=false;
        $this->editCustomerAndVehicle=true;
        $this->showCustomerForm=true;
        $this->showPlateNumber=true;
        $this->otherVehicleDetailsForm=true;
        $this->searchByChaisisForm=true;
        $this->addVehicleFormBtn=true;
        $this->cancelEdidAddFormBtn=true;

        
        $this->mobile = $this->selectedVehicleInfo->customerInfoMaster['Mobile'];
        $this->name = $this->selectedVehicleInfo->customerInfoMaster['TenantName'];
        $this->email = $this->selectedVehicleInfo->customerInfoMaster['Email'];
        $this->customer_id = $this->selectedVehicleInfo->customerInfoMaster['TenantId'];
        $this->customer_code = $this->selectedVehicleInfo->customerInfoMaster['TenantCode'];

        $this->plate_country = 'AE';
        $this->plate_state = 'Dubai';
        $this->plate_category = null;
        $this->plate_code = null;
        $this->plate_number = null;
        $this->vehicle_type = null;
        $this->make = null;
        $this->model = null;
        $this->chassis_number = null;
        $this->vehicle_image = null;
        $this->chaisis_image = null;
        $this->vehicle_km = null;
    }

    public function addNewCustomerVehicle(){
        
        $validatedData = $this->validate([
            'plate_country'=>'required',
            'plate_state'=>'required',
            'plate_code'=>'required',
            'plate_number'=>'required',
            'vehicle_type' => 'required',
            'make' => 'required',
            'model'=> 'required',
        ]);

        
        if($this->vehicle_image)
        {
            $customerVehicleInsert['vehicle_image'] = $this->vehicle_image->store('vehicle', 'public');
        }
        if($this->plate_number_image)
        {
            $customerVehicleInsert['plate_number_image'] = $this->plate_number_image->store('plate_number', 'public');
        }
        if($this->chaisis_image)
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
        $customerVehicleInsert['created_by']=auth()->user('user')['id'];
        $customerVehicleInsert['is_active']=1;
        $newcustomer = CustomerVehicle::create($customerVehicleInsert);
        
        return redirect()->to('customer-service-job/'.$this->customer_id.'/'.$newcustomer->id);
        session()->flash('success', 'New Customer vehicle added Successfully !');
    }

    public function closeUpdateVehicleCustomer(){
        $this->dispatchBrowserEvent('refreshPage');
    }

    public function submitService(){
        if($this->job_number){
            return redirect()->to('submit-job-update/'.$this->customer_id.'/'.$this->vehicle_id.'/'.$this->job_number);
        }
        else{
            return redirect()->to('submit-job/'.$this->customer_id.'/'.$this->vehicle_id);
        }
    }

    public function openPackages(){

        $this->showPackageList=true;
        $this->selectPackageMenu=true;

        $this->service_group_id = null;
        $this->service_group_name = null;
        $this->service_group_code = null;
        $this->station = null;
        $this->section_service_search='';

        $this->propertyCode=null;
        $this->selectedSectionName = null;
        $this->showSectionsList=false;
        $this->showServiceSectionsList=false;

        $this->showQlItemSearch = false;
        $this->showQlItemsList = false;
        $this->showQlEngineOilItems=false;
        $this->showQlItemsOnly=false;
        $this->showServiceItems = false;

        $this->showBundleList=false;
        $this->selectBundleMenu=false;
        $this->dispatchBrowserEvent('scrollto', [
            'scrollToId' => 'packageServiceListDiv',
        ]);
    }

    public function openBundles(){

        $this->showBundleList=true;
        $this->selectBundleMenu=true;

        $this->showPackageList=false;
        $this->selectPackageMenu=false;

        $this->service_group_id = null;
        $this->service_group_name = null;
        $this->service_group_code = null;
        $this->station = null;
        $this->section_service_search='';

        $this->propertyCode=null;
        $this->selectedSectionName = null;
        $this->showSectionsList=false;
        $this->showServiceSectionsList=false;

        $this->showQlItemSearch = false;
        $this->showQlItemsList = false;
        $this->showQlEngineOilItems=false;
        $this->showQlItemsOnly=false;
        $this->showServiceItems = false;
        $this->dispatchBrowserEvent('scrollto', [
            'scrollToId' => 'bundleServiceListDiv',
        ]);
    }

    public function openBundleListDetails($bundleDetails){
        $this->selectedBundles=json_decode($bundleDetails,true);
        //dd($this->selectedBundles);
        $this->bundleServiceLists = [];
        //$this->bundleServiceLists[$this->selectedBundles['TypeId']]['show']=true;
        //dd($this->selectedBundles);
        foreach($this->selectedBundles['bundles_details'] as $selectedBundle)
        {
            //dd($selectedBundle);
            $this->bundleServiceLists[$selectedBundle['Code']] = $selectedBundle;
            //dd(ServiceBundleDiscountedPrice::where(['Code'=>$selectedBundle['Code']])->get());
            foreach(ServiceBundleDiscountedPrice::where(['Code'=>$selectedBundle['Code']])->get() as $sBDPkey => $serviceBundleDiscountedPrice){
                $this->bundleServiceLists[$selectedBundle['Code']]['lists'][$sBDPkey]['ServiceItemCode'] = $serviceBundleDiscountedPrice->ServiceItemCode;
                $this->bundleServiceLists[$selectedBundle['Code']]['lists'][$sBDPkey]['DiscountPerc'] = $serviceBundleDiscountedPrice->DiscountPerc;
                $this->bundleServiceLists[$selectedBundle['Code']]['lists'][$sBDPkey]['CustomerGroupId'] = $serviceBundleDiscountedPrice->CustomerGroupId;

                $this->bundleServiceLists[$selectedBundle['Code']]['lists'][$sBDPkey]['Type'] = $serviceBundleDiscountedPrice->Type;
                $this->bundleServiceLists[$selectedBundle['Code']]['lists'][$sBDPkey]['Division'] = $serviceBundleDiscountedPrice->Division;
                $this->bundleServiceLists[$selectedBundle['Code']]['lists'][$sBDPkey]['ItemName'] = $serviceBundleDiscountedPrice->ItemName;
                $this->bundleServiceLists[$selectedBundle['Code']]['lists'][$sBDPkey]['Qty'] = $serviceBundleDiscountedPrice->Qty;
                
                if($serviceBundleDiscountedPrice->Type=='S')
                {
                    $bundleLaborMaster = LaborItemMaster::where([
                        //'DivisionCode'=>auth()->user('user')['station_code'],
                        'Active'=>1,
                        'ItemCode'=>$serviceBundleDiscountedPrice->ServiceItemCode,
                    ])->first();
                    $this->bundleServiceLists[$selectedBundle['Code']]['lists'][$sBDPkey]['services'] = $bundleLaborMaster;
                }
                else if($serviceBundleDiscountedPrice->Type=='I')
                {
                    $bundleItemMaster = InventoryItemMaster::where([
                        'Active'=>1,
                        'ItemCode'=>$serviceBundleDiscountedPrice->ServiceItemCode,
                    ])->first();
                    
                    $this->bundleServiceLists[$selectedBundle['Code']]['lists'][$sBDPkey]['items'] = $bundleItemMaster;
                    
                }
            }
        }

        //dd($this->bundleServiceLists);
        $this->showBundleServiceSectionsList=true;
        $this->dispatchBrowserEvent('openBundleServicesListModal');
    }

    public function bundleAddtoCart($bundleListDetails){
        $bundleListDetails = json_decode($bundleListDetails,true);
        foreach($bundleListDetails['lists'] as $bundleInfo)
        {
            $bundleListDetails['PriceID'] = $bundleListDetails['Id'];
            $bundleListDetails['CustomerGroupId'] = $bundleListDetails['CustomerGroupId'];
            $bundleListDetails['CustomerGroupCode'] = $bundleListDetails['CustomerGroupCode'];
            $bundleListDetails['MinPrice'] = null;
            $bundleListDetails['MaxPrice'] = null;
            $bundleListDetails['StartDate'] = null;
            $bundleListDetails['EndDate'] = null;
            $bundleListDetails['DiscountPerc'] = $bundleInfo['DiscountPerc'];

            if($bundleInfo['Type']=='S'){
                $this->addtoCart(json_encode($bundleInfo['services']),json_encode($bundleListDetails));
            }
            if($bundleInfo['Type']=='I'){
                $this->addtoCartItem($bundleInfo['items']['ItemCode'],json_encode($bundleListDetails));
            }
        }
        //$this->showBundleServiceSectionsList=false;
        $this->dispatchBrowserEvent('closeBundleServicesListModal');
        $this->dispatchBrowserEvent('scrollto', [
            'scrollToId' => 'cartDisplayId',
        ]);
        session()->flash('success', 'New Bundle added Successfully !');
    }

    public function validatePackageContinue(){
        $validatedData = $this->validate([
            'package_number' => 'required',
        ]);
        $customerPackageInfo = PackageBookings::with(['customerInfo','customerVehicle','stationInfo'])->where(['package_number'=>$this->package_number])->first();
        if($customerPackageInfo->payment_status==2){
            if($customerPackageInfo->package_status==2){
                $mobileNumber = isset($customerPackageInfo->customerInfo['Mobile'])?'971'.substr($customerPackageInfo->customerInfo['Mobile'], -9):null;
                $customerName = isset($customerPackageInfo->customerInfo['TenantName'])?$customerPackageInfo->customerInfo['TenantName']:null;
                $otpPack = fake()->randomNumber(6);
                PackageBookings::where(['package_number'=>$this->package_number])->update(['otp_code'=>$otpPack,'otp_verify'=>0]);
                if($mobileNumber!=''){
                    if($mobileNumber=='971566993709'){
                        $msgtext = urlencode('Dear '.$customerName.', to confirm your GSS Service Contract creation, please use the OTP '.$otpPack.'. This OTP is valid for 10 minutes. Do not share it with anyone. For assistance, call 800477823.');
                        $response = Http::get(config('global.sms')[1]['sms_url']."&mobileno=".$mobileNumber."&msgtext=".$msgtext."&CountryCode=ALL");
                    }
                }
                $this->showPackageOtpVerify=true;
                session()->flash('package_success', 'Package is valid, '.$otpPack.' please enter the OTP shared in the registered mobile number..!');
            }
            else{
                session()->flash('package_error', 'Package is invalid !');
            }
        }
        else{
            session()->flash('package_error', 'Package is invalid !');
        }
        
    }

    public function verifyPackageOtp(){
        $validatedData = $this->validate([
            'package_otp' => 'required',
        ]);
        //dd(PackageBookings::where(['package_number'=>$this->package_number,'otp_code'=>$this->package_otp])->exists());
        if(PackageBookings::where(['package_number'=>$this->package_number,'otp_code'=>$this->package_otp])->exists())
        {
            $this->showOpenPackageDetails=true;
            $this->showPackageServiceSectionsList=true;
            $this->showPackageOtpVerify=false;
            $this->otpVerified=true;
            $this->dispatchBrowserEvent('openServicesPackageListModal');

        }
        else
        {
            $this->showPackageOtpVerify=true;
            $this->otpVerified=false;
            $this->otp_message='OTP is not matching..!';
            $this->dispatchBrowserEvent('scrollto', [
                'scrollToId' => 'packageOTPVerifyRow',
            ]);
        }
    }

    public function resendPackageOtp(){
        $this->package_otp=null;
        $customerPackageInfo = PackageBookings::with(['customerInfo','customerVehicle','stationInfo'])->where(['package_number'=>$this->package_number])->first();
        $mobileNumber = isset($customerPackageInfo->customerInfo['Mobile'])?'971'.substr($customerPackageInfo->customerInfo['Mobile'], -9):null;
        $customerName = isset($customerPackageInfo->customerInfo['TenantName'])?$customerPackageInfo->customerInfo['TenantName']:null;
        $otpPack = fake()->randomNumber(6);
        PackageBookings::where(['package_number'=>$this->package_number])->update(['otp_code'=>$otpPack,'otp_verify'=>0]);
        if($mobileNumber!=''){
            //if($mobileNumber=='971566993709'){
                $msgtext = urlencode('Dear '.$customerName.', to confirm your GSS Service Contract creation, please use the OTP '.$otpPack.'. This OTP is valid for 10 minutes. Do not share it with anyone. For assistance, call 800477823.');
                $response = Http::get(config('global.sms')[1]['sms_url']."&mobileno=".$mobileNumber."&msgtext=".$msgtext."&CountryCode=ALL");
            //}
        }
        $this->showOtpVerify=true;
    }

    public function packageContinue($servicePackageId){
        return redirect()->to('submit-package/'.$this->customer_id.'/'.$this->vehicle_id.'/'.$servicePackageId);
    }

    public function confirmDelete($id)
    {
        $this->confirming = $id;
    }

    public function kill($id,$item_id)
    {
        //dd($item_id);
        //dd($id);
        CustomerServiceCart::where(['id'=>$id])->delete();
        if($this->job_number){
            $chheckCustomerJobServiceQuery = CustomerJobCardServices::where(['job_number'=>$this->job_number,'item_id'=>$item_id]);
            if($chheckCustomerJobServiceQuery->exists()){
                $chheckCustomerJobServiceQuery->delete();
            }
        }
    }

    public function safe($id){
        $this->confirming = null;
    }


    public function customerJobDetails(){
        $customerJobCardsQuery = CustomerJobCards::with(['customerInfo','customerJobServices','checklistInfo','makeInfo','modelInfo','tempServiceCart','checklistInfo']);
        $customerJobCardsQuery = $customerJobCardsQuery->where(['job_number'=>$this->job_number]);



        $this->jobDetails =  $customerJobCardsQuery->first();
        $this->customer_id = $this->jobDetails->customer_id;
        $this->vehicle_id = $this->jobDetails->vehicle_id;
        $this->showTempCart = true;
        if(!CustomerServiceCart::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->vehicle_id,'job_number'=>$this->job_number])->exists())
        {
            foreach($this->jobDetails->customerJobServices as $customerJobServices)
            {
                $customerBasketCheck = CustomerServiceCart::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->vehicle_id,'item_id'=>$customerJobServices->item_id,'job_number'=>$this->job_number]);
                if($customerBasketCheck->count()==0)
                {
                    $cartInsert = [
                        'customer_id'=>$this->customer_id,
                        'vehicle_id'=>$this->vehicle_id,
                        'item_id'=>$customerJobServices->item_id,
                        'item_code'=>$customerJobServices->item_code,
                        'cart_item_type'=>$customerJobServices->service_item_type,
                        'company_code'=>$customerJobServices->company_code,
                        'category_id'=>$customerJobServices->category_id,
                        'sub_category_id'=>$customerJobServices->sub_category_id,
                        'brand_id'=>$customerJobServices->brand_id,
                        'bar_code'=>$customerJobServices->bar_code,
                        'item_name'=>$customerJobServices->item_name,
                        'description'=>$customerJobServices->description,
                        'division_code'=>$customerJobServices->division_code,
                        'department_code'=>$customerJobServices->department_code,
                        'department_name'=>$customerJobServices->department_name,
                        'section_code'=>$customerJobServices->section_code,
                        'unit_price'=>$customerJobServices->total_price,
                        'quantity'=>$customerJobServices->quantity,
                        'created_by'=>auth()->user('user')->id,
                        'created_at'=>Carbon::now(),
                        'job_number'=>$customerJobServices->job_number,
                    ];
                    $cartInsert['price_id']=$customerJobServices->discount_id;
                    $cartInsert['customer_group_id']=$customerJobServices->discount_id;
                    $cartInsert['customer_group_code']=$customerJobServices->discount_code;
                    $cartInsert['min_price']=$customerJobServices->discount_amount;
                    $cartInsert['max_price']=$customerJobServices->discount_amount;
                    $cartInsert['start_date']=$customerJobServices->discount_start_date;
                    $cartInsert['end_date']=$customerJobServices->discount_end_date;
                    $cartInsert['discount_perc']=$customerJobServices->discount_percentage;

                    CustomerServiceCart::insert($cartInsert);
                }
                else
                {
                    $customerBasketCheck->increment('quantity', 1);
                }
            }

        }
    }

    public function checkCustomizedPrice($itemId)
    {
        dd($this->customise_service_item_price[$itemId]);
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
}
