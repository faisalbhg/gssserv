<?php

namespace App\Http\Livewire;

use Livewire\Component;

use thiagoalessio\TesseractOCR\TesseractOCR; 
use Illuminate\Http\Request;
use Livewire\WithFileUploads;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\Http;
use LaravelPayfort\Facades\Payfort;
use Illuminate\Support\Facades\Hash;
use DB;

use App\Models\PlateCode;
use App\Models\VehicleMakes;
use App\Models\VehicleModels;
use App\Models\Vehicletypes;
use App\Models\ServiceChecklist;
use App\Models\CustomerVehicle;
use App\Models\CustomerJobCards;
use App\Models\CustomerJobCardServices;
use App\Models\CustomerJobCardServiceLogs;
use App\Models\WorkOrderJob;
use App\Models\JobcardChecklistEntries;
use App\Models\TenantMasterCustomers;
use App\Models\LaborItemMaster;
use App\Models\JobCardChecklists;

class CarsTaxi extends Component
{
    use WithFileUploads;
    public $customer_id=259, $vehicle_id, $mobile, $name, $ct_number, $meter_id, $plate_number_image, $plate_code, $plate_number, $vehicle_type, $make, $model, $chaisis_image, $chassis_number, $checklistLabel, $fuel, $scratchesFound, $scratchesNotFound, $vImageR1, $vImageR2, $vImageF, $vImageB, $vImageL1, $vImageL2, $customerSignature,$roof_images, $dash_image1, $dash_image2, $passenger_seat_image, $driver_seat_image, $back_seat1, $back_seat2, $back_seat3, $back_seat4, $photo, $car_roof_images;
    public $plateEmiratesCodes=[], $vehicleTypesList=[], $listVehiclesMake=[], $vehiclesModelList=[], $checklistLabels=[], $carTaxiServiceInfo;
    public $isValidInput;
    public $grand_total, $total, $tax, $job_number;
    public $showlistCarTaxiToday=true, $searchDate;
    public $carTaxiJobs, $getCountCarTaxiJob;
    public $showUpdateModel = false, $filterTab='total', $filter = [0,1,2,3,4], $search_ct_number = '', $search_meter_number = '', $search_job_date, $search_plate_number, $selected_item_id, $all_car_taxi_Service=[], $selectedCarTaxiService, $selectedSectionName, $selectedCarTaxiEntry=false;
    public $jobCustomerInfo,$updateService=false;
    public $jobcardDetails, $showaddServiceItems=false;
    public $showVehicleImageDetails=false;
    public $checkListDetails, $vehicleSidesImages=[], $vehicleCheckedChecklist;
    public $showNumberPlateFilter=false, $search_plate_country, $stateList=[], $search_plate_state, $search_plate_code, $search_station;
    public $turn_key_on_check_for_fault_codes, $start_engine_observe_operation, $reset_the_service_reminder_alert, $stick_update_service_reminder_sticker_on_b_piller, $interior_cabin_inspection_comments, $check_power_steering_fluid_level, $check_power_steering_tank_cap_properly_fixed, $check_brake_fluid_level, $brake_fluid_tank_cap_properly_fixed, $check_engine_oil_level, $check_radiator_coolant_level, $check_radiator_cap_properly_fixed, $top_off_windshield_washer_fluid, $check_windshield_cap_properly_fixed, $underHoodInspectionComments, $check_for_oil_leaks_engine_steering, $check_for_oil_leak_oil_filtering, $check_drain_lug_fixed_properly, $check_oil_filter_fixed_properly, $ubi_comments;
    public $customerjobservices =[];
    public $job_status, $job_departent;
    public $showchecklist=[],$checklist_comments,$checklists;
    public $canceljobReasonButton=false,$cancelError,$cancelationReason,$customerSignatureShow;
    public $onlyChaisisRequired=false;
    public $alreadyUpdationGOing=false;
    public $updateJob = false;

    function mount( Request $request) {
        $this->search_job_date = Carbon::now()->format('Y-m-d');
    }

