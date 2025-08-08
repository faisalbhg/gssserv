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

use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;




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
use App\Models\ManualDiscountAprovals;
use App\Models\ManualDiscountServices;
use App\Models\TempCustomerSignature;
use App\Models\ItemWarehouse;
use App\Models\ItemCurrentStock;


class CustomerServiceJob extends Component
{
    use WithFileUploads;
    public $selectedCustomerVehicle=false, $showSectionsList=false, $showServiceSectionsList=false, $showServiceItems=false, $showItemsSearchResults=false, $showQlItemSearch=false, $showQlEngineOilItems=false, $showQlItemsOnly=false, $showQlItemsList=false, $showPackageList=false, $selectPackageMenu=false, $showPackageServiceSectionsList=false, $showAddMakeModelNew=false;
    public $showServiceGroup=true, $showCheckout;
    public $showVehicleAvailable, $selectedVehicleInfo, $selected_vehicle_id, $customer_id;
    public $servicesGroupList, $service_group_id, $service_group_name, $service_group_code, $station, $section_service_search, $propertyCode, $selectedSectionName;
    public $selectServiceItems, $sectionsLists;
    public $serviceAddedMessgae=[], $serviceStockErrShow=[], $serviceStockErrMessgae=[],$cartItems = [], $cardShow=false, $ql_item_qty=[], $ceramic_dicount, $showManulDiscount=[],$manualDiscountInput;
    public $itemCategories=[], $itemSubCategories=[], $itemBrandsLists=[], $item_search_category, $item_search_subcategory, $item_search_brand, $item_search_name, $item_search_code, $serviceItemsList=[];
    public $quickLubeItemsList = [], $qlBrandsLists=[], $ql_search_brand, $ql_km_range, $ql_search_category, $itemQlCategories=[], $quickLubeItemSearch, $quickLubeItemCode;
    public $customerGroupLists;
    public $selectedDiscount, $appliedDiscount=[], $showDiscountDroup=false, $discountSearch=true;
    public $discount_card_imgae, $discount_card_number, $discount_card_validity;
    public $discountCardApplyForm=false, $engineOilDiscountForm=false, $discountForm=false;
    public $customerSelectedDiscountGroup, $employeeId, $searchStaffId, $staffavailable;

    public $editCUstomerInformation=false, $addNewVehicleInformation=false, $showForms=false, $searchByMobileNumber = false, $editCustomerAndVehicle=false, $showByMobileNumber=true, $showCustomerForm=false, $showPlateNumber=false, $otherVehicleDetailsForm=false, $searchByChaisisForm=false, $updateVehicleFormBtn = false, $addVehicleFormBtn=false, $cancelEdidAddFormBtn=false, $showSaveCustomerButton=false, $showSearchByPlateNumberButton=false, $showSearchByChaisisButton=false;
    public $mobile, $name, $email, $customer_code, $plate_number_image, $plate_country = 'AE', $plateStateCode=2, $plate_state='Dubai', $plate_category, $plate_code, $plate_number, $vehicle_image, $vehicle_type, $make, $model, $chaisis_image, $chassis_number, $vehicle_km;
    public $stateList, $plateEmiratesCodes, $vehicleTypesList, $listVehiclesMake, $vehiclesModelList=[];
    public $servicePackages, $showPackageAddons=false;
    public $package_number, $package_code, $showPackageOtpVerify=false, $package_otp, $package_otp_message, $customerBookedPackages=[], $openPackageDetailsVerify,$showOpenPackageDetails=false, $sectionPackageServiceLists=[];
    public $customize_price=-1, $customise_service_item_price, $extra_note,$extra_description, $mechanical_discount;
    public $showTempCart=false,$jobDetails, $tempCartItems, $tempCartItemCount;
    public $confirming, $confirmingRA=false;
    public $customizedErrorMessage=[];
    public $new_make, $new_make_id, $makeSearchResult=[], $modelSearchResult=[], $showAddNewModel=false, $new_model;
    public $showBundleList=false, $selectBundleMenu=false, $bundlleLists, $selectedBundles, $showBundleServiceSectionsList, $bundleServiceLists=[];
    public $selectAdvanceCouponMenu=false, $showAdvanceCouponList=false, $showAdvanceCouponOtpVerify=false, $advance_coupon_number, $numberPlateRequired=true;
    public $lineDIscountItemId, $linePriceDiscount, $discountAvailability;
    public $showSelectedDiscount=false, $priceDiscountList, $lineItemDetails, $showLineDiscountItems=false; 
    public $applyManualDiscount=false, $selectedManualDiscountGroup, $manualDiscountValue, $manulDiscountForm=false;
    public $pendingExistingJobs=null, $showPendingJobList=false;
    public $customerSignature, $showCustomerSignature=false;
    public $shoeJobHistoryModal=false, $jobsHistory;
    
