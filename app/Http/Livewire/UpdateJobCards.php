<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Carbon\Carbon;
use Session;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use DB;

use App\Models\CustomerJobCards;
use App\Models\CustomerJobCardServices;
use App\Models\CustomerJobCardServiceLogs;
use App\Models\CustomerVehicle;
use App\Models\LaborCustomerGroup;
use App\Models\Development;
use App\Models\Sections;
use App\Models\LaborItemMaster;
use App\Models\TempCustomerServiceCart;
use App\Models\InventoryItemMaster;
use App\Models\CustomerDiscountGroup;
use App\Models\LaborSalesPrices;
use App\Models\ItemCategories;
use App\Models\InventorySubCategory;
use App\Models\InventoryBrand;
use App\Models\InventorySalesPrices;
use App\Models\ServiceChecklist;
use App\Models\StateList;
use App\Models\PlateCode;
use App\Models\Vehicletypes;
use App\Models\VehicleMakes;
use App\Models\VehicleModels;

class UpdateJobCards extends Component
{

    public $jobDetails, $selectedVehicleInfo;
    public $showServiceGroup=false, $confirmContinueUpdate=false, $vehicleServvicesItems=true, $editCUstomerInformation=false, $showServiceItems=false, $showQlItemSearch=false, $showSectionsList=false, $showQlItemsList=false, $showQlEngineOilItems=false, $showQlItemsOnly=false, $showItemsSearchResults=false, $showServiceSectionsList=false;
    public $mobile, $name, $email, $customer_code, $plate_number_image, $plate_country = 'AE', $plateStateCode=2, $plate_state='Dubai', $plate_category, $plate_code, $plate_number, $vehicle_image, $vehicle_type, $make, $model, $chaisis_image, $chassis_number, $vehicle_km;
    public $stateList, $plateEmiratesCodes, $vehicleTypesList, $listVehiclesMake, $vehiclesModelList=[];
    public $customer_id, $vehicle_id;
    public $servicesGroupList, $service_group_id, $service_group_name, $service_group_code, $station, $section_service_search, $propertyCode, $selectedSectionName;
    public $sectionsLists;
    public $customerGroupLists, $selectedDiscount, $appliedDiscount=[], $showDiscountDroup=false, $discountSearch=true;
    public $discount_card_imgae, $discount_card_number, $discount_card_validity;
    public $discountCardApplyForm=false, $engineOilDiscountForm=false, $discountForm=false;
    public $customerSelectedDiscountGroup, $employeeId, $searchStaffId, $staffavailable, $serviceAddedMessgae=[];



    public $sectionServiceLists=[],$service_sort=1, $selectServiceItems, $selectPackageMenu=false;
    public $jobCardDetails;
    public $qlFilterOpen=false, $qlBrandsLists=[];

    public $quickLubeItemsList=[],$serviceItemsList=[], $quickLubeItemSearch='', $showQlItems=false, $showQlCategoryFilterItems=false, $showQuickLubeItemSearchItems=false, $itemQlCategories=[],  $ql_search_category, $ql_search_subcategory, $ql_search_brand, $ql_km_range;
    public $item_search_category, $itemCategories=[], $item_search_subcategory, $itemSubCategories =[], $item_search_brand, $itemBrandsLists=[], $itemSearchName, $ql_item_qty;
    public $discountGroup;
    public $confirming;

    //Discount Section 
    public $tempServiceCart;
    public $totalDiscount, $total, $tax, $grand_total, $showCheckList, $showFuelScratchCheckList, $showCheckout, $showQLCheckList, $successPage;
    public $checklistLabels = [], $checklistLabel = [], $fuel, $scratchesFound, $scratchesNotFound, $vImageR1, $vImageR2, $vImageF, $vImageB, $vImageL1, $vImageL2, $customerSignature, $vImageR1T, $vImageR2T, $vImageFT, $vImageBT, $vImageL1T, $vImageL2T;

    function mount( Request $request) {
        $this->job_number = $request->job_number;
        if($this->job_number)
        {
            $this->customerJobDetails();
            $this->selectVehicle();
            $this->applyItemToTempCart();
        }

    }

