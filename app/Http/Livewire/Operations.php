<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\CustomerJobCards;
use App\Models\CustomerJobCardServices;
use App\Models\CustomerJobCardServiceLogs;

use App\Models\Customers;
use App\Models\Services;
use App\Models\ServicesType;
use App\Models\ServicesGroup;
use App\Models\StateList;
use App\Models\ServiceItemsPrice;
use App\Models\CustomerVehicle;
use App\Models\ServicesJobUpdate;
use App\Models\JobcardChecklistEntries;
use App\Models\ServiceChecklist;
use App\Models\TenantMasterCustomers;
use App\Models\Country;
use App\Models\PlateCategories;
use App\Models\PlateEmiratesCategory;
use App\Models\PlateCode;
use App\Models\Development;
use App\Models\Sections;
use App\Models\LaborItemMaster;
use App\Models\CustomerServiceCart;
use App\Models\ItemCategories;
use App\Models\InventoryBrand;
use App\Models\InventoryItemMaster;
use App\Models\Landlord;
use App\Models\TempCustomerServiceCart;
use App\Models\JobCardChecklists;

use Carbon\Carbon;
use Session;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use DB;

class Operations extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search_job_number = '', $search_job_date;
    public $customerDetails = false;
    public $job_number, $job_date_time, $vehicle_image, $make, $model, $plate_number, $chassis_number, $vehicle_km, $name, $email, $mobile, $customerType, $payment_status=0, $payment_type=0, $job_status=0, $job_departent, $total_price, $vat, $grand_total, $tax;
    public $filter = [0,1,2,3,4];

    public $customerjobservices =array();
    public $customerjoblogs = array();
    public $customerJobUpdation = [];

    public $showUpdateModel = false;
    public $filterTab='total';

    public $showServiceGroup  = false;
    public $showServiceType = false;
    public $showServicesitems = false;
    public $servicesGroups;
    public $servicesTypesList=[];
    public $cartItems = [], $cartItemCount=0, $quantity,$extra_note,$cartItemQty;
    public $cardShow=false;

    public $selected_vehicle_id, $customer_type,$service_group_id,$station,$service_search;
    public $service_group_name, $service_group_code;

    public $customer_id, $vehicle_id, $sCtmrVhlcustomer_vehicle_id, $sCtmrVhlvehicle_image, $sCtmrVhlvehicleName, $sCtmrVhlmake_model, $sCtmrVhlplate_number, $sCtmrVhlchassis_number, $sCtmrVhlvehicle_km, $sCtmrVhlname, $sCtmrVhlcustomerType, $sCtmrVhlemail, $sCtmrVhlmobile, $customer_vehicle_id, $vehicleName, $make_model;
    public $serviceItemsList = [];

    public $turn_key_on_check_for_fault_codes, $start_engine_observe_operation, $reset_the_service_reminder_alert, $stick_update_service_reminder_sticker_on_b_piller, $interior_cabin_inspection_comments, $check_power_steering_fluid_level, $check_power_steering_tank_cap_properly_fixed, $check_brake_fluid_level, $brake_fluid_tank_cap_properly_fixed, $check_engine_oil_level, $check_radiator_coolant_level, $check_radiator_cap_properly_fixed, $top_off_windshield_washer_fluid, $check_windshield_cap_properly_fixed, $underHoodInspectionComments, $check_for_oil_leaks_engine_steering, $check_for_oil_leak_oil_filtering, $check_drain_lug_fixed_properly, $check_oil_filter_fixed_properly, $ubi_comments;

    public $frontSideBumperCheck, $frontSideGrillCheck, $frontSideNumberPlateCheck, $frontSideHeadLampsCheck, $frontSideFogLampsCheck, $frontSideHoodCheck, $rearSideBumperCheck, $rearSideMufflerCheck, $rearSideNumberPlateCheck, $rearSideTrunkCheck, $rearSideLightsCheck, $rearSideRoofTopCheck, $leftSideWheelCheck, $leftSideFenderCheck, $leftSideSideMirrorCheck, $leftSideDoorGlassInOutCheck, $leftSideDoorHandleCheck, $leftSideSideStepperCheck, $rightSideWheelCheck, $rightSideFenderCheck, $rightSideSideMirrorCheck, $rightSideDoorGlassInOutCheck, $rightSideDoorHandleCheck, $rightSideSideStepperCheck, $innerCabinSmellCheck, $innerCabinWindshieldFRRRCheck, $innerCabinSteeringWheelCheck, $innerCabinGearKnobCheck, $innerCabinCentreConsoleCheck, $innerCabinAshTryCheck, $innerCabinDashboardCheck, $innerCabinACVentsFRRRCheck, $innerCabinInteriorTrimCheck, $innerCabinFloorMatCheck, $innerCabinRearViewMirrorCheck, $innerCabinLuggageCompCheck, $innerCabinRoofTopCheck;

    public $jobCustomerInfo,$updateService=false;
    public $jobcardDetails, $showaddServiceItems=false;
    public $showVehicleImageDetails=false;
    public $checkListDetails, $checklistLabels, $vehicleSidesImages, $vehicleCheckedChecklist, $vImageR1, $vImageR2, $vImageF, $vImageB, $vImageL1, $vImageL2, $customerSignature;
    public $showNumberPlateFilter=false, $search_plate_country, $stateList=[], $plateEmiratesCodes=[], $search_plate_state, $search_plate_code, $search_plate_number, $search_station, $search_payment;
    public $selectedVehicleInfo, $selectedCustomerVehicle=false, $showSectionsList=false, $selectServiceItems, $showPackageList=false, $selectPackageMenu=false, $showServiceSectionsList=false;
    public $propertyCode, $selectedSectionName;
    public $servicesGroupList, $sectionsLists=[], $sectionServiceLists=[];
    public $customerDiscontGroupId, $customerDiscontGroupCode;
    public $quickLubeItemsList=[], $quickLubeItemSearch='', $qlFilterOpen=false, $showQlItems=false, $showQlEngineOilItems=false, $showQlCategoryFilterItems=false, $showQuickLubeItemSearchItems=false, $itemQlCategories=[],  $ql_search_category, $ql_search_subcategory, $qlBrandsLists=[], $ql_search_brand, $ql_km_range, $search_jobType;
    public $customerJobServiceLogs;
    public $jobOrderReference;

    public $wash_bumber_check;
    public $showchecklist=[],$checklist_comments,$checklists;


    
    function mount( Request $request) {
        $job_number = $request->job_number;
        $filter = $request->filter;
        if($job_number)
        {
            $this->showUpdateModel=true;
            $this->customerJobUpdate($job_number);

        }
        else if($filter)
        {
            $this->filterTab = $filter;
            $this->filterJobListPage($filter);
        }

    }

    public function render()
    {
        /*CustomerJobCards::with(['stationInfo'])->where(['job_number'=>'JOB-GQS-00002056'])->where('payment_link_order_ref','!=',Null)->update(['payment_status'=>0]);*/
        //CustomerJobCardServices::where(['job_number'=>'JOB-GQS-00002056'])->update(['job_status'=>0,'job_departent'=>0]);
        /*CustomerJobCards::with(['stationInfo'])->where(['job_number'=>'JOB-GQS-00002056'])->where('payment_link_order_ref','!=',Null)->update(['payment_status'=>0]);
        dd(CustomerJobCards::with(['stationInfo','customerJobServices'])->where(['job_number'=>'JOB-GQS-00002056'])->get());
        dd(CustomerJobCards::with(['stationInfo'])->where(['job_number'=>'JOB-GQS-00002056','payment_status'=>0,'payment_type'=>1])->where('payment_link_order_ref','!=',Null)->get());*/
        
        $this->stationsList = Landlord::all();
        
        $getCountSalesJob = CustomerJobCards::select(
            array(
                \DB::raw('count(DISTINCT(customer_id)) customers'),
                \DB::raw('count(job_number) jobs'),
                \DB::raw('count(case when job_status = 0 then job_status end) new'),
                \DB::raw('count(case when job_status = 1 then job_status end) working_progress'),
                \DB::raw('count(case when job_status = 2 then job_status end) work_finished'),
                \DB::raw('count(case when job_status = 3 then job_status end) ready_to_deliver'),
                \DB::raw('count(case when job_status = 4 then job_status end) delivered'),
                \DB::raw('count(case when job_status in (0,1,2,3,4) then job_status end) total'),
                \DB::raw('SUM(grand_total) as saletotal'),
            )
        );


        $customerjobs = CustomerJobCards::with(['customerInfo','makeInfo','modelInfo','createdInfo']);
        if($this->filter){
            $customerjobs = $customerjobs->whereIn('job_status', $this->filter);
        }
        if($this->search_job_number)
        {
            $customerjobs = $customerjobs->where('job_number', 'like', "%{$this->search_job_number}%");
            $getCountSalesJob = $getCountSalesJob->where('job_number', 'like', "%{$this->search_job_number}%");
        }
        if($this->search_job_date){
            $customerjobs = $customerjobs->whereBetween('job_date_time', [$this->search_job_date." 00:00:00",$this->search_job_date." 23:59:59"]);
            $getCountSalesJob = $getCountSalesJob->whereBetween('job_date_time', [$this->search_job_date." 00:00:00",$this->search_job_date." 23:59:59"]);
        }
        if($this->search_plate_number)
        {
            $customerjobs = $customerjobs->where('plate_number', 'like',"%$this->search_plate_number%");
        }
        if($this->search_payment)
        {
            $customerjobs = $customerjobs->where('payment_type', '=',$this->search_payment);
        }
        if($this->search_station){
            //dd($this->search_station);
            $customerjobs = $customerjobs->where(['station'=>$this->search_station]);
            $getCountSalesJob = $getCountSalesJob->where(['station'=>$this->search_station]);
        }
        if($this->search_jobType){
            //dd($this->search_station);
            $customerjobs = $customerjobs->with(['customerJobServices'])->where(function ($query) {
                $query->whereRelation('customerJobServices', 'department_name', '=', $this->search_jobType);
            });
        }
        
        
        
        //dd($customerjobs);
        $getCountSalesJob = $getCountSalesJob->where('is_contract','=',null);
        if(auth()->user('user')->user_type!=1){
            $customerjobs = $customerjobs->where(['station'=>auth()->user('user')['station_code']]);
            $getCountSalesJob = $getCountSalesJob->where(['station'=>auth()->user('user')['station_code']]); 
            //$customerjobs=$customerjobs->with('createdInfo');
        }
        $customerjobs = $customerjobs->where('is_contract','=',null)->orderBy('id','DESC');
        $customerjobs = $customerjobs->paginate(10);
        
        $getCountSalesJob = $getCountSalesJob->first();
        //dd($customerjobs);

        /*$customerjobs = Customerjobs::
            select('customerjobs.*','customers.name','customers.email','customers.mobile','customertypes.customer_type as customerType')
            
            ->join('customers','customers.id','=','customerjobs.customer_id')
            ->join('customertypes','customertypes.id','=','customerjobs.customer_type')
            
            ->where('customerjobs.job_number', 'like', "%{$this->search}%")
            ->whereIn('customerjobs.job_status', $this->filter)
            ->paginate(20);*/
        
        
        $data['getCountSalesJob'] = $getCountSalesJob;
        $data['customerjobs'] = $customerjobs;
        $this->dispatchBrowserEvent('filterTab',['tabName'=>$this->filterTab]);

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

        return view('livewire.operations',$data);
    }

    public function showSearchPlateNumber(){
        $this->showNumberPlateFilter=true;
    }

    public function filterJobListPage($statusFilter)
    {
        switch($statusFilter){
            case 'total': $this->filter = [0,1,2,3,4];break;
            case 'working_progress': $this->filter = [1];break;
            case 'work_finished': $this->filter = [2,3];break;
            case 'ready_to_deliver': $this->filter = [3];break;
            case 'delivered': $this->filter = [4];break;
        }
        $this->filterTab = $statusFilter;
        $this->dispatchBrowserEvent('filterTab',['tabName'=>$this->filterTab]);
    }


    public function resendPaymentLink($job_number){
        $customerjobs = CustomerJobCards::
            select('customerjobs.*','customers.name','customers.email','customers.mobile','customertypes.customer_type as customerType')
            ->join('customers','customers.id','=','customerjobs.customer_id')
            ->join('customertypes','customertypes.id','=','customerjobs.customer_type')
            ->where(['customerjobs.job_number'=>$job_number])
            ->take(5)->first();
        $response = Http::withBasicAuth('20092622', 'buhaleeba@123')->post("https://mshastra.com/sendurlcomma.aspx?user=20092622&pwd=buhaleeba@123&senderid=BuhaleebaRE&mobileno=971566993709&msgtext=".urlencode('Job Id #'.$customerjobs->job_number.' is processing, Please click complete payment '.$customerjobs->payment_link)."&CountryCode=ALL");
    }


    public function updatePayment($job_number, $payment_status)
    {
        $this->payment_status = $payment_status;
        CustomerJobCards::where(['job_number'=>$job_number])->update(['payment_status'=>$payment_status]);
        
    }

    public function qualityCheck($services,$ql=null)
    {
        //dd($services['id']);
        $this->showchecklist[$services['id']]=true;
    }

    public function updateJobService($services,$ql=null)
    {
        $jobServiceId = $services['id'];
        $this->job_status = $services['job_status']+1;
        $this->job_departent = $services['job_departent']+1;
        
        $serviceJobUpdate = [
            'job_status'=>$services['job_status']+1,
            'job_departent'=>$services['job_status']+1,
        ];
        //dd($serviceJobUpdate);

        if($services['job_status']==1){
            JobCardChecklists::create([
                'job_number'=>$services['job_number'],
                'job_Service_id'=>$jobServiceId,
                'checklist'=>json_encode($this->checklists),
                'checklist_notes'=>json_encode($this->checklist_comments),
                'created_by'=>auth()->user('user')->id
            ]);
        }
        

        if($ql){
            CustomerJobCardServices::where(['job_number'=>$services['job_number'],'section_name'=>'Quick Lube'])->update($serviceJobUpdate);
        }
        else
        {
            CustomerJobCardServices::where(['id'=>$jobServiceId])->update($serviceJobUpdate);
        }

        $serviceJobUpdateLog = [
            'job_number'=>$services['job_number'],
            'customer_job__card_service_id'=>$jobServiceId,
            'job_status'=>$services['job_status']+1,
            'job_departent'=>$services['job_departent']+1,
            'job_description'=>json_encode($this),
            'created_by'=>auth()->user('user')->id,
        ];
        CustomerJobCardServiceLogs::create($serviceJobUpdateLog);

        $getCountSalesJobStatus = CustomerJobCardServices::select(
            array(
                \DB::raw('count(case when job_status = 0 then job_status end) new'),
                \DB::raw('count(case when job_status = 1 then job_status end) working_progress'),
                \DB::raw('count(case when job_status = 2 then job_status end) qualitycheck'),
                \DB::raw('count(case when job_status = 3 then job_status end) ready_to_deliver'),
                \DB::raw('count(case when job_status = 4 then job_status end) delivered'),
            )
        )->where(['job_number'=>$services['job_number']])->first();
        //dd($getCountSalesJobStatus);
        if($getCountSalesJobStatus->working_progress>0){
            $mainSTatus=1;
        }
        else if($getCountSalesJobStatus->qualitycheck>0){
            $mainSTatus=2;
        }
        else if($getCountSalesJobStatus->ready_to_deliver>0){
            $mainSTatus=3;
        }
        else if($getCountSalesJobStatus->delivered>0){
            $mainSTatus=4;
        }
        $mianJobUpdate = [
            'job_status'=>$mainSTatus,
            'job_departent'=>$mainSTatus,
        ];
        
        $customerJobDetailsHeader = CustomerJobCards::where(['job_number'=>$services['job_number']]);
        $customerJobStatusUpdate = $customerJobDetailsHeader->update($mianJobUpdate);

        
        

        $job = CustomerJobCards::with(['customerInfo','customerJobServices'])->where(['job_number'=>$services['job_number']])->first();
        $this->jobcardDetails = $job;
        $this->customerjobservices = $job->customerJobServices;

        if($mainSTatus==3)
        {
            
            try {
                DB::select('EXEC [dbo].[CreateCashierFinancialEntries_2] @jobnumber = "'.$services['job_number'].'", @doneby = "'.auth()->user('user')->id.'", @stationcode  = "'.auth()->user('user')->station_code.'", @paymentmode = "C", @customer_id = "'.$job->customer_id.'" ');
            } catch (\Exception $e) {
                //dd($e->getMessage());
                //return $e->getMessage();
            }


            /*try {
                DB::select('EXEC [dbo].[CreateCashierFinancialEntries_2] @jobnumber = "'.$services['job_number'].'", @doneby = "'.auth()->user('user')->id.'", @stationcode  = "'.auth()->user('user')->station_code.'", @paymentmode = "C", @customer_id = "'.$services['customer_id'].'" ');
            } catch (\Exception $e) {
                //return $e->getMessage();
            }*/


            if(auth()->user('user')->stationName['StationID']==4){
                $mobileNumber = isset($this->jobcardDetails['customer_mobile'])?'971'.substr($this->jobcardDetails['customer_mobile'], -9):null;
            }
            else
            {
                $mobileNumber = isset(auth()->user('user')->phone)?'971'.substr(auth()->user('user')->phone, -9):null;
            }
            
            $customerName = isset($this->jobcardDetails['customer_name'])?$this->jobcardDetails['customer_name']:null;
            if($mobileNumber!=''){
                //if($mobileNumber=='971566993709'){
                    $msgtext = urlencode('Dear '.$customerName.', your vehicle '.$this->plate_number.' is ready for pickup at '.auth()->user('user')->stationName['CorporateName'].'. Please collect your car within 1 hour from now , or a parking charge of AED 30 per hour will be applied separately, https://gsstations.ae/qr/'.$services['job_number'].' for the updates. Thank you for choosing GSS! . For assistance, call 800477823.');
                    $response = Http::get(config('global.sms')[1]['sms_url']."&mobileno=".$mobileNumber."&msgtext=".$msgtext."&CountryCode=ALL");
                //}
            }
        }
        
        
    }

    public function updateGSService($services)
    {
        $services = CustomerJobCardServices::find($services);
        

        $jobServiceId = $services->id;
        $this->job_status = $services->job_status+1;
        $this->job_departent = $services->job_departent+1;
        
        $serviceJobUpdate = [
            'job_status'=>$services->job_status+1,
            'job_departent'=>$services->job_status+1,
        ];
        CustomerJobCardServices::where(['id'=>$jobServiceId])->update($serviceJobUpdate);

        $serviceJobUpdateLog = [
            'job_number'=>$services->job_number,
            'customer_job_service_id'=>$jobServiceId,
            'job_status'=>$services->job_status+1,
            'job_departent'=>$services->job_departent+1,
            'job_description'=>json_encode($this),
        ];
        CustomerJobCardServiceLogs::create($serviceJobUpdateLog);
        
        $customerJobServiceDetails = CustomerJobCardServices::where(['job_number'=>$services->job_number])->get();
        $mainJobStatus=true;
        foreach($customerJobServiceDetails as $service)
        {
            if($service->job_status==1)
            {
                $mainJobStatus=false;
                break;
            }
            else
            {
                $mainJobStatus = true;
            }
        }
        if($mainJobStatus==true){
            Customerjobs::where(['job_number'=>$services->job_number])->update($serviceJobUpdate);
        }
        $this->customerjobservices = CustomerJobCardServices::where(['job_number'=>$services->job_number])->get();
    }
    public function updateQLService($services)
    {
        $services = json_decode($services);
        $jobServiceId = $services->id;
        $this->job_status = $services->job_status+1;
        $this->job_departent = $services->job_departent+1;
        
        $serviceJobUpdate = [
            'job_status'=>$services->job_status+1,
            'job_departent'=>$services->job_status+1,
        ];
        CustomerJobCardServices::where(['id'=>$jobServiceId])->update($serviceJobUpdate);

        $serviceJobUpdateLog = [
            'job_number'=>$services->job_number,
            'customer_job_service_id'=>$jobServiceId,
            'job_status'=>$services->job_status+1,
            'job_departent'=>$services->job_departent+1,
            'job_description'=>json_encode($this),
        ];
        CustomerJobCardServiceLogs::create($serviceJobUpdateLog);
        
        $customerJobServiceDetails = CustomerJobCardServices::where(['job_number'=>$services->job_number])->get();
        $mainJobStatus=true;
        foreach($customerJobServiceDetails as $service)
        {
            if($service->job_status==1)
            {
                $mainJobStatus=false;
                break;
            }
            else
            {
                $mainJobStatus = true;
            }
        }
        if($mainJobStatus==true){
            Customerjobs::where(['job_number'=>$services->job_number])->update($serviceJobUpdate);
        }
        $this->customerjobservices = CustomerJobCardServices::where(['job_number'=>$services->job_number])->get();
    }

    public function updateService($services)
    {
        $services = json_decode($services);
        if($services->job_status==1 && $services->service_group_id==8)
        {
            $this->dispatchBrowserEvent('hideServiceUpdate');
            $this->dispatchBrowserEvent('showQwChecklistModel');

        }
        else
        {
            $jobServiceId = $services->id;
            $this->job_status = $services->job_status+1;
            $this->job_departent = $services->job_departent+1;
            
            $serviceJobUpdate = [
                'job_status'=>$services->job_status+1,
                'job_departent'=>$services->job_status+1,
            ];
            CustomerJobCardServices::where(['id'=>$jobServiceId])->update($serviceJobUpdate);

            $serviceJobUpdateLog = [
                'job_number'=>$services->job_number,
                'customer_job_service_id'=>$jobServiceId,
                'job_status'=>$services->job_status+1,
                'job_departent'=>$services->job_departent+1,
                'job_description'=>json_encode($this),
            ];
            CustomerJobCardServiceLogs::create($serviceJobUpdateLog);
            
            $customerJobServiceDetails = CustomerJobCardServices::where(['job_number'=>$services->job_number])->get();
            $mainJobStatus=true;
            foreach($customerJobServiceDetails as $service)
            {
                if($service->job_status==1)
                {
                    $mainJobStatus=false;
                    break;
                }
                else
                {
                    $mainJobStatus = true;
                }
            }
            if($mainJobStatus==true){
                Customerjobs::where(['job_number'=>$services->job_number])->update($serviceJobUpdate);
            }
            $this->customerjobservices = CustomerJobCardServices::where(['job_number'=>$services->job_number])->get();

        }
        
        
    }
    public function openVehicleImageDetails(){
        $this->showVehicleImageDetails=true;
    }
    public function closeVehicleImageDetails()
    {
        $this->showVehicleImageDetails=false;
    }

    public function customerJobUpdate($job_number)
    {
        
        $this->showVehicleImageDetails=false;
        $this->updateService=true;
        $this->jobcardDetails = CustomerJobCards::with(['customerInfo','customerJobServices','checklistInfo','makeInfo','modelInfo','stationInfo'])->where(['job_number'=>$job_number])->first();
        foreach($this->jobcardDetails->customerJobServices as $jobcardDetailsList)
        {
            $this->showchecklist[$jobcardDetailsList->id]=false;
        }
        
        
        if($this->jobcardDetails->payment_type==1 && $this->jobcardDetails->payment_status == 0){
            //$this->checkPaymentStatus($this->jobcardDetails->job_number,$this->jobcardDetails->payment_link_order_ref,$this->jobcardDetails->stationInfo['StationID']);
        }
        
        //$this->customerJobServiceLogs = CustomerJobCardServices::where(['job_number'=>$job_number])->get();
        //dd($this->customerJobServiceLogs);
        if($this->jobcardDetails->checklistInfo!=null){
            $this->checkListDetails=$this->jobcardDetails->checklistInfo;
            $this->checklistLabels = ServiceChecklist::get();
            $this->vehicleCheckedChecklist = json_decode($this->jobcardDetails->checklistInfo['checklist'],true);
            $this->vehicleSidesImages = json_decode($this->jobcardDetails->checklistInfo['vehicle_image'],true);
            $this->turn_key_on_check_for_fault_codes = $this->checkListDetails['turn_key_on_check_for_fault_codes'];
            $this->start_engine_observe_operation = $this->checkListDetails['start_engine_observe_operation'];
            $this->reset_the_service_reminder_alert = $this->checkListDetails['reset_the_service_reminder_alert'];
            $this->stick_update_service_reminder_sticker_on_b_piller = $this->checkListDetails['stick_update_service_reminder_sticker_on_b_piller'];
            $this->interior_cabin_inspection_comments = $this->checkListDetails['interior_cabin_inspection_comments'];
            $this->check_power_steering_fluid_level = $this->checkListDetails['check_power_steering_fluid_level'];
            $this->check_power_steering_tank_cap_properly_fixed = $this->checkListDetails['check_power_steering_tank_cap_properly_fixed'];
            $this->check_brake_fluid_level = $this->checkListDetails['check_brake_fluid_level'];
            $this->brake_fluid_tank_cap_properly_fixed = $this->checkListDetails['brake_fluid_tank_cap_properly_fixed'];
            $this->check_engine_oil_level = $this->checkListDetails['check_engine_oil_level'];
            $this->check_radiator_coolant_level = $this->checkListDetails['check_radiator_coolant_level'];
            $this->check_radiator_cap_properly_fixed = $this->checkListDetails['check_radiator_cap_properly_fixed'];
            $this->top_off_windshield_washer_fluid = $this->checkListDetails['top_off_windshield_washer_fluid'];
            $this->check_windshield_cap_properly_fixed = $this->checkListDetails['check_windshield_cap_properly_fixed'];
            $this->underHoodInspectionComments = $this->checkListDetails['underHoodInspectionComments'];
            $this->check_for_oil_leaks_engine_steering = $this->checkListDetails['check_for_oil_leaks_engine_steering'];
            $this->check_for_oil_leak_oil_filtering = $this->checkListDetails['check_for_oil_leak_oil_filtering'];
            $this->check_drain_lug_fixed_properly = $this->checkListDetails['check_drain_lug_fixed_properly'];
            $this->check_oil_filter_fixed_properly = $this->checkListDetails['check_oil_filter_fixed_properly'];
            $this->ubi_comments = $this->checkListDetails['ubi_comments'];
            //dd($this->checkListDetails);
        }
        
        $this->dispatchBrowserEvent('showServiceUpdate');
        $this->dispatchBrowserEvent('hideQwChecklistModel');
    }
    

    public function checkPaymentStatus($job_number, $order_ref, $station, $jobs_plate_number)
    {
        //,$order_ref,$station
        $arrData['job_number'] = $job_number;
        $arrData['order_number'] = $order_ref;
        $arrData['station'] = $station;

        $mobileNumber=null;
        if($arrData['station']==4)
        {
            $mobileNumber = isset($jobs->customer_mobile)?'971'.substr($jobs->customer_mobile, -9):null;
        }
        $customerName = isset($jobs->customer_name)?$jobs->customer_name:null;

        $response = Http::withBasicAuth('onlinewebtutor', 'admin123')->post(config('global.synchronize_single_paymenkLink_url'),$arrData);
        $paymentResponse = json_decode($response,true);
        $orderResponseAmount = str_replace("د.إ.\u{200F} ","",$paymentResponse['order_response']['amount']);
        //dd($paymentResponse);
        if($paymentResponse['order_response']['status']=='PURCHASED' || $paymentResponse['order_response']['status']=='CAPTURED' )
        {
            CustomerJobCards::where(['job_number'=>$paymentResponse['order_response']['orderReference']])->update(['payment_status'=>1]);
            if($mobileNumber!=null){
                //dd($mobileNumber);  
                //if($mobileNumber=='971566993709'){
                    $msgtext = urlencode('Dear '.$customerName.', your payment of AED'.$orderResponseAmount.' for service on vehicle '.$jobs_plate_number.' at '.$jobs->stationInfo['ShortName'].' has been received. Receipt No:'.$paymentResponse['order_response']['orderReference'].', click here to access your gate pass for vehicle exit https://gsstations.ae/qr/'.$paymentResponse['order_response']['orderReference'].'. Thank you for your trust in GSS');
                    $response = Http::get(config('global.sms')[1]['sms_url']."&mobileno=".$mobileNumber."&msgtext=".$msgtext."&CountryCode=ALL");
                //}
            }
            session()->flash('paymentLinkStatusSuccess', 'Payment Link is paid..!');
            try {
                DB::select('EXEC [dbo].[Job.CashierAcceptPayment] @jobId = "'.$job_number.'", @paymentmode = "L", @doneby = "admin", @paymentDate="'.Carbon::now().'",@amountcollected='.$orderResponseAmount.',@advanceInvoice=NULL ');
            } catch (\Exception $e) {
                //dd($e->getMessage());
                //return $e->getMessage();
            }
        }
        else
        {
            session()->flash('paymentLinkStatusError', 'Payment Link is not yet paid..!');
        }
        $this->customerJobUpdate($paymentResponse['order_response']['orderReference']);
    }

    public function selectVehicle($customerId,$vehicleId){
        //dd($this);
        //dd($customerId.'-'.$vehicleId);
        //dd(CustomerVehicle::limit(2)->where(['id'=>$vehicleId])->get());
        $customers = CustomerVehicle::with(['customerInfoMaster','makeInfo','modelInfo','customerDiscountLists'])->where(['is_active'=>1,'id'=>$vehicleId,'customer_id'=>$customerId])->first();
        //dd($customers);
        
        $this->selectedVehicleInfo=$customers;
        $this->selected_vehicle_id = $customers->id;
        $this->customer_id = $customers->customer_id;
        $this->mobile = $customers->customerInfoMaster['Mobile'];
        $this->name = $customers->customerInfoMaster['TenantName'];
        $this->email = $customers->customerInfoMaster['Email'];
        //dd($this);
        
    }
    public function openServiceGroup(){
        $this->showServiceGroup=true;
        $this->showCheckout=false;
        $this->showPayLaterCheckout=false;
        $this->successPage=false;
    }

    public function addNewServiceItem($job_number)
    {


        $this->job_number = $job_number;


        $this->showServiceGroup=true;
        $this->showServiceType=true;

        $job = CustomerJobCards::with(['customerInfo','customerVehicle'])->where(['job_number'=>$this->job_number])->first();
        //dd($job);
        $this->selectVehicle($job->customer_id,$job->vehicle_id);

        
        $this->selected_vehicle_id = $job->vehicle_id;
        $this->customer_type = $job->customer_type;
        //dd(auth()->user('user')->station_id);
        $this->service_group_id;
        $this->station = auth()->user('user')->station_id;
        $this->servicesGroups = ServicesGroup::where(['is_active'=>1])->get();
        
        
        $this->showaddServiceItems=true;
        $this->selectedCustomerVehicle=true;
        $this->dispatchBrowserEvent('hideServiceUpdate');
        $this->dispatchBrowserEvent('showAddServiceItems');

    }

    public function serviceGroupForm($service)
    {
        $this->service_group_id = $service['id'];
        $this->service_group_name = $service['department_name'];
        $this->service_group_code = $service['department_code'];
        $this->station = $service['station_code'];
        $this->service_search='';
        $this->showSectionsList=true;
        if($this->service_group_name !='Quick Lube' || $this->showQlItems == true)
        {
            $this->showQlItems=false;
        }

        $this->selectedCustomerVehicle=true;
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
        //dd($section);
        $this->propertyCode=$section['PropertyCode'];
        $this->selectedSectionName = $section['PropertyName'];
        
        /*foreach($this->sectionServiceLists as $sectionServiceLists)
        {
            dd($sectionServiceLists);
        }*/
        $this->showServiceSectionsList=true;
        $this->dispatchBrowserEvent('openServicesListModal');
    }

    public function getServiceTypes()
    {
        $this->servicesTypesList = ServicesType::select(
            'services.*',
            'services_types.id AS service_type_id',
            'services_types.service_type_name',
            'services_types.service_type_code',
            'services_types.service_type_description',
            'services_types.service_group_id',
            'services_types.department_id',
            'services_types.section_id',
            'services_types.station_id',
            'services_groups.service_group_name',
            'services_groups.service_group_code',
        )
        ->join('services', 'services_types.id', '=', 'services.service_type_id')
        ->join('services_groups', 'services_groups.id', '=', 'services_types.service_group_id')
        ->where(
            [
                'services.customer_type'=> $this->customer_type,
                'services_types.service_group_id' => $this->service_group_id,
                'services_types.station_id'=>$this->station,
            ]
        )
        ->where('services_types.service_type_name', 'like', "%{$this->service_search}%")
        ->get();
    }

    public function selectedCustomerVehivleDetails($customerVehiceId)
    {
        $selectedCustomerVehicleDetails = CustomerVehicle::select(
            'customers.*',
            'customer_vehicles.id as customer_vehicle_id',
            'customer_vehicles.customer_id',
            'customer_vehicles.vehicle_type',
            'customer_vehicles.vehicle_image',
            'customer_vehicles.make as vehicleName',
            'customer_vehicles.model',
            'customer_vehicles.plate_number_final',
            'customer_vehicles.chassis_number',
            'customer_vehicles.vehicle_km',
            'customertypes.customer_type as customerType',
        )
        ->join('customers', 'customer_vehicles.customer_id', '=', 'customers.id')
        ->join('customertypes', 'customertypes.id', '=', 'customers.customer_type')
        ->where(['customer_vehicles.id'=>$customerVehiceId])->first();
        //dd($selectedCustomerVehicleDetails);
        $this->sCtmrVhlcustomer_vehicle_id = $selectedCustomerVehicleDetails->customer_vehicle_id;
        $this->sCtmrVhlvehicle_image =  $selectedCustomerVehicleDetails->vehicle_image;
        $this->sCtmrVhlvehicleName =  $selectedCustomerVehicleDetails->vehicleName;
        $this->sCtmrVhlmake_model =  $selectedCustomerVehicleDetails->model;
        $this->sCtmrVhlplate_number =  $selectedCustomerVehicleDetails->plate_number_final;
        $this->sCtmrVhlchassis_number =  $selectedCustomerVehicleDetails->chassis_number;
        $this->sCtmrVhlvehicle_km =  $selectedCustomerVehicleDetails->vehicle_km;
        $this->sCtmrVhlname =  $selectedCustomerVehicleDetails->name;
        $this->sCtmrVhlcustomerType =  $selectedCustomerVehicleDetails->customerType;
        $this->sCtmrVhlemail =  $selectedCustomerVehicleDetails->email;
        $this->sCtmrVhlmobile =  $selectedCustomerVehicleDetails->mobile;

        $this->customer_vehicle_id = $selectedCustomerVehicleDetails->customer_vehicle_id;
        $this->vehicle_image =  $selectedCustomerVehicleDetails->vehicle_image;
        $this->vehicleName =  $selectedCustomerVehicleDetails->vehicleName;
        $this->make_model =  $selectedCustomerVehicleDetails->model;
        $this->plate_number =  $selectedCustomerVehicleDetails->plate_number_final;
        $this->chassis_number =  $selectedCustomerVehicleDetails->chassis_number;
        $this->vehicle_km =  $selectedCustomerVehicleDetails->vehicle_km;
        $this->name =  $selectedCustomerVehicleDetails->name;
        $this->customerType =  $selectedCustomerVehicleDetails->customerType;
        $this->email =  $selectedCustomerVehicleDetails->email;
        $this->mobile =  $selectedCustomerVehicleDetails->mobile;
    }

    public function showServiceItem()
    {
        //dd($this->customer_type);
        $this->serviceItemsList = ServiceItemsPrice::with('serviceItems')
                    ->where('customer_types','=',$this->customer_type)
                    ->where('start_date', '<=', Carbon::now())
                    ->where(function ($query) {
                            $query->orWhere('end_date', '>=', Carbon::now())
                        ->orWhere('end_date', '=', null ) ;
                        }
                    )
                    ->get();
        $this->showServicesitems=true;
        $this->selectServicesitems=true;
        $this->showServiceType=false;
        //dd($this->serviceItemsList[0]);
    }

    public function showServices()
    {
        //dd($this->servicesTypesList);
        //dd($this);
        $this->getServiceTypes();
        $this->showServiceType=true;
        $this->selectServicesitems=false;
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
                'created_by'=>auth()->user('user')->id,
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
                'created_by'=>auth()->user('user')->id,
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
    public function searchQuickLubeItem(){
        $validatedData = $this->validate([
            'quickLubeItemSearch' => 'required',
        ]);

        $this->showQlItems=true;
        $this->showQlCategoryFilterItems=false;
        $this->showQuickLubeItemSearchItems=true;
        
    }

    public function qlCategorySelect(){
        $this->showQlItems=true;
        $this->showQlCategoryFilterItems=true;
        $this->showQuickLubeItemSearchItems=false;
        $this->dispatchBrowserEvent('scrolltopQl');
    }

    public function updateCart()
    {
        $this->getServiceTypes();
        \Cart::update($this->cartItems['id'], [
            'quantity' => [
                'relative' => false,
                'value' => $this->quantity
            ]
        ]);
        $this->cartItems = \Cart::getContent()->toArray();
        if(!empty($this->cartItems))
        {
            $this->cardShow=true;
        }
        else
        {
         $this->cardShow=false;   
        }
        $this->emit('cartUpdated');
    }

    public function removeCart($id)
    {
        $this->getServiceTypes();
        \Cart::remove($id);
        
        /*$this->dispatchBrowserEvent('swal:modal', [
            'type' => 'success',
            'message' => 'Service has removed',
            'text' => 'service added..!',
            'cartitemcount'=>\Cart::getTotalQuantity()
        ]);*/
        $this->cartItems = \Cart::getContent()->toArray();
        if(!empty($this->cartItems))
        {
            $this->cardShow=true;
        }
        else
        {
            $this->cardShow=false;
        }
    }

    public function clearAllCart()
    {
        $this->getServiceTypes();
        \Cart::clear();
        $this->dispatchBrowserEvent('swal:modal', [
            'type' => 'success',
            'message' => 'All Service Cart Clear Successfully !',
            'text' => 'service added..!',
            'cartitemcount'=>\Cart::getTotalQuantity()
        ]);
        $this->cartItems = \Cart::getContent()->toArray();
        $this->cardShow=false;
    }

    public function submitService(){
        $cartDetails = \Cart::getContent()->toArray();
        $job_number = $this->job_number;
        $customerVehicleId = $this->selected_vehicle_id;
        $customerId = $this->customer_id;
        $vehicleDetails = CustomerVehicle::find($customerVehicleId);
        
        $jobDetails = CustomerJobCards::where(['job_number'=>$job_number])->first();
        $oldTotalPrice = $jobDetails->total_price;
        $oldGrandTotal = $jobDetails->grand_total;
        $oldVat = $jobDetails->vat;

        $total = \Cart::getTotal();
        $tax = $total * (config('global.TAX_PERCENT') / 100);
        $grand_total = $total  * ((100 + config('global.TAX_PERCENT')) / 100);
        
        $customerJobUpdate = 
            [
                'total_price'=>custom_round(($total+$oldTotalPrice)),
                'vat'=>custom_round(($tax+$oldVat)),
                'grand_total'=>custom_round(($grand_total+$oldGrandTotal)),
                'job_status'=>1,
                'job_departent'=>1,
                'payment_status'=>0,
                'created_by'=>auth()->user('user')->id,
                'payment_updated_by'=>auth()->user('user')->id,
            ];
        CustomerJobCards::where(['job_number'=>$job_number])->update($customerJobUpdate);
        
        foreach($cartDetails as $cartData)
        {
            $serviceItemTax = $cartData['price'] * (config('global.TAX_PERCENT') / 100);
            $serviceGrandTotal = $cartData['price']  * ((100 + config('global.TAX_PERCENT')) / 100);
            $customerJobServiceData = [
                'job_number'=>$this->job_number,
                'job_id'=>$jobDetails->id,
                'total_price'=>$cartData['price'],
                'quantity'=>$cartData['quantity'],
                'vat'=>$serviceItemTax,
                'grand_total'=>$serviceGrandTotal,
                'job_status'=>1,
                'job_departent'=>1,
                'is_added'=>1,
                'is_removed'=>0,
                'created_by'=>auth()->user('user')->id,
            ];
            if($cartData['attributes']['service_item']==true)
            {
                $customerJobServiceData['service_item']=$cartData['attributes']['service_item'];
                $customerJobServiceData['item_id']=$cartData['attributes']['item_id'];
                $customerJobServiceData['item_code']=$cartData['attributes']['item_code'];
                $customerJobServiceData['item_name']=$cartData['attributes']['item_name'];
                $customerJobServiceData['brand_id']=$cartData['attributes']['brand_id'];
                $customerJobServiceData['brand_name']=$cartData['attributes']['brand_name'];
                $customerJobServiceData['category_id']=$cartData['attributes']['category_id'];
                $customerJobServiceData['category_name']=$cartData['attributes']['category_name'];
                $customerJobServiceData['item_group_id']=$cartData['attributes']['item_group_id'];
                $customerJobServiceData['product_group_name']=$cartData['attributes']['product_group_name'];
            }
            else
            {
                $customerJobServiceData['service_item']=$cartData['attributes']['service_item'];
                $customerJobServiceData['service_group_id']=$cartData['attributes']['service_group_id'];
                $customerJobServiceData['service_group_code']=$cartData['attributes']['service_group_code'];
                $customerJobServiceData['service_group_name']=$cartData['attributes']['service_group_name'];
                $customerJobServiceData['service_type_id']=$cartData['id'];
                $customerJobServiceData['service_type_code']=$cartData['attributes']['service_type_code'];
                $customerJobServiceData['service_type_name']=$cartData['name'];
            }

            $customerJobServiceId = CustomerJobCardservices::create($customerJobServiceData);

            CustomerJobCardServiceLogs::create([
                'job_number'=>$this->job_number,
                'job_status'=>1,
                'job_departent'=>1,
                'job_description'=>json_encode($customerJobServiceData),
                'customer_job_service_id'=>$customerJobServiceId->id,
                'created_by'=>auth()->user('user')->id,
            ]);
        }
        $this->showServiceType=false;
        $this->showServicesitems =false;
        $this->showServiceGroup=false;
        $this->dispatchBrowserEvent('showPaymentPannel');
    }

    public function completePaymnet($mode, $job_number)
    {
        //
    }

    public function removeService($service)
    {
        $service = json_decode($service);
        dd($service);
        $customerJobServiceUpdate = ['is_removed'=>1];
        CustomerJobCardServices::find($service->id)->update($customerJobServiceUpdate);

        /*$oldTotalPrice = $service->total_price*$service->quantity;
        $oldGrandTotal = $service->grand_total;
        $oldVat = $service->vat;

        $customerJobUpdate = 
            [
                'total_price'=>custom_round(($total+$oldTotalPrice),2),
                'vat'=>custom_round(($tax+$oldVat),2),
                'grand_total'=>custom_round(($grand_total+$oldGrandTotal),2),
                'job_status'=>1,
                'job_departent'=>1,
                'payment_status'=>0,
                'created_by'=>auth()->user('user')->id,
            ];
        Customerjobs::where(['job_number'=>$job_number])->update($customerJobUpdate);*/


        $this->customerjobservices = CustomerJobCardServices::where(['job_number'=>$service->job_number])->get();
    }

    public function clickQlJobOperation($in_out,$up_ser,$service)
    {
        $service = CustomerJobCardServices::find($service);
        if($in_out=='start')
        {
            $serviceUpdate[$up_ser.'_time_in'] = Carbon::now();
        }
        else if($in_out=='stop')
        {
            $serviceUpdate[$up_ser.'_time_out'] = Carbon::now();
        }
        CustomerJobCardServices::where(['job_number'=>$service->job_number,'id'=>$service->id])->update($serviceUpdate);
        $serviceJobUpdateLog = [
            'job_number'=>$service->job_number,
            'customer_job__card_service_id'=>$service->id,
            'job_status'=>$service->job_status,
            'job_departent'=>$service->job_departent,
            'job_description'=>json_encode($serviceUpdate),
        ];
        CustomerJobCardServiceLogs::create($serviceJobUpdateLog);

        //$this->customerJobUpdate($service['job_number']);
        //$this->customerjobservices = CustomerJobCardServices::where(['job_number'=>$service['job_number']])->get();
        //dd($this->customerjobservices);
        $job = CustomerJobCards::with(['customerInfo','customerJobServices'])->where(['job_number'=>$service['job_number']])->first();
        $this->jobcardDetails = $job;
        //dd($this->jobcardDetails);
        $this->customerjobservices = $job->customerJobServices;
    }

    public function clickJobOperation($in_out,$up_ser,$service)
    {
        $service = CustomerJobCardServices::find($service);
        if($in_out=='start')
        {
            $serviceUpdate[$up_ser.'_time_in'] = Carbon::now();
            //$serviceUpdate[$up_ser]=1;
        }
        else if($in_out=='stop')
        {
            $serviceUpdate[$up_ser.'_time_out'] = Carbon::now();
            //$serviceUpdate[$up_ser] = 2;
        }
        CustomerJobCardServices::where(['id'=>$service->id,'job_number'=>$service->job_number])->update($serviceUpdate);
        
        $serviceJobUpdateLog = [
            'job_number'=>$service['job_number'],
            'customer_job__card_service_id'=>$service['id'],
            'job_status'=>$service['job_status'],
            'job_departent'=>$service['job_departent'],
            'job_description'=>json_encode($serviceUpdate),
        ];
        CustomerJobCardServiceLogs::create($serviceJobUpdateLog);

        //$this->customerJobUpdate($service['job_number']);
        //$this->customerjobservices = CustomerJobCardServices::where(['job_number'=>$service['job_number']])->get();
        //dd($this->customerjobservices);
        $job = CustomerJobCards::with(['customerInfo','customerJobServices'])->where(['job_number'=>$service['job_number']])->first();
        $this->jobcardDetails = $job;
        //dd($this->jobcardDetails);
        $this->customerjobservices = $job->customerJobServices;
    }

    public function addNewServiceItemsJob($job_number){
        //dd($this->jobcardDetails->customerJobServices);
        foreach($this->jobcardDetails->customerJobServices as $customerJobServices){
            $customerBasketCheck = CustomerServiceCart::where(['customer_id'=>$this->jobcardDetails->customer_id,'vehicle_id'=>$this->jobcardDetails->vehicle_id,'item_id'=>$customerJobServices->item_id,'job_number'=>$job_number]);
            if($customerBasketCheck->count()==0)
            {
                $cartInsert = [
                    'customer_id'=>$this->jobcardDetails->customer_id,
                    'vehicle_id'=>$this->jobcardDetails->vehicle_id,
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
        //dd(CustomerServiceCart::where(['job_number'=>$this->job_number])->get());
        return redirect()->to('customer-service-job/'.$this->jobcardDetails->customer_id.'/'.$this->jobcardDetails->vehicle_id.'/'.$job_number);

    }

}
