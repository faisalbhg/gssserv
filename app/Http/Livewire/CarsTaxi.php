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

class CarsTaxi extends Component
{
    use WithFileUploads;
    public $customer_id=259, $vehicle_id, $mobile, $name, $ct_number, $meter_id, $plate_number_image, $plate_code, $plate_number, $vehicle_type, $make, $model, $checklistLabel, $fuel, $scratchesFound, $scratchesNotFound, $vImageR1, $vImageR2, $vImageF, $vImageB, $vImageL1, $vImageL2, $customerSignature,$roof_images, $dash_image1, $dash_image2, $passenger_seat_image, $driver_seat_image, $back_seat1, $back_seat2, $back_seat3, $back_seat4, $photo;
    public $plateEmiratesCodes=[], $vehicleTypesList=[], $listVehiclesMake=[], $vehiclesModelList=[], $checklistLabels=[], $carTaxiServiceInfo;
    public $isValidInput;
    public $grand_total, $total, $tax, $job_number;
    public $showlistCarTaxiToday=true, $searchDate;
    public $carTaxiJobs, $getCountCarTaxiJob;
    public $showUpdateModel = false, $filterTab='total', $filter = [0,1,2,3,4], $search_job_number = '', $search_job_date, $search_plate_number;

    public function render()
    {
        if($this->showlistCarTaxiToday)
        {
            $this->plateEmiratesCodes = [];
            $this->vehicleTypesList=[];
            $this->listVehiclesMake=[];
            $this->vehiclesModelList=[];
            $this->checklistLabels=[];
            $this->carTaxiServiceInfo=null;

            $this->search_job_date = Carbon::now()->format('Y-m-d');

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


            $carTaxiJobs = CustomerJobCards::with(['makeInfo','modelInfo']);
            if($this->filter){
                $carTaxiJobs = $carTaxiJobs->whereIn('job_status', $this->filter);
            }
            if($this->search_job_number)
            {
                $carTaxiJobs = $carTaxiJobs->where('job_number', 'like', "%{$this->search_job_number}%");
                $getCountCarTaxiJob = $getCountCarTaxiJob->where('job_number', 'like', "%{$this->search_job_number}%");
            }
            if($this->search_job_date){
                $carTaxiJobs = $carTaxiJobs->whereBetween('job_date_time', [$this->search_job_date." 00:00:00",$this->search_job_date." 23:59:59"]);
                $getCountCarTaxiJob = $getCountCarTaxiJob->whereBetween('job_date_time', [$this->search_job_date." 00:00:00",$this->search_job_date." 23:59:59"]);
            }
            if($this->search_plate_number)
            {
                $carTaxiJobs = $carTaxiJobs->where('plate_number', 'like',"%$this->search_plate_number%");
            }
            
            $carTaxiJobs = $carTaxiJobs->where('is_contract','=',1)->orderBy('id','ASC')->where(['created_by'=>auth()->user('user')->id])->get();
            $getCountCarTaxiJob = $getCountCarTaxiJob->where('is_contract','=',1)->where(['created_by'=>auth()->user('user')->id])->first();

            $this->getCountCarTaxiJob = $getCountCarTaxiJob;
            $this->carTaxiJobs = $carTaxiJobs;
        }
        else
        {
            $this->isValidInput = $this->getErrorBag()->count();
            if($this->isValidInput>0)
            {
                if( array_key_exists( 'ct_number',$this->getErrorBag()->messages() ) ){
                    $scrollTo = 'ctNumberInput';
                }else if( array_key_exists( 'meter_id',$this->getErrorBag()->messages() ) ){
                    $scrollTo = 'ctNumberInput';
                }else if( array_key_exists( 'plate_code',$this->getErrorBag()->messages() ) ){
                    $scrollTo = 'plateCode';
                }else if( array_key_exists( 'plate_number',$this->getErrorBag()->messages() ) ){
                    $scrollTo = 'plateNumber';
                }else if( array_key_exists( 'plate_number_image',$this->getErrorBag()->messages() ) ){
                    $scrollTo = 'plateImage';
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
            $this->listVehiclesMake = VehicleMakes::get();
            if($this->make){
                $this->vehiclesModelList = VehicleModels::where(['vehicle_make_id'=>$this->make])->get();
            }
            $this->checklistLabels = ServiceChecklist::get();
            $this->carTaxiServiceInfo = LaborItemMaster::where([
                    //'SectionCode'=>$this->propertyCode,
                    'Active'=>1,
                    'ItemCode'=>'S255'
                ])->where('UnitPrice','>',0)->first();
            if($this->carTaxiServiceInfo){
                $this->total = $this->carTaxiServiceInfo->UnitPrice;
                $this->tax = $this->total * (config('global.TAX_PERCENT') / 100);
                $this->grand_total = $this->total+$this->tax;
            }
            
            $this->dispatchBrowserEvent('selectSearchEvent'); 
        }
        $this->dispatchBrowserEvent('imageUpload');
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

    public function addNewCarTaxi()
    {
        $this->showlistCarTaxiToday=false;
    }

    public function clickShowSignature()
    {
        $this->dispatchBrowserEvent('showSignature');

    }

    public function createTaxiJob()
    {
        $validatedData = $this->validate([
            'ct_number' => 'required',
            'meter_id' => 'required',
            'plate_code' => 'required',
            'plate_number' => 'required',
            'plate_number_image' => 'required'
        ]);

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
        //$customerVehicleData['chassis_number']=isset($this->chassis_number)?$this->chassis_number:'';
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
            'job_date_time'=>Carbon::now(),
            'customer_id'=>$this->customer_id,
            'customer_name'=>$this->name,
            'customer_mobile'=>$this->mobile,
            'vehicle_id'=>$this->vehicle_id,
            'vehicle_type'=>$this->vehicle_type,
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
            'item_id'=>$this->carTaxiServiceInfo->ItemId,
            'item_code'=>$this->carTaxiServiceInfo->ItemCode,
            'company_code'=>$this->carTaxiServiceInfo->CompanyCode,
            'category_id'=>$this->carTaxiServiceInfo->CategoryId,
            'sub_category_id'=>$this->carTaxiServiceInfo->SubCategoryId,
            'brand_id'=>$this->carTaxiServiceInfo->BrandId,
            'bar_code'=>$this->carTaxiServiceInfo->BarCode,
            'item_name'=>$this->carTaxiServiceInfo->ItemName,
            'description'=>$this->carTaxiServiceInfo->Description,
            'division_code'=>$this->carTaxiServiceInfo->DivisionCode,
            'department_code'=>$this->carTaxiServiceInfo->DepartmentCode,
            'department_name'=>'General Service',
            'section_code'=>$this->carTaxiServiceInfo->SectionCode,
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


        $this->showlistCarTaxiToday=true;
        
    }

    public function updateQwService($job_number,$status)
    {
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
}