    public function clickShowSignature()
    {
        TempCustomerSignature::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->vehicle_id,'is_active'=>1])->delete();
        $this->customerSignature=null;
        $this->showCustomerSignature=true;
        $this->dispatchBrowserEvent('showSignature');

    }

    function mount( Request $request) {
        $this->customer_id = $request->customer_id;
        $this->vehicle_id = $request->vehicle_id;
        $this->job_number = $request->job_number;
        if($this->vehicle_id && $this->customer_id)
        {
            $this->selectVehicle();
            
        }
        if($this->job_number)
        {
            $this->customerJobDetails();
        }

    }

    public function selectVehicle(){
        $customers = CustomerVehicle::with(['customerInfoMaster','makeInfo','modelInfo','customerDiscountLists'])->where(['is_active'=>1,'id'=>$this->vehicle_id,'customer_id'=>$this->customer_id])->first();
        //dd($customers);
        $this->selectedCustomerVehicle=true;

        $this->showServiceGroup = true;
        
        $this->showVehicleAvailable = false;
        $this->selectedVehicleInfo=$customers;

        $this->mobile = $customers->customerInfoMaster['Mobile'];
        $this->name = $customers->customerInfoMaster['TenantName'];
        $this->email = $customers->customerInfoMaster['Email'];
        
        
    }

    public function customerJobDetails(){
        $customerJobCardsQuery = CustomerJobCards::with(['customerInfo','customerJobServices','checklistInfo','makeInfo','modelInfo','tempServiceCart','checklistInfo']);
        $customerJobCardsQuery = $customerJobCardsQuery->where(['job_number'=>$this->job_number]);
        $customerJobCardsQuery = $customerJobCardsQuery->where('payment_status','!=',1);
        //$customerJobCardsQuery = $customerJobCardsQuery->whereIn('job_status', ['1'])
        $customerJobCardsQuery = $customerJobCardsQuery->where('job_status','!=',4);

        $this->jobDetails =  $customerJobCardsQuery->first();
        //dd($this->jobDetails);
        if($this->jobDetails){
            $this->customer_id = $this->jobDetails->customer_id;
            $this->vehicle_id = $this->jobDetails->vehicle_id;

            $this->showTempCart = true;
            if($this->jobDetails->customer_job_update==null){
                CustomerJobCards::where(['job_number'=>$this->job_number])->update(['customer_job_update'=>1]);
                CustomerServiceCart::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->vehicle_id,'job_number'=>$this->job_number])->delete();
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
        }
        $validatedData = $this->validate($validateSaveVehicle);



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
                //$customerVehicleUpdate['vehicle_image_base64']=base64_encode(file_get_contents($this->vehicle_image->getRealPath()));
            }

            if($this->plate_number_image)
            {
                $customerVehicleUpdate['plate_number_image'] = $this->plate_number_image->store('plate_number', 'public');
                //$customerVehicleUpdate['plate_number_image_base64'] = base64_encode(file_get_contents($this->plate_number_image->getRealPath()));
            }

            if($this->chaisis_image)
            {
                $customerVehicleUpdate['chaisis_image'] = $this->chaisis_image->store('chaisis_image', 'public');
                //$customerVehicleUpdate['chaisis_image_base64']=base64_encode(file_get_contents($this->chaisis_image->getRealPath()));
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
        }
        $validatedData = $this->validate($validateSaveVehicle);

        
        if($this->vehicle_image)
        {
            $customerVehicleInsert['vehicle_image'] = $this->vehicle_image->store('vehicle', 'public');
            //$customerVehicleInsert['vehicle_image_base64']=base64_encode(file_get_contents($this->vehicle_image->getRealPath()));
        }
        if($this->plate_number_image)
        {
            $customerVehicleInsert['plate_number_image'] = $this->plate_number_image->store('plate_number', 'public');
            //$customerVehicleInsert['plate_number_image_base64']=base64_encode(file_get_contents($this->plate_number_image->getRealPath()));
        }
        if($this->chaisis_image)
        {
            $customerVehicleInsert['chaisis_image'] = $this->chaisis_image->store('chaisis_image', 'public');
            //$customerVehicleInsert['chaisis_image_base64']=base64_encode(file_get_contents($this->chaisis_image->getRealPath()));
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

    /**
     * Customer Services Selection
     * */
    public function openServiceGroup(){
        $this->showServiceGroup=true;
        $this->dispatchBrowserEvent('scrollto', [
            'scrollToId' => 'servceGroup',
        ]);
    }


    public function render()
    {
        /*$getJobLisTgbj = CustomerServiceCart::with(['getJobInfo'])->where(function ($query) {
                            $query->whereRelation('getJobInfo', 'job_status', '=',4);
                        })->where('job_number','!=',null)->get();
        foreach($getJobLisTgbj as $job_numberDget)
        {
            if($job_numberDget->getJobInfo['job_status']>3){
                CustomerServiceCart::where(['customer_id'=>$job_numberDget->customer_id,'vehicle_id'=>$job_numberDget->vehicle_id,'job_number'=>$job_numberDget->job_number])->delete();
            }
        }*/
        if($this->job_number==null){
            $this->checkExistingJobs();
        }

        if($this->new_make)
        {
            $this->makeSearchResult = VehicleMakes::where('vehicle_name','like',"%{$this->new_make}%")->where('is_deleted','=',null)->get();
            if($this->showAddNewModel && $this->new_model)
            {
                $this->modelSearchResult = VehicleModels::where('vehicle_make_name','=',$this->new_make)->where('vehicle_model_name','like',"%{$this->new_model}%")->get();
            }
        }
        else
        {
            $this->showAddNewModel=false;
        }
        
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

        }

        
        if($this->showServiceSectionsList)
        {
            $sectionServiceLists = LaborItemMaster::select("ItemId","ItemCode","CompanyCode","CategoryId","SubCategoryId","BrandId","LedgerId","SubLedgerId","SerialNo","BarCode","ItemName","Description","MinimumStockQuantity","MinimumOrderQuantity","StockQuantity","PurchasePrice","AveragePurchasePrice","SellingPriceType","SellingPriceMarkupType","SellingPrice","WarehouseId","AddVatToSellPrice","AllowDiscount","StorageBin","IsTerminated","TerminationDate","ReplacementPartId","Active","CreatedDate","CreatedBy","ModifiedDate","ModifiedBy","Origin","StockType","PriceCalculationMethod","Status","StatusChangedDate","ApprovalStatus","ApprovalDate","ApprovedBy","UnitMeasurement","QuantityBooked","Rank","ParentItemId","ApprovedDate","SubmittedDate","SubmittedBy","PurchaseUnitMeasurement","QuantityPerPurchase","VATGroupId","DivisionCode","DepartmentCode","SectionCode","UnitPrice","Id","SortIndex","CustomizePrice","MinPrice","MaxPrice","isDirectDiscount","DirectDiscPerc","ExtraNotes","CustomizeName","IsCeramicWash","IsWarranty","WarrantyPeriod","WarrantyTerms")->with(['departmentName','sectionName'])->where([
                'SectionCode'=>$this->propertyCode,
                'DivisionCode'=>auth()->user('user')->stationName['LandlordCode'],
                'Active'=>1,
            ]);
            if($this->section_service_search){
                $sectionServiceLists = $sectionServiceLists->where('ItemName','like',"%$this->section_service_search%");
            }

            $sectionServiceLists = $sectionServiceLists->orderBy('SortIndex','ASC')->get();
            if($this->selectedVehicleInfo->customerInfoMaster['discountgroup']==14 || $this->selectedVehicleInfo->ceramic_wash_discount_count > 0){
                //$sectionServicePriceLists = [];
                foreach($sectionServiceLists as $key => $sectionServiceList){
                    $discountLaborSalesPrices = LaborSalesPrices::where([
                        'ServiceItemId'=>$sectionServiceList->ItemId,
                        'CustomerGroupCode'=>$this->selectedVehicleInfo->customerInfoMaster['TenantCode']
                    ]);
                    $discountLaborSalesPrices = $discountLaborSalesPrices->where('StartDate', '<=', Carbon::now());
                    if($discountLaborSalesPrices->exists()){
                        $sectionServiceLists[$key]['discountDetails'] = $discountLaborSalesPrices->first();
                    }

                    if($sectionServiceList->ItemCode == 'S322')
                    {
                        $discountLaborSalesPricesCeramcDis = LaborSalesPrices::where([
                            'ServiceItemId'=>$sectionServiceList->ItemId,
                            'CustomerGroupCode'=>'CERAMIC_WASH',
                        ]);
                        $discountLaborSalesPricesCeramcDis = $discountLaborSalesPricesCeramcDis->where('StartDate', '<=', Carbon::now());
                        //$discountLaborSalesPricesCeramcDis = $discountLaborSalesPricesCeramcDis->where('EndDate', '>=', Carbon::now() );
                        $sectionServiceLists[$key]['discountDetails'] = $discountLaborSalesPricesCeramcDis->first();
                        
                    }

                    
                    //dd($sectionServiceLists);
                    
                }
            }
            if($this->selectedVehicleInfo->ceramic_wash_discount_count > 0)
            {
                $discountLaborSalesPrices = LaborSalesPrices::where([
                        'ServiceItemId'=>$sectionServiceList->ItemId,
                        'CustomerGroupCode'=>'CERAMIC_WASH',
                    ]);
                $discountLaborSalesPrices = $discountLaborSalesPrices->where('StartDate', '<=', Carbon::now());
                //$discountLaborSalesPrices = $discountLaborSalesPrices->where('EndDate', '>=', Carbon::now() );
                $sectionServiceLists[$key]['discountDetails'] = $discountLaborSalesPrices->first();
            }
            //dd($sectionServiceLists);
            $this->sectionServiceLists = $sectionServiceLists;
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
                'division_code'=>auth()->user('user')['station_code'],
                //'payment_status'=>1
            ])->get();
            $sectionServicePriceLists = [];
            //dd($packageBookingServicesQuery);
            foreach($packageBookingServicesQuery as $key => $packageServices)
            {
                $sectionServicePriceLists[$key]['package_quantity'] = $packageServices->quantity;
                $sectionServicePriceLists[$key]['package_quantity_used'] = $packageServices->package_service_use_count;
                $sectionServicePriceLists[$key]['priceDetails'] = $packageServices->labourItemDetails;
                $serviceUnitPrice = $packageServices->unit_price;
                $serviceDiscountPrice = $packageServices->discounted_price;
                $servicePriceDiff = $serviceUnitPrice-$serviceDiscountPrice;

                $discountPerc = ($servicePriceDiff/$serviceUnitPrice) * 100;
                $packageServices['DiscountPerc']=round($discountPerc,2);
                $sectionServicePriceLists[$key]['discountDetails']=$packageServices;
                
            }
            $this->sectionPackageServiceLists=$sectionServicePriceLists;
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
                if($this->item_search_code){
                    $inventoryItemMasterLists = $inventoryItemMasterLists->where('ItemCode','like',"%{$this->item_search_code}%");
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
                                'DivisionCode'=>auth()->user('user')->stationName['LandlordCode'],
                            ]);
                        if($this->appliedDiscount['groupType']==1)
                        {
                            $qlInventorySalesPricesQuery = $qlInventorySalesPricesQuery->where('EndDate', '=', null );
                            //$qlInventorySalesPricesQuery = $qlInventorySalesPricesQuery;

                        }else if($this->appliedDiscount['groupType']==2)
                        {
                            $qlInventorySalesPricesQuery = $qlInventorySalesPricesQuery->where('StartDate', '<=', Carbon::now())->where('EndDate', '>=', Carbon::now() );
                        }
                        $qlInventorySalesPricesQuery = $qlInventorySalesPricesQuery->first();
                        $itemPriceLists[$key]['discountDetails'] = $qlInventorySalesPricesQuery;
                    }
                    else if($this->selectedVehicleInfo->customerInfoMaster['discountgroup']==14)
                    {
                        $qlInventorySalesPricesQuery = InventorySalesPrices::where([
                            'ServiceItemId'=>$itemMasterList->ItemId,
                            'CustomerGroupCode'=>$this->selectedVehicleInfo->customerInfoMaster['TenantCode'],
                            'DivisionCode'=>auth()->user('user')->stationName['LandlordCode']
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
                    if($this->quickLubeItemCode){
                        $quickLubeItemsNormalList = $quickLubeItemsNormalList->where('ItemCode','like',"%{$this->quickLubeItemCode}%");
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
                                    'DivisionCode'=>auth()->user('user')->stationName['LandlordCode'],
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
                                'DivisionCode'=>auth()->user('user')->stationName['LandlordCode']
                            ]);
                            $qlKMInventorySalesPricesQuery = $qlKMInventorySalesPricesQuery->where('StartDate', '<=', Carbon::now());
                            //$qlKMInventorySalesPricesQuery = $qlKMInventorySalesPricesQuery->where('EndDate', '>=', Carbon::now() );
                            $qlItemPriceLists[$key]['discountDetails'] = $qlKMInventorySalesPricesQuery->first();
                        }
                        else
                        {
                            $qlItemPriceLists[$key]['discountDetails']=null;
                        }
                        //$this->ql_item_qty[$qlItemsList->ItemId]=null;
                        
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
                                        'DivisionCode'=>auth()->user('user')->stationName['LandlordCode'],
                                    ])->first();

                                }else if($this->appliedDiscount['groupType']==2)
                                {
                                    
                                    $qlMakeModelCatItmDetails[$key]['discountDetails'] = InventorySalesPrices::where([
                                        'ServiceItemId'=>$qlMakeModelCatItm->ItemId,
                                        'CustomerGroupCode'=>$this->appliedDiscount['code'],
                                        'DivisionCode'=>auth()->user('user')->stationName['LandlordCode'],
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
                                        'DivisionCode'=>auth()->user('user')->stationName['LandlordCode'],
                                    ])->first();

                                }else if($this->appliedDiscount['groupType']==2)
                                {
                                    
                                    $qlMakeModelCatItmDetails[$key]['discountDetails'] = InventorySalesPrices::where([
                                        'ServiceItemId'=>$qlMakeModelCatItm->ItemId,
                                        'CustomerGroupCode'=>$this->appliedDiscount['code'],
                                        'DivisionCode'=>auth()->user('user')->stationName['LandlordCode'],
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
                            //$this->ql_item_qty[$qlItemMakeModelItem->ItemId]=null;

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
            $this->customerBookedPackages = PackageBookings::with(['customerPackageServices','packageSubTypes'])->where([
                'customer_id'=>$this->customer_id,
                'vehicle_id'=>$this->vehicle_id,
                'station'=>auth()->user('user')['station_code'],
                'payment_status'=>1
            ])
            ->orderBy('id','DESC')->get();
            //dd($this->customerBookedPackages);
            /*foreach($this->customerBookedPackages as $customerBookedPackages){
                $this->openPackageDetailsVerify[$customerBookedPackages['package_number']]=false;
            }*/
            $this->servicePackages = ServicePackage::with(['packageDetails','packageTypes','packageSubTypes'])->where(['Status'=>'A','Division'=>auth()->user('user')['station_code']])->get();
            //dd($this->servicePackages);

            //$this->showPackageAddons=false;
        }
        else{
            $this->customerBookedPackages=null;
            $this->servicePackages=null;
        }

        if($this->showBundleList)
        {
            $this->bundlleLists = ServiceBundleType::with(['bundleDiscountedPrice'])->where(['Active'=>1])->get();
        }
        else
        {
            $this->bundlleLists=null;
        }


        //$this->openServiceGroup();
        $this->getCartInfo();
        $this->dispatchBrowserEvent('selectSearchEvent');
        $this->emit('chosenUpdated');
        if($this->job_number)
        {
            $this->customerJobDetails();
        }
        if($this->customerSignature){
            if(!TempCustomerSignature::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->vehicle_id,'is_active'=>1])->exists()){
                TempCustomerSignature::create([
                    'customer_id'=>$this->customer_id,
                    'vehicle_id'=>$this->vehicle_id,
                    'signature'=>$this->customerSignature,
                    'is_active'=>1,
                ]);
            }
        }
        if(TempCustomerSignature::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->vehicle_id,'is_active'=>1])->exists())
        {
            $tempCustomerSignature = TempCustomerSignature::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->vehicle_id,'is_active'=>1])->first();
            $this->customerSignature = $tempCustomerSignature->signature;
        }

        

        return view('livewire.customer-service-job');
    }

    public function applyLineDiscount($item){
        //dd($item);
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
                'DivisionCode'=>auth()->user('user')->stationName['LandlordCode'],
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
        $this->priceDiscountList = $inventorySalesPricesResult;
        //dd($this->priceDiscountList);
        $this->showLineDiscountItems = true;
        $this->dispatchBrowserEvent('showPriceDiscountList');
        $this->dispatchBrowserEvent('scrolltoInModalTopNew');
    }


     /**
     * Apply Discount on Saved Discount
     * customer based
     * */
    public function savedCustomerLineDiscountGroup($item,$savedCustomerDiscount){
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

    public function applyDiscountOnSavedCustomerDiscount()
    {
        $item = $this->lineItemDetails;
        //dd($item);
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
            //dd($inventorySalesPricesResult);
        }
        else if($item['cart_item_type']==2){
            $inventorySalesPricesQuery = InventorySalesPrices::where([
                'ServiceItemId'=>$item['item_id'],
                'CustomerGroupCode'=>$this->selectedDiscount['code'],
                'DivisionCode'=>auth()->user('user')->stationName['LandlordCode'],
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

    public function applyDIsountinItemService($discountPrice){
        //dd($discountPrice);
        $itemCartId = $this->lineItemDetails['id'];
        $customerBasket = CustomerServiceCart::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->vehicle_id,'id'=>$itemCartId])->first();
        $cartUpdate['price_id']=$discountPrice['PriceID'];
        $cartUpdate['customer_group_id']=$discountPrice['CustomerGroupId'];
        $cartUpdate['customer_group_code']=$discountPrice['CustomerGroupCode'];
        $cartUpdate['min_price']=$discountPrice['MinPrice'];
        $cartUpdate['max_price']=$discountPrice['MaxPrice'];
        $cartUpdate['start_date']=$discountPrice['StartDate'];
        $cartUpdate['end_date']=$discountPrice['EndDate'];
        $cartUpdate['discount_perc']=$discountPrice['DiscountPerc'];
        CustomerServiceCart::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->vehicle_id,'id'=>$itemCartId])->update($cartUpdate);
        
        $this->dispatchBrowserEvent('closePriceDiscountList');
        $this->lineDIscountItemId = null;
        $this->linePriceDiscount = null;
        $this->selectedDiscount = null;

        $this->discountCardApplyForm=false;
        $this->showSelectedDiscount=false;
    }


    /**
     * Check Staff DIscount Submit
     * */
    public function checkLineStaffDiscountGroup(){
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

    public function clickLineDiscountGroup(){
        $this->selectedDiscount=null;
        $this->discountCardApplyForm=false;
        $this->showSelectedDiscount=false;
        //$this->dispatchBrowserEvent('closeDiscountGroupModal');
    }


    public function saveSelectedLineDiscountGroup(){
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

    public function selectEngineOilLineDiscount($percentage){
        
        $this->discountCardApplyForm=false;
        $this->discountForm=false;
        $this->appliedDiscount = $this->selectedDiscount;

        $this->engineOilDiscountPercentage=$percentage;
        $this->customerDiscontGroupId = $this->selectedDiscount['id'];
        $this->customerDiscontGroupCode = $this->selectedDiscount['code'];
        $this->applyEngineOilDiscount();
        
        $this->selectedDiscount=null;
        $this->showSelectedDiscount=false;
        
        $this->dispatchBrowserEvent('closePriceDiscountList');
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
                $this->manulDiscountForm=false;
                $this->engineOilDiscountForm=false;
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
        $cartUpdate['min_price']=custom_round(($this->manualDiscountValue/$this->lineItemDetails['unit_price'])*100);
        $cartUpdate['max_price']=custom_round(($this->manualDiscountValue/$this->lineItemDetails['unit_price'])*100);
        $cartUpdate['start_date']=null;
        $cartUpdate['end_date']=null;
        $cartUpdate['discount_perc']=custom_round(($this->manualDiscountValue/$this->lineItemDetails['unit_price'])*100);
        $cartUpdate['manual_discount_value']=$this->manualDiscountValue;
        $cartUpdate['manual_discount_percentage']=custom_round(($this->manualDiscountValue/$this->lineItemDetails['unit_price'])*100);
        $cartUpdate['manual_discount_applied_by']=auth()->user('user')['id'];
        $cartUpdate['manual_discount_applied_datetime']=Carbon::now();
        $cartUpdate['manual_discount_status']=1;
        CustomerServiceCart::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->vehicle_id,'id'=>$this->lineItemDetails['id']])->update($cartUpdate);
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
                        'discount_status'=>1,
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






    public function openPackageDetails($packBookd){
        //
    }

    public function redeemPackageDetails($packBookd){
        $packageFinished=false;
        foreach($packBookd['customer_package_services'] as $customer_package_services){
            if($customer_package_services['quantity'] == $customer_package_services['package_service_use_count']){
                $packageFinished=true;
            }
            else
            {
                $packageFinished=false;
            }
        }
        //dd($packBookd);
        if($packageFinished==false)
        {
            $this->package_number= $packBookd['package_number'];
            $this->package_code= $packBookd['package_code'];
            $mobileNumber = isset($packBookd['customer_mobile'])?'971'.substr($packBookd['customer_mobile'], -9):null;
            //$mobileNumber = '971566993709';
            $customerName = isset($packBookd['customer_name'])?$packBookd['customer_name']:null;
            $otpPack = fake()->randomNumber(6);
            PackageBookings::where(['package_number'=>$packBookd['package_number']])->update(['otp_code'=>$otpPack,'otp_verify'=>0]);
            if($mobileNumber!='' && auth()->user('user')->stationName['EnableSMS']==1){
                $msgtext = urlencode('Dear Customer, use OTP '.$otpPack.' to redeem your GSS '.$this->package_number.'. Valid for 10 mins. Do not share it with anyone. For help, call 800477823');
                $response = Http::get(config('global.sms')[1]['sms_url']."&mobileno=".$mobileNumber."&msgtext=".$msgtext."&CountryCode=ALL");
            }
            $this->showPackageOtpVerify=true;
            session()->flash('package_success', 'Package is valid, please enter the OTP shared in the registered mobile number..!');
        }
        else
        {
            session()->flash('package_error', 'Package is completely used..!');
        }

        $this->dispatchBrowserEvent('showpckageRedeemModal');
        /*$this->showOpenPackageDetails=true;
        $this->package_number= $packBookd['package_number'];
        $this->showPackageServiceSectionsList=true;
        $this->dispatchBrowserEvent('openServicesPackageListModal');*/
    }

    public function checkExistingJobs(){
        $existingJobs = CustomerJobCards::with(['customerJobServices'])->where([
            'vehicle_id'=>$this->vehicle_id,
            'customer_id'=>$this->customer_id
        ])->where('payment_status','!=',1)->where('job_status','<',3);
        if($existingJobs->exists())
        {
            $this->showPendingJobList=true;
            $this->pendingExistingJobs = $existingJobs->get();
            $this->dispatchBrowserEvent('openPendingJobListModal');
            //$existingJobs = $existingJobs->first();
            //return redirect()->to('customer-service-job/'.$this->customer_id.'/'.$this->vehicle_id.'/'.$existingJobs->job_number);
        }
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
        }

        /*$this->cartItems = CustomerServiceCart::with(['manualDiscountServiceInfo'])->where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->vehicle_id])->get();
        
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

    

    public function getSectionServices($section)
    {
        $this->propertyCode=$section['PropertyCode'];
        $this->selectedSectionName = $section['PropertyName'];
        $this->showServiceSectionsList=true;
        $this->showServiceItems = false;
        $this->dispatchBrowserEvent('openServicesListModal');
        
    }

    

    public function serviceGroupForm($service){
        $this->showManulDiscount['S408']=false;
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
        $this->showAdvanceCouponList=false;
        $this->selectBundleMenu=false;
        $this->selectAdvanceCouponMenu=false;

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
        $this->quickLubeItemCode=null;
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
        
        if($this->quickLubeItemSearch==null && $this->quickLubeItemCode==null)
        {
            $validatedData = $this->validate([
                'quickLubeItemSearch' => 'required',
            ]);
        }
        else
        {
            $this->ql_search_brand=null;
            $this->ql_km_range=null;
            $this->ql_search_category=null;
            $this->showQlItemSearch = true;
            $this->showQlItemsList = true;
            $this->showQlEngineOilItems=true;
            $this->showQlItemsOnly=false;
        }
        

        
    }
    public function addToCartCP($servicePrice,$discount,$customize_price){
        $validatedData = $this->validate([
            'customise_service_item_price' => 'required',
        ]);
    }
    public function addtoCart($servicePrice,$discount=null)
    {

        //dd(CustomerServiceCart::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->vehicle_id])->get());
        $update=true;
        $addtoCartAllowed=false;
        $servicePrice = json_decode($servicePrice,true);
        //dd($servicePrice);
        $discountPrice = json_decode($discount,true);
        //dd($discountPrice);
        if(in_array($servicePrice['ItemCode'],config('global.extra_description_applied')))
        {
           $validatedData = $this->validate([
                'extra_description.'.$servicePrice['ItemId'] => 'required',
            ]);
            $update=false; 
        }
        if($servicePrice['CustomizePrice']==1)
        {
            $validatedData = $this->validate([
                'customise_service_item_price.'.$servicePrice['ItemId'] => 'required',
            ]);

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
            if($this->job_number)
            {
                $customerBasketCheck = $customerBasketCheck->where(['job_number'=>$this->job_number]);
            }
            else
            {
                $customerBasketCheck = $customerBasketCheck->where(['job_number'=>null]);
            }
            if($customerBasketCheck->count() && $update==true)
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
                    'item_name'=>isset($this->extra_description[$servicePrice['ItemId']])?$this->extra_description[$servicePrice['ItemId']]:$servicePrice['ItemName'],
                    'description'=>$servicePrice['Description'],
                    'division_code'=>$servicePrice['DivisionCode'],
                    'department_code'=>$servicePrice['DepartmentCode'],
                    'section_name'=>$servicePrice['section_name']['PropertyName'],
                    'department_name'=>$servicePrice['department_name']['DevelopmentName'],
                    'section_code'=>$servicePrice['SectionCode'],
                    'unit_price'=>$servicePrice['UnitPrice'],
                    'quantity'=>1,
                    'created_by'=>auth()->user('user')['id'],
                    'created_at'=>Carbon::now(),
                ];
                if($servicePrice['IsWarranty'])
                {
                   $cartInsert['isWarranty'] = $servicePrice['IsWarranty'];
                   $cartInsert['warrantyPeriod'] = $servicePrice['WarrantyPeriod'];
                   $cartInsert['warrantyTerms'] = $servicePrice['WarrantyTerms'];
                }
                if($this->extra_note!=null){
                   $cartInsert['extra_note']=isset($this->extra_note[$servicePrice['ItemId']])?$this->extra_note[$servicePrice['ItemId']]:null; 
                }

                if(isset($this->mechanical_discount[$servicePrice['ItemId']]))
                {
                    $cartInsert['price_id']=null;
                    $cartInsert['customer_group_id']=157;
                    $cartInsert['customer_group_code']='MANUAL_DISCOUNT';
                    $cartInsert['min_price']=null;
                    $cartInsert['max_price']=null;
                    $cartInsert['start_date']=Carbon::now();
                    $cartInsert['end_date']=Carbon::now();

                    $totalMechServItem = $servicePrice['UnitPrice']; // Original price
                    $discAmountMechSrvItm = $servicePrice['UnitPrice']-$this->mechanical_discount[$servicePrice['ItemId']]; // Discounted price

                    if ($totalMechServItem > 0) {
                        $discountPercentage = (($totalMechServItem - $discAmountMechSrvItm) / $totalMechServItem) * 100;
                        $discountPercentage = round($discountPercentage, 2); // Round to 2 decimal places
                    } else {
                        $discountPercentage = 0;
                    }
                    $cartInsert['discount_perc']=$discountPercentage;
                    $discountPrice==null;
                    //dd($cartInsert);
                    
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

                if($this->job_number)
                {
                    $cartInsert['job_number']=$this->job_number;
                }
                if($servicePrice['ItemCode'] == config('global.ceramic.discount_in'))
                {
                    $discountPriceCW=null;
                    if($this->selectedVehicleInfo->ceramic_wash_discount_count>0){
                        $cartInsert['ceramic_wash_discount_count'] = 1;
                        $discountLaborSalesPricesCW = LaborSalesPrices::where([
                            'ServiceItemId'=>$servicePrice['ItemId'],
                            'CustomerGroupCode'=>'CERAMIC_WASH',
                        ]);
                        $discountLaborSalesPricesCW = $discountLaborSalesPricesCW->where('StartDate', '<=', Carbon::now());
                        $discountPriceCW = $discountLaborSalesPricesCW->first();
                    }
                    else if(isset($this->ceramic_dicount[$servicePrice['ItemId']])){
                        $cartInsert['ceramic_wash_discount_count'] = $this->ceramic_dicount[$servicePrice['ItemId']];
                        $discountLaborSalesPricesCW = LaborSalesPrices::where([
                            'ServiceItemId'=>$servicePrice['ItemId'],
                            'CustomerGroupCode'=>'CERAMIC_WASH',
                        ]);
                        $discountLaborSalesPricesCW = $discountLaborSalesPricesCW->where('StartDate', '<=', Carbon::now());
                        $discountPriceCW = $discountLaborSalesPricesCW->first();
                    }

                    if($discountPriceCW!=null){
                        $cartInsert['price_id']=$discountPriceCW->PriceID;
                        $cartInsert['customer_group_id']=$discountPriceCW->CustomerGroupId;
                        $cartInsert['customer_group_code']=$discountPriceCW->CustomerGroupCode;
                        $cartInsert['min_price']=$discountPriceCW->MinPrice;
                        $cartInsert['max_price']=$discountPriceCW->MaxPrice;
                        $cartInsert['start_date']=$discountPriceCW->StartDate;
                        $cartInsert['end_date']=$discountPriceCW->EndDate;
                        $cartInsert['discount_perc']=$discountPriceCW->DiscountPerc;
                    }

                }
                //dd($cartInsert);
                CustomerServiceCart::insert($cartInsert);
            }
            $this->serviceAddedMessgae[$servicePrice['ItemCode']]=true;
        }
        if($servicePrice['ItemCode']=='S267' || $servicePrice['ItemCode']=='S403')
        {
            $discount = InventorySalesPrices::where([
                                        'ServiceItemCode'=>'I04433',
                                        'CustomerGroupCode'=>'MICRO_FIB',
                                        //'DivisionCode'=>auth()->user('user')->stationName['LandlordCode'],
                                    ])
                                //->where('StartDate', '<=', Carbon::now())->where('EndDate', '>=', Carbon::now() )
                            ->first();
            $this->ql_item_qty['4420']=2;
            $this->addtoCartItem('I04433', json_encode($discount));
        }
        
        //$this->dispatchBrowserEvent('closeServicesListModal');

        /*$this->dispatchBrowserEvent('swal:modal', [
            'type' => 'success',
            'message' => 'Added to Cart Successfully',
            'text' => 'service added..!',
            'cartitemcount'=>\Cart::getTotalQuantity()
        ]);*/
        //session()->flash('cartsuccess', 'Service is Added to Cart Successfully !');
    }

    public function addtoCartItem($ItemCode,$discount=null)
    {
        //dd(CustomerServiceCart::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->vehicle_id])->get());
        $items = InventoryItemMaster::where(['ItemCode'=>$ItemCode])->first();
        $qty=1;
        if(isset($this->ql_item_qty[$items->ItemId]))
        {
            $qty=$this->ql_item_qty[$items->ItemId];
        }

        //dd($qty);
        //$qty = isset($this->ql_item_qty[$items->ItemId])?$this->ql_item_qty[$items->ItemId]:1;
        if($this->checkItemStock($items->ItemId, $items->ItemCode, $qty)){
        
            $discountPrice = json_decode($discount,true);    
            $customerBasketCheck = CustomerServiceCart::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->vehicle_id,'item_id'=>$items->ItemId]);
            if($this->job_number)
            {
                $customerBasketCheck = $customerBasketCheck->where(['job_number'=>$this->job_number]);
            }
            else
            {
                $customerBasketCheck = $customerBasketCheck->where(['job_number'=>null]);
            }
            if($customerBasketCheck->count())
            {
                if($items->ItemCode=='I09137')
                {
                    if(!CustomerServiceCart::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->vehicle_id,'item_id'=>$items->ItemId])->where('customer_group_id','!=',90)->increment('quantity', 4)){
                        CustomerServiceCart::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->vehicle_id,'item_id'=>$items->ItemId])->where('customer_group_id','=',null)->increment('quantity', 4);    
                    }
                    
                    CustomerServiceCart::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->vehicle_id,'item_id'=>$items->ItemId])->where('customer_group_id','=',90)->increment('quantity', 1);
                }
                else
                {
                    $customerBasketCheck->increment('quantity', $qty);
                }
                
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
                if($items->ItemCode=='I09137')
                {
                    $cartInsert['quantity']=4;
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
                if($this->job_number)
                {
                    $cartInsert['job_number']=$this->job_number;
                }
                //dd($cartInsert);
                CustomerServiceCart::insert($cartInsert);
                if($items->ItemCode=='I09137')
                {
                    $cartInsert['quantity']=1;
                    $discountAddOn = InventorySalesPrices::where([
                        'ServiceItemCode'=>'I09137',
                        'CustomerGroupCode'=>'MOBIL4+1',
                    ])->first();
                    if($discountAddOn!=null){
                        $cartInsert['price_id']=$discountAddOn['PriceID'];
                        $cartInsert['customer_group_id']=$discountAddOn['CustomerGroupId'];
                        $cartInsert['customer_group_code']=$discountAddOn['CustomerGroupCode'];
                        $cartInsert['min_price']=$discountAddOn['MinPrice'];
                        $cartInsert['max_price']=$discountAddOn['MaxPrice'];
                        $cartInsert['start_date']=$discountAddOn['StartDate'];
                        $cartInsert['end_date']=$discountAddOn['EndDate'];
                        $cartInsert['discount_perc']=$discountAddOn['DiscountPerc'];
                    }
                    CustomerServiceCart::insert($cartInsert);
                }
                
            }
            $this->serviceAddedMessgae[$items->ItemCode]=true;
            $this->serviceStockErrShow[$items->ItemCode]=false;

            /*if(CustomerServiceCart::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->vehicle_id,'item_code'=>'I09137'])->sum('quantity')==5)
            {
                $discountAddOn = InventorySalesPrices::where([
                    'ServiceItemCode'=>'I09137',
                    'CustomerGroupCode'=>'MOBIL4+1',
                ])->first();
                if($discountAddOn!=null){
                    $cartUpdate['price_id']=$discountAddOn['PriceID'];
                    $cartUpdate['customer_group_id']=$discountAddOn['CustomerGroupId'];
                    $cartUpdate['customer_group_code']=$discountAddOn['CustomerGroupCode'];
                    $cartUpdate['min_price']=$discountAddOn['MinPrice'];
                    $cartUpdate['max_price']=$discountAddOn['MaxPrice'];
                    $cartUpdate['start_date']=$discountAddOn['StartDate'];
                    $cartUpdate['end_date']=$discountAddOn['EndDate'];
                    $cartUpdate['discount_perc']=$discountAddOn['DiscountPerc'];
                    CustomerServiceCart::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->vehicle_id,'item_code'=>'I09137'])->update($cartUpdate);
                }
            }*/
            /*if($items->ItemCode=='I09137')
            {
                if($this->ql_item_qty[$items->ItemId]
                $discountAddOn = InventorySalesPrices::where([
                    'ServiceItemCode'=>'I09137',
                    'CustomerGroupCode'=>'MOBIL4+1',
                ])->first();
                $this->addtoCartItem('I09137',json_encode($discountAddOn));
            }*/

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
            $this->serviceAddedMessgae[$items->ItemCode]=false;
        }
    }

    public function checkItemStock($ItemId, $ItemCode, $qty)
    {
        
        $wareHouseDetails = ItemWarehouse::where(['DivisionId'=>auth()->user('user')->station_code])->first();
        $itemCurrentStock = ItemCurrentStock::where(['StoreId'=>$wareHouseDetails->WarehouseId,'ItemCode'=>$ItemCode])->first();
        $itemsInCart = CustomerServiceCart::where(['division_code'=>auth()->user('user')->station_code,'item_code'=>$ItemCode])->sum('quantity');
        $itemsInCart=0;
        $itemStock = (float)($itemCurrentStock->QuantityInStock);
        $totalAvailable =  $itemStock - $itemsInCart;

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

     public function addtoCartPackage($servicePrice,$discount)
    {
        //dd($servicePrice);
        $servicePrice = json_decode($servicePrice,true);

        $discountPrice = json_decode($discount,true);
        $customerBasketCheck = CustomerServiceCart::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->vehicle_id,'item_id'=>$servicePrice['ItemId'],'is_package'=>1]);
        if($customerBasketCheck->exists())
        {
            //dd($discountPrice);
            //$customerBasketCheck->increment('quantity', 1);
            if($discountPrice!=null){
                $cartUpdate['price_id']=$discountPrice['id'];
                $cartUpdate['customer_group_id']=$discountPrice['package_id'];
                $cartUpdate['customer_group_code']=$discountPrice['package_code'];
                $cartUpdate['min_price']=$discountPrice['unit_price'];
                $cartUpdate['max_price']=$discountPrice['unit_price'];
                //$cartUpdate['start_date']=$discountPrice['created_at'];
                //$cartUpdate['end_date']=$discountPrice['EndDate'];
                $cartUpdate['discount_perc']= custom_round($discountPrice['DiscountPerc']);
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
                /*'section_name'=>$this->selectedSectionName,
                'department_name'=>$this->service_group_name,*/
                'section_name'=>$servicePrice['section_name']['PropertyName'],
                    'department_name'=>$servicePrice['department_name']['DevelopmentName'],
                'section_code'=>$servicePrice['SectionCode'],
                'is_package'=>1,
                'package_code'=>$this->package_code,
                'package_number'=>$this->package_number,
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
                $cartInsert['discount_perc']=custom_round($discountPrice['DiscountPerc']);
            }
            if($this->job_number)
            {
                $cartInsert['job_number']=$this->job_number;
            }
            
            CustomerServiceCart::insert($cartInsert);
        }
        $this->serviceAddedMessgae[$servicePrice['ItemCode']]=true;
        $this->dispatchBrowserEvent('closeServicesPackageListModal');

        /*$this->dispatchBrowserEvent('swal:modal', [
            'type' => 'success',
            'message' => 'Added to Cart Successfully',
            'text' => 'service added..!',
            'cartitemcount'=>\Cart::getTotalQuantity()
        ]);*/
        //session()->flash('cartsuccess', 'Service is Added to Cart Successfully !');
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
        
    }

    public function removeCart($id)
    {
        CustomerServiceCart::find($id)->delete();
    }

    public function clearAllCart()
    {
        CustomerServiceCart::where(['customer_id'=>$this->customer_id, 'vehicle_id'=>$this->vehicle_id])->delete();
        $this->confirmingRA = false;
        session()->flash('cartsuccess', 'All Service Cart Clear Successfully !');
    }

    public function openServiceItems(){
        if($this->job_number){
            return redirect()->to('customer-service-items/'.$this->customer_id.'/'.$this->vehicle_id.'/'.$this->job_number);
        }
        else
        {
            return redirect()->to('customer-service-items/'.$this->customer_id.'/'.$this->vehicle_id);
        }
            
        
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
        $this->selectAdvanceCouponMenu=false;
        $this->showAdvanceCouponList=false;
        $this->dispatchBrowserEvent('scrollto', [
            'scrollToId' => 'serviceItemsListDiv',
        ]);
    }

    public function searchServiceItems(){
        
        /*$validatedData = $this->validate([
            //'item_search_category' => 'required',
            //'item_search_subcategory' => 'required',
        ]);*/
        $this->showItemsSearchResults=true;
    }

    public function clickDiscountGroup(){
        $this->discountSearch=true;
        $this->showDiscountDroup=true;
        $this->customerGroupLists = LaborCustomerGroup::where('GroupType','!=',5)->where('GroupType','!=',4)->where(['Active'=>true])->get();
        $this->dispatchBrowserEvent('openDiscountGroupModal');
    }


    public function selectDiscountGroup($discountGroup){
        //dd($discountGroup);
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
                $this->manulDiscountForm=false;
                $this->discountCardApplyForm=false;
                $this->engineOilDiscountForm=false;
            }
            else if($discountGroup['Id']==41)
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
            else
            {
                $this->discountCardApplyForm=true;
                $this->searchStaffId=false;
                $this->manulDiscountForm=false;
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
                //'vehicle_id'=>$this->vehicle_id,
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
        //$this->getCartInfo();

        CustomerServiceCart::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->vehicle_id,'id'=>$serviceId])->update($cartUpdate);
    }

    public function removeManualLineDiscount($serviceId){
        $cartUpdate['price_id']=null;
        $cartUpdate['customer_group_id']=null;
        $cartUpdate['customer_group_code']=null;
        $cartUpdate['min_price']=null;
        $cartUpdate['max_price']=null;
        $cartUpdate['start_date']=null;
        $cartUpdate['end_date']=null;
        $cartUpdate['discount_perc']=null;
        $cartUpdate['manual_discount_value']=null;
        $cartUpdate['manual_discount_percentage']=null;
        $cartUpdate['manual_discount_applied_by']=null;
        $cartUpdate['manual_discount_applied_datetime']=null;
        $cartUpdate['manual_discount_status']=null;
        //$this->getCartInfo();

        CustomerServiceCart::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->vehicle_id,'id'=>$serviceId])->update($cartUpdate);
    }



    public function removeDiscount(){

        $this->selectedDiscount=null;
        $this->appliedDiscount = null;
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
                    'DivisionCode'=>auth()->user('user')->stationName['LandlordCode'],
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
            }
        }
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
        $this->selectAdvanceCouponMenu=false;
        $this->showAdvanceCouponList=false;
        $this->dispatchBrowserEvent('scrollto', [
            'scrollToId' => 'packageServiceListDiv',
        ]);
    }

    public function openBundles(){

        $this->showBundleList=true;
        $this->selectBundleMenu=true;

        $this->showPackageList=false;
        $this->selectPackageMenu=false;
        $this->selectAdvanceCouponMenu=false;
        $this->showAdvanceCouponList=false;

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
        $this->bundleServiceLists = [];
        //$this->bundleServiceLists[$this->selectedBundles['TypeId']]['show']=true;
        foreach($this->selectedBundles['bundles_details'] as $selectedBundle)
        {
            $this->bundleServiceLists[$selectedBundle['Code']] = $selectedBundle;
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
                    $bundleLaborMaster = LaborItemMaster::select("ItemId","ItemCode","CompanyCode","CategoryId","SubCategoryId","BrandId","LedgerId","SubLedgerId","SerialNo","BarCode","ItemName","Description","MinimumStockQuantity","MinimumOrderQuantity","StockQuantity","PurchasePrice","AveragePurchasePrice","SellingPriceType","SellingPriceMarkupType","SellingPrice","WarehouseId","AddVatToSellPrice","AllowDiscount","StorageBin","IsTerminated","TerminationDate","ReplacementPartId","Active","CreatedDate","CreatedBy","ModifiedDate","ModifiedBy","Origin","StockType","PriceCalculationMethod","Status","StatusChangedDate","ApprovalStatus","ApprovalDate","ApprovedBy","UnitMeasurement","QuantityBooked","Rank","ParentItemId","ApprovedDate","SubmittedDate","SubmittedBy","PurchaseUnitMeasurement","QuantityPerPurchase","VATGroupId","DivisionCode","DepartmentCode","SectionCode","UnitPrice","Id","SortIndex","CustomizePrice","MinPrice","MaxPrice","isDirectDiscount","DirectDiscPerc","ExtraNotes","CustomizeName","IsCeramicWash","IsWarranty","WarrantyPeriod","WarrantyTerms")->with(['departmentName','sectionName'])->where([
                        //'DivisionCode'=>auth()->user('user')->stationName['LandlordCode'],
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

        $this->showBundleServiceSectionsList=true;
        $this->dispatchBrowserEvent('openBundleServicesListModal');
    }

    public function bundleAddtoCartDiscountApply()
    {
        $this->dispatchBrowserEvent('closeBundleServicesListModal');
        $this->clickDiscountGroup();
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
        //dd($customerPackageInfo);
        if($customerPackageInfo->payment_status==1){
            if($customerPackageInfo->package_status==1){
                $mobileNumber = isset($customerPackageInfo->customer_mobile)?'971'.substr($customerPackageInfo->customer_mobile, -9):null;
                $customerName = isset($customerPackageInfo->customer_name)?$customerPackageInfo->customer_name:null;
                $otpPack = fake()->randomNumber(6);
                PackageBookings::where(['package_number'=>$this->package_number])->update(['otp_code'=>$otpPack,'otp_verify'=>0]);
                if($mobileNumber!='' && auth()->user('user')->stationName['EnableSMS']==1){
                    $msgtext = urlencode('Dear Customer, use OTP '.$otpPack.' to redeem your GSS Package:#'.$this->package_number.'. Valid for 10 mins. Do not share it with anyone. For help, call 800477823');
                    $response = Http::get(config('global.sms')[1]['sms_url']."&mobileno=".$mobileNumber."&msgtext=".$msgtext."&CountryCode=ALL");
                }
                $this->showPackageOtpVerify=true;
                session()->flash('package_success', 'Package is valid, Please enter the OTP shared in the registered mobile number..!');
                $this->dispatchBrowserEvent('showpckageRedeemModal');
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
        //dd(PackageBookings::where(['package_number'=>$this->package_number,'otp_code'=>$this->package_otp,'payment_status'=>1])->exists());
        if(PackageBookings::where(['package_number'=>$this->package_number,'otp_code'=>$this->package_otp,'payment_status'=>1])->exists())
        {
            $packageInfoRed = PackageBookings::where(['package_number'=>$this->package_number,'otp_code'=>$this->package_otp,'payment_status'=>1])->first();
            //dd($packageInfoRed);
            if($packageInfoRed->payment_status!=1){
                $this->openPackageDetailsVerify[$this->package_number]=false;
                $this->showPackageOtpVerify=true;
                $this->otpVerified=false;
                $this->otp_message='Package is not valied..!';
                $this->dispatchBrowserEvent('scrollto', [
                    'scrollToId' => 'packageOTPVerifyRow',
                ]);
            }else{
                $this->openPackageDetailsVerify[$this->package_number]=true;
                $this->showOpenPackageDetails=true;
                $this->showPackageServiceSectionsList=true;
                $this->showPackageOtpVerify=false;
                $this->otpVerified=true;
                $this->dispatchBrowserEvent('closepckageRedeemModal');
                $this->dispatchBrowserEvent('openServicesPackageListModal');
            }
        }
        else
        {
            $this->openPackageDetailsVerify[$this->package_number]=false;
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
        $mobileNumber = isset($customerPackageInfo->customer_mobile)?'971'.substr($customerPackageInfo->customer_mobile, -9):null;
        $customerName = isset($customerPackageInfo->customer_name)?$customerPackageInfo->customer_name:null;
        $otpPack = fake()->randomNumber(6);
        PackageBookings::where(['package_number'=>$this->package_number])->update(['otp_code'=>$otpPack,'otp_verify'=>0]);
        if($mobileNumber!='' && auth()->user('user')->stationName['EnableSMS']==1){
            $msgtext = urlencode('Dear Customer, use OTP '.$otpPack.' to redeem your GSS Package: #'.$this->package_number.'. Valid for 10 mins. Do not share it with anyone. For help, call 800477823');
            $response = Http::get(config('global.sms')[1]['sms_url']."&mobileno=".$mobileNumber."&msgtext=".$msgtext."&CountryCode=ALL");
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
    public function confirmDeleteRA()
    {
        $this->confirmingRA = true;
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

    public function safe($id){
        $this->confirming = null;
    }

    public function safeRA(){
        $this->confirmingRA = false;
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

    public function manualDiscount($priceDetails){
        $priceDetails = json_decode($priceDetails,true);
        $this->showManulDiscount[$priceDetails['ItemCode']]=true;
    }


    /*
    *AdvanceCoupons
    */
    public function openAdvanceCoupons(){

        $this->selectAdvanceCouponMenu=true;
        $this->showAdvanceCouponList=true;
        
        

        $this->showPackageList=false;
        $this->selectPackageMenu=false;
        $this->showBundleList=false;
        $this->selectBundleMenu=false;
        

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

    public function openJobHistory(){
        $this->shoeJobHistoryModal=true;
        $jobsHistoryQuery = CustomerJobCards::with(['customerJobServices'])->where([
            'vehicle_id'=>$this->vehicle_id,
            'customer_id'=>$this->customer_id,
            'payment_status'=>1,
            'job_status'=>4
        ]);
        $this->jobsHistory = $jobsHistoryQuery->get();
        //dd($this->jobsHistory);
        $this->dispatchBrowserEvent('openJobHIstoryModal');
    }

    public function makeNewSameJob($job_number)
    {
        $jobsDetails = CustomerJobCards::with(['customerJobServices'])->where([
            'vehicle_id'=>$this->vehicle_id,
            'customer_id'=>$this->customer_id,
            'job_number'=>$job_number
        ])->first();
        foreach($jobsDetails->customerJobServices as $customerJobServices)
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
            ];

            CustomerServiceCart::insert($cartInsert);
        }
        $this->dispatchBrowserEvent('closeJobHIstoryModal');
    }   
}
