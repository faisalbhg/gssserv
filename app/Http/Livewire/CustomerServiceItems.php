<?php

namespace App\Http\Livewire;

use Livewire\Component;

use Illuminate\Http\Request;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\Http;
use LaravelPayfort\Facades\Payfort;
use Illuminate\Support\Facades\Hash;
use DB;
use Spatie\Image\Image;

use App\Models\CustomerVehicle;
use App\Models\ItemCategories;
use App\Models\InventorySubCategory;
use App\Models\InventoryBrand;
use App\Models\InventoryItemMaster;
use App\Models\InventorySalesPrices;
use App\Models\CustomerServiceCart;
use App\Models\Development;
use App\Models\Sections;
use App\Models\LaborSalesPrices;
use App\Models\LaborCustomerGroup;
use App\Models\CustomerDiscountGroup;
use App\Models\CustomerJobCards;
use App\Models\CustomerJobCardServices;
use App\Models\ItemWarehouse;
use App\Models\ItemCurrentStock;
use App\Models\ManualDiscountAprovals;
use App\Models\ManualDiscountServices;


class CustomerServiceItems extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $customer_id, $vehicle_id, $job_number, $selected_section, $department_code, $department_name, $section_code, $section_name;
    public $selectedCustomerVehicle=false, $showForms=false, $cardShow=false, $showItemsSearchResults=false, $showLineDiscountItems=false;
    public $itemCategories=[], $itemSubCategories=[], $itemBrandsLists=[], $item_search_category, $item_search_subcategory, $item_search_brand, $item_search_name, $item_search_code;
    public $serviceAddedMessgae=[], $serviceStockErrShow=[], $serviceStockErrMessgae=[], $cartItems = [], $cartItemCount, $ql_item_qty, $ceramic_dicount, $showManulDiscount=[],$manualDiscountInput;
    public $confirming, $confirmingRA=false, $priceDiscountList, $lineItemDetails;
    public $showSelectedDiscount=false,$selectedDiscount, $appliedDiscount, $discountForm=false; 
    public $customerSelectedDiscountGroup, $employeeId, $searchStaffId=false, $staffavailable;
    public $discount_card_imgae, $discount_card_number, $discount_card_validity;
    public $discountCardApplyForm=false, $engineOilDiscountForm=false;
    public $engineOilDiscountPercentage, $customerDiscontGroupId, $customerDiscontGroupCode;
    public $lineDIscountItemId, $linePriceDiscount, $discountAvailability;
    public $applyManualDiscount=false, $selectedManualDiscountGroup, $manualDiscountValueType='amount', $manualDiscountValue, $manualDiscountRemarks, $manulDiscountForm=false, $manualDiscountRefNo;

    public function render()
    {
        $this->itemCategories = ItemCategories::where(['Active'=>1])->get();
        if($this->item_search_category){
            $this->itemSubCategories = InventorySubCategory::where(['CategoryId'=>$this->item_search_category])->get();
        }
        $this->itemBrandsLists = InventoryBrand::where(['Active'=>1])->get();
        $data=[];
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
            if($this->item_search_code){
                $inventoryItemMasterLists = $inventoryItemMasterLists->where('ItemCode','like',"%{$this->item_search_code}%");
            }
            $data['inventoryItemMasterLists']=$inventoryItemMasterLists->paginate(20);
        }
        $this->getCartInfo();
        return view('livewire.customer-service-items',$data);
    }

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

    public function customerJobDetails(){
        $customerJobCardsQuery = CustomerJobCards::with(['customerInfo','customerJobServices','checklistInfo','makeInfo','modelInfo','tempServiceCart','checklistInfo']);
        $customerJobCardsQuery = $customerJobCardsQuery->where(['job_number'=>$this->job_number]);
        $customerJobCardsQuery = $customerJobCardsQuery->where('payment_status','!=',1);
        //$customerJobCardsQuery = $customerJobCardsQuery->whereIn('job_status', ['1'])
        $customerJobCardsQuery = $customerJobCardsQuery->where('job_status','!=',4)->where('job_status','!=',5);

        $this->jobDetails =  $customerJobCardsQuery->first();
        //dd($this->jobDetails);
        if($this->jobDetails){
            $this->customer_id = $this->jobDetails->customer_id;
            $this->vehicle_id = $this->jobDetails->vehicle_id;

            $this->showTempCart = true;
            if($this->jobDetails->customer_job_update==null){
                CustomerJobCards::where(['job_number'=>$this->job_number])->update(['customer_job_update'=>1]);
                CustomerServiceCart::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->vehicle_id,'job_number'=>$this->job_number,'division_code'=>auth()->user('user')->stationName['LandlordCode']])->delete();
                //dd($this->jobDetails->customerJobServices);
                foreach($this->jobDetails->customerJobServices as $customerJobServices)
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
                        'section_name'=>$customerJobServices->section_name,
                        'unit_price'=>$customerJobServices->total_price,
                        'quantity'=>$customerJobServices->quantity,
                        'created_by'=>auth()->user('user')->id,
                        'created_at'=>Carbon::now(),
                        'job_number'=>$customerJobServices->job_number,
                        'current_job_status'=>$customerJobServices->job_status,
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
            }
        }
        else
        {
            return redirect()->to('/customer-job-update/'.$this->job_number);
        }
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

    public function getCartInfo($value='')
    {

        $customerServiceCartQuery = CustomerServiceCart::with(['manualDiscountServiceInfo','customerInfo'])->where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->vehicle_id,'division_code'=>auth()->user('user')->stationName['LandlordCode']]);
        if($this->job_number)
        {
            $customerServiceCartQuery = $customerServiceCartQuery->where(['job_number'=>$this->job_number]);
        }
        else
        {
            $customerServiceCartQuery = $customerServiceCartQuery->where(['job_number'=>null]);
        }

        $this->cartItemCount = $customerServiceCartQuery->count();
        if($this->cartItemCount>0){
            $this->cartItems = $customerServiceCartQuery->get();
            $this->cardShow=true;
        }
        else
        {
            $this->cardShow=false;
        }
        //dd($this->cartItems);
        foreach($this->cartItems as $cartCheckItem){
            if($cartCheckItem->division_code != auth()->user('user')->stationName['LandlordCode'])
            {
                dd('Error, Contact techincal team..!');
            }
            if($cartCheckItem->manual_discount_ref_no){
                $this->manualDiscountRefNo = $cartCheckItem->manual_discount_ref_no;
            }
        }

        /*$this->cartItems = CustomerServiceCart::with(['manualDiscountServiceInfo'])->where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->vehicle_id,'division_code'=>auth()->user('user')->stationName['LandlordCode']])->get();
        
        $this->cartItemCount = count($this->cartItems); 
        if($this->cartItemCount>0)
        {
            $this->cardShow=true;
        }
        else
        {
            $this->cardShow=false;
        }*/


        


    }

    public function backToService(){
        if($this->job_number){
            return redirect()->to('customer-service-job/'.$this->customer_id.'/'.$this->vehicle_id.'/'.$this->job_number);
        }
        {
            return redirect()->to('customer-service-job/'.$this->customer_id.'/'.$this->vehicle_id);
        }

    }

    public function selectSection($section){
        switch ($section) {
            case '1':
                $departmentName = 'Quick Lube';
                // code...
                break;

            case '2':
                $departmentName = 'General Service';
                // code...
                break;

            case '3':
                $departmentName = 'Misc Sales';
                // code...
                break;
            
            default:
                // code...
                break;
        }
        $departmentDetails = Development::select('DevelopmentCode as department_code','DevelopmentName as department_name','id','LandlordCode as station_code')
            ->where([
                'DevelopmentName'=>$departmentName,
                'LandlordCode'=>auth()->user('user')['station_code']
            ])->first();
        //dd($departmentDetails);
        $this->department_code=$departmentDetails->department_code;
        $this->department_name=$departmentDetails->department_name;
        if($this->department_name == 'General Service')
        {
            $this->department_name = 'Mechanical';    
        }

        $sectionsDetails = Sections::select('id','PropertyCode','DevelopmentCode','PropertyNo','PropertyName','Operation')
            ->where([
                'DevelopmentCode'=>$this->department_code,
                'Operation'=>true,
                'PropertyName'=>$this->department_name,
            ])->first();
        $this->section_code=$sectionsDetails->PropertyCode;
        $this->section_name=$sectionsDetails->PropertyName;
        $this->selected_section=$this->section_name;
    }

    public function searchServiceItems(){
        $validatedData = $this->validate([
            'selected_section' => 'required',
        ]);
        /*$validatedData = $this->validate([
            //'item_search_category' => 'required',
            //'item_search_subcategory' => 'required',
        ]);*/
        $this->showItemsSearchResults=true;
    }


    public function addtoCartItem($itemDetails)
    {
        $qty = isset($this->ql_item_qty[$itemDetails['ItemId']])?$this->ql_item_qty[$itemDetails['ItemId']]:1;

        if($this->checkItemStock($itemDetails['ItemId'], $itemDetails['ItemCode'], $qty)){

        
            $customerBasketCheck = CustomerServiceCart::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->vehicle_id,'item_id'=>$itemDetails['ItemId'],'division_code'=>auth()->user('user')->stationName['LandlordCode']]);
            if($customerBasketCheck->exists())
            {
                if($itemDetails['ItemCode']=='I09137')
                {
                    if(CustomerServiceCart::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->vehicle_id,'item_code'=>'I09137','division_code'=>auth()->user('user')->stationName['LandlordCode']])->where('customer_group_id','!=',90)->exists()){
                        CustomerServiceCart::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->vehicle_id,'item_code'=>'I09137','division_code'=>auth()->user('user')->stationName['LandlordCode']])->where('customer_group_id','!=',90)->increment('quantity', 4);    
                    }else if(!CustomerServiceCart::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->vehicle_id,'item_code'=>'I09137','division_code'=>auth()->user('user')->stationName['LandlordCode']])->where('customer_group_id','=',null)->increment('quantity', 4)){
                        CustomerServiceCart::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->vehicle_id,'item_code'=>'I09137','division_code'=>auth()->user('user')->stationName['LandlordCode']])->where('customer_group_id','=',null)->increment('quantity', 4);    
                    }
                    
                    CustomerServiceCart::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->vehicle_id,'item_code'=>'I09137','division_code'=>auth()->user('user')->stationName['LandlordCode']])->where('customer_group_id','=',90)->increment('quantity', 1);
                }
                else
                {
                    $customerBasketCheck->increment('quantity', $qty);
                    //$customerBasketCheck->increment('quantity', 1);
                }            
            }
            else
            {
                $cartInsert = [
                    'customer_id'=>$this->customer_id,
                    'vehicle_id'=>$this->vehicle_id,
                    'item_id'=>$itemDetails['ItemId'],
                    'item_code'=>$itemDetails['ItemCode'],
                    'company_code'=>$itemDetails['CompanyCode'],
                    'category_id'=>$itemDetails['CategoryId'],
                    'sub_category_id'=>$itemDetails['SubCategoryId'],
                    'brand_id'=>$itemDetails['BrandId'],
                    'bar_code'=>$itemDetails['BarCode'],
                    'item_name'=>$itemDetails['ItemName'],
                    'cart_item_type'=>2,
                    'description'=>$itemDetails['Description'],
                    'division_code'=>auth()->user('user')['station_code'],
                    'department_code'=>$this->department_code,
                    'department_name'=>$this->department_name,
                    'section_code'=>$this->section_code,
                    'section_name'=>$this->section_name,
                    'unit_price'=>$itemDetails['UnitPrice'],
                    'quantity'=>isset($this->ql_item_qty[$itemDetails['ItemId']])?$this->ql_item_qty[$itemDetails['ItemId']]:1,
                    'created_by'=>auth()->user('user')['id'],
                    'created_at'=>Carbon::now(),
                ];
                if($itemDetails['ItemCode']=='I09137')
                {
                    $cartInsert['quantity']=4;
                }
                
                if($this->job_number)
                {
                    $cartInsert['job_number']=$this->job_number;
                }

                $this->insertItemToCart($cartInsert);
                if($itemDetails['ItemCode']=='I09137')
                {
                    $cartInsert1 = $this->applyDiscountOnItem('I09137','MOBIL4+1');
                    $cartInsert = array_merge($cartInsert1,$cartInsert);
                    $cartInsert['quantity']=1;
                    $this->insertItemToCart($cartInsert);
                }
            }
            $this->serviceAddedMessgae[$itemDetails['ItemCode']]=true;
            $this->serviceStockErrShow[$itemDetails['ItemCode']]=false;

            /*$this->dispatchBrowserEvent('swal:modal', [
                'type' => 'success',
                'message' => 'Added to Cart Successfully',
                'text' => 'service added..!',
                'cartitemcount'=>\Cart::getTotalQuantity()
            ]);*/
            session()->flash('cartsuccess', 'Service is Added to Cart Successfully !');
        }
        else
        {
            $this->serviceAddedMessgae[$itemDetails['ItemCode']]=false;
        }
    }

    public function checkItemStock($ItemId, $ItemCode, $qty)
    {
        $wareHouseDetails = ItemWarehouse::where(['DivisionId'=>auth()->user('user')->station_code])->first();
        $itemCurrentStock = ItemCurrentStock::where(['StoreId'=>$wareHouseDetails->WarehouseId,'ItemCode'=>$ItemCode])->first();
        $itemsInCart = CustomerServiceCart::where(['division_code'=>auth()->user('user')->station_code,'item_code'=>$ItemCode])->sum('quantity');
        $itemsInCart=0;
        $totalAvailable = number_format($itemCurrentStock->QuantityInStock) - $itemsInCart;
        if($totalAvailable >= $qty){
            return true;
        }
        else
        {
            $this->serviceStockErrShow[$ItemCode]=true;
            $this->serviceStockErrMessgae[$ItemCode]=$totalAvailable;
            return false;
        }

    }

    public function insertItemToCart($insertItemsData){
        CustomerServiceCart::insert($insertItemsData);
    }

    public function applyDiscountOnItem($itemCode,$discountCode){
        $discountAddOn = InventorySalesPrices::where([
            'ServiceItemCode'=>$itemCode,
            'CustomerGroupCode'=>$discountCode,
        ])->first();
        $itemsDiscount=[];
        if($discountAddOn!=null){
            $itemsDiscount['price_id']=$discountAddOn['PriceID'];
            $itemsDiscount['customer_group_id']=$discountAddOn['CustomerGroupId'];
            $itemsDiscount['customer_group_code']=$discountAddOn['CustomerGroupCode'];
            $itemsDiscount['min_price']=$discountAddOn['MinPrice'];
            $itemsDiscount['max_price']=$discountAddOn['MaxPrice'];
            $itemsDiscount['start_date']=$discountAddOn['StartDate'];
            $itemsDiscount['end_date']=$discountAddOn['EndDate'];
            $itemsDiscount['discount_perc']=$discountAddOn['DiscountPerc'];
        }

        return $itemsDiscount;
    }

    public function confirmDelete($id)
    {
        $this->confirming = $id;
    }
    public function confirmDeleteRA()
    {
        $this->confirmingRA = true;
    }

    public function safe($id){
        $this->confirming = null;
    }
    public function safeRA(){
        $this->confirmingRA = false;
    }

    public function kill($id,$item_id)
    {
        CustomerServiceCart::where(['id'=>$id])->delete();
        /*if($this->job_number){
            $chheckCustomerJobServiceQuery = CustomerJobCardServices::where(['job_number'=>$this->job_number,'item_id'=>$item_id]);
            if($chheckCustomerJobServiceQuery->exists()){
                $chheckCustomerJobServiceQuery->delete();
            }
        }*/
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
        //$this->getCartInfo();

        CustomerServiceCart::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->vehicle_id,'id'=>$serviceId,'division_code'=>auth()->user('user')->stationName['LandlordCode']])->update($cartUpdate);
    }

    public function cartSetDownQty($cartId){
        $item = CustomerServiceCart::find($cartId); // or however you're retrieving it
        if ($item->quantity > 1) {
            $item->quantity--;
            $item->save();
        }

        //CustomerServiceCart::find($cartId)->decrement('quantity');
    }
    public function cartSetUpQty($cartId){
        $cartItemDetails = CustomerServiceCart::find($cartId);
        if($cartItemDetails->cart_item_type==2)
        {
            if($this->checkItemStock($cartItemDetails->item_id, $cartItemDetails->item_code, 1))
            {
                CustomerServiceCart::find($cartId)->increment('quantity');
                session()->flash('cartsuccess', 'Updated Cart Successfully !');
            }
            else
            {
                session()->flash('carterror', 'Available Stock: '.$this->serviceStockErrMessgae[$cartItemDetails->item_code]);
            }

        }
        else{
            CustomerServiceCart::find($cartId)->increment('quantity');    
            //session()->flash('cartsuccess', 'Updated Cart Successfully !');
        }

        //CustomerServiceCart::find($cartId)->increment('quantity');
    }

    public function removeCart($id)
    {
        CustomerServiceCart::find($id)->delete();
    }

    public function clearAllCart()
    {
        CustomerServiceCart::where(['customer_id'=>$this->customer_id, 'vehicle_id'=>$this->vehicle_id,'division_code'=>auth()->user('user')->stationName['LandlordCode']])->delete();
        $this->confirmingRA = false;
        session()->flash('cartsuccess', 'All Service Cart Clear Successfully !');
    }

    public function applyLineDiscount($item){
        $this->lineDIscountItemId = $item['id'];
        $this->selectedDiscount=null;
        $this->showSelectedDiscount=false;
        $this->priceDiscountList=null;
        $this->applyManualDiscount=true;

        if($item['cart_item_type']==1){
            $inventorySalesPricesQuery = LaborSalesPrices::where([
                'ServiceItemId'=>$item['item_id'],
                //'CustomerGroupCode'=>$this->appliedDiscount['code']
            ])->where('StartDate', '<=', Carbon::now());

            $inventorySalesPricesQuery = $inventorySalesPricesQuery->with(['customerDiscountGroup'])->where(function ($query) {
                $query->whereRelation('customerDiscountGroup', 'GroupType', '!=', 4);
                $query->whereRelation('customerDiscountGroup', 'GroupType', '!=', 5);
                $query->whereRelation('customerDiscountGroup', 'Active', '=', true);
            });
            $inventorySalesPricesResult = $inventorySalesPricesQuery->get();
        }
        else if($item['cart_item_type']==2){
            $inventorySalesPricesQuery = InventorySalesPrices::where([
                'ServiceItemId'=>$item['item_id'],
                //'CustomerGroupCode'=>$this->appliedDiscount['code'],
                'DivisionCode'=>auth()->user('user')['station_code'],
            ]);
            $inventorySalesPricesQuery = $inventorySalesPricesQuery->with(['customerDiscountGroup'])->where(function ($query) {
                $query->whereRelation('customerDiscountGroup', 'GroupType', '!=', 4);
                $query->whereRelation('customerDiscountGroup', 'GroupType', '!=', 5);
                $query->whereRelation('customerDiscountGroup', 'Active', '=', true);
            });
            $inventorySalesPricesResult = $inventorySalesPricesQuery->get();
            //dd($inventorySalesPricesResult);
        }
        $this->lineItemDetails = $item;
        //dd($this->lineItemDetails['unit_price']);
        $this->priceDiscountList = $inventorySalesPricesResult;
        $this->showLineDiscountItems = true;
        $this->dispatchBrowserEvent('showPriceDiscountList');
        $this->dispatchBrowserEvent('scrolltoInModalTopNew');
    }

    /**
     * Apply Discount on Saved Discount
     * customer based
     * */
    public function savedCustomerDiscountGroup($item,$savedCustomerDiscount){

        $this->selectedDiscount = [
            'unitId'=>isset($savedCustomerDiscount['discount_unit_id'])?$savedCustomerDiscount['discount_unit_id']:null,
            'code'=>$savedCustomerDiscount['discount_code'],
            'title'=>$savedCustomerDiscount['discount_title'],
            'id'=>$savedCustomerDiscount['discount_id'],
            'groupType'=>$savedCustomerDiscount['groupType'],
        ];
        $this->appliedDiscount = $this->selectedDiscount;
        $savedCustDiscount = $this->applyDiscountOnSavedCustomerDiscount();
        
        if($savedCustDiscount){
            $getSavedCustDiscount = $savedCustDiscount->customerDiscountGroup;
            if($savedCustomerDiscount['discount_id']==8 || $savedCustomerDiscount['discount_id']==9){
                $customerStaffIdCheck = $this->checkStffAvailablity($savedCustomerDiscount['employee_code']);
                if($customerStaffIdCheck)
                {
                    $this->applyDIsountinItemService($savedCustDiscount);    
                }
                else
                {
                    $this->staffavailable="Employee does not exist..!";
                }
            }
            else
            {
                $this->applyDIsountinItemService($savedCustDiscount);
            }
        }
        else
        {
            $this->discountAvailability="Discount is unavailable for this..!";
        }


        
            
    }


    /**
     * CHecking HR System STaff Available or not
     **/
    public function checkStffAvailablity($employee_code){
        $this->employeeId = sprintf('%06d', $employee_code);
        
        //Call Procedure for Customer Staff ID Check
        $customerStaffIdCheck = DB::select('EXEC GetEmployee @employee_code = "'.$this->employeeId.'"', [
            $this->employeeId,
        ]); 
        return $customerStaffIdCheck;
    }


    /**
     * Check Staff DIscount Submit
     * */
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
                //'vehicle_id'=>$this->vehicle_id,
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
            $this->applyDIsountinItemService($this->linePriceDiscount);
            //$this->applyDiscountOnCart();
            //$this->dispatchBrowserEvent('closeDiscountGroupModal');
        }
        else
        {
            $this->staffavailable="Employee does not exist..!";
        }

    }

    public function applyDiscountOnSavedCustomerDiscount()
    {
        $item = $this->lineItemDetails;
        $discountGroupType = $this->selectedDiscount['groupType'];
        if($item['cart_item_type']==1){
            $inventorySalesPricesQuery = LaborSalesPrices::where([
                'ServiceItemId'=>$this->lineItemDetails['item_id'],
                'CustomerGroupCode'=>$this->selectedDiscount['code']
            ])->where('StartDate', '<=', Carbon::now());

            $inventorySalesPricesQuery = $inventorySalesPricesQuery->with(['customerDiscountGroup'])->where(function ($query)  use ($discountGroupType)  {
                $query->whereRelation('customerDiscountGroup', 'GroupType', '=', $discountGroupType);
                //$query->whereRelation('customerDiscountGroup', 'GroupType', '!=', 5);
                $query->whereRelation('customerDiscountGroup', 'Active', '=', true);
            });
            $inventorySalesPricesResult = $inventorySalesPricesQuery->get();
        }
        else if($item['cart_item_type']==2){
            $inventorySalesPricesQuery = InventorySalesPrices::where([
                'ServiceItemId'=>$item['item_id'],
                'CustomerGroupCode'=>$this->selectedDiscount['code'],
                'DivisionCode'=>auth()->user('user')['station_code'],
            ]);

            $inventorySalesPricesQuery = $inventorySalesPricesQuery->with(['customerDiscountGroup'])->where(function ($query) use ($discountGroupType) {
                $query->whereRelation('customerDiscountGroup', 'GroupType', '=', $discountGroupType);
                //$query->whereRelation('customerDiscountGroup', 'GroupType', '!=', 5);
                $query->whereRelation('customerDiscountGroup', 'Active', '=', true);
            });
            $inventorySalesPricesResult = $inventorySalesPricesQuery->get();
        }
        $savedCustDiscount = null;
        foreach($inventorySalesPricesResult as $inventorySalesPrices)
        {
            if($inventorySalesPrices->customerDiscountGroup['GroupType'] == 1 && $inventorySalesPrices->EndDate == null)
            {
                $savedCustDiscount = $inventorySalesPrices;
            }
            elseif($inventorySalesPrices->customerDiscountGroup['GroupType']==2)
            {
                $givenDate = \Carbon\Carbon::parse($inventorySalesPrices->EndDate); // Replace with your date
                $now = \Carbon\Carbon::now();
                if ($givenDate->isPast()) {
                    //
                }
                else
                {
                    $savedCustDiscount = $inventorySalesPrices;
                }
            }
        }
        return $savedCustDiscount;
        
    }


    public function applyLineDiscountSubmit($itemDetails,$priceDiscount,$discountGroup){
        
        $this->linePriceDiscount = $priceDiscount;
        $this->selectedDiscount = [
            'unitId'=>isset($discountGroup['UnitId'])?$discountGroup['UnitId']:null,
            'code'=>$discountGroup['Code'],
            'title'=>$discountGroup['Title'],
            'id'=>$discountGroup['Id'],
            'groupType'=>$discountGroup['GroupType'],
        ];
        $this->showSelectedDiscount=true;
        if($discountGroup['GroupType']==2 || $discountGroup['GroupType']==6 )
        {
            $this->applyDIsountinItemService($priceDiscount);

            //$this->appliedDiscount = $this->selectedDiscount;
        }
        else{
            $this->discountForm=true;
            if($discountGroup['Id']==8 || $discountGroup['Id']==9){
                $this->searchStaffId=true;
                $this->discountCardApplyForm=false;
                $this->engineOilDiscountForm=false;
                $this->manulDiscountForm=false;
                $this->dispatchBrowserEvent('scrolltoInModal', [
                    'scrollToId' => 'discountTop',
                ]);
            }
            else if($discountGroup['Id']==41)
            {
                if(auth()->user('user')['station_id']!=1){
                    $this->engineOilDiscountForm=true;
                    $this->discountCardApplyForm=false;
                    $this->searchStaffId=false;
                    $this->manulDiscountForm=false;
                    $this->dispatchBrowserEvent('scrolltoInModal', [
                        'scrollToId' => 'discountTop',
                    ]);
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
                $this->manulDiscountForm=false;
                $this->dispatchBrowserEvent('scrolltoInModal', [
                    'scrollToId' => 'discountTop',
                ]);
            }
        }

        //dd($discountGroup);

        /*CustomerServiceCart::find($itemDetails)->update([
            "price_id" => $priceDiscount['PriceID'],
            "customer_group_id" => $priceDiscount['CustomerGroupId'],
            "customer_group_code" => $priceDiscount['CustomerGroupCode'],
            "min_price" => $priceDiscount['MinPrice'],
            "max_price" => $priceDiscount['MaxPrice'],
            "start_date" => $priceDiscount['StartDate'],
            "end_date" => $priceDiscount['EndDate'],
            "discount_perc" => $priceDiscount['DiscountPerc']
        ]);*/
        //$this->dispatchBrowserEvent('closePriceDiscountList');
    }

    public function applyEngineOilLineDiscountSubmit($item_id){
        $discountGroup = [
            "Id" => "41",
            "Code" => "ENGINE_OIL",
            "Title" => "ENGINE OIL",
            "Active" => "1",
            "GroupType" => "3",
            "UnitId" => null,
            "DiscountCard" => null
        ];
        $this->selectedDiscount = [
            'unitId'=>isset($discountGroup['UnitId'])?$discountGroup['UnitId']:null,
            'code'=>$discountGroup['Code'],
            'title'=>$discountGroup['Title'],
            'id'=>$discountGroup['Id'],
            'groupType'=>$discountGroup['GroupType'],
        ];
        $this->showSelectedDiscount=true;
        if($discountGroup['Id']==41)
        {
            if(auth()->user('user')['station_id']!=1){
                $this->engineOilDiscountForm=true;
                $this->discountCardApplyForm=false;
                $this->searchStaffId=false;
                $this->manulDiscountForm=false;
            }
            else
            {
                $this->staffavailable="Discount Not Available..!";
            }
        }

        $this->dispatchBrowserEvent('scrolltoInModal', [
            'scrollToId' => 'scrollToDiscountTop',
        ]);
    }

    public function applyDIsountinItemService($discountPrice){
        //dd($discountPrice);
        $itemCartId = $this->lineItemDetails['id'];
        $customerBasket = CustomerServiceCart::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->vehicle_id,'id'=>$itemCartId,'division_code'=>auth()->user('user')->stationName['LandlordCode']])->first();
        $cartUpdate['price_id']=$discountPrice['PriceID'];
        $cartUpdate['customer_group_id']=$discountPrice['CustomerGroupId'];
        $cartUpdate['customer_group_code']=$discountPrice['CustomerGroupCode'];
        $cartUpdate['min_price']=$discountPrice['MinPrice'];
        $cartUpdate['max_price']=$discountPrice['MaxPrice'];
        $cartUpdate['start_date']=$discountPrice['StartDate'];
        $cartUpdate['end_date']=$discountPrice['EndDate'];
        $cartUpdate['discount_perc']=$discountPrice['DiscountPerc'];
        CustomerServiceCart::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->vehicle_id,'id'=>$itemCartId,'division_code'=>auth()->user('user')->stationName['LandlordCode']])->update($cartUpdate);
        
        $this->dispatchBrowserEvent('closePriceDiscountList');
        $this->lineDIscountItemId = null;
        $this->linePriceDiscount = null;
        $this->selectedDiscount = null;

        $this->discountCardApplyForm=false;
        $this->showSelectedDiscount=false;
    }

    public function selectDiscountGroup($discountGroup){
        $this->manulDiscountForm=false;
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
            //$this->dispatchBrowserEvent('closeDiscountGroupModal');
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

    

    public function clickDiscountGroup(){
        $this->selectedDiscount=null;
        $this->discountCardApplyForm=false;
        $this->showSelectedDiscount=false;
        //$this->dispatchBrowserEvent('closeDiscountGroupModal');
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
                    if($items->customer_group_code != 'MOBIL4+1'){
                        $discountSalePrice= $this->engineOilDiscountPercentage;
                    }
                    else
                    {
                        $discountSalePrice= null;
                    }
                    
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
                CustomerServiceCart::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->vehicle_id,'id'=>$items->id,'division_code'=>auth()->user('user')->stationName['LandlordCode']])->update($cartUpdate);
            }
        }

        $this->dispatchBrowserEvent('closePriceDiscountList');
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
            //'vehicle_id'=>$this->vehicle_id,
            'discount_id'=>$this->selectedDiscount['id'],
            'discount_card_number'=>$this->discount_card_number,
            'is_active'=>1
        ]);

        if(!$customerDiscountGroupQuery->exists())
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
            //dd($customerDiscontGroupInfo);
            $customerDiscontGroup = CustomerDiscountGroup::create($customerDiscontGroupInfo);
        }
        else{
            $customerDiscountGroupQuery->update([
                'discount_card_validity'=>$this->discount_card_validity,
                'groupType'=>$this->selectedDiscount['groupType']
            ]);
            
        }

        $this->appliedDiscount = $this->selectedDiscount;
        $this->applyDIsountinItemService($this->linePriceDiscount);
        //$this->applyDiscountOnCart();
        $this->dispatchBrowserEvent('closeDiscountGroupModal');

    }


    public function submitService(){
        if($this->job_number){
            return redirect()->to('submit-job-update/'.$this->customer_id.'/'.$this->vehicle_id.'/'.$this->job_number);
        }
        else{
            return redirect()->to('submit-job/'.$this->customer_id.'/'.$this->vehicle_id);
        }
    }


    public function applyManualLineDiscountSubmit($cartId,$ItemCode){
        $selectedManualDiscountGroup = LaborCustomerGroup::where('GroupType','=',7)->where(['Active'=>true])->first();
        $this->selectedDiscount = [
            'unitId'=>isset($selectedManualDiscountGroup['UnitId'])?$selectedManualDiscountGroup['UnitId']:null,
            'code'=>$selectedManualDiscountGroup['Code'],
            'title'=>$selectedManualDiscountGroup['Title'],
            'id'=>$selectedManualDiscountGroup['Id'],
            'groupType'=>$selectedManualDiscountGroup['GroupType'],
        ];
        $this->showSelectedDiscount=true;
        $this->engineOilDiscountForm=false;
        $this->discountCardApplyForm=false;
        $this->searchStaffId=false;
        $this->manulDiscountForm=true;
    }

    public function saveManulDiscountAproval(){
        $validatedData = $this->validate([
            'manualDiscountValue' => 'required',
        ]);
        
        $cartUpdate['price_id']=158;
        $cartUpdate['customer_group_id']=158;
        $cartUpdate['customer_group_code']='MANUAL_DISCOUNT';
        if($this->manualDiscountValueType=='amount'){
            $cartUpdate['min_price']=$this->lineItemDetails['unit_price']-$this->manualDiscountValue;
            $cartUpdate['max_price']=$this->lineItemDetails['unit_price']-$this->manualDiscountValue;
            $cartUpdate['discount_perc']=custom_round(($this->manualDiscountValue/$this->lineItemDetails['unit_price'])*100);
            $cartUpdate['manual_discount_percentage']=custom_round(($this->manualDiscountValue/$this->lineItemDetails['unit_price'])*100);
        }
        else{
            $cartUpdate['min_price']=custom_round($this->lineItemDetails['unit_price'] - (($this->lineItemDetails['unit_price'] * $this->manualDiscountValue) / 100));
            $cartUpdate['max_price']=custom_round($this->lineItemDetails['unit_price'] - (($this->lineItemDetails['unit_price'] * $this->manualDiscountValue) / 100));
            $cartUpdate['discount_perc']=custom_round($this->manualDiscountValue);
            $cartUpdate['manual_discount_percentage']=custom_round($this->manualDiscountValue);
        }
        $cartUpdate['start_date']=null;
        $cartUpdate['end_date']=null;
        $cartUpdate['manual_discount_value']=$this->manualDiscountValue;
        $cartUpdate['manual_discount_applied_by']=auth()->user('user')['id'];
        $cartUpdate['manual_discount_applied_datetime']=Carbon::now();
        $cartUpdate['manual_discount_status']=1;
        $cartUpdate['manual_discount_remark']=$this->manualDiscountRemarks;
        CustomerServiceCart::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->vehicle_id,'id'=>$this->lineItemDetails['id'],'division_code'=>auth()->user('user')->stationName['LandlordCode']])->update($cartUpdate);
        $this->dispatchBrowserEvent('closePriceDiscountList');
        $this->lineDIscountItemId = null;
        $this->linePriceDiscount = null;
        $this->selectedDiscount = null;

        $this->discountCardApplyForm=false;
        $this->showSelectedDiscount=false;
        $this->getCartInfo();
    }

    public function sendManualDiscountApproval($refNo=null){
        if($refNo==null){
            $manualDiscountAprovals = ManualDiscountAprovals::create([
                'customer_id'=>$this->customer_id,
                'vehicle_id'=>$this->vehicle_id,
                'customer_name'=>$this->name,
                'customer_mobile'=>$this->mobile,
                'customer_email'=>$this->email,
                'make'=>$this->selectedVehicleInfo->make,
                'vehicle_image'=>$this->selectedVehicleInfo->vehicle_image,
                'model'=>$this->selectedVehicleInfo->model,
                'plate_number'=>$this->selectedVehicleInfo->plate_number_final,
                'station'=>auth()->user('user')['station_code'],
                'discount_status'=>1,
                'created_by'=>auth()->user('user')['id'],
                'is_active'=>1,
            ]);
            $refNo = $manualDiscountAprovals->id;
        }


        $cartTotal=0;
        $manualDiscountTotal=0;
        //dd($this->cartItems);
        foreach($this->cartItems as $cartItems)
        {
            if($cartItems->manual_discount_status ==1 && $cartItems->manual_discount_send_for_aproval ==null){
                $manualDiscountServicesGet = ManualDiscountServices::where(['manual_discount_ref_no'=>$refNo,
                    'item_id'=>$cartItems->item_id,
                    'cart_id'=>$cartItems->id,
                    'item_code'=>$cartItems->item_code]);
                if($manualDiscountServicesGet->exists()){
                    $manualDiscountServicesResult = $manualDiscountServicesGet->first();
                    ManualDiscountServices::where(['id'=>$manualDiscountServicesResult->id])->update([
                        'manual_discount_ref_no'=>$refNo,
                        'item_id'=>$cartItems->item_id,
                        'cart_id'=>$cartItems->id,
                        'item_code'=>$cartItems->item_code,
                        'item_name'=>$cartItems->item_name,
                        'service_item_type'=>$cartItems->cart_item_type,
                        'department_code'=>$cartItems->department_code,
                        'department_name'=>$cartItems->department_name,
                        'section_code'=>$cartItems->section_code,
                        'section_name'=>$cartItems->section_name,
                        'unit_price'=>$cartItems->unit_price,
                        'quantity'=>$cartItems->quantity,
                        'manual_discount_value'=>$cartItems->manual_discount_value,
                        'manual_discount_percentage'=>$cartItems->manual_discount_percentage,
                        'manual_discount_applied_by'=>$cartItems->manual_discount_applied_by,
                        'manual_discount_applied_datetime'=>$cartItems->manual_discount_applied_datetime,
                        'manual_discount_send_for_aproval'=>1,
                        'discount_status'=>1,
                        'manual_discount_remark'=>$cartItems->manual_discount_remark,
                        'updated_by'=>auth()->user('user')['id'],
                        'is_active'=>1,
                    ]);
                    $manualDiscountTotal = $manualDiscountTotal+($cartItems->manual_discount_value*$cartItems->quantity);
                    CustomerServiceCart::where(['id'=>$cartItems->id])->update([
                        'manual_discount_send_for_aproval'=>1,
                        'manual_discount_ref_no'=>$refNo,
                    ]);

                }else{
                    ManualDiscountServices::create([
                        'manual_discount_ref_no'=>$refNo,
                        'item_id'=>$cartItems->item_id,
                        'cart_id'=>$cartItems->id,
                        'item_code'=>$cartItems->item_code,
                        'item_name'=>$cartItems->item_name,
                        'service_item_type'=>$cartItems->cart_item_type,
                        'department_code'=>$cartItems->department_code,
                        'department_name'=>$cartItems->department_name,
                        'section_code'=>$cartItems->section_code,
                        'section_name'=>$cartItems->section_name,
                        'unit_price'=>$cartItems->unit_price,
                        'quantity'=>$cartItems->quantity,
                        'manual_discount_value'=>$cartItems->manual_discount_value,
                        'manual_discount_percentage'=>$cartItems->manual_discount_percentage,
                        'manual_discount_applied_by'=>$cartItems->manual_discount_applied_by,
                        'manual_discount_applied_datetime'=>$cartItems->manual_discount_applied_datetime,
                        'manual_discount_remark'=>$cartItems->manual_discount_remark,
                        'discount_status'=>1,
                        'created_by'=>auth()->user('user')['id'],
                        'is_active'=>1,
                    ]);
                    $manualDiscountTotal = $manualDiscountTotal+($cartItems->manual_discount_value*$cartItems->quantity);

                    CustomerServiceCart::where(['id'=>$cartItems->id])->update([
                        'manual_discount_send_for_aproval'=>1,
                        'manual_discount_ref_no'=>$refNo,
                    ]);
                }
            }
            $cartTotal = $cartTotal+($cartItems->unit_price*$cartItems->quantity);
        }

        $manualDiscountTotalPercentage = custom_round(($manualDiscountTotal/$cartTotal)*100);
        ManualDiscountAprovals::where(['id'=>$refNo])->update([
            'manual_discount_value'=>$manualDiscountTotal,
            'manual_discount_percentage'=>$manualDiscountTotalPercentage,
            'manual_discount_applied_by'=>auth()->user('user')['id'],
            'manual_discount_applied_datetime'=>Carbon::now()
        ]);

        try {
            DB::select('EXEC [dbo].[ManualDiscountJob] @referenceCodde = "'.$refNo.'", @doneby = "'.auth()->user('user')->id.'" ');
        } catch (\Exception $e) {
            //dd($e->getMessage());
            //return $e->getMessage();
        }

        

        session()->flash('cartsuccess', 'Manual discount successfully send for approval, please wait until the discount approved!');
        $this->getCartInfo();
    }

}
