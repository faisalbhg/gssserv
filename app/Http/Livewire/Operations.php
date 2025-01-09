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

use Carbon\Carbon;
use Session;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

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
    public $cartItems = [];
    public $cardShow=false;
    public $quantity;

    public $selected_vehicle_id, $customer_type,$service_group_id,$station,$service_search;
    public $service_group_name, $service_group_code;

    public $customer_id, $vehicle_id, $sCtmrVhlcustomer_vehicle_id, $sCtmrVhlvehicle_image, $sCtmrVhlvehicleName, $sCtmrVhlmake_model, $sCtmrVhlplate_number, $sCtmrVhlchassis_number, $sCtmrVhlvehicle_km, $sCtmrVhlname, $sCtmrVhlcustomerType, $sCtmrVhlemail, $sCtmrVhlmobile, $customer_vehicle_id, $vehicleName, $make_model;
    public $serviceItemsList = [];

    public $frontSideBumperCheck, $frontSideGrillCheck, $frontSideNumberPlateCheck, $frontSideHeadLampsCheck, $frontSideFogLampsCheck, $frontSideHoodCheck, $rearSideBumperCheck, $rearSideMufflerCheck, $rearSideNumberPlateCheck, $rearSideTrunkCheck, $rearSideLightsCheck, $rearSideRoofTopCheck, $leftSideWheelCheck, $leftSideFenderCheck, $leftSideSideMirrorCheck, $leftSideDoorGlassInOutCheck, $leftSideDoorHandleCheck, $leftSideSideStepperCheck, $rightSideWheelCheck, $rightSideFenderCheck, $rightSideSideMirrorCheck, $rightSideDoorGlassInOutCheck, $rightSideDoorHandleCheck, $rightSideSideStepperCheck, $innerCabinSmellCheck, $innerCabinWindshieldFRRRCheck, $innerCabinSteeringWheelCheck, $innerCabinGearKnobCheck, $innerCabinCentreConsoleCheck, $innerCabinAshTryCheck, $innerCabinDashboardCheck, $innerCabinACVentsFRRRCheck, $innerCabinInteriorTrimCheck, $innerCabinFloorMatCheck, $innerCabinRearViewMirrorCheck, $innerCabinLuggageCompCheck, $innerCabinRoofTopCheck;
    public $jobCustomerInfo,$updateService=false;
    public $jobcardDetails, $showaddServiceItems=false;
    public $showVehicleImageDetails=false;
    public $checkListDetails, $checklistLabels, $vehicleSidesImages, $vehicleCheckedChecklist, $vImageR1, $vImageR2, $vImageF, $vImageB, $vImageL1, $vImageL2, $customerSignature;
    public $showNumberPlateFilter=false, $search_plate_country, $stateList=[], $plateEmiratesCodes=[], $search_plate_state, $search_plate_code, $search_plate_number;


    
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
        if($this->showNumberPlateFilter){
            $this->stateList = StateList::where(['CountryCode'=>$this->search_plate_country])->get();
            if($this->search_plate_state)
            {
                switch ($this->search_plate_state) {
                    case 'Abu Dhabi':
                        $plateStateCode = 1;
                        $this->search_plate_category = '242';
                        break;
                    case 'Dubai':
                        $plateStateCode = 2;
                        $this->search_plate_category = '1';
                        break;
                    case 'Sharjah':
                        $plateStateCode = 3;
                        $this->search_plate_category = '103';
                        break;
                    case 'Ajman':
                        $plateStateCode = 4;
                        $this->search_plate_category = '122';
                        break;
                    case 'Umm Al-Qaiwain':
                        $plateStateCode = 5;
                        $this->search_plate_category = '134';
                        break;
                    case 'Ras Al-Khaimah':
                        $plateStateCode = 6;
                        $this->search_plate_category = '147';
                        break;
                    case 'Fujairah':
                        $plateStateCode = 7;
                        $this->search_plate_category = '169';
                        break;
                    
                    default:
                        $plateStateCode = 1;
                        $this->search_plate_category = '242';
                        break;
                }
                
                $this->plateEmiratesCategories = PlateEmiratesCategory::where([
                        'plateEmiratesId'=>$plateStateCode,'is_active'=>1,
                    ])->get();
                //dd($plateStateCode);
                if($this->search_plate_category){
                    $this->plateEmiratesCodes = PlateCode::where([
                        'plateEmiratesId'=>$plateStateCode,'plateCategoryId'=>$this->search_plate_category,'is_active'=>1,
                    ])->get();
                }
            }
        }
        else
        {
            /*$this->stateList=null;
            $this->plateEmiratesCategories=null;
            $this->plateEmiratesCodes=null;*/
        }

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


        $customerjobs = CustomerJobCards::with(['customerInfo']);
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
        $customerjobs = $customerjobs->orderBy('id','DESC')->paginate(10);
        //dd($customerjobs);
        $getCountSalesJob = $getCountSalesJob->first();

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
            case 'work_finished': $this->filter = [2];break;
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

    public function updateQwService($services)
    {
        /*CustomerJobCardServices::where('job_number','!=',null)->update(['job_status'=>1,'job_departent'=>1]);
        CustomerJobCards::where('job_number','!=',null)->update(['job_status'=>1,'job_departent'=>1]);
        dd(CustomerJobCards::where(['job_number'=>$services['job_number']])->get());
        */
        //dd($services);
        //$services = json_decode($services);
        /*$validatedData = $this->validate([
            'frontSideBumperCheck' => 'required',
            'frontSideGrillCheck' => 'required',
            'frontSideNumberPlateCheck' => 'required',
            'frontSideHeadLampsCheck' => 'required',
            'frontSideFogLampsCheck' => 'required',
            'frontSideHoodCheck' => 'required',
            'rearSideBumperCheck' => 'required',
            'rearSideMufflerCheck' => 'required',
            'rearSideNumberPlateCheck' => 'required',
            'rearSideTrunkCheck' => 'required',
            'rearSideLightsCheck' => 'required',
            'rearSideRoofTopCheck' => 'required',
            'leftSideWheelCheck' => 'required',
            'leftSideFenderCheck' => 'required',
            'leftSideSideMirrorCheck' => 'required',
            'leftSideDoorGlassInOutCheck' => 'required',
            'leftSideDoorHandleCheck' => 'required',
            'leftSideSideStepperCheck' => 'required',
            'rightSideWheelCheck' => 'required',
            'rightSideFenderCheck' => 'required',
            'rightSideSideMirrorCheck' => 'required',
            'rightSideDoorGlassInOutCheck' => 'required',
            'rightSideDoorHandleCheck' => 'required',
            'rightSideSideStepperCheck' => 'required',
            'innerCabinSmellCheck' => 'required',
            'innerCabinWindshieldFRRRCheck' => 'required',
            'innerCabinSteeringWheelCheck' => 'required',
            'innerCabinGearKnobCheck' => 'required',
            'innerCabinCentreConsoleCheck' => 'required',
            'innerCabinAshTryCheck' => 'required',
            'innerCabinDashboardCheck' => 'required',
            'innerCabinACVentsFRRRCheck' => 'required',
            'innerCabinInteriorTrimCheck' => 'required',
            'innerCabinFloorMatCheck' => 'required',
            'innerCabinRearViewMirrorCheck' => 'required',
            'innerCabinLuggageCompCheck' => 'required',
            'innerCabinRoofTopCheck' => 'required',
        ]);*/
        //dd($validatedData);
        $jobServiceId = $services['id'];
        $this->job_status = $services['job_status']+1;
        $this->job_departent = $services['job_departent']+1;
        
        $serviceJobUpdate = [
            'job_status'=>$services['job_status']+1,
            'job_departent'=>$services['job_status']+1,
        ];
        //dd($serviceJobUpdate);
        CustomerJobCardServices::where(['id'=>$jobServiceId])->update($serviceJobUpdate);

        $serviceJobUpdateLog = [
            'job_number'=>$services['job_number'],
            'customer_job__card_service_id'=>$jobServiceId,
            'job_status'=>$services['job_status']+1,
            'job_departent'=>$services['job_departent']+1,
            'job_description'=>json_encode($this),
            'created_by'=>Session::get('user')->id,
        ];
        CustomerJobCardServiceLogs::create($serviceJobUpdateLog);

        $getCountSalesJobStatus = CustomerJobCardServices::select(
            array(
                \DB::raw('count(case when job_status = 0 then job_status end) new'),
                \DB::raw('count(case when job_status = 1 then job_status end) working_progress'),
                \DB::raw('count(case when job_status = 2 then job_status end) work_finished'),
                \DB::raw('count(case when job_status = 3 then job_status end) ready_to_deliver'),
                \DB::raw('count(case when job_status = 4 then job_status end) delivered'),
            )
        )->where(['job_number'=>$services['job_number']])->first();
        //dd($getCountSalesJobStatus);
        if($getCountSalesJobStatus->working_progress>0){
            $mainSTatus=1;
        }
        else if($getCountSalesJobStatus->work_finished>0){
            $mainSTatus=2;
        }
        else if($getCountSalesJobStatus->ready_to_deliver>0){
            $mainSTatus=3;
        }
        else if($getCountSalesJobStatus->delivered>0){
            $mainSTatus=4;
        }
        //dd($mainSTatus);
        $mianJobUpdate = [
            'job_status'=>$mainSTatus,
            'job_departent'=>$mainSTatus,
        ];
        CustomerJobCards::where(['job_number'=>$services['job_number']])->update($mianJobUpdate);
        
        $job = CustomerJobCards::with(['customerInfo','customerJobServices'])->where(['job_number'=>$services['job_number']])->first();
        $this->jobcardDetails = $job;
        $this->customerjobservices = $job->customerJobServices;
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
        Customerjoblogs::create($serviceJobUpdateLog);
        
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
        Customerjoblogs::create($serviceJobUpdateLog);
        
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
            Customerjoblogs::create($serviceJobUpdateLog);
            
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
        
        $job = CustomerJobCards::with(['customerInfo','customerJobServices','checklistInfo','makeInfo','modelInfo'])->where(['job_number'=>$job_number])->first();
        //dd($job);
        $this->jobcardDetails = $job;
        //dd($this->jobcardDetails->modelInfo['vehicle_model_name']);
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
        
        $this->job_number = $job->job_number;
        $this->job_date_time = $job->job_date_time;
        $this->customerDetails = true;
        $this->vehicle_image = $job->vehicle_image;
        $this->make = $job->make;
        $this->model = $job->model;
        $this->plate_number = $job->plate_number;
        $this->chassis_number = $job->chassis_number;
        $this->vehicle_km = $job->vehicle_km;
        $this->name = $job->customerInfo['name'];
        $this->email = $job->customerInfo['email'];
        $this->mobile = $job->customerInfo['mobile'];
        //$this->customerType = $job->customerInfo->customertype['customer_type'];
        $this->payment_status = $job->payment_status;
        $this->payment_type = $job->payment_type;
        $this->job_status = $job->job_status;
        $this->job_departent = $job->job_departent;
        $this->total_price = $job->total_price;
        $this->vat = $job->vat;
        $this->grand_total = $job->grand_total;

        $this->jobCustomerInfo = $job->customerInfo;

        $this->customerjobservices = $job->customerJobServices;
        //dd($this->customerjobservices);
        //dd($this);
        
        $this->dispatchBrowserEvent('showServiceUpdate');
        $this->dispatchBrowserEvent('hideQwChecklistModel');
    }
    

    public function checkPaymentStatus($job_number)
    {
        $arrData['order_number'] = $job_number;
        $response = Http::withBasicAuth('onlinewebtutor', 'admin123')->post('http://172.23.140.170/gssapi/api/check-payment-status',$arrData);
        if(json_decode($response)->payment_status!=0)
        {
            CustomerJobCards::where(['job_number'=>$job_number])->update(['payment_status'=>json_decode($response)->payment_status]);
            session()->flash('paymentLinkStatusSuccess', 'Payment Link is not yet paid..!');
        }
        else
        {
            session()->flash('paymentLinkStatusError', 'Payment Link is not yet paid..!');
        }
    }

    public function addNewServiceItem($job_number)
    {
        $this->job_number = $job_number;
        $this->showServiceGroup=true;
        $this->showServiceType=true;

        $job = CustomerJobCards::with(['customerInfo','customerVehicle'])->where(['job_number'=>$this->job_number])->first();
        //dd($job);

        
        $this->selected_vehicle_id = $job->vehicle_id;
        $this->customer_type = $job->customer_type;
        //dd(Session::get('user')->station_id);
        $this->service_group_id;
        $this->station = Session::get('user')->station_id;
        $this->servicesGroups = ServicesGroup::where(['is_active'=>1])->get();
        
        
        $this->showaddServiceItems=true;
        $this->dispatchBrowserEvent('hideServiceUpdate');
        $this->dispatchBrowserEvent('showAddServiceItems');

    }

    public function serviceGroupForm($service)
    {
        $service = json_decode($service);
        $this->service_group_id = $service->id;
        $this->service_group_name = $service->service_group_name;
        $this->service_group_code = $service->service_group_code;
        $this->station = $service->station_id;
        $this->service_search='';
        $this->selectedCustomerVehivleDetails($this->selected_vehicle_id);
        $this->customer_id = $this->customer_id;
        $this->vehicle_id = $this->vehicle_id;
        $this->customer_type = $this->customer_type;
        $this->mobile = $this->mobile;
        $this->name = $this->name;
        $this->email = $this->email;
        $this->showServiceType=true;
        $this->selectServicesitems=false;
        $this->showServicesitems=true;

        $this->getServiceTypes();
        //dd($this->servicesTypesList);
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

    public function addtoCart($serviceType)
    {
        $this->getServiceTypes();
        $serviceType = json_decode($serviceType);
        \Cart::add([
            'id' => $serviceType->service_type_id,
            'name' => $serviceType->service_type_name,
            'price' => $serviceType->unit_price,
            'quantity' => 1,
            'attributes' => array(
                'service_item'=>false,
                'service_type_id' => $serviceType->service_type_id,
                'service_type_code' => $serviceType->service_type_code,
                'service_type_name' => $serviceType->service_type_name,
                'service_group_id' => $serviceType->service_group_id,
                'service_group_code' => $serviceType->service_group_code,
                'service_group_name' => $serviceType->service_group_name,
                'department_id' => $serviceType->department_id,
                'station_id' => $serviceType->station_id,
                'station_id' => $serviceType->station_id,
            )
        ]);
        $this->cartItems = \Cart::getContent()->toArray();
        if(!empty($this->cartItems))
        {
            $this->cardShow=true;
        }
        $total = \Cart::getTotal();
        $this->tax = $total * (config('global.TAX_PERCENT') / 100);
        $this->grand_total = $total  * ((100 + config('global.TAX_PERCENT')) / 100);
        
        /*$this->dispatchBrowserEvent('swal:modal', [
            'type' => 'success',
            'message' => 'Added to Cart Successfully',
            'text' => 'service added..!',
            'cartitemcount'=>\Cart::getTotalQuantity()
        ]);*/
    }
    
    public function addtoCartItem($items)
    {
        $this->getServiceTypes();
        $items = json_decode($items);
        $itemsDetails = $items->service_items;
        //dd($itemsDetails->item_name);
        $itemBrand = $itemsDetails->item_brand;
        $itemsCategory = $itemsDetails->item_category;
        $itemsGroup = $itemsDetails->product_group;
        
        \Cart::add([
            'id' => $items->item_id,
            'name' => $itemsDetails->item_name,
            'price' => $items->sale_price,
            'quantity' => 1,
            'attributes' => array(
                'service_item'=>true,
                'item_id' => $itemsDetails->id,
                'item_code' => $itemsDetails->item_code,
                'item_name' => $itemsDetails->item_name,
                'brand_id' => $itemBrand->id,
                'brand_name' => $itemBrand->brand_name,
                'category_id' => $itemsCategory->id,
                'category_name' => $itemsCategory->category_name,
                'item_group_id' => $itemsGroup->id,
                'product_group_name' => $itemsGroup->product_group_name,
            )
        ]);
        
        $this->cartItems = \Cart::getContent()->toArray();
        if(!empty($this->cartItems))
        {
            $this->cardShow=true;
        }
        $total = \Cart::getTotal();
        $this->tax = $total * (config('global.TAX_PERCENT') / 100);
        $this->grand_total = $total  * ((100 + config('global.TAX_PERCENT')) / 100);
        /*$this->dispatchBrowserEvent('swal:modal', [
            'type' => 'success',
            'message' => 'Added to Cart Successfully',
            'text' => 'service added..!',
            'cartitemcount'=>1
        ]);*/

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
                'total_price'=>round(($total+$oldTotalPrice),2),
                'vat'=>round(($tax+$oldVat),2),
                'grand_total'=>round(($grand_total+$oldGrandTotal),2),
                'job_status'=>1,
                'job_departent'=>1,
                'payment_status'=>0,
                'created_by'=>Session::get('user')->id,
                'payment_updated_by'=>Session::get('user')->id,
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
                'created_by'=>Session::get('user')->id,
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

            Customerjoblogs::create([
                'job_number'=>$this->job_number,
                'job_status'=>1,
                'job_departent'=>1,
                'job_description'=>json_encode($customerJobServiceData),
                'customer_job_service_id'=>$customerJobServiceId->id,
                'created_by'=>Session::get('user')->id,
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
                'total_price'=>round(($total+$oldTotalPrice),2),
                'vat'=>round(($tax+$oldVat),2),
                'grand_total'=>round(($grand_total+$oldGrandTotal),2),
                'job_status'=>1,
                'job_departent'=>1,
                'payment_status'=>0,
                'created_by'=>Session::get('user')->id,
            ];
        Customerjobs::where(['job_number'=>$job_number])->update($customerJobUpdate);*/


        $this->customerjobservices = CustomerJobCardServices::where(['job_number'=>$service->job_number])->get();
    }

    public function clickQlOperation($in_out,$up_ser,$service)
    {
        $service = CustomerJobCardServices::find($service);
        
        if($in_out=='start')
        {
            $serviceUpdate = [$up_ser.'_time_in' => Carbon::now()];
            $serviceUpdate = [$up_ser => 1];
        }
        else if($in_out=='stop')
        {
            $serviceUpdate = [$up_ser.'_time_in' => Carbon::now()];
            $serviceUpdate = [$up_ser => 2];
        }
        CustomerJobCardServices::find($service['id'])->update($serviceUpdate);
        
        $serviceJobUpdateLog = [
            'job_number'=>$service['job_number'],
            'customer_job_service_id'=>$service['id'],
            'job_status'=>$service['job_status'],
            'job_departent'=>$service['job_departent'],
            'job_description'=>json_encode($serviceUpdate),
        ];
        Customerjoblogs::create($serviceJobUpdateLog);

        $this->customerjobservices = CustomerJobCardServices::where(['job_number'=>$service['job_number']])->get();
        //dd($this->customerjobservices);
    }

}
