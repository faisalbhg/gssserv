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


class CustomerServiceJob extends Component
{
    use WithFileUploads;
    public $selectedCustomerVehicle=false, $selectPackageMenu=false, $showSectionsList=false, $showServiceSectionsList=false, $showServiceItems=false, $showItemsSearchResults=false, $showQlItemSearch=false, $showQlEngineOilItems=false, $showQlItemsOnly=false, $showQlItemsList=false;
    public $showServiceGroup, $showCheckout;
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

    function mount( Request $request) {
        $this->customer_id = $request->customer_id;
        $this->vehicle_id = $request->vehicle_id;
        if($this->vehicle_id && $this->customer_id)
        {
            $this->selectVehicle();

        }

    }


    public function render()
    {
        if($this->editCUstomerInformation || $this->addNewVehicleInformation)
        {
            $this->stateList = StateList::where(['CountryCode'=>$this->plate_country])->get();
            if($this->plate_state){
                $this->plateEmiratesCodes = PlateCode::where(['plateEmiratesId'=>$this->plateStateCode,'is_active'=>1])->get();
            }
            $this->vehicleTypesList = Vehicletypes::orderBy('type_name','ASC')->get();
            $this->listVehiclesMake = VehicleMakes::get();
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
            $this->servicesGroupList = Development::select('DevelopmentCode as department_code','DevelopmentName as department_name','id','LandlordCode as station_code')->where(['Operation'=>true,'LandlordCode'=>Session::get('user')['station_code']])->get();
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


        if($this->showServiceSectionsList)
        {
            $sectionServiceLists = LaborItemMaster::where([
                'SectionCode'=>$this->propertyCode,
                'DivisionCode'=>Session::get('user')['station_code'],
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
                                'DivisionCode'=>Session::get('user')['station_code'],
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
                                    'DivisionCode'=>Session::get('user')['station_code'],
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
                                        'DivisionCode'=>Session::get('user')['station_code'],
                                    ])->first();

                                }else if($this->appliedDiscount['groupType']==2)
                                {
                                    
                                    $qlMakeModelCatItmDetails[$key]['discountDetails'] = InventorySalesPrices::where([
                                        'ServiceItemId'=>$qlMakeModelCatItm->ItemId,
                                        'CustomerGroupCode'=>$this->appliedDiscount['code'],
                                        'DivisionCode'=>Session::get('user')['station_code'],
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
                                        'DivisionCode'=>Session::get('user')['station_code'],
                                    ])->first();

                                }else if($this->appliedDiscount['groupType']==2)
                                {
                                    
                                    $qlMakeModelCatItmDetails[$key]['discountDetails'] = InventorySalesPrices::where([
                                        'ServiceItemId'=>$qlMakeModelCatItm->ItemId,
                                        'CustomerGroupCode'=>$this->appliedDiscount['code'],
                                        'DivisionCode'=>Session::get('user')['station_code'],
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


        $this->openServiceGroup();
        $this->getCartInfo();
        $this->dispatchBrowserEvent('selectSearchEvent');

        return view('livewire.customer-service-job');
    }

    public function getCartInfo($value='')
    {
        $this->cartItems = CustomerServiceCart::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->vehicle_id])->get();
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

    public function openServiceGroup(){
        $this->showServiceGroup=true;
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

    public function addtoCart($servicePrice,$discount)
    {
        $servicePrice = json_decode($servicePrice,true);
        $discountPrice = json_decode($discount,true);
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
                'created_by'=>Session::get('user')['id'],
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

    public function addtoCartItem($items,$discount)
    {
        $items = json_decode($items,true);
        $discountPrice = json_decode($discount,true);
        $customerBasketCheck = CustomerServiceCart::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->vehicle_id,'item_id'=>$items['ItemId']]);
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
                CustomerServiceCart::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->vehicle_id,'item_id'=>$items['ItemId']])->update($cartUpdate);
            }
            
        }
        else
        {
            $cartInsert = [
                'customer_id'=>$this->customer_id,
                'vehicle_id'=>$this->vehicle_id,
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
                'department_name'=>$this->service_group_name,
                'section_code'=>$this->propertyCode,
                'unit_price'=>$items['UnitPrice'],
                'quantity'=>isset($this->ql_item_qty[$items['ItemId']])?$this->ql_item_qty[$items['ItemId']]:1,
                'created_by'=>Session::get('user')['id'],
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
            CustomerServiceCart::insert($cartInsert);
        }
        $this->serviceAddedMessgae[$items['ItemCode']]=true;
        //dd($this->sectionServiceLists);
        /*$this->dispatchBrowserEvent('swal:modal', [
            'type' => 'success',
            'message' => 'Added to Cart Successfully',
            'text' => 'service added..!',
            'cartitemcount'=>\Cart::getTotalQuantity()
        ]);*/
        session()->flash('cartsuccess', 'Service is Added to Cart Successfully !');
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

        $this->showQlItemSearch = false;
        $this->showQlItemsList = false;
        $this->showQlEngineOilItems=false;
        $this->showQlItemsOnly=false;
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
        CustomerServiceCart::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->vehicle_id,'id'=>$serviceId])->update($cartUpdate);
    }

    public function removeDiscount(){

        $this->selectedDiscount=null;
        $this->appliedDiscount = null;
        //dd($this->cartItems);
        foreach($this->cartItems as $items)
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
        }
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
                        'DivisionCode'=>Session::get('user')['station_code'],
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
            $customerVehicleUpdate['created_by']=Session::get('user')['id'];
            //dd($customerVehicleUpdate);
            CustomerVehicle::where(['id'=>$this->vehicle_id,'customer_id'=>$this->customer_id])->update($customerVehicleUpdate);
        }
        $this->selectedCustomerVehicle=true;
        $this->editCUstomerInformation=false;
        $this->updateVehicleFormBtn=false;
        $this->showForms=false;
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
        $customerVehicleInsert['created_by']=Session::get('user')['id'];
        $customerVehicleInsert['is_active']=1;
        $newcustomer = CustomerVehicle::create($customerVehicleInsert);
        
        return redirect()->to('customer-service-job/'.$this->customer_id.'/'.$newcustomer->id);
        session()->flash('success', 'New Customer vehicle added Successfully !');
    }

    public function closeUpdateVehicleCustomer(){
        $this->dispatchBrowserEvent('refreshPage');
    }

    public function submitService(){
        return redirect()->to('submit-job/'.$this->customer_id.'/'.$this->vehicle_id);
    }
}