    public function render()
    {
        if($this->editCUstomerInformation)
        {
            $this->stateList = StateList::where(['CountryCode'=>$this->plate_country])->get();
            if($this->plate_state){
                $this->plateEmiratesCodes = PlateCode::where(['plateEmiratesId'=>$this->plateStateCode,'is_active'=>1])->get();
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
        else
        {
            $this->servicesGroupList=[];
        }

        if($this->showSectionsList){
            $this->sectionsLists = Sections::select('id','PropertyCode','DevelopmentCode','PropertyNo','PropertyName','Operation')
                ->where([
                    'DevelopmentCode'=>$this->service_group_code,
                    'Operation'=>true
                ])
                ->orderBy('SortIndex','ASC')
                ->get();
        }
        else
        {
            $this->sectionsLists =[];
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
                else
                {
                    $sectionServicePriceLists[$key]['discountDetails']=null;
                }
            }
            $this->sectionServiceLists = $sectionServicePriceLists;
        }
        else
        {
            $this->sectionServiceLists=[];
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

                    if($this->ql_search_category!=43)
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
                    else
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
        

        
        $this->tempServiceCart = TempCustomerServiceCart::where(['customer_id'=>$this->jobDetails->customer_id,'vehicle_id'=>$this->jobDetails->vehicle_id,'job_number'=>$this->job_number])->get();


        $this->dispatchBrowserEvent('selectSearchEvent');
            
        return view('livewire.update-job-cards');
    }

    public function customerJobDetails(){
        $customerJobCardsQuery = CustomerJobCards::with(['customerInfo','customerJobServices','checklistInfo','makeInfo','modelInfo','tempServiceCart','checklistInfo']);
        $customerJobCardsQuery = $customerJobCardsQuery->where(['job_number'=>$this->job_number]);

        $this->jobDetails =  $customerJobCardsQuery->first();
        //dd($this->jobDetails);
        $this->customer_id = $this->jobDetails->customer_id;
        $this->vehicle_id = $this->jobDetails->vehicle_id;
    }

    public function selectVehicle(){
        $customers = CustomerVehicle::with(['customerInfoMaster','makeInfo','modelInfo','customerDiscountLists'])->where(['is_active'=>1,'id'=>$this->jobDetails->vehicle_id,'customer_id'=>$this->jobDetails->customer_id])->first();
        $this->selectedVehicleInfo=$customers;
    }

    public function editCustomer(){
        $this->editCUstomerInformation=true;
        $this->vehicleServvicesItems=false;
        $this->showServiceGroup=false;
        $this->showCheckList=false;
        $this->showCheckout=false;
        $this->dispatchBrowserEvent('imageUpload');

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
            CustomerVehicle::where(['id'=>$this->vehicle_id,'customer_id'=>$this->customer_id])->update($customerVehicleUpdate);
        }
        
        $this->editCUstomerInformation=false;
        $this->vehicleServvicesItems=true;
        $this->showServiceGroup=false;
        $this->showCheckList=false;
        $this->showCheckout=false;

        session()->flash('success', 'Customer vehicle details updated Successfully !');
    }

    public function closeUpdateVehicleCustomer(){
        $this->dispatchBrowserEvent('refreshPage');
    }


    public function openServiceGroup(){
        $this->showServiceGroup=true;
        $this->showCheckList=false;
        $this->showCheckout=false;
        $this->showPayLaterCheckout=false;
        $this->successPage=false;
        $this->dispatchBrowserEvent('scrollto', [
            'scrollToId' => 'servceGroup',
        ]);
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
        $this->dispatchBrowserEvent('scrollto', [
            'scrollToId' => 'servceSectionsList',
        ]);
    }

    public function getSectionServices($section)
    {
        $this->serviceAddedMessgae=[];
        $this->propertyCode=$section['PropertyCode'];
        $this->selectedSectionName = $section['PropertyName'];
        $this->showServiceSectionsList=true;
        $this->showServiceItems = false;
        $this->dispatchBrowserEvent('openServicesListModal');
        
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
        $this->servicePackage=[];
        $this->dispatchBrowserEvent('scrollto', [
            'scrollToId' => 'servceGroup',
        ]);
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

        $this->dispatchBrowserEvent('scrollto', [
            'scrollToId' => 'serviceQlItems',
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
        $this->dispatchBrowserEvent('scrollto', [
            'scrollToId' => 'serviceQlItems',
        ]);
    }

    public function qlCategorySelect(){
        $this->showQlItems=true;
        $this->showQlCategoryFilterItems=true;
        $this->showQuickLubeItemSearchItems=false;
        $this->dispatchBrowserEvent('scrollto', [
            'scrollToId' => 'serviceQlItems',
        ]);
    }
    
    public function confirmDelete($id)
    {
        $this->confirming = $id;
    }

    public function kill($id,$item_id)
    {
        //dd($item_id);
        //dd($id);
        TempCustomerServiceCart::where(['id'=>$id])->delete();
        CustomerJobCardServices::where(['job_number'=>$this->job_number,'item_id'=>$item_id])->delete();
        $this->applyItemToTempCart();
        //CustomerJobCardServices::destroy($id);
    }
    public function safe($id)
    {
        $this->confirming = null;
    }

    public function removeCoupon()
    {
        dd($this->jobDetails);
    }

    public function applyItemToTempCart(){
        //dd($this->jobDetails->customerJobServices);
        foreach($this->jobDetails->customerJobServices as $customerJobServices){
            
                //dd($customerJobServices);
                $customerBasketCheck = TempCustomerServiceCart::where(['customer_id'=>$this->jobDetails->customer_id,'vehicle_id'=>$this->jobDetails->vehicle_id,'item_id'=>$customerJobServices->item_id,'job_number'=>$this->job_number]);
                if($customerBasketCheck->count()>0)
                {
                    if(!empty($this->appliedDiscount)){
                        if($customerJobServices->service_item_type==1){
                        
                            $discountSalePriceQuery = LaborItemMaster::with(['discountServicePrice' => function ($query) {
                                $query->where('CustomerGroupCode', '=', $this->appliedDiscount['code']);
                                //$query->where('StartDate', '<=', Carbon::now());
                                //$query->where('EndDate', '=', null);
                            }])->where(['ItemId'=>$customerJobServices->item_id])->first();
                            $discountSalePrice= $discountSalePriceQuery->discountServicePrice;

                        }
                        else if($customerJobServices->service_item_type==2)
                        {
                            $discountSalePriceQuery = InventoryItemMaster::with(['discountItemPrice' => function ($query) {
                                $query->where('CustomerGroupCode', '=', $this->appliedDiscount['code']);
                                //$query->where('StartDate', '<=', Carbon::now());
                                //$query->where('EndDate', '=', null);
                            }])->where(['ItemId'=>$customerJobServices->item_id])->first();
                            $discountSalePrice= $discountSalePriceQuery->discountItemPrice;
                        }
                        $cartUpdate=[];
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
                            TempCustomerServiceCart::where(['customer_id'=>$this->jobDetails->customer_id,'vehicle_id'=>$this->jobDetails->vehicle_id,'item_id'=>$customerJobServices->item_id,'job_number'=>$this->job_number])->update($cartUpdate);
                        }

                    }

                }
                else
                {
                    $cartInsert = [
                        'customer_id'=>$this->jobDetails->customer_id,
                        'vehicle_id'=>$this->jobDetails->vehicle_id,
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

                    if(!empty($this->appliedDiscount)){
                        if($customerJobServices->service_item_type==1){
                        
                            $discountSalePriceQuery = LaborItemMaster::with(['discountServicePrice' => function ($query) {
                                $query->where('CustomerGroupCode', '=', $this->appliedDiscount['code']);
                                //$query->where('StartDate', '<=', Carbon::now());
                                //$query->where('EndDate', '=', null);
                            }])->where(['ItemId'=>$customerJobServices->item_id])->first();
                            $discountSalePrice= $discountSalePriceQuery->discountServicePrice;

                        }
                        else if($customerJobServices->service_item_type==2)
                        {
                            $discountSalePriceQuery = InventoryItemMaster::with(['discountItemPrice' => function ($query) {
                                $query->where('CustomerGroupCode', '=', $this->appliedDiscount['code']);
                                //$query->where('StartDate', '<=', Carbon::now());
                                //$query->where('EndDate', '=', null);
                            }])->where(['ItemId'=>$items->item_id])->first();
                            $discountSalePrice= $discountSalePriceQuery->discountItemPrice;
                        }

                        if($discountSalePrice){
                            $cartInsert['price_id']=$discountSalePrice->PriceID;
                            $cartInsert['customer_group_id']=$discountSalePrice->CustomerGroupId;
                            $cartInsert['customer_group_code']=$discountSalePrice->CustomerGroupCode;
                            $cartInsert['min_price']=$discountSalePrice->MinPrice;
                            $cartInsert['max_price']=$discountSalePrice->MaxPrice;
                            $cartInsert['start_date']=$discountSalePrice->StartDate;
                            $cartInsert['end_date']=$discountSalePrice->EndDate;
                            $cartInsert['discount_perc']=$discountSalePrice->DiscountPerc;
                            
                        }

                    }
                    else
                    {
                        $cartInsert['price_id']=$customerJobServices->discount_id;
                        $cartInsert['customer_group_id']=$customerJobServices->discount_id;
                        $cartInsert['customer_group_code']=$customerJobServices->discount_code;
                        $cartInsert['min_price']=$customerJobServices->discount_amount;
                        $cartInsert['max_price']=$customerJobServices->discount_amount;
                        $cartInsert['start_date']=$customerJobServices->discount_start_date;
                        $cartInsert['end_date']=$customerJobServices->discount_end_date;
                        $cartInsert['discount_perc']=$customerJobServices->discount_percentage;
                    }
                    TempCustomerServiceCart::insert($cartInsert);
                }
            
            
        }
    }



    public function addtoCart($servicePrice,$discount)
    {
        $servicePrice = json_decode($servicePrice,true);
        $discountPrice = json_decode($discount,true);
        $customerBasketCheck = TempCustomerServiceCart::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->vehicle_id,'item_id'=>$servicePrice['ItemId'],'job_number'=>$this->job_number]);
        if($customerBasketCheck->count())
        {
            $customerBasketCheck->increment('quantity', 1);
            if(!empty($discountPrice)){
                $cartUpdate['price_id']=$discountPrice['PriceID'];
                $cartUpdate['customer_group_id']=$discountPrice['CustomerGroupId'];
                $cartUpdate['customer_group_code']=$discountPrice['CustomerGroupCode'];
                $cartUpdate['min_price']=$discountPrice['MinPrice'];
                $cartUpdate['max_price']=$discountPrice['MaxPrice'];
                $cartUpdate['start_date']=$discountPrice['StartDate'];
                $cartUpdate['end_date']=$discountPrice['EndDate'];
                $cartUpdate['discount_perc']=$discountPrice['DiscountPerc'];
                TempCustomerServiceCart::where([
                    'customer_id'=>$this->jobDetails->customer_id,
                    'vehicle_id'=>$this->jobDetails->vehicle_id,
                    'item_id'=>$servicePrice['ItemId'],
                    'job_number'=>$this->job_number,
                ])->update($cartUpdate);
            }
            
        }
        else
        {
            $cartInsert = [
                'job_number'=>$this->job_number,
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
                'created_by'=>auth()->user('user')->id,
                'created_at'=>Carbon::now(),
            ];
            
            if(!empty($discountPrice)){
                $cartInsert['price_id']=$discountPrice['PriceID'];
                $cartInsert['customer_group_id']=$discountPrice['CustomerGroupId'];
                $cartInsert['customer_group_code']=$discountPrice['CustomerGroupCode'];
                $cartInsert['min_price']=$discountPrice['MinPrice'];
                $cartInsert['max_price']=$discountPrice['MaxPrice'];
                $cartInsert['start_date']=$discountPrice['StartDate'];
                $cartInsert['end_date']=$discountPrice['EndDate'];
                $cartInsert['discount_perc']=$discountPrice['DiscountPerc'];
            }
            //dd($cartInsert);
            TempCustomerServiceCart::insert($cartInsert);
        }
        $this->serviceAddedMessgae[$servicePrice['ItemCode']]=true;
        //$this->dispatchBrowserEvent('closeServicesListModal');
        //session()->flash('cartsuccess', 'Service is Added to Cart Successfully !');
    }

    public function addtoCartItem($items,$discount)
    {
        $items = json_decode($items,true);
        $discountPrice = json_decode($discount,true);
        $customerBasketCheck = TempCustomerServiceCart::where(['customer_id'=>$this->jobDetails->customer_id,'vehicle_id'=>$this->jobDetails->vehicle_id,'item_id'=>$items['ItemId'],'job_number'=>$this->job_number]);
        if($customerBasketCheck->count()>0)
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
                dd($cartUpdate);
                TempCustomerServiceCart::where([
                    'customer_id'=>$this->jobDetails->customer_id,
                    'vehicle_id'=>$this->jobDetails->vehicle_id,
                    'item_id'=>$items['ItemId'],
                    'job_number'=>$this->job_number,
                ])->update($cartUpdate);
            }
            

        }
        else
        {
            $cartInsert = [
                'job_number'=>$this->job_number,
                'customer_id'=>$this->jobDetails->customer_id,
                'vehicle_id'=>$this->jobDetails->vehicle_id,
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
                'division_code'=>$this->station,
                'department_code'=>$this->service_group_code,
                'department_name'=>$this->selectedSectionName,
                'section_code'=>$this->propertyCode,
                'unit_price'=>$items['UnitPrice'],
                'quantity'=>isset($this->ql_item_qty[$items['ItemId']])?$this->ql_item_qty[$items['ItemId']]:1,
                'created_by'=>auth()->user('user')->id,
                'created_at'=>Carbon::now(),
            ];
            if(!empty($discountPrice)){
                $cartInsert['price_id']=$discountPrice['PriceID'];
                $cartInsert['customer_group_id']=$discountPrice['CustomerGroupId'];
                $cartInsert['customer_group_code']=$discountPrice['CustomerGroupCode'];
                $cartInsert['min_price']=$discountPrice['MinPrice'];
                $cartInsert['max_price']=$discountPrice['MaxPrice'];
                $cartInsert['start_date']=$discountPrice['StartDate'];
                $cartInsert['end_date']=$discountPrice['EndDate'];
                $cartInsert['discount_perc']=$discountPrice['DiscountPerc'];
            }
                TempCustomerServiceCart::insert($cartInsert);
        }
        $this->serviceAddedMessgae[$items['ItemCode']]=true;
        session()->flash('cartsuccess', 'Service is Added to Cart Successfully !');
    }

    public function orderSetDownQty($cartId){
        TempCustomerServiceCart::find($cartId)->decrement('quantity');
    }
    public function orderSetUpQty($cartId){
        TempCustomerServiceCart::find($cartId)->increment('quantity');
    }


    public function clickDiscountGroup(){
        $this->discountSearch=true;
        $this->showDiscountDroup=true;
        $this->customerGroupLists = LaborCustomerGroup::get();
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
        if($discountGroup['GroupType']==2)
        {
            $this->applyDiscountOnCart();
            $this->discountCardApplyForm=false;
            $this->discountForm=false;
            $this->appliedDiscount = $this->selectedDiscount;
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
                if(Session()->get('user')['station_id']!=1){
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
            $this->applyDiscountOnCart();
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
        $this->applyDiscountOnCart();
        $this->dispatchBrowserEvent('closeDiscountGroupModal');
    }

    public function applyEngineOilDiscount(){

        foreach($this->tempServiceCart as $items)
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
                TempCustomerServiceCart::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->vehicle_id,'id'=>$items->id,'job_number'=>$this->job_number])->update($cartUpdate);
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
        $this->applyDiscountOnCart();
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
        TempCustomerServiceCart::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->vehicle_id,'id'=>$serviceId])->update($cartUpdate);
    }

    public function removeDiscount(){

        $this->selectedDiscount=null;
        $this->appliedDiscount = null;
        //dd($this->tempServiceCart);
        foreach($this->tempServiceCart as $items)
        {
            $cartUpdate['price_id']=null;
            $cartUpdate['customer_group_id']=null;
            $cartUpdate['customer_group_code']=null;
            $cartUpdate['min_price']=null;
            $cartUpdate['max_price']=null;
            $cartUpdate['start_date']=null;
            $cartUpdate['end_date']=null;
            $cartUpdate['discount_perc']=null;
            TempCustomerServiceCart::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->vehicle_id,'id'=>$items->id])->update($cartUpdate);
        }
    }

    public function applyDiscountOnCart(){
        foreach($this->tempServiceCart as $items)
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
                    TempCustomerServiceCart::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->vehicle_id,'id'=>$items->id])->update($cartUpdate);
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
                    TempCustomerServiceCart::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->vehicle_id,'id'=>$items->id])->update($cartUpdate);
                }
                //dd($discountCartServiceItemPrices);
            }
        }
    }

    


    public function updateServiceConfirm(){

        return redirect()->to('submit-job-update/'.$this->job_number);
    }




}
