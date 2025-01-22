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

class UpdateJobCards extends Component
{

    public $jobDetails, $selectedVehicleInfo;
    public $showServiceGroup=false, $confirmContinueUpdate=false;
    

    public $servicesGroupList, $service_group_id, $service_group_name, $service_group_code, $sectionsLists, $sectionServiceLists=[], $station,$service_sort=1, $selectServiceItems, $selectPackageMenu=false, $showServiceSectionsList=false;
    public $jobCardDetails;
    public $showSectionsList=false, $qlFilterOpen=false, $qlBrandsLists=[];

    public $quickLubeItemsList=[],$serviceItemsList=[], $quickLubeItemSearch='', $showQlItems=false, $showQlEngineOilItems=false, $showQlCategoryFilterItems=false, $showQuickLubeItemSearchItems=false, $itemQlCategories=[],  $ql_search_category, $ql_search_subcategory, $ql_search_brand, $ql_km_range;
    public $item_search_category, $itemCategories=[], $item_search_subcategory, $itemSubCategories =[], $item_search_brand, $itemBrandsLists=[], $itemSearchName, $ql_item_qty;
    public $propertyCode,$selectedSectionName, $discountGroup;
    public $confirming;

    //Discount Section 
    public $customerGroupLists;
    public $selectedDiscount, $appliedDiscount=[], $showDiscountDroup=false, $discountSearch=true;
    public $discount_card_imgae, $discount_card_number, $discount_card_validity;
    public $discountCardApplyForm=false, $engineOilDiscountForm=false, $discountForm=false;
    public $customerSelectedDiscountGroup, $searchStaffId, $staffavailable;
    public $tempServiceCart;
    public $employeeId, $customer_id, $selected_vehicle_id;
    public $totalDiscount, $total, $tax, $grand_total, $showCheckList, $showFuelScratchCheckList, $showCheckout, $showQLCheckList, $successPage;
    public $checklistLabels = [], $checklistLabel = [], $fuel, $scratchesFound, $scratchesNotFound, $vImageR1, $vImageR2, $vImageF, $vImageB, $vImageL1, $vImageL2, $customerSignature, $vImageR1T, $vImageR2T, $vImageFT, $vImageBT, $vImageL1T, $vImageL2T;

    function mount( Request $request) {
        $job_number = $request->job_number;
        if($job_number)
        {
            $this->customerJobDetails($job_number);
            $this->selectVehicle();
        }

    }