    public function render()
    {
        //dd(LaborItemMaster::where(['Active'=>1])->whereIn('ItemCode', ['S255','S408'])->get());
        $carTaxiServiceInfoQuery = LaborItemMaster::where(['Active'=>1,'DivisionCode'=>auth()->user('user')['station_code'],])->where('UnitPrice','>',0)->whereIn('ItemCode', ['S255','S408']);
        $this->all_car_taxi_Service = $carTaxiServiceInfoQuery->get();
        //dd($this->all_car_taxi_Service);

        if($this->showlistCarTaxiToday)
        {
            $this->plateEmiratesCodes = [];
            $this->vehicleTypesList=[];
            $this->listVehiclesMake=[];
            $this->vehiclesModelList=[];
            $this->checklistLabels=[];
            $this->carTaxiServiceInfo=null;

            //$this->search_job_date = Carbon::now()->format('Y-m-d');

            $getCountCarTaxiJob = CustomerJobCards::select(
                array(
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
            $carTaxiJobs = CustomerJobCards::with(['customerInfo','customerJobServices','makeInfo','modelInfo']);
            if($this->filter){
                $carTaxiJobs = $carTaxiJobs->whereIn('job_status', $this->filter);
            }
            
            
            if($this->search_ct_number)
            {
                $carTaxiJobs = $carTaxiJobs->where('ct_number', 'like', "%{$this->search_ct_number}%");
                //$getCountCarTaxiJob = $getCountCarTaxiJob->where('job_number', 'like', "%{$this->search_job_number}%");
            }
            if($this->search_meter_number)
            {
                $carTaxiJobs = $carTaxiJobs->where('meter_id', 'like', "%{$this->search_meter_number}%");
                //$getCountCarTaxiJob = $getCountCarTaxiJob->where('job_number', 'like', "%{$this->search_job_number}%");
            }
            if($this->search_job_date){
                $carTaxiJobs = $carTaxiJobs->whereBetween('job_date_time', [$this->search_job_date." 00:00:00",$this->search_job_date." 23:59:59"]);
                $getCountCarTaxiJob = $getCountCarTaxiJob->whereBetween('job_date_time', [$this->search_job_date." 00:00:00",$this->search_job_date." 23:59:59"]);
            }
            if($this->search_plate_number)
            {
                $carTaxiJobs = $carTaxiJobs->where('plate_number', 'like',"%$this->search_plate_number%");
            }
            
            $carTaxiJobs = $carTaxiJobs->where('is_contract','=',1)->orderBy('id','ASC');
            if(auth()->user('user')->user_type!=1){
                $carTaxiJobs = $carTaxiJobs->where(['created_by'=>auth()->user('user')->id]);
                $getCountCarTaxiJob = $getCountCarTaxiJob->where(['created_by'=>auth()->user('user')->id]);
            }
            
            $getCountCarTaxiJob = $getCountCarTaxiJob->where('is_contract','=',1);

            $this->getCountCarTaxiJob = $getCountCarTaxiJob->first();
            $this->carTaxiJobs = $carTaxiJobs->get();
            
        }
        else
        {
            $this->isValidInput = $this->getErrorBag()->count();
            if($this->isValidInput>0)
            {
                if( array_key_exists( 'ct_number',$this->getErrorBag()->messages() ) ){
                    $scrollTo = 'ctNumberInput';
                }else if( array_key_exists( 'meter_id',$this->getErrorBag()->messages() ) ){
                    $scrollTo = 'meterIdInput';
                }else if( array_key_exists( 'plate_code',$this->getErrorBag()->messages() ) ){
                    $scrollTo = 'plateCode';
                }else if( array_key_exists( 'plate_number',$this->getErrorBag()->messages() ) ){
                    $scrollTo = 'plateNumber';
                }else if( array_key_exists( 'plate_number_image',$this->getErrorBag()->messages() ) ){
                    $scrollTo = 'plateImageFile';
                }
                else if( array_key_exists( 'vehicle_type',$this->getErrorBag()->messages() ) ){
                    $scrollTo = 'vehicleTypeInput';
                }
                else if( array_key_exists( 'make',$this->getErrorBag()->messages() ) ){
                    $scrollTo = 'vehicleMakeInput';
                }
                else if( array_key_exists( 'model',$this->getErrorBag()->messages() ) ){
                    $scrollTo = 'vehicleModelInput';
                }
                else if( array_key_exists( 'chassis_number',$this->getErrorBag()->messages() ) ){
                    $scrollTo = 'chaisisNumberInput';
                }

                

                $this->dispatchBrowserEvent('scrollto', [
                    'scrollToId' => $scrollTo,
                ]);
            }

            $this->plateEmiratesCodes = PlateCode::where([
                    'plateEmiratesId'=>2,
                    'plateCategoryId'=>1,
                    'is_active'=>1,
                ])->get();
            $this->vehicleTypesList = Vehicletypes::orderBy('type_name','ASC')->get();
            $this->listVehiclesMake = VehicleMakes::where('is_deleted','=',null)->get();
            if($this->make){
                $this->vehiclesModelList = VehicleModels::where(['vehicle_make_id'=>$this->make])->get();
            }
            $this->checklistLabels = ServiceChecklist::get();

            

            
            if($this->selectedCarTaxiEntry){
                $this->total = $this->selectedCarTaxiService['UnitPrice'];
                $this->tax = $this->total * (config('global.TAX_PERCENT') / 100);
                $this->grand_total = $this->total+$this->tax;
            }
            
            $this->dispatchBrowserEvent('selectSearchEvent'); 
            $this->dispatchBrowserEvent('imageUpload');
        }
        
        return view('livewire.cars-taxi');
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

    public function addNewCarTaxi($service)
    {

        //Seat Cleaning
        $this->selectedCarTaxiService = $service;
        if($service['ItemCode']=='S255')
        {
            $this->selectedSectionName = 'Seat Cleaning';
        }
        if($service['ItemCode']=='S408')
        {
            $this->selectedSectionName = 'Seat Cleaning';
        }
        
        $this->selectedCarTaxiEntry=true;
        $this->showlistCarTaxiToday=false;
    }

    public function clickShowSignature()
    {
        $this->dispatchBrowserEvent('showSignature');

    }

    public function checklistToggleSelectAll($services)
    {
        $services = json_decode($services,true);
        //dd($services);
        if($services['item_code']=="S255"){
            foreach(config('global.check_list.interiorCleaning.checklist.types') as $chTypeKey => $types)
            {
                if($types['show_inner_section'])
                {
                    foreach($types['subtypes'] as $chSubTypeKey => $subtype_list)
                    {
                        foreach($subtype_list['inner_sections'] as $chSubTypeDtlkey => $subtypesdetails)
                        {
                            $this->checklists['interior'][$chTypeKey][$chSubTypeKey][$chSubTypeDtlkey]='G';
                        }

                    }

                }
                else{
                    foreach($types['subtypes'] as $chSubTypeKey => $subtype_list)
                    {
                        $this->checklists['interior'][$chTypeKey][$chSubTypeKey]='G';
                    }

                }

            }
            //$this->checklists['vehicleImages'];

        }
        elseif(in_array($services['section_name'], config('global.check_list.wash.services'))){
            foreach(config('global.check_list.wash.checklist.types') as $chTypeKey => $types){
                if($types['subtype']){
                    foreach($types['subtype_list'] as $chSubTypeKey => $subtype_list)
                    {
                        foreach($subtype_list['subtypes'] as $chSubTypeDtlkey => $subtypesdetails)
                        {
                            $this->checklists['wash'][$chTypeKey][$chSubTypeKey][$chSubTypeDtlkey]='G';
                        }

                    }
                }
                else
                {
                    //
                }
            }
            
        }
        elseif(in_array($services['section_name'], config('global.check_list.glazing.services'))){
            foreach(config('global.check_list.glazing.checklist.types') as $chTypeKey => $types)
            {
                if($types['show_inner_section'])
                {
                    foreach($types['subtypes'] as $chSubTypeKey => $subtype_list)
                    {
                        foreach($subtype_list['inner_sections'] as $chSubTypeDtlkey => $subtypesdetails)
                        {
                            $this->checklists['glazing'][$chTypeKey][$chSubTypeKey][$chSubTypeDtlkey]="G";
                        }
                    }
                }
                else
                {
                    foreach($types['subtypes'] as $chSubTypeKey => $subtype_list)
                    {
                        $this->checklists['glazing'][$chTypeKey][$chSubTypeKey]="G";
                    }
                }
            }
        }
        elseif(in_array($services['section_name'], config('global.check_list.interiorCleaning.services'))){
            foreach(config('global.check_list.interiorCleaning.checklist.types') as $chTypeKey => $types)
            {
                if($types['show_inner_section'])
                {
                    foreach($types['subtypes'] as $chSubTypeKey => $subtype_list)
                    {
                        foreach($subtype_list['inner_sections'] as $chSubTypeDtlkey => $subtypesdetails)
                        {
                            $this->checklists['interior'][$chTypeKey][$chSubTypeKey][$chSubTypeDtlkey]='G';
                        }

                    }

                }
                else{
                    foreach($types['subtypes'] as $chSubTypeKey => $subtype_list)
                    {
                        $this->checklists['interior'][$chTypeKey][$chSubTypeKey]='G';
                    }

                }

            }
        }
        elseif(in_array($services['section_name'], config('global.check_list.oilChange.services'))){
            foreach(config('global.check_list.oilChange.checklist.types') as $chTypeKey => $types)
            {
                if($types['show_inner_section'])
                {
                    foreach($types['subtypes'] as $chSubTypeKey => $subtype_list)
                    {
                        foreach($subtype_list['inner_sections'] as $chSubTypeDtlkey => $subtypesdetails)
                        {
                            $this->checklists['oilchange'][$chTypeKey][$chSubTypeKey][$chSubTypeDtlkey]="G";
                        }
                    }

                }else
                {
                    foreach($types['subtypes'] as $chSubTypeKey => $subtype_list)
                    {
                        $this->checklists['oilchange'][$chTypeKey][$chSubTypeKey]="G";
                    }

                }
            }
        }
        elseif(in_array($services['s'], config('global.check_list.tinting.services'))){
            foreach(config('global.check_list.tinting.checklist.types') as $chTypeKey => $types)
            {
                if($types['show_inner_section'])
                {
                    foreach($types['subtypes'] as $chSubTypeKey => $subtype_list)
                    {
                        foreach($subtype_list['inner_sections'] as $chSubTypeDtlkey => $subtypesdetails)
                        {
                            $this->checklists['tinting'][$chTypeKey][$chSubTypeKey][$chSubTypeDtlkey]="G";
                        }
                    }
                }
                else
                {
                    foreach($types['subtypes'] as $chSubTypeKey => $subtype_list)
                    {
                        $this->checklists['tinting'][$chTypeKey][$chSubTypeKey]="G";
                    }
                }
            }
        }

        /*$this->selectAll = !$this->selectAll;
        if ($this->selectAll) {
            $this->group1 = 'option1'; // Set default values for each group
            $this->group2 = 'option1';
        } else {
            $this->group1 = null;
            $this->group2 = null;
        }*/
    }

    public function createTaxiJob()
    {
        if($this->onlyChaisisRequired){
            $validatedData = $this->validate([
                'chassis_number' => 'required',
                'make' => 'required',
                'model' => 'required',
                'vehicle_type' => 'required',
                'plate_number_image' => 'required',
            ]);
        }
        else{
            $validatedData = $this->validate([
                'ct_number' => 'required',
                'meter_id' => 'required',
                //'plate_code' => 'required',
                'plate_number' => 'required',
                'plate_number_image' => 'required',
                'make' => 'required',
                'model' => 'required',
                'vehicle_type' => 'required',
            ]);
        }

        $customerVehicleData['customer_id']=$this->customer_id;
        $customerVehicleData['vehicle_type']=$this->vehicle_type;
        $customerVehicleData['make']=$this->make;
        $customerVehicleData['model']=$this->model;
        $customerVehicleData['plate_country']='AE';
        $customerVehicleData['plate_state']='Dubai';
        $customerVehicleData['plate_code']=$this->plate_code;
        $customerVehicleData['plate_number']=$this->plate_number;
        $completePlateNumber = 'Dubai '.$this->plate_code.' '.$this->plate_number;
        $customerVehicleData['plate_number_final']=$completePlateNumber;
        if($this->chaisis_image){
            $customerVehicleData['chaisis_image'] = $this->chaisis_image->store('chaisis_image', 'public');
        }
        $customerVehicleData['chassis_number']=isset($this->chassis_number)?$this->chassis_number:'';
        $customerVehicleData['chassis_number']=isset($this->chassis_number)?$this->chassis_number:'';
        //$customerVehicleData['vehicle_km']=isset($this->vehicle_km)?$this->vehicle_km:'';
        $customerVehicleData['is_active']=1;
        $customerVehicleData['created_by']=auth()->user('user')->id;

        if($this->plate_number_image){
            $customerVehicleData['plate_number_image'] = $this->plate_number_image->store('plate_number', 'public');
            $customerVehicleData['vehicle_image'] = $customerVehicleData['plate_number_image'];
        }
        $customerVehicleDetails = CustomerVehicle::create($customerVehicleData);
        $this->vehicle_id = $customerVehicleDetails->id;

        $customerjobData = [
            'job_number'=>Carbon::now()->format('y').Carbon::now()->format('m').Carbon::now()->format('d').rand(1,1000),
            'carTaxiJobs'=>1,
            'job_date_time'=>Carbon::now(),
            'customer_id'=>$this->customer_id,
            'customer_name'=>$this->name,
            'customer_mobile'=>$this->mobile,
            'vehicle_id'=>$this->vehicle_id,
            'vehicle_type'=>$this->vehicle_type,
            'chassis_number'=>$this->chassis_number,
            'make'=>$this->make,
            'vehicle_image'=>$customerVehicleData['vehicle_image'],
            'model'=>$this->model,
            'plate_number'=>$completePlateNumber,
            'is_contract'=>1,
            'ct_number'=>$this->ct_number,
            'meter_id'=>$this->meter_id,
            'station'=>auth()->user('user')->stationName['LandlordCode'],
            'total_price'=>$this->total,
            'vat'=>$this->tax,
            'grand_total'=>$this->grand_total,
            'job_status'=>1,
            'job_departent'=>1,
            'payment_status'=>0,
            'payment_type'=>4,
            'created_by'=>auth()->user('user')->id,
            'payment_updated_by'=>auth()->user('user')->id,
        ];
        $customerjobId = CustomerJobCards::create($customerjobData);
        $stationJobNumber = CustomerJobCards::where(['is_contract'=>1,'station'=>auth()->user('user')->station_code])->count();
        $this->job_number = 'JOB-DCT-'.auth()->user('user')->stationName['Abbreviation'].'-'.sprintf('%08d', $stationJobNumber+1);
        CustomerJobCards::where(['id'=>$customerjobId->id])->update(['job_number'=>$this->job_number]);

        $customerJobServiceData = [
            'job_number'=>$this->job_number,
            'job_id'=>$customerjobId->id,
            'job_status'=>1,
            'job_departent'=>1,
            'is_added'=>0,
            'is_removed'=>0,
            'created_by'=>auth()->user('user')->id,
            'item_id'=>$this->selectedCarTaxiService['ItemId'],
            'item_code'=>$this->selectedCarTaxiService['ItemCode'],
            'company_code'=>$this->selectedCarTaxiService['CompanyCode'],
            'category_id'=>$this->selectedCarTaxiService['CategoryId'],
            'sub_category_id'=>$this->selectedCarTaxiService['SubCategoryId'],
            'brand_id'=>$this->selectedCarTaxiService['BrandId'],
            'bar_code'=>$this->selectedCarTaxiService['BarCode'],
            'item_name'=>$this->selectedCarTaxiService['ItemName'],
            'description'=>$this->selectedCarTaxiService['Description'],
            'division_code'=>$this->selectedCarTaxiService['DivisionCode'],
            'department_code'=>$this->selectedCarTaxiService['DepartmentCode'],
            'department_name'=>'General Service',
            'section_code'=>$this->selectedCarTaxiService['SectionCode'],
            'section_name'=>$this->selectedSectionName,
            'station'=>auth()->user('user')->stationName['LandlordCode'],
            'service_item_type'=>1,
            'total_price'=>$this->total,
            'quantity'=>1,
            'vat'=>$this->tax,
            'grand_total'=>$this->grand_total
        ];
        $customerJobServiceId = CustomerJobCardServices::create($customerJobServiceData);
        
        CustomerJobCardServiceLogs::create([
            'job_number'=>$this->job_number,
            'job_status'=>1,
            'job_departent'=>1,
            'job_description'=>json_encode($customerJobServiceData),
            'customer_job__card_service_id'=>$customerJobServiceId->id,
            'created_by'=>auth()->user('user')->id,
            'created_at'=>Carbon::now(),
        ]);

        WorkOrderJob::create(
            [
                "DocumentCode"=>$this->job_number,
                "DocumentDate"=>$customerjobData['job_date_time'],
                "Status"=>"A",
                "LandlordCode"=>auth()->user('user')->station_code,
            ]
        );

        
        $vehicle_image = [
            'vImageR1'=>isset($this->vImageR1)?$this->vImageR1->store('dubai_taxi_image', 'public'):null,
            'vImageR2'=>isset($this->vImageR2)?$this->vImageR2->store('dubai_taxi_image', 'public'):null,
            'vImageF'=>isset($this->vImageF)?$this->vImageF->store('dubai_taxi_image', 'public'):null,
            'vImageB'=>isset($this->vImageB)?$this->vImageB->store('dubai_taxi_image', 'public'):null,
            'vImageL1'=>isset($this->vImageL1)?$this->vImageL1->store('dubai_taxi_image', 'public'):null,
            'vImageL2'=>isset($this->vImageL2)?$this->vImageL2->store('dubai_taxi_image', 'public'):null,
            'roof_images'=>isset($this->roof_images)?$this->roof_images->store('dubai_taxi_image', 'public'):null,
            'dash_image1'=>isset($this->dash_image1)?$this->dash_image1->store('dubai_taxi_image', 'public'):null,
            'dash_image2'=>isset($this->dash_image2)?$this->dash_image2->store('dubai_taxi_image', 'public'):null,
            'passenger_seat_image'=>isset($this->passenger_seat_image)?$this->passenger_seat_image->store('dubai_taxi_image', 'public'):null,
            'driver_seat_image'=>isset($this->driver_seat_image)?$this->driver_seat_image->store('dubai_taxi_image', 'public'):null,
            'back_seat1'=>isset($this->back_seat1)?$this->back_seat1->store('dubai_taxi_image', 'public'):null,
            'back_seat2'=>isset($this->back_seat2)?$this->back_seat2->store('dubai_taxi_image', 'public'):null,
            'back_seat3'=>isset($this->back_seat3)?$this->back_seat3->store('dubai_taxi_image', 'public'):null,
            'back_seat4'=>isset($this->back_seat4)?$this->back_seat4->store('dubai_taxi_image', 'public'):null,
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
            /*'turn_key_on_check_for_fault_codes'=>$this->turn_key_on_check_for_fault_codes,
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
            'ubi_comments'=>$this->ubi_comments,*/
            'created_by'=>auth()->user('user')->id,
        ];
        $checkListEntryInsert = JobcardChecklistEntries::create($checkListEntryData);

        try {
            $meterialRequestResponse = DB::select("EXEC [dbo].[CreateFinancialEntriesContract] @jobnumber = ?, @doneby = ? ", [
                $this->job_number,
                "admin"
            ]);
        } catch (\Exception $e) {
            //dd($e->getMessage());
            //return $e->getMessage();
        }
        return redirect()->to('kabi-llc');

        $this->showlistCarTaxiToday=true;
    }

    public function updateCarTaxiHomeService($job_number,$status)
    {
        //dd($job_number.$status);
        $this->job_status = $status;
        $this->job_departent = $status;
        
        $serviceJobUpdate = [
            'job_status'=>$this->job_status,
            'job_departent'=>$this->job_status,
        ];
        //dd($serviceJobUpdate);
        $serviceJobDetails = CustomerJobCardServices::where(['job_number'=>$job_number])->first();
        CustomerJobCardServices::where(['job_number'=>$job_number])->update($serviceJobUpdate);
        
        $serviceJobUpdateLog = [
            'job_number'=>$job_number,
            'customer_job__card_service_id'=>$serviceJobDetails->id,
            'job_status'=>$this->job_status,
            'job_departent'=>$this->job_status,
            'job_description'=>json_encode($this),
            'created_by'=>auth()->user('user')->id,
        ];
        CustomerJobCardServiceLogs::create($serviceJobUpdateLog);

        
        $mianJobUpdate = [
            'job_status'=>$this->job_status,
            'job_departent'=>$this->job_status,
        ];
        CustomerJobCards::where(['job_number'=>$job_number])->update($mianJobUpdate);
        
        
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
        //dd($this->checklists);
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

            $mobileNumber = isset($this->jobcardDetails['customer_mobile'])?'971'.substr($this->jobcardDetails['customer_mobile'], -9):null;
            //$mobileNumber = isset(auth()->user('user')->phone)?'971'.substr(auth()->user('user')->phone, -9):null;
            $customerName = isset($this->jobcardDetails['customer_name'])?$this->jobcardDetails['customer_name']:null;
            if($mobileNumber!='' && auth()->user('user')->stationName['EnableSMS']==1){
                $msgtext = urlencode('Dear Customer, '.$this->plate_number.' is ready at '.auth()->user('user')->stationName['CorporateName'].'. Please collect within 1 hr or Ɖ30/hr parking will apply. Thank you for choosing GSS. For help 800477823.');
                //$response = Http::get(config('global.sms')[1]['sms_url']."&mobileno=".$mobileNumber."&msgtext=".$msgtext."&CountryCode=ALL");
            }
        }
        
        
    }


    public function updateQwService($services)
    {


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

        if($mainSTatus==4)
        {
            

            try {
                DB::select('EXEC [dbo].[CreateCashierFinancialEntries_2] @jobnumber = "'.$services['job_number'].'", @doneby = "'.auth()->user('user')->id.'", @stationcode  = "'.auth()->user('user')->station_code.'", @paymentmode = "C", @customer_id = "'.$services['customer_id'].'" ');
            } catch (\Exception $e) {
                //return $e->getMessage();
            }



            $mobileNumber = isset($this->jobcardDetails['customer_mobile'])?'971'.substr($this->jobcardDetails['customer_mobile'], -9):null;
            //$mobileNumber = isset(auth()->user('user')->phone)?'971'.substr(auth()->user('user')->phone, -9):null;
            $customerName = isset($this->jobcardDetails['customer_name'])?$this->jobcardDetails['customer_name']:null;
            if($mobileNumber!='' && auth()->user('user')->stationName['EnableSMS']==1){
                $msgtext = urlencode('Dear Customer, '.$plate_number.' is ready at '.auth()->user('user')->stationName['CorporateName'].'. Please collect within 1 hr or Ɖ30/hr parking will apply. Thank you for choosing GSS. For help 800477823.');
                //$response = Http::get(config('global.sms')[1]['sms_url']."&mobileno=".$mobileNumber."&msgtext=".$msgtext."&CountryCode=ALL");
            }
        }
        
        
    }

    public function customerJobUpdate($job_number)
    {
        $this->showVehicleImageDetails=false;
        $this->updateService=true;
        $this->jobcardDetails = CustomerJobCards::with(['customerInfo','customerJobServices','checklistInfo','makeInfo','modelInfo','stationInfo'])->where(['job_number'=>$job_number,'is_contract'=>1])->first();

        $this->jobOrderReference=null;
        foreach($this->jobcardDetails->customerJobServices as $jobcardDetailsList)
        {
            $this->showchecklist[$jobcardDetailsList->id]=false;
        }

        if($this->jobcardDetails->payment_type==1 && $this->jobcardDetails->payment_status == 0)
        {
            $paymentResponse = json_decode($this->jobcardDetails->payment_response,true);
            $paymentResponseOrderResponse =json_decode(json_decode($paymentResponse['order_response'],true),true);
            $this->jobOrderReference = $paymentResponseOrderResponse['orderReference'];
            //$this->checkPaymentStatus($this->jobcardDetails->job_number,$paymentResponseOrderResponse['orderReference'],$this->jobcardDetails->stationInfo['StationID']);
        }
        if($this->jobcardDetails->checklistInfo){
            $this->checkListDetails=$this->jobcardDetails->checklistInfo;
            $this->checklistLabels = ServiceChecklist::get();
            $this->vehicleCheckedChecklist = json_decode($this->jobcardDetails->checklistInfo['checklist'],true);
            $this->vehicleSidesImages = json_decode($this->jobcardDetails->checklistInfo['vehicle_image'],true);
            //dd($this->vehicleSidesImages);
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
            $this->customerSignatureShow = $this->jobcardDetails->checklistInfo['signature'];
            //dd($this->checkListDetails);
        }
        
        $this->dispatchBrowserEvent('showServiceUpdate');
        $this->dispatchBrowserEvent('hideQwChecklistModel');
    }

    public function openVehicleImageDetails(){
        $this->showVehicleImageDetails=true;
    }

    public function closeVehicleImageDetails()
    {
        $this->showVehicleImageDetails=false;
    }

    public function qualityCheck($servicesId,$ql=null)
    {
        //dd($services);
        $this->showchecklist[$servicesId]=true;
    }

    public function markScrach($img){
        //
    }

    public function cancelJob($job_number)
    {
        if($this->jobcardDetails->meterialRequestResponse)
        {
            $response = DB::select('EXEC [dbo].[CheckMaterialIssued] @materialrequisioncode = "'.$this->jobcardDetails->meterialRequestResponse.'" ');
            if(!empty($response)){
                $this->cancelError='Materials already issued, please contact store to return the items and proceed cancellation..!';
                $this->canceljobReasonButton=false;
            }
            else
            {
                $this->canceljobReasonButton=true;
            }
        }
        else
        {
            $this->canceljobReasonButton=true;
        }
        
        /*CustomerJobCards::where(['job_number'=>$job_number])->update(['job_status'=>5]);
        if($customerJobDetails->meterialRequestResponse)
        {
            try {
                DB::select('EXEC [dbo].[CheckMaterialIssued] @materialrequisioncode = "'.$customerJobDetails->meterialRequestResponse.'" ');
            } catch (\Exception $e) {
                //dd($e->getMessage());
                //return $e->getMessage();
            }
        }*/
        
    }

    public function confirmCancelJob($job_number){
        //dd(MaterialRequest::limit(1)->get());
        //dd($job_number);
        $validatedData = $this->validate([
            'cancelationReason' => 'required',
        ]);
        CustomerJobCards::where(['job_number'=>$job_number])->update([
            'job_status'=>5,
            'cancellation_reson'=>$this->cancelationReason,
            'cancelled_by'=>auth()->user('user')->id,
            'cancelled_date_time'=>Carbon::now()
        ]);
        //dd(CustomerJobCards::where(['job_number'=>$job_number])->first());
        //dd($this->jobcardDetails->meterialRequestResponse);
        if($this->jobcardDetails->meterialRequestResponse)
        {
            $response = DB::select('EXEC [dbo].[CheckMaterialIssued] @materialrequisioncode = "'.$this->jobcardDetails->meterialRequestResponse.'" ');
            if(!empty($response)){
                $this->cancelError='Materials already issued, please contact store to return the items and proceed cancellation..!';
                $this->canceljobReasonButton=false;
            }
            else
            {
                CustomerJobCardServices::where(['job_number'=>$job_number])->update(['job_status'=>5]);
                //MaterialRequest::where(['sessionId'=>$this->job_number])->delete();
                /*MaterialRequest::where(['sessionId'=>$this->job_number])->update([
                    'Status'=>'C',
                    'ApprovalStatus'=>'C',
                    'Cancelled'=>Carbon::now(),
                    'CancelledBy'=>auth()->user('user')->id
                ]);*/
            }
            
        }
        else{
            CustomerJobCardServices::where(['job_number'=>$job_number])->update(['job_status'=>5]);
        }
        $this->customerJobUpdate($job_number);
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
}
