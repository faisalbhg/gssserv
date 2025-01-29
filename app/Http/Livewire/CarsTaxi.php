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
use App\Models\CustomerJobCards;
use App\Models\CustomerJobCardServices;
use App\Models\CustomerJobCardServiceLogs;
use App\Models\WorkOrderJob;
use App\Models\JobcardChecklistEntries;
use App\Models\TenantMasterCustomers;
class CarsTaxi extends Component
{
    use WithFileUploads;
    public $mobile, $name, $ct_number, $meter_id, $plate_number_image, $plate_code, $plate_number, $vehicle_type, $make, $model, $checklistLabel, $fuel, $scratchesFound, $scratchesNotFound, $vImageR1, $vImageR2, $vImageF, $vImageB, $vImageL1, $vImageL2, $customerSignature,$roof_images=[], $dash_image1, $dash_image2, $passenger_seat_image, $driver_seat_image, $back_seat1, $back_seat2, $back_seat3, $back_seat4, $photo;
    public $plateEmiratesCodes=[], $vehicleTypesList=[], $listVehiclesMake=[], $vehiclesModelList=[], $checklistLabels=[];
    public $isValidInput;
    public function render()
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
        
        $this->dispatchBrowserEvent('selectSearchEvent'); 
        return view('livewire.cars-taxi');
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
        ]);

        $carTaxiItemDetails = LaborItemMaster::where([
                //'SectionCode'=>$this->propertyCode,
                'Active'=>1,
                'ItemCode'=>'S255'
            ])->where('UnitPrice','>',0)->first();

        $customerVehicleData['customer_id']=259;
        $customerVehicleData['vehicle_type']=$this->vehicle_type;
        $customerVehicleData['make']=$this->make;
        $customerVehicleData['model']=$this->model;
        $customerVehicleData['plate_country']='AE';
        $customerVehicleData['plate_state']=isset($this->plate_state)?$this->plate_state:'';
        $customerVehicleData['plate_category']=$this->plate_category;
        $customerVehicleData['plate_code']=$this->plate_code;
        $customerVehicleData['plate_number']=$this->plate_number;
        $completePlateNumber = $this->plate_state.' '.$this->plate_code.' '.$this->plate_number;
        if($this->plate_country!='AE')
        {
            $plateNumberCode = Country::where(['CountryCode'=>$this->plate_country])->first();
            $completePlateNumber = $plateNumberCode->NumberPlate.' '.$this->plate_code.' '.$this->plate_number;
        }
        $customerVehicleData['plate_number_final']=$completePlateNumber;
        $customerVehicleData['chassis_number']=isset($this->chassis_number)?$this->chassis_number:'';
        $customerVehicleData['vehicle_km']=isset($this->vehicle_km)?$this->vehicle_km:'';
        $customerVehicleData['is_active']=1;
        $customerVehicleData['created_by']=Session::get('user')->id;

        if($this->vehicle_image){

            $customerVehicleData['vehicle_image'] = $this->vehicle_image->store('vehicle', 'public');
        }

        if($this->plate_number_image){
            $customerVehicleData['plate_number_image'] = $this->plate_number_image->store('plate_number', 'public');
        }

        if($this->chaisis_image){
            $customerVehicleData['chaisis_image'] = $this->chaisis_image->store('chaisis_image', 'public');
        }
        $customerVehicleDetails = CustomerVehicle::create($customerVehicleData);

        $customerjobData = [
            'job_number'=>Carbon::now()->format('y').Carbon::now()->format('m').Carbon::now()->format('d').rand(1,1000),
            'job_date_time'=>Carbon::now(),
            'customer_id'=>259,
            //'customer_type'=>$this->customer_type,
            'vehicle_id'=>$this->vehicle_id,
            'vehicle_type'=>isset($this->selectedVehicleInfo['vehicle_type'])?$this->selectedVehicleInfo['vehicle_type']:0,
            'make'=>$this->selectedVehicleInfo['make'],
            'vehicle_image'=>$this->selectedVehicleInfo['vehicle_image'],
            'model'=>$this->selectedVehicleInfo['model'],
            'plate_number'=>$this->selectedVehicleInfo['plate_number_final'],
            'chassis_number'=>$this->selectedVehicleInfo['chassis_number'],
            'vehicle_km'=>$this->selectedVehicleInfo['vehicle_km'],
            'station'=>Session::get('user')->stationName['LandlordCode'],
            /*'customer_discount_id'=>Session::get('user')->stationName['LandlordCode'],
            'discount_id',
            'discount_unit_id',
            'discount_code',
            'discount_title',
            'discount_percentage',
            'discount_amount',
            'coupon_used',
            'coupon_type',
            'coupon_code',
            'coupon_amount',*/
            'total_price'=>$this->total,
            'vat'=>$this->tax,
            'grand_total'=>$this->grand_total,
            'job_status'=>1,
            'job_departent'=>1,
            'payment_status'=>0,
            'created_by'=>Session::get('user')->id,
            'payment_updated_by'=>Session::get('user')->id,
        ];
        if($this->showQLCheckList==true){
            //$customerjobData['ql_km_range']=$this->ql_km_range;
        }
        $customerjobId = CustomerJobCards::create($customerjobData);
        $stationJobNumber = CustomerJobCards::where(['station'=>Session::get('user')->station_code])->count();
        $this->job_number = 'JOB-'.Session::get('user')->stationName['Abbreviation'].'-'.sprintf('%08d', $stationJobNumber+1);
        CustomerJobCards::where(['id'=>$customerjobId->id])->update(['job_number'=>$this->job_number]);

        $meterialRequestItems=[];
        $passmetrialRequest = false;
        $totalDiscountInJob=0;
        foreach($this->cartItems as $cartData)
        {
            $customerJobServiceData = [
                'job_number'=>$this->job_number,
                'job_id'=>$customerjobId->id,
                'job_status'=>1,
                'job_departent'=>1,
                'is_added'=>0,
                'is_removed'=>0,
                'created_by'=>Session::get('user')->id,
            ];
            
            
            $customerJobServiceData['item_id']=$cartData->item_id;
            $customerJobServiceData['item_code']=$cartData->item_code;
            $customerJobServiceData['company_code']=$cartData->company_code;
            $customerJobServiceData['category_id']=$cartData->category_id;
            $customerJobServiceData['sub_category_id']=$cartData->sub_category_id;
            $customerJobServiceData['brand_id']=$cartData->brand_id;
            $customerJobServiceData['bar_code']=$cartData->bar_code;
            $customerJobServiceData['item_name']=$cartData->item_name;
            $customerJobServiceData['description']=$cartData->description;
            $customerJobServiceData['division_code']=$cartData->division_code;
            $customerJobServiceData['department_code']=$cartData->department_code;
            $customerJobServiceData['department_name']=$cartData->department_name;
            $customerJobServiceData['section_code']=$cartData->section_code;
            $customerJobServiceData['station']=Session::get('user')->stationName['LandlordCode'];
            $customerJobServiceData['extra_note']=$cartData->extra_note;
            $customerJobServiceData['service_item_type']=$cartData->cart_item_type;
            //dd($customerJobServiceData);
            $customerJobServiceDiscountAmount=0;
            if($cartData->discount_perc){
                
                //$customerJobServiceData['customer_discount_id']=$this->customerSelectedDiscountGroup['id'];
                $customerJobServiceData['discount_id']=$cartData->customer_group_id;
                $customerJobServiceData['discount_unit_id']=$cartData->customer_group_id;
                $customerJobServiceData['discount_code']=$cartData->customer_group_code;
                $customerJobServiceData['discount_title']=$cartData->customer_group_code;
                $customerJobServiceData['discount_percentage'] = $cartData->discount_perc;
                $customerJobServiceDiscountAmount = round((($cartData->discount_perc/100)*($cartData->unit_price*$cartData->quantity)),2);
                $customerJobServiceData['discount_amount'] = $customerJobServiceDiscountAmount;
                $customerJobServiceData['discount_start_date']=$cartData->start_date;
                $customerJobServiceData['discount_end_date']=$cartData->end_date;
                $totalDiscountInJob = $totalDiscountInJob+$customerJobServiceDiscountAmount;
            }

            
            $total = $cartData->unit_price*$cartData->quantity;
            $totalAfterDisc = $total - $customerJobServiceDiscountAmount;
            $tax = $totalAfterDisc * (config('global.TAX_PERCENT') / 100);
            $grand_total = $totalAfterDisc+$tax;

            $customerJobServiceData['total_price']=$cartData->unit_price;
            $customerJobServiceData['quantity']=$cartData->quantity;
            $customerJobServiceData['vat']=$tax;
            $customerJobServiceData['grand_total']=$grand_total;

            /*if($this->customerSelectedDiscountGroup)
            {
                $customerJobServiceData['customer_discount_id']=$this->customerSelectedDiscountGroup['id'];
                $customerJobServiceData['discount_id']=$this->customerSelectedDiscountGroup['discount_id'];
                $customerJobServiceData['discount_unit_id']=$this->customerSelectedDiscountGroup['discount_unit_id'];
                $customerJobServiceData['discount_code']=$this->customerSelectedDiscountGroup['discount_code'];
                $customerJobServiceData['discount_title']=$this->customerSelectedDiscountGroup['discount_title'];
                $customerJobServiceData['discount_percentage'] = $cartData->discount_perc;
                $customerJobServiceData['discount_amount'] = round((($cartData->discount_perc/100)*$cartData->unit_price),2);
            }*/
            //dd($customerJobServiceData);
            $customerJobServiceId = CustomerJobCardServices::create($customerJobServiceData);
            
            CustomerJobCardServiceLogs::create([
                'job_number'=>$this->job_number,
                'job_status'=>1,
                'job_departent'=>1,
                'job_description'=>json_encode($customerJobServiceData),
                'customer_job__card_service_id'=>$customerJobServiceId->id,
                'created_by'=>Session::get('user')->id,
                'created_at'=>Carbon::now(),
            ]);
            
            if($cartData->cart_item_type==2){

                $passmetrialRequest = true;
                $propertyCodeMR = $cartData->department_code;
                $unitCodeMR = $cartData->section_code;
                
                

                //$meterialRequestItems= '';
                $meterialRequestItems = MaterialRequest::create([
                    'sessionId'=>$this->job_number,
                    'ItemCode'=>$cartData->item_code,
                    'ItemName'=>$cartData->item_name,
                    'QuantityRequested'=>$cartData->quantity,
                    'Activity2Code'=>Session::get('user')->station_code
                ]);
            }
            

        }

        if($totalDiscountInJob>0)
        {
            //$customerjobData['customer_discount_id']=$this->customerSelectedDiscountGroup['id'];
            /*$customerjobData['discount_id']=$discountGroupId;
            $customerjobData['discount_unit_id']=$discountGroupId;
            $customerjobData['discount_code']=$discountGroupCode;
            $customerjobData['discount_title']=$discountGroupCode;
            $customerjobData['discount_percentage']=$discountGroupDiscountPercentage;*/
            $customerjobDataUpdate['discount_amount']=$totalDiscountInJob;
            CustomerJobCards::where(['id'=>$customerjobId->id])->update($customerjobDataUpdate);
        }



        WorkOrderJob::create(
                [
                    "DocumentCode"=>$this->job_number,
                    "DocumentDate"=>$customerjobData['job_date_time'],
                    "Status"=>"A",
                    "LandlordCode"=>Session::get('user')->station_code,
                ]
            );

        $vehicle_image=[];
        //dd($vehicle_image);
        if($this->showCheckList)
        {
            $vehicle_image = [
                'vImageR1'=>isset($this->vImageR1)?$this->vImageR1->store('car_image', 'public'):null,
                'vImageR2'=>isset($this->vImageR2)?$this->vImageR2->store('car_image', 'public'):null,
                'vImageF'=>isset($this->vImageF)?$this->vImageF->store('car_image', 'public'):null,
                'vImageB'=>isset($this->vImageB)?$this->vImageB->store('car_image', 'public'):null,
                'vImageL1'=>isset($this->vImageL1)?$this->vImageL1->store('car_image', 'public'):null,
                'vImageL2'=>isset($this->vImageL2)?$this->vImageL2->store('car_image', 'public'):null,
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
                'turn_key_on_check_for_fault_codes'=>$this->turn_key_on_check_for_fault_codes,
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
                'ubi_comments'=>$this->ubi_comments,
                'created_by'=>Session::get('user')->id,
            ];
            $checkListEntryInsert = JobcardChecklistEntries::create($checkListEntryData);
        }
        if($passmetrialRequest==true)
        {
            try {
                $meterialRequestResponse = DB::select("EXEC [Inventory].[MaterialRequisition.Update.Operation] @companyCode = '".Session::get('user')->stationName['PortfolioCode']."', @documentCode = null, @documentDate = '".$customerjobData['job_date_time']."', @SessionId = '".$this->job_number."', @sourceType = 'J', @sourceCode = '".$this->job_number."', @locationId = '0', @referenceNo = '".$this->job_number."', @LandlordCode = '".Session::get('user')->station_code."', @propertyCode = '".$propertyCodeMR."', @UnitCode = '".$unitCodeMR."', @IsApprove = '1', @doneby = 'admin', @documentCode_out = null ", [
                        Session::get('user')->stationName['PortfolioCode'],
                        null,
                        $customerjobData['job_date_time'],
                        $this->job_number,
                        "J",
                        $this->job_number,
                        "0",
                        $this->job_number,
                        Session::get('user')->station_code,
                        $propertyCodeMR,
                        $unitCodeMR,
                         "1",
                         "admin",
                         null
                    ]);

                $meterialRequestResponse = json_encode($meterialRequestResponse[0],true);
                $meterialRequestResponse = json_decode($meterialRequestResponse,true);
                CustomerJobCards::where(['id'=>$customerjobId->id])->update(['meterialRequestResponse'=>$meterialRequestResponse['refCode']]);

                /*'division_code'=>"LL/00004",
                'department_code'=>"PP/00037",
                'section_code'=>"U-000225",*/


            } catch (\Exception $e) {
                //dd($e->getMessage());
                //return $e->getMessage();
            }
        }
    }
}