    public function render()
    {
        //CustomerJobCardServices::where('id','=',737)->update(['discount_amount'=>13]);
        //dd($this->jobDetails);
        //Discount
        /*"customer_discount_id" => null
        "discount_id" => "41"
        "discount_unit_id" => "41"
        "discount_code" => "ENGINE_OIL"
        "discount_title" => "ENGINE_OIL"
        "discount_percentage" => "10"
        "discount_amount" => "48.090000000000003"*/

        $this->servicesGroupList = Development::select('DevelopmentCode as department_code','DevelopmentName as department_name','id','LandlordCode as station_code')->where(['Operation'=>true,'LandlordCode'=>Session::get('user')->station_code])->get();

        if($this->service_group_code)
        {
            $this->showSectionsList=true;
            $this->sectionsLists = Sections::select('id','PropertyCode','DevelopmentCode','PropertyNo','PropertyName','Operation')
                ->where([
                    'DevelopmentCode'=>$this->service_group_code,
                    'Operation'=>true
                ])
                ->get();
        }

        if($this->propertyCode)
        {
            
            $sectionServiceLists = LaborItemMaster::where([
                'SectionCode'=>$this->propertyCode,
                'DivisionCode'=>Session::get('user')->station_code,
            ]);
            $sectionServiceLists = $sectionServiceLists->get();
            $sectionServicePriceLists = [];
            foreach($sectionServiceLists as $key => $sectionServiceList)
            {
                $sectionServicePriceLists[$key]['priceDetails'] = $sectionServiceList;
                if(!empty($this->appliedDiscount)){
                    if($this->appliedDiscount['groupType']==1)
                    {

                        $discountLaborSalesPrices = LaborSalesPrices::where(['ServiceItemId'=>$sectionServiceList->ItemId,'CustomerGroupCode'=>$this->appliedDiscount['code']]);
                        $discountLaborSalesPrices = $discountLaborSalesPrices->where('StartDate', '<=', Carbon::now())->where('EndDate', '=', null );
                        $sectionServicePriceLists[$key]['discountDetails'] = $discountLaborSalesPrices->first();

                    }else if($this->discountGroup['groupType']==2)
                    {
                        $discountLaborSalesPrices = LaborSalesPrices::where(['ServiceItemId'=>$sectionServiceList->ItemId,'CustomerGroupCode'=>$this->appliedDiscount['code']]);
                        $discountLaborSalesPrices = $discountLaborSalesPrices->where('StartDate', '<=', Carbon::now())->where('EndDate', '>=', Carbon::now() );
                        $sectionServicePriceLists[$key]['discountDetails'] = $discountLaborSalesPrices->first();
                    }
                    else
                    {
                        $sectionServicePriceLists[$key]['discountDetails']=null;
                    }
                    
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

        if($this->service_group_name =='Quick Lube')
        {
            $this->itemCategories = ItemCategories::where(['Active'=>1])->get();
            if($this->item_search_category){
                $this->itemSubCategories = InventorySubCategory::where(['CategoryId'=>$this->item_search_category])->get();
            }
            $this->qlBrandsLists = InventoryBrand::where(['Active'=>1,'show_engine_oil'=>1])->get();
            $this->dispatchBrowserEvent('selectSearchEvent');
        }

        if($this->showQlItems)
        {
            if($this->showQuickLubeItemSearchItems)
            {
                $quickLubeItemsNormalList1 = InventoryItemMaster::whereIn("InventoryPosting",['1','7'])->where('Active','=',1);
                if($this->quickLubeItemSearch){
                    $quickLubeItemsNormalList1 = $quickLubeItemsNormalList1->where('ItemName','like',"%{$this->quickLubeItemSearch}%");
                }
                $quickLubeItemsNormalList1=$quickLubeItemsNormalList1->get();
                $qlItemPriceLists1 = [];
                foreach($quickLubeItemsNormalList1 as $key => $qlItemsList1)
                {
                    $qlItemPriceLists1[$key]['priceDetails'] = $qlItemsList1;
                    if($this->customerDiscontGroupCode){
                    
                        if($this->customerSelectedDiscountGroup['groupType']==1)
                        {

                            $qlItemPriceLists1[$key]['discountDetails'] = InventorySalesPrices::where([
                                'ServiceItemId'=>$qlItemsList1->ItemId,
                                'CustomerGroupCode'=>$this->customerDiscontGroupCode,
                                'DivisionCode'=>Session::get('user')->station_code,
                            ])->first();

                        }else if($this->customerSelectedDiscountGroup['groupType']==2)
                        {
                            $qlItemPriceLists1[$key]['discountDetails'] = InventorySalesPrices::where([
                                'ServiceItemId'=>$qlItemsList1->ItemId,
                                'CustomerGroupCode'=>$this->customerDiscontGroupCode,
                                'DivisionCode'=>Session::get('user')->station_code,
                            ])->where('StartDate', '<=', Carbon::now())->where('EndDate', '>=', Carbon::now() )->first();
                        }
                        else
                        {
                            $qlItemPriceLists1[$key]['discountDetails']=null;
                        }
                        
                    }
                    else
                    {
                        $qlItemPriceLists1[$key]['discountDetails']=null;
                    }
                }
                $this->quickLubeItemsList = $qlItemPriceLists1;
            }
            else if($this->showQlCategoryFilterItems)
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
                    
                            if($this->customerSelectedDiscountGroup['groupType']==1)
                            {

                                $qlMakeModelCatItmDetails[$key]['discountDetails'] = InventorySalesPrices::where([
                                    'ServiceItemId'=>$qlMakeModelCatItm->ItemId,
                                    'CustomerGroupCode'=>$this->customerDiscontGroupCode,
                                    'DivisionCode'=>Session::get('user')->station_code,
                                ])->first();

                            }else if($this->customerSelectedDiscountGroup['groupType']==2)
                            {
                                
                                $qlMakeModelCatItmDetails[$key]['discountDetails'] = InventorySalesPrices::where([
                                    'ServiceItemId'=>$qlMakeModelCatItm->ItemId,
                                    'CustomerGroupCode'=>$this->customerDiscontGroupCode,
                                    'DivisionCode'=>Session::get('user')->station_code,
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
                
                $quickLubeItemsNormalList=$quickLubeItemsNormalList->get();
                $qlItemPriceLists = [];
                foreach($quickLubeItemsNormalList as $key => $qlItemsList)
                {
                    $qlItemPriceLists[$key]['priceDetails'] = $qlItemsList;
                    if(!empty($this->appliedDiscount)){
                    
                        if($this->appliedDiscount['groupType']==1)
                        {

                            $qlItemPriceLists[$key]['discountDetails'] = InventorySalesPrices::where([
                                'ServiceItemId'=>$qlItemsList->ItemId,
                                'CustomerGroupCode'=>$this->appliedDiscount['code'],
                                'DivisionCode'=>Session::get('user')->station_code,
                            ])->first();

                        }else if($this->appliedDiscount['groupType']==2)
                        {
                            
                            $qlItemPriceLists[$key]['discountDetails'] = InventorySalesPrices::where([
                                'ServiceItemId'=>$qlItemsList->ItemId,
                                'CustomerGroupCode'=>$this->appliedDiscount['code'],
                                'DivisionCode'=>Session::get('user')->station_code,
                            ])->where('StartDate', '<=', Carbon::now())->where('EndDate', '>=', Carbon::now() )->first();
                        }
                        else
                        {
                            $qlItemPriceLists[$key]['discountDetails']=null;
                        }
                        
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

        
        $this->applyItemToTempCart();
        $this->tempServiceCart = TempCustomerServiceCart::where(['customer_id'=>$this->jobDetails->customer_id,'vehicle_id'=>$this->jobDetails->vehicle_id,'job_number'=>$this->jobDetails->job_number])->get();
        dd($this->jobDetails);
        return view('livewire.update-job-cards');
    }

    public function customerJobDetails($job_number){
        $this->jobDetails = CustomerJobCards::with(['customerInfo','customerJobServices','checklistInfo','makeInfo','modelInfo','tempServiceCart','checklistInfo'])->where(['job_number'=>$job_number])->first();
        $this->customer_id = $this->jobDetails->customer_id;
        $this->selected_vehicle_id = $this->jobDetails->vehicle_id;
    }

    public function selectVehicle(){
        $customers = CustomerVehicle::with(['customerInfoMaster','makeInfo','modelInfo','customerDiscountLists'])->where(['is_active'=>1,'id'=>$this->jobDetails->vehicle_id,'customer_id'=>$this->jobDetails->customer_id])->first();
        $this->selectedVehicleInfo=$customers;
    }


    public function openServiceGroup(){
        $this->showServiceGroup=true;
        $this->showCheckList=false;
        $this->showCheckout=false;
        $this->showPayLaterCheckout=false;
        $this->successPage=false;
    }


    public function serviceGroupForm($service){
        $this->service_group_id = $service['id'];
        $this->service_group_name = $service['department_name'];
        $this->service_group_code = $service['department_code'];
        $this->station = $service['station_code'];

        $this->showSectionsList=true;
        $this->showServiceType=false;
        $this->selectServicesitems=false;
        $this->showServicesitems=true; 

        $this->showPackageList=false;
        $this->showSectionsList=true;
        $this->selectPackageMenu=false;
        $this->selectServiceItems=false;
        $this->showQlItems=false;

        if($this->service_group_name =='Quick Lube')
        {
            $sectionDetails = Sections::select('id','PropertyCode','DevelopmentCode','PropertyNo','PropertyName','Operation')
                ->where([
                    'DevelopmentCode'=>$this->service_group_code,
                    'Operation'=>true,
                    'PropertyName'=>'Quick Lube',
                ])->first();
            $this->propertyCode=$sectionDetails->PropertyCode;
            $this->selectedSectionName = $sectionDetails->PropertyName;
            $this->qlFilterOpen=true;
        }

        if($this->service_group_name !='Quick Lube' || $this->showQlItems == true)
        {
            $this->showQlItems=false;
            $this->qlFilterOpen=false;
            /*$this->propertyCode=$sectionDetails->PropertyCode;
            $this->selectedSectionName = $sectionDetails->PropertyName;*/

        }
    }

    public function getSectionServices($section)
    {
        //dd($section);
        $this->propertyCode=$section['PropertyCode'];
        $this->selectedSectionName = $section['PropertyName'];
        $this->showServiceSectionsList=true;
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

        $this->showQlItems=true;
        $this->showQlCategoryFilterItems=false;
        $this->showQuickLubeItemSearchItems=true;
        
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
        $this->showQuickLubeItemSearchItems=false;
        
        $this->dispatchBrowserEvent('scrolltopQl');
    }

    public function qlCategorySelect(){
        $this->showQlItems=true;
        $this->showQlCategoryFilterItems=true;
        $this->showQuickLubeItemSearchItems=false;
        $this->dispatchBrowserEvent('scrolltopQl');
    }
    
    public function confirmDelete($id)
    {
        $this->confirming = $id;
    }

    public function kill($id)
    {
        TempCustomerServiceCart::find($id)->delete();
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
        foreach($this->jobDetails->customerJobServices as $customerJobServices){
            //dd($customerJobServices);
            $customerBasketCheck = TempCustomerServiceCart::where(['customer_id'=>$this->jobDetails->customer_id,'vehicle_id'=>$this->jobDetails->vehicle_id,'item_id'=>$customerJobServices->item_id]);
            if($customerBasketCheck->count())
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
                    if($discountSalePrice){
                        $cartUpdate['price_id']=$discountSalePrice->PriceID;
                        $cartUpdate['customer_group_id']=$discountSalePrice->CustomerGroupId;
                        $cartUpdate['customer_group_code']=$discountSalePrice->CustomerGroupCode;
                        $cartUpdate['min_price']=$discountSalePrice->MinPrice;
                        $cartUpdate['max_price']=$discountSalePrice->MaxPrice;
                        $cartUpdate['start_date']=$discountSalePrice->StartDate;
                        $cartUpdate['end_date']=$discountSalePrice->EndDate;
                        $cartUpdate['discount_perc']=$discountSalePrice->DiscountPerc;
                        TempCustomerServiceCart::where(['customer_id'=>$this->jobDetails->customer_id,'vehicle_id'=>$this->jobDetails->vehicle_id,'item_id'=>$customerJobServices->item_id,'job_number'=>$this->jobDetails->job_number])->update($cartUpdate);
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
                    'created_by'=>Session::get('user')->id,
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
        $servicePrice = json_decode($servicePrice, true);
        $discountPrice = json_decode($discount, true);
        //dd($discountPrice);
        $customerBasketCheck = TempCustomerServiceCart::where(['customer_id'=>$this->jobDetails->customer_id,'vehicle_id'=>$this->jobDetails->vehicle_id,'item_id'=>$servicePrice['ItemId'],'job_number'=>$this->jobDetails->job_number]);
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
            }
            TempCustomerServiceCart::where([
                'customer_id'=>$this->jobDetails->customer_id,
                'vehicle_id'=>$this->jobDetails->vehicle_id,
                'item_id'=>$servicePrice['ItemId'],
                'job_number'=>$this->jobDetails->job_number,
            ])->update($cartUpdate);
        }
        else
        {
            $cartInsert = [
                'job_number'=>$this->jobDetails->job_number,
                'customer_id'=>$this->jobDetails->customer_id,
                'vehicle_id'=>$this->jobDetails->vehicle_id,
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
                'department_name'=>$this->service_group_name,
                'section_code'=>$servicePrice['SectionCode'],
                'unit_price'=>$servicePrice['UnitPrice'],
                'quantity'=>1,
                'created_by'=>Session::get('user')->id,
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
        $discountPrice = json_decode($discount,true);
        $customerBasketCheck = TempCustomerServiceCart::where(['customer_id'=>$this->jobDetails->customer_id,'vehicle_id'=>$this->jobDetails->vehicle_id,'item_id'=>$items['ItemId']]);
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
            }
            TempCustomerServiceCart::where([
                'customer_id'=>$this->jobDetails->customer_id,
                'vehicle_id'=>$this->jobDetails->vehicle_id,
                'item_id'=>$items['ItemId'],
                'job_number'=>$this->jobDetails->job_number,
            ])->update($cartUpdate);

        }
        else
        {
            $cartInsert = [
                'job_number'=>$this->jobDetails->job_number,
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
                'created_by'=>Session::get('user')->id,
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
            'unitId'=>$discountGroup['UnitId'],
            'code'=>$discountGroup['Code'],
            'title'=>$discountGroup['Title'],
            'id'=>$discountGroup['Id'],
            'groupType'=>$discountGroup['GroupType'],
        ];
        if($discountGroup['GroupType']==2)
        {
            $this->discountCardApplyForm=false;
            $this->discountForm=false;
            $this->appliedDiscount = $this->selectedDiscount;
            $this->applyItemToTempCart();
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
                if(Session()->get('user')->station_id!=1){
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
                'vehicle_id'=>$this->selected_vehicle_id,
                'discount_id'=>$this->selectedDiscount['id'],
            ])->exists())
            {
                $customerStaffIdResult = (array)$customerStaffIdCheck[0];
                $customerDiscontGroupInfo = [
                    'customer_id'=>$this->jobDetails->customer_id,
                    'vehicle_id'=>$this->jobDetails->vehicle_id,
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
                    'vehicle_id'=>$this->selected_vehicle_id,
                    'discount_id'=>$this->selectedDiscount['id']
                ])->first();
            }
            

            $this->appliedDiscount = $this->selectedDiscount;
            $this->selectVehicle();
            $this->dispatchBrowserEvent('closeDiscountGroupModal');
        }
        else
        {
            $this->staffavailable="Employee does not exist..!";
        }

    }

    public function selectEngineOilDiscount($percentage){

        $this->customerSelectedDiscountGroup = $this->selectedDiscount;
        $this->engineOilDiscountPercentage=$percentage;
        $this->customerDiscontGroupId = $this->selectedDiscount['id'];
        $this->customerDiscontGroupCode = $this->selectedDiscount['code'];
        $this->selectVehicle($this->customer_id,$this->selected_vehicle_id);
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
                CustomerServiceCart::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->selected_vehicle_id,'id'=>$items->id])->update($cartUpdate);
            }
        }

        $this->cartItems = CustomerServiceCart::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->selected_vehicle_id])->get();
    }

    

    public function saveSelectedDiscountGroup(){

        $proceeddisctount=false;
        $validatedData = $this->validate([
            //'discount_card_imgae' => 'required',
            'discount_card_number' => 'required',
            'discount_card_validity' => 'required',
        ]);

        if (!CustomerDiscountGroup::where([
                'customer_id'=>$this->customer_id,
                'vehicle_id'=>$this->selected_vehicle_id,
                'discount_id'=>$this->selectedDiscount['id'],
                'discount_card_number'=>$this->discount_card_number,
                'is_active'=>1
            ])->exists())
        {
        
            $customerDiscontGroupInfo = [
                'customer_id'=>$this->customer_id,
                'vehicle_id'=>$this->selected_vehicle_id,
                'discount_id'=>$this->selectedDiscount['id'],
                'discount_unit_id'=>$this->selectedDiscountUnitId,
                'discount_code'=>$this->selectedDiscountCode,
                'discount_title'=>$this->selectedDiscountTitle,
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


            $this->appliedDiscount = $this->selectedDiscount;
            $this->selectVehicle();
            $this->dispatchBrowserEvent('closeDiscountGroupModal');
        }
        else{
            CustomerDiscountGroup::where([
                'customer_id'=>$this->customer_id,
                'vehicle_id'=>$this->selected_vehicle_id,
                'discount_id'=>$this->selectedDiscount['id'],
                'discount_card_number'=>$this->discount_card_number,
                'is_active'=>1
            ])->update(['discount_card_validity'=>$this->discount_card_validity,'groupType'=>$this->selectedDiscount['groupType']]);
            $customerDiscontGroup = CustomerDiscountGroup::where([
                'customer_id'=>$this->customer_id,
                'vehicle_id'=>$this->selected_vehicle_id,
                'discount_id'=>$this->selectedDiscount['id'],
                'discount_card_number'=>$this->discount_card_number,
                'is_active'=>1
            ])->first();
            $this->appliedDiscount = $this->selectedDiscount;
            $this->selectVehicle();
            $this->dispatchBrowserEvent('closeDiscountGroupModal');
        }
    }

    public function updateServiceConfirm(){

        $cartDetails = $this->tempServiceCart;
        $this->cartItemCount = count($this->tempServiceCart); 
        
        $generalservice=false;
        $quicklubeservice=false;
        $showchecklist=false;

        

        $this->totalDiscount=0;
        $this->total=0;
        foreach($this->tempServiceCart as $items)
        {
            if($this->station==null){
                $this->station = $items->division_code;
            }
            
            if($items->department_name=='Quick Lube' && $generalservice==false){
                $generalservice=true;
                $showchecklist=true;
            }
            else if($items->department_name=='Electrical' && $quicklubeservice==false){
                $quicklubeservice=true;
                $showchecklist=true;
            }
            $this->total = $this->total+($items->quantity*$items->price);
            $this->totalDiscount = $this->totalDiscount+round((($items->discount_perc/100)*($items->unit_price*$items->quantity)),2);
        }
        
        if($showchecklist==true)
        {
            

            $this->showCheckList=true;
            $this->showFuelScratchCheckList=true;
            $this->showServiceGroup=false;
            $this->showCheckout=false;
            $this->checklistLabels = ServiceChecklist::get();
            $this->checklistLabel = json_decode($this->jobDetails->checklistInfo['checklist'],true);
            $this->fuel = $this->jobDetails->checklistInfo['fuel'];
            $this->scratchesFound = $this->jobDetails->checklistInfo['scratches_found'];
            $this->scratchesNotFound = $this->jobDetails->checklistInfo['scratches_notfound'];
            $vehicleImage = json_decode($this->jobDetails->checklistInfo['vehicle_image'],true);
            $this->vImageR1T = isset($vehicleImage['vImageR1'])?$vehicleImage['vImageR1']:null;
            $this->vImageR2T = isset($vehicleImage['vImageR2'])?$vehicleImage['vImageR2']:null;
            $this->vImageFT = isset($vehicleImage['vImageF'])?$vehicleImage['vImageF']:null;
            $this->vImageBT = isset($vehicleImage['vImageB'])?$vehicleImage['vImageB']:null;
            $this->vImageL1T = isset($vehicleImage['vImageL1'])?$vehicleImage['vImageL1']:null;
            $this->vImageL2T = isset($vehicleImage['vImageL2'])?$vehicleImage['vImageL2']:null;
            $this->customerSignature = $this->jobDetails->checklistInfo['signature'];

            //dd($this->jobDetails->checklistInfo['vehicle_image']);
            //dd($this->checklistLabel);
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
            //$this->createJob();
            //dd($this->mobile);
            $this->showCheckout=true;
        }

        $totalAfterDisc = $this->total - $this->totalDiscount;
        $tax = $totalAfterDisc * (config('global.TAX_PERCENT') / 100);
                                            $grand_total = $totalAfterDisc+$tax;

        $this->tax = $totalAfterDisc * (config('global.TAX_PERCENT') / 100);
        $this->grand_total = $totalAfterDisc+$this->tax;

        $this->dispatchBrowserEvent('imageUpload');
        //$this->dispatchBrowserEvent('showSignature'); 
        
        //$this->dispatchBrowserEvent('showSignature'); 
        /*$this->showServiceGroup=false;
        $this->cardShow=false;
        $this->showCheckout=true;*/
        //dd($this->cartItems);
        //dd($this->total);
    }




}
