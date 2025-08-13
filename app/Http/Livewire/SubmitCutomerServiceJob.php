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

use App\Models\CustomerServiceCart;
use App\Models\CustomerVehicle;
use App\Models\CustomerJobCards;
use App\Models\CustomerJobCardServices;
use App\Models\CustomerJobCardServiceLogs;
use App\Models\MaterialRequest;
use App\Models\WorkOrderJob;
use App\Models\JobcardChecklistEntries;
use App\Models\ServiceChecklist;
use App\Models\PackageBookings;
use App\Models\PackageBookingServices;
use App\Models\PackageBookingServiceLogs;
use App\Models\JobCardsDeletedServices;
use App\Models\TempCustomerSignature;

class SubmitCutomerServiceJob extends Component
{
    use WithFileUploads;
    public $customer_id, $vehicle_id, $mobile, $name, $email, $selectedVehicleInfo;
    public $selectedCustomerVehicle=true, $showCheckout=true, $successPage=false, $showCheckList=false, $showQLCheckList=false, $showFuelScratchCheckList=false, $showCustomerSignature=false, $discountApply=false;
    public $serviceAddedMessgae=[], $cartItemCount, $cartItems=[], $job_number, $total, $totalAfterDisc, $grand_total, $tax;

    public $vImageR1, $vImageR2, $vImageF, $vImageB, $vImageL1, $vImageL2, $dash_image1, $dash_image2, $passenger_seat_image, $driver_seat_image, $back_seat1, $back_seat2, $back_seat3, $back_seat4, $roof_images;
    public $existingImageR1, $existingImageR2, $existingImageF, $existingImageB, $existingImageL1, $existingImageL2, $existingdash_image1, $existingdash_image2, $existingpassenger_seat_image, $existingdriver_seat_image, $existingback_seat1, $existingback_seat2, $existingback_seat3, $existingback_seat4, $existingroof_images;

    public $customerSignature, $checklistLabels = [], $checklistLabel = [], $fuel, $scratchesFound, $scratchesNotFound;
    public $turn_key_on_check_for_fault_codes, $start_engine_observe_operation, $reset_the_service_reminder_alert, $stick_update_service_reminder_sticker_on_b_piller, $interior_cabin_inspection_comments, $check_power_steering_fluid_level, $check_power_steering_tank_cap_properly_fixed, $check_brake_fluid_level, $brake_fluid_tank_cap_properly_fixed, $check_engine_oil_level, $check_radiator_coolant_level, $check_radiator_cap_properly_fixed, $top_off_windshield_washer_fluid, $check_windshield_cap_properly_fixed, $underHoodInspectionComments, $check_for_oil_leaks_engine_steering, $check_for_oil_leak_oil_filtering, $check_drain_lug_fixed_properly, $check_oil_filter_fixed_properly, $ubi_comments;
    public $staff_id,$staff_number,$show_staff_details=false;
    public $job_date_time;
    public $package_job=false;
    public $showSignaturePad=false, $showvehicleImage=true, $showTermsandCondition=false, $jobUpdateSendSMS, $showSendSmsPannel=true, $doNotSendSms=false;

    function mount( Request $request) {
        $this->customer_id = $request->customer_id;
        $this->vehicle_id = $request->vehicle_id;
        $this->job_numbber = $request->job_number;
        if($this->vehicle_id && $this->customer_id)
        {
            $this->getCustomerCart();
            $this->selectVehicle();

        }

        if($this->job_number)
        {
            $this->showSendSmsPannel=true;
            $this->customerJobDetails();
        }

    }

    public function render()
    {
        
        $this->isValidInput = $this->getErrorBag()->count();
        if($this->isValidInput>0)
        {
            if( array_key_exists( 'staff_id',$this->getErrorBag()->messages() ) ){
                $scrollTo = 'staffIdInput';
            }else if( array_key_exists( 'staff_number',$this->getErrorBag()->messages() ) ){
                $scrollTo = 'staffNumberInput';
            }
            else if( array_key_exists( 'jobUpdateSendSMS',$this->getErrorBag()->messages() ) ){
                $scrollTo = 'jobUpdateSendSMS1';
            }
            $this->dispatchBrowserEvent('scrollto', [
                'scrollToId' => $scrollTo,
            ]);
        }

        if($this->selectedVehicleInfo->customerInfoMaster['Required_StaffDtls'])
        {
            $this->show_staff_details=true;
        }
        if($this->showCheckList)
        {
            $this->showFuelScratchCheckList=true;
            $this->checklistLabels= ServiceChecklist::get();
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
        //

        foreach($this->cartItems as $cartCheckItem){
            if($cartCheckItem->division_code != auth()->user('user')->stationName['LandlordCode'])
            {
                dd('Error, Contact techincal team..!');
            }
        }
        
        //$this->getCustomerCart();
        return view('livewire.submit-cutomer-service-job');
    }

    public function customerJobDetails(){
        //dd(JobcardChecklistEntries::where(['job_number'=>'JOB-GWW-00000028'])->get());
        $customerJobCardsQuery = CustomerJobCards::with(['customerInfo','customerJobServices','checklistInfo','makeInfo','modelInfo']);
        $customerJobCardsQuery = $customerJobCardsQuery->where(['job_number'=>$this->job_number]);
        $customerJobCardsQuery = $customerJobCardsQuery->where('payment_status','!=',1);
        $customerJobCardsQuery = $customerJobCardsQuery->where('job_status','!=',4)->where('job_status','!=',5);
        $this->jobDetails =  $customerJobCardsQuery->first();
        if($this->jobDetails){
            //dd($this->jobDetails);
            $this->showFuelScratchCheckList=true;
            $this->checklistEntry = JobcardChecklistEntries::where(['job_number'=>$this->job_number])->first();
            //dd($this->checklistEntry);
            if($this->checklistEntry){
                //dd($this->checklistEntry);
                $this->checklistLabel = json_decode($this->checklistEntry->checklist,true);
                $this->fuel = $this->checklistEntry->fuel;
                $this->vehicle_image = json_decode($this->checklistEntry->vehicle_image,true);
                $this->existingImageR1 = $this->vehicle_image['vImageR1'];
                $this->existingImageR2 = $this->vehicle_image['vImageR2'];
                $this->existingImageF = $this->vehicle_image['vImageF'];
                $this->existingImageB = $this->vehicle_image['vImageB'];
                $this->existingImageL1 = $this->vehicle_image['vImageL1'];
                $this->existingImageL2 = $this->vehicle_image['vImageL2'];
                $this->turn_key_on_check_for_fault_codes = $this->checklistEntry->turn_key_on_check_for_fault_codes;
                $this->start_engine_observe_operation = $this->checklistEntry->start_engine_observe_operation;
                $this->reset_the_service_reminder_alert = $this->checklistEntry->reset_the_service_reminder_alert;
                $this->stick_update_service_reminder_sticker_on_b_piller = $this->checklistEntry->stick_update_service_reminder_sticker_on_b_piller;
                $this->interior_cabin_inspection_comments = $this->checklistEntry->interior_cabin_inspection_comments;
                $this->check_power_steering_fluid_level = $this->checklistEntry->check_power_steering_fluid_level;
                $this->check_power_steering_tank_cap_properly_fixed = $this->checklistEntry->check_power_steering_tank_cap_properly_fixed;
                $this->check_brake_fluid_level = $this->checklistEntry->check_brake_fluid_level;
                $this->brake_fluid_tank_cap_properly_fixed = $this->checklistEntry->brake_fluid_tank_cap_properly_fixed;
                $this->check_engine_oil_level = $this->checklistEntry->check_engine_oil_level;
                $this->check_radiator_coolant_level = $this->checklistEntry->check_radiator_coolant_level;
                $this->check_radiator_cap_properly_fixed = $this->checklistEntry->check_radiator_cap_properly_fixed;
                $this->top_off_windshield_washer_fluid = $this->checklistEntry->top_off_windshield_washer_fluid;
                $this->check_windshield_cap_properly_fixed = $this->checklistEntry->check_windshield_cap_properly_fixed;
                $this->underHoodInspectionComments = $this->checklistEntry->underHoodInspectionComments;
                $this->check_for_oil_leaks_engine_steering = $this->checklistEntry->check_for_oil_leaks_engine_steering;
                $this->check_for_oil_leak_oil_filtering = $this->checklistEntry->check_for_oil_leak_oil_filtering;
                $this->check_drain_lug_fixed_properly = $this->checklistEntry->check_drain_lug_fixed_properly;
                $this->check_oil_filter_fixed_properly = $this->checklistEntry->check_oil_filter_fixed_properly;
                $this->ubi_comments = $this->checklistEntry->ubi_comments;
                $this->customerSignature = $this->checklistEntry->signature;
            }
        }
        else
        {
            return redirect()->to('/customer-job-update/'.$this->job_number);
        }
        
    }

    public function getCustomerCart(){
        $customerServiceCartQuery = CustomerServiceCart::with(['customerInfo'])->where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->vehicle_id,'division_code'=>auth()->user('user')->stationName['LandlordCode']]);
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
            //dd($this->cartItems);
            $total=0;
            $totalDiscount=0;
            $serviceIncludeArray=[];
            $gsQlIn = false;
            //dd($this->cartItems);
            foreach($this->cartItems as $item)
            {
                $total = $total+($item->quantity*$item->unit_price);
                if($item->discount_perc){
                    $this->discountApply=true;
                    $discountGroupId = $item->customer_group_id;
                    $discountGroupCode = $item->customer_group_code;
                    $discountGroupDiscountPercentage = $item->discount_perc;
                    $discountGroupPrice = $item->customer_id;
                    $totalDiscount = $totalDiscount+custom_round((($item->discount_perc/100)*($item->unit_price*$item->quantity)));
                }
                if($item->section_name=='Quick Lube'  || $item->section_name=='Mechanical')
                {
                    $this->showCheckout =false;
                    $this->showCheckList=true;
                    $this->showSignaturePad=true;
                    $this->showTermsandCondition=true;
                    $this->doNotSendSms=true;
                    $this->jobUpdateSendSMS='no';
                    $this->dispatchBrowserEvent('imageUpload');
                    $showSendSmsPannel=false;
                }

                if($item->department_name=='General Service')
                {
                    $this->showCheckout =false;
                    $this->showCheckList=true;
                    $this->showSignaturePad=true;
                    $this->showTermsandCondition=true;
                }
                if($item->is_package==1){
                    $this->package_job=true;

                }
            }
            $this->total = $total;
            $this->totalAfterDisc = $this->total - $totalDiscount;
            if($this->cartItems[0]->customerInfo['VatApplicable']==1){
                $this->tax = $this->totalAfterDisc * (config('global.TAX_PERCENT') / 100);
            }
            else
            {
                $this->tax = 0;
            }
            if($this->package_job)
            {
                $this->tax = 0;
            }
            $this->grand_total = custom_round($this->totalAfterDisc+$this->tax);
        }
        else
        {
            return redirect()->to('customer-service-job/'.$this->customer_id.'/'.$this->vehicle_id);
        }


    }
    public function selectVehicle(){
        $customers = CustomerVehicle::with(['customerInfoMaster','makeInfo','modelInfo','customerDiscountLists'])->where(['is_active'=>1,'id'=>$this->vehicle_id,'customer_id'=>$this->customer_id])->first();
        $this->selectedVehicleInfo=$customers;

        $this->mobile = $customers->customerInfoMaster['Mobile'];
        $this->name = $customers->customerInfoMaster['TenantName'];
        $this->email = $customers->customerInfoMaster['Email'];
    }   

    public function updateServiceItem(){
        if($this->job_number)
        {
            return redirect()->to('customer-service-job/'.$this->customer_id.'/'.$this->vehicle_id.'/'.$this->job_number);
        }
        else
        {
            return redirect()->to('customer-service-job/'.$this->customer_id.'/'.$this->vehicle_id);
        }
    }

    public function clickShowSignature()
    {
        if($this->selectedVehicleInfo->customerInfoMaster['Required_StaffDtls'])
        {
            if($this->selectedVehicleInfo['customerInfoMaster']['TenantId']=='6630'){
                $validatedData = $this->validate([
                    'staff_id' => 'required',
                    'staff_number' => 'required'
                ]);
            }
            else
            {
                $validatedData = $this->validate([
                    'staff_id' => 'required',
                    //'staff_number' => 'required'
                ]);
            }
        }
        
        TempCustomerSignature::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->vehicle_id,'is_active'=>1])->delete();
        $this->customerSignature=null;
        $this->showCustomerSignature=true;
        $this->dispatchBrowserEvent('showSignature');

    }

    public function completePaymnet($mode){
        //stationName
        if($this->showSendSmsPannel)
        {
            $validatedData = $this->validate([
                'jobUpdateSendSMS' => 'required'
            ]);
        }
        else if($this->doNotSendSms)
        {
            $this->jobUpdateSendSMS = 'no';
        }
        /*if($this->job_number){
            $validatedData = $this->validate([
                'jobUpdateSendSMS' => 'required'
            ]);
        }*/
        if($this->cartItemCount>0){

        
            $this->createJobEntry();
            $this->job_number;
            
            $customerjobs = CustomerJobCards::with(['customerInfo','customerVehicle','stationInfo'])->where(['job_number'=>$this->job_number])->first();
            $mobileNumber = isset($customerjobs->customer_mobile)?'971'.substr($customerjobs->customer_mobile, -9):null;
            $customerName = isset($customerjobs->customer_name)?$customerjobs->customer_name:null;
            $plate_number = $customerjobs->plate_number;
            $paymentmode = null;
            if($mobileNumber!='' && auth()->user('user')->stationName['EnableSMS']==1){
                $msgtext = urlencode('Dear Customer, '.$plate_number.' received at '.auth()->user('user')->stationName['ShortName'].'. Track or pay online: https://gsstations.ae/qr/'.$this->job_number.'. For help, call 800477823.');
                //dd(config('global.sms')[1]['sms_url']."&mobileno=".$mobileNumber."&msgtext=".$msgtext."&CountryCode=ALL");
                
                if(!$this->showSendSmsPannel && !$this->doNotSendSms)
                {
                    $response = Http::get(config('global.sms')[1]['sms_url']."&mobileno=".$mobileNumber."&msgtext=".$msgtext."&CountryCode=ALL");
                }
                else
                {
                    if($this->jobUpdateSendSMS=='yes')
                    {
                        $response = Http::get(config('global.sms')[1]['sms_url']."&mobileno=".$mobileNumber."&msgtext=".$msgtext."&CountryCode=ALL");
                    }
                }
                
            }

            $createJobUpdate['job_create_status']=1;
            if($mode=='link')
            {
                $paymentmode = "O";
                $createJobUpdate['payment_type']=1;
            }
            else if($mode=='card')
            {
                $paymentmode = "O";
                $createJobUpdate['payment_type']=2;
            }
            else if($mode=='cash')
            {
                $paymentmode = "C";
                $createJobUpdate['payment_type']=3;
            }
            else if($mode=='full_discount')
            {
                $paymentmode = "C";
                $createJobUpdate['payment_type']=3;
                $createJobUpdate['payment_status']=1;
            }
            else if($mode=='empty')
            {
                $createJobUpdate['payment_type']=6;
                $createJobUpdate['payment_status']=1;
                $createJobUpdate['payment_request']='package';
            }
            $customerjobId = CustomerJobCards::where(['job_number'=>$this->job_number])->update($createJobUpdate);
            
            //Cart empty..!
            $customerServiceCartQuery = CustomerServiceCart::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->vehicle_id])->delete();

            $this->successPage=true;
            $this->showCheckout =false;
            $this->cardShow=false;
            $this->showServiceGroup=false;
            $this->showPayLaterCheckout=false;
            $this->selectedCustomerVehicle=false;
        }
        
        else
        {
            return redirect()->to('customer-service-job/'.$this->customer_id.'/'.$this->vehicle_id);
        }

    }

    public function jobServiceTableUpdate(){

        
        $missing = [];
        $fourPLuOneRequested = false;
        
        foreach(CustomerJobCardServices::where(['job_number'=>$this->job_number])->get() as $tabKey => $customerJobCardServices){
            JobCardsDeletedServices::create($customerJobCardServices->toArray());
            CustomerJobCardServices::where(['job_number'=>$customerJobCardServices->job_number,'id'=>$customerJobCardServices->id])->delete();
        }
        
    }

    

    public function createJobEntry(){

        if($this->cartItemCount==0){
            dd('Contact IT..!');
        }

        $job_update = false;
        if($this->job_number){
            $job_update = true;
            MaterialRequest::where(['sessionId'=>$this->job_number])->delete();
            $this->jobServiceTableUpdate();
        }

        $this->job_date_time =  Carbon::parse($this->job_date_time)->format('Y-m-d H:i:s');
        $customerjobData = [
            
            'job_date_time'=>isset($this->job_date_time)?$this->job_date_time:Carbon::now(),
            'customer_id'=>$this->customer_id,
            'customer_name'=>$this->name,
            'customer_email'=>$this->email,
            'customer_mobile'=>$this->mobile,
            'vehicle_id'=>$this->vehicle_id,
            'vehicle_type'=>isset($this->selectedVehicleInfo['vehicle_type'])?$this->selectedVehicleInfo['vehicle_type']:0,
            'make'=>$this->selectedVehicleInfo['make'],
            'vehicle_image'=>$this->selectedVehicleInfo['vehicle_image'],
            'model'=>$this->selectedVehicleInfo['model'],
            'plate_number'=>$this->selectedVehicleInfo['plate_number_final'],
            'chassis_number'=>$this->selectedVehicleInfo['chassis_number'],
            'vehicle_km'=>$this->selectedVehicleInfo['vehicle_km'],
            'station'=>auth()->user('user')->stationName['LandlordCode'],
            'total_price'=>$this->total,
            'vat'=>$this->tax,
            'grand_total'=>$this->grand_total,
            'job_status'=>1,
            'job_departent'=>1,
            'payment_status'=>0,
            //'payment_updated_by'=>auth()->user('user')->id,
        ];
        if($this->selectedVehicleInfo->customerInfoMaster['Required_StaffDtls'])
        {
            $customerjobData['validate_number']=$this->staff_id;
            $customerjobData['validate_id']=$this->staff_number;
        }
        //dd($customerjobData);
        if($this->job_number)
        {
            $customerjobData['updated_by']=auth()->user('user')->id;
            //dd($customerjobData);
            CustomerJobCards::where(['job_number'=>$this->job_number])->update($customerjobData);
            
            CustomerJobCards::where(['job_number'=>$this->job_number])->update(['customer_job_update'=>null]);
            $customerjobId = $this->jobDetails->id;
        }
        else
        {

            $customerjobData['created_by']=auth()->user('user')->id;
            //Get Job Number
            $jobStartChar = 'JOB-'.auth()->user('user')->stationName['Abbreviation'].'-';
            /*
            $jobNumDb = '[dbo].[customer_job_cards]';
            $jobNumTable = 'job_number';
            $jobNumZeros = 8;
            $jobNumOut = null;
            $jobNumber = DB::select('EXEC [Document].[Code.Series.Generate] @type = ?, @table = ?, @code_column = ?, @no_of_zeros = ?, @code = ?', [
                $jobStartChar,
                $jobNumDb,
                $jobNumTable,
                $jobNumZeros,
                $jobNumOut,
            ]);

            $jobNumberResult = (array)$jobNumber[0];
            dd($jobNumberResult);

            $jobNumber = DB::select(" exec [Document].[Code.Series.Generate] '".$jobStartChar."','[dbo].[customer_job_cards]','job_number','8', @document_code output ");
            dd($jobNumber);*/

            
            
            $lastJobNumber = CustomerJobCards::where(['station'=>auth()->user('user')->station_code])->where('job_number','!=',null)->where('carTaxiJobs','=',null)->orderBy('id','DESC')->first();
            //dd($lastJobNumber);
            $lastJobNumber = $lastJobNumber->job_number;
            $NewJobNumber = explode('-',$lastJobNumber);
            $this->job_number = $jobStartChar.sprintf('%08d', $NewJobNumber[count($NewJobNumber)-1]+1);
            $customerjobData['job_number']=$this->job_number;
            //$createdCustomerJob = CustomerJobCards::create($customerjobData);
            
            try {
                if(!CustomerJobCards::where(['job_number'=>$this->job_number])->exists()){
                    $createdCustomerJob = CustomerJobCards::create($customerjobData);    
                }
                else
                {
                    $lastJobNumber = CustomerJobCards::where(['station'=>auth()->user('user')->station_code])->where('job_number','!=',null)->orderBy('id','DESC')->first();
                    $lastJobNumber = $lastJobNumber->job_number;
                    $NewJobNumber = explode('-',$lastJobNumber);
                    $this->job_number = $jobStartChar.sprintf('%08d', $NewJobNumber[count($NewJobNumber)-1]+1);
                    $customerjobData['job_number']=$this->job_number;
                    $createdCustomerJob = CustomerJobCards::create($customerjobData);
                }
                
            } catch (\Exception $e) {
                $lastJobNumber = CustomerJobCards::where(['station'=>auth()->user('user')->station_code])->where('job_number','!=',null)->orderBy('id','DESC')->first();
                $lastJobNumber = $lastJobNumber->job_number;

                $NewJobNumber = explode('-',$lastJobNumber);
                $this->job_number = $jobStartChar.sprintf('%08d', $NewJobNumber[count($NewJobNumber)-1]+1);
                $customerjobData['job_number']=$this->job_number;
                $createdCustomerJob = CustomerJobCards::create($customerjobData); 
                //return $e->getMessage();
            }

            $customerjobId = $createdCustomerJob->id;
            /*$stationJobNumber = CustomerJobCards::where(['station'=>auth()->user('user')->station_code])->count();
            if($stationJobNumber==1)
            {
                $stationJobNumber=0;
            }
            $this->job_number = 'JOB-'.auth()->user('user')->stationName['Abbreviation'].'-'.sprintf('%08d', $stationJobNumber+1);*/

            /*DB::transaction(function () use ($request) {
                // Lock the table or matching rows to prevent others from inserting
                $existing = CustomerJobCards::where('job_number', $this->job_number)
                                  ->lockForUpdate()
                                  ->first();

                if ($existing) {
                    $customerjobId = $createdCustomerJob->id;
                    $stationJobNumber = CustomerJobCards::where(['station'=>auth()->user('user')->station_code])->count();
                    if($stationJobNumber==1)
                    {
                        $stationJobNumber=0;
                    }
                    $this->job_number = 'JOB-'.auth()->user('user')->stationName['Abbreviation'].'-'.sprintf('%08d', $stationJobNumber+1);
                }

                // Safe to insert
                CustomerJobCards::where(['id'=>$customerjobId])->update(['job_number'=>$this->job_number]); 
            });*/


            /*try {
                CustomerJobCards::where(['id'=>$customerjobId])->update(['job_number'=>$this->job_number]);    
            } catch (\Exception $e) {
                $stationJobNumber = CustomerJobCards::where(['station'=>auth()->user('user')->station_code])->count();
                if($stationJobNumber==1)
                {
                    $stationJobNumber=0;
                }
                $this->job_number = 'JOB-'.auth()->user('user')->stationName['Abbreviation'].'-'.sprintf('%08d', $stationJobNumber+1);
                CustomerJobCards::where(['id'=>$customerjobId])->update(['job_number'=>$this->job_number]);    
                //return $e->getMessage();
            }*/
        }
        
        

        $meterialRequestItems=[];
        $passmetrialRequest = false;
        $totalDiscountInJob=0;
        $is_package=false;
        $package_code=null;
        $package_number=null;
        $fourPLuOneRequested=false;
        $packageGrand_total=0;
        foreach($this->cartItems as $cartData)
        {
            $customerJobServiceData = [
                'job_number'=>$this->job_number,
                'job_id'=>$customerjobId,
                'job_status'=>1,
                'job_departent'=>1,
                'is_added'=>0,
                'is_removed'=>0,
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
            $customerJobServiceData['section_name']=$cartData->section_name;
            $customerJobServiceData['section_code']=$cartData->section_code;
            $customerJobServiceData['station']=auth()->user('user')->stationName['LandlordCode'];
            $customerJobServiceData['extra_note']=$cartData->extra_note;
            $customerJobServiceData['service_item_type']=$cartData->cart_item_type;
            //dd($customerJobServiceData);

            /*if($cartData->division_code !=auth()->user('user')->stationName['LandlordCode'])
            {
                dd($cartData);
            }*/
            $customerJobServiceDiscountAmount=0;
            if($cartData->discount_perc){
                
                //$customerJobServiceData['customer_discount_id']=$this->customerSelectedDiscountGroup['id'];
                $customerJobServiceData['discount_id']=$cartData->customer_group_id;
                $customerJobServiceData['discount_unit_id']=$cartData->customer_group_id;
                $customerJobServiceData['discount_code']=$cartData->customer_group_code;
                $customerJobServiceData['discount_title']=$cartData->customer_group_code;
                $customerJobServiceData['discount_percentage'] = $cartData->discount_perc;
                $customerJobServiceDiscountAmount = custom_round((($cartData->discount_perc/100)*($cartData->unit_price*$cartData->quantity)));
                $customerJobServiceData['discount_amount'] = $customerJobServiceDiscountAmount;
                $customerJobServiceData['discount_start_date']=$cartData->start_date;
                $customerJobServiceData['discount_end_date']=$cartData->end_date;
                $totalDiscountInJob = $totalDiscountInJob+$customerJobServiceDiscountAmount;
            }
            else{
                $customerJobServiceData['discount_id']=null;
                $customerJobServiceData['discount_unit_id']=null;
                $customerJobServiceData['discount_code']=null;
                $customerJobServiceData['discount_title']=null;
                $customerJobServiceData['discount_percentage'] = null;
                $customerJobServiceData['discount_amount'] = null;
                $customerJobServiceData['discount_start_date']=null;
                $customerJobServiceData['discount_end_date']=null;
            }

            if($cartData->cart_item_type==3){
                $customerJobServiceData['is_package']=1;
                $customerJobServiceData['package_number']=$cartData->package_number;
                $customerJobServiceData['package_code']=$cartData->package_code;
            }

            /*if($cartData->cart_item_type==2){
                $customerJobServiceData['job_status']=7;
            }*/

            
            $total = $cartData->unit_price*$cartData->quantity;
            $totalAfterDisc = $total - $customerJobServiceDiscountAmount;
            if($cartData->customerInfo['VatApplicable']==1){
                $tax = $totalAfterDisc * (config('global.TAX_PERCENT') / 100);
            }
            else
            {
                $tax = 0;
            }

            if($cartData->is_package==1){
                $tax = 0;

            }

            $grand_total = $totalAfterDisc+$tax;

            $customerJobServiceData['total_price']=$cartData->unit_price;
            $customerJobServiceData['quantity']=$cartData->quantity;
            $customerJobServiceData['vat']=$tax;
            $customerJobServiceData['grand_total']=$grand_total;


            //Warewnty
            if($cartData->isWarranty){
                $customerJobServiceData['iswarranty'] = $cartData->isWarranty;
                $customerJobServiceData['warrantyperiod'] = $cartData->warrantyPeriod;
                $customerJobServiceData['warrantyTerms'] = $cartData->warrantyTerms;
                $customerJobServiceData['warranty_start'] = Carbon::now()->format('Y-m-d H:i:s');
                $customerJobServiceData['warranty_ends'] = Carbon::now()->addMonths($cartData->warrantyPeriod)->format('Y-m-d H:i:s');
            }

            if($cartData->section_name == 'Quick Lube' || $cartData->section_name == 'Mechanical')
            {
                $customerJobServiceData['job_status']=6;
                $customerJobServiceData['job_departent']=6;
            }

            if($job_update==true){
                $customerJobServiceData['updated_by']=auth()->user('user')->id;
                if($cartData->current_job_status!=null)
                {
                    $customerJobServiceData['job_status'] = $cartData->current_job_status;
                }
                else
                {
                    if($cartData->section_name == 'Quick Lube' || $cartData->section_name == 'Mechanical')
                    {
                        $customerJobServiceData['job_status']=6;
                        $customerJobServiceData['job_departent']=6;
                    }
                }
                /*$customerJobServiceQuery = CustomerJobCardServices::where([
                    'job_number'=>$this->job_number,
                    'job_id'=>$customerjobId,
                    'item_id'=>$cartData->item_id,
                    'item_code'=>$cartData->item_code,
                ]);

                if($cartData->item_code=='I09137'){
                    if($cartData->discount_perc){
                        $customerJobServiceQuery->where([
                            //'discount_id'=>$cartData->customer_group_id,
                            'discount_code'=>$cartData->customer_group_code
                        ]);
                    }
                }
                if($customerJobServiceQuery->exists()){
                    $customerJobServiceQuery->update($customerJobServiceData);
                    $customerJobServiceId = $customerJobServiceQuery->first();    
                }
                else
                {
                    $customerJobServiceData['created_by']=auth()->user('user')->id;
                    $customerJobServiceId = CustomerJobCardServices::create($customerJobServiceData);
                }*/
                
            }
            else
            {
                $customerJobServiceData['created_by']=auth()->user('user')->id;
                //$customerJobServiceId = CustomerJobCardServices::create($customerJobServiceData);
            }
            //$customerJobServiceData['created_by']=auth()->user('user')->id;
            $customerJobServiceId = CustomerJobCardServices::create($customerJobServiceData);
            //dd($customerJobServiceId);
            
            CustomerJobCardServiceLogs::create([
                'job_number'=>$this->job_number,
                'job_status'=>$customerJobServiceData['job_status'],
                'job_departent'=>$customerJobServiceData['job_departent'],
                'job_description'=>json_encode($customerJobServiceId),
                'customer_job__card_service_id'=>$customerJobServiceId->id,
                'created_by'=>auth()->user('user')->id,
                'created_at'=>Carbon::now(),
            ]);

            
            if($cartData->cart_item_type==2){

                $passmetrialRequest = true;
                $propertyCodeMR = $cartData->department_code;
                $unitCodeMR = $cartData->section_code;
                
                
                if($cartData->item_code=='I09137'){
                    if($cartData->customer_group_code=='MOBIL4+1' && $fourPLuOneRequested == false){
                        $meterialRequestItems = MaterialRequest::create([
                            'sessionId'=>$this->job_number,
                            'ItemCode'=>$cartData->item_code,
                            'ItemName'=>$cartData->item_name,
                            'QuantityRequested'=>$cartData->quantity*5,
                            'Activity2Code'=>auth()->user('user')->station_code
                        ]);
                        $fourPLuOneRequested=true;
                    }
                }
                else
                {
                    $meterialRequestItems = MaterialRequest::create([
                        'sessionId'=>$this->job_number,
                        'ItemCode'=>$cartData->item_code,
                        'ItemName'=>$cartData->item_name,
                        'QuantityRequested'=>$cartData->quantity,
                        'Activity2Code'=>auth()->user('user')->station_code
                    ]);
                }
                //$meterialRequestItems= '';
                
            }


            if($cartData->cart_item_type==3){
                //dd(PackageBookings::with(['customerPackageServices'])->where(['customer_id'=>$cartData->customer_id,'package_code'=>$cartData->customer_group_code])->first());
                PackageBookingServices::where([
                    'item_id'=>$cartData->item_id,
                    'item_code'=>$cartData->item_code,
                    'package_number'=>$cartData->package_number,
                ])->increment('package_service_use_count', $cartData->quantity);
                //dd($cartData);
                //dd(PackageBookingServices::where(['package_number'=>$cartData->package_number])->get());
                /*dd(PackageBookingServices::where([
                    'item_id'=>$cartData->item_id,
                    'item_code'=>$cartData->item_code,
                    'package_number'=>$cartData->package_number,
                ])->get());*/

                $is_package=true;
                $package_code=$cartData->package_code;
                $package_number=$cartData->package_number;

                //$packageGrand_total = $packageGrand_total+$grand_total;//Package Price Total Service Wise
            }

            //Ceramic Wash Discount Count
            if(in_array($cartData->item_code,config('global.ceramic.service'))){
                CustomerVehicle::where([
                    'id'=>$this->vehicle_id,
                    'customer_id'=>$this->customer_id
                ])->increment('ceramic_wash_discount_count',10);
            }else if($cartData->item_code == config('global.ceramic.discount_in') && $cartData->ceramic_wash_discount_count != null){
                $getCustomerCeramicDiscountQuery = CustomerVehicle::where([
                    'id'=>$this->vehicle_id,
                    'customer_id'=>$this->customer_id
                ])->first();
                if($getCustomerCeramicDiscountQuery->ceramic_wash_discount_count>0)
                {
                    CustomerVehicle::where([
                        'id'=>$this->vehicle_id,
                        'customer_id'=>$this->customer_id
                    ])->decrement('ceramic_wash_discount_count',$cartData->quantity);    
                }
                else
                {
                    CustomerVehicle::where([
                        'id'=>$this->vehicle_id,
                        'customer_id'=>$this->customer_id
                    ])->update(['ceramic_wash_discount_count'=>$cartData->ceramic_wash_discount_count]);
                }
                /*
                CustomerVehicle::where([
                    'id'=>$this->vehicle_id,
                    'customer_id'=>$this->customer_id
                ])->decrement('ceramic_wash_discount_count',$cartData->quantity);*/
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
            CustomerJobCards::where(['id'=>$customerjobId])->update($customerjobDataUpdate);
        }


        

        $vehicle_image=[];
        
        if($this->showCheckList)
        {
            $checkListEntryData = [
                'checklist'=>json_encode($this->checklistLabel),
                'fuel'=>$this->fuel,
                'scratches_found'=>$this->scratchesFound,
                'scratches_notfound'=>$this->scratchesNotFound,
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
            ];
        }
        if($this->showvehicleImage){
            if($job_update==true){
                if($this->vImageR1==null){
                    $vehicle_image['vImageR1']=$this->existingImageR1;
                }
                else{
                    $vehicle_image['vImageR1']=$this->vImageR1->store('car_image', 'public');
                }
                
                if($this->vImageR2==null){
                    $vehicle_image['vImageR2']=$this->existingImageR2;
                }
                else{
                    $vehicle_image['vImageR2']=$this->vImageR2->store('car_image', 'public');
                }

                if($this->vImageF==null){
                    $vehicle_image['vImageF']=$this->existingImageF;
                }
                else{
                    $vehicle_image['vImageF']=$this->vImageF->store('car_image', 'public');
                }

                if($this->vImageB==null){
                    $vehicle_image['vImageB']=$this->existingImageB;
                }
                else{
                    $vehicle_image['vImageB']=$this->vImageB->store('car_image', 'public');
                }

                if($this->vImageL1==null){
                    $vehicle_image['vImageL1']=$this->existingImageL1;
                }
                else{
                    $vehicle_image['vImageL1']=$this->vImageL1->store('car_image', 'public');
                }

                if($this->vImageL2==null){
                    $vehicle_image['vImageL2']=$this->existingImageL2;
                }
                else{
                    $vehicle_image['vImageL2']=$this->vImageL2->store('car_image', 'public');
                }

                if($this->dash_image1==null){
                    $vehicle_image['dash_image1']=$this->existingdash_image1;
                }
                else{
                    $vehicle_image['dash_image1']=$this->dash_image1->store('car_image', 'public');
                }

                if($this->dash_image2==null){
                    $vehicle_image['dash_image2']=$this->existingdash_image2;
                }
                else{
                    $vehicle_image['dash_image2']=$this->dash_image2->store('car_image', 'public');
                }

                if($this->passenger_seat_image==null){
                    $vehicle_image['passenger_seat_image']=$this->existingpassenger_seat_image;
                }
                else{
                    $vehicle_image['passenger_seat_image']=$this->passenger_seat_image->store('car_image', 'public');
                }

                if($this->driver_seat_image==null){
                    $vehicle_image['driver_seat_image']=$this->existingdriver_seat_image;
                }
                else{
                    $vehicle_image['driver_seat_image']=$this->driver_seat_image->store('car_image', 'public');
                }

                if($this->back_seat1==null){
                    $vehicle_image['back_seat1']=$this->existingback_seat1;
                }
                else{
                    $vehicle_image['back_seat1']=$this->back_seat1->store('car_image', 'public');
                }

                if($this->back_seat2==null){
                    $vehicle_image['back_seat2']=$this->existingback_seat2;
                }
                else{
                    $vehicle_image['back_seat2']=$this->back_seat2->store('car_image', 'public');
                }

                if($this->back_seat3==null){
                    $vehicle_image['back_seat3']=$this->existingback_seat3;
                }
                else{
                    $vehicle_image['back_seat3']=$this->back_seat3->store('car_image', 'public');
                }

                if($this->back_seat4==null){
                    $vehicle_image['back_seat4']=$this->existingback_seat4;
                }
                else{
                    $vehicle_image['back_seat4']=$this->back_seat4->store('car_image', 'public');
                }

                if($this->roof_images==null){
                    $vehicle_image['roof_images']=$this->existingroof_images;
                }
                else{
                    $vehicle_image['roof_images']=$this->roof_images->store('car_image', 'public');
                }
                $checkListEntryData['vehicle_image']=json_encode($vehicle_image);
                $checkListEntryData['updated_by']=auth()->user('user')->id;
                //dd($checkListEntryData);
                $checkListEntryInsert = JobcardChecklistEntries::where(['job_number'=>$this->job_number])->update($checkListEntryData);
            }
            else{
                $vehicle_image = [
                    'vImageR1'=>isset($this->vImageR1)?$this->vImageR1->store('car_image', 'public'):null,
                    'vImageR2'=>isset($this->vImageR2)?$this->vImageR2->store('car_image', 'public'):null,
                    'vImageF'=>isset($this->vImageF)?$this->vImageF->store('car_image', 'public'):null,
                    'vImageB'=>isset($this->vImageB)?$this->vImageB->store('car_image', 'public'):null,
                    'vImageL1'=>isset($this->vImageL1)?$this->vImageL1->store('car_image', 'public'):null,
                    'vImageL2'=>isset($this->vImageL2)?$this->vImageL2->store('car_image', 'public'):null,
                    'dash_image1'=>isset($this->dash_image1)?$this->dash_image1->store('car_image', 'public'):null,
                    'dash_image2'=>isset($this->dash_image2)?$this->dash_image2->store('car_image', 'public'):null,
                    'passenger_seat_image'=>isset($this->passenger_seat_image)?$this->passenger_seat_image->store('car_image', 'public'):null,
                    'driver_seat_image'=>isset($this->driver_seat_image)?$this->driver_seat_image->store('car_image', 'public'):null,
                    'back_seat1'=>isset($this->back_seat1)?$this->back_seat1->store('car_image', 'public'):null,
                    'back_seat2'=>isset($this->back_seat2)?$this->back_seat2->store('car_image', 'public'):null,
                    'back_seat3'=>isset($this->back_seat3)?$this->back_seat3->store('car_image', 'public'):null,
                    'back_seat4'=>isset($this->back_seat4)?$this->back_seat4->store('car_image', 'public'):null,
                    'roof_images'=>isset($this->roof_images)?$this->roof_images->store('car_image', 'public'):null,
                ];
                $checkListEntryData['vehicle_image']=json_encode($vehicle_image);
                $checkListEntryData['job_number']=$this->job_number;
                $checkListEntryData['job_id']=$customerjobId;
                $checkListEntryData['created_by']=auth()->user('user')->id;
                $checkListEntryInsert = JobcardChecklistEntries::create($checkListEntryData);                
            }
        }

        if($job_update!=true){

            if($is_package==true)
            {
                //$packageGrand_total = $packageGrand_total - $totalDiscountInJob;

                try {
                    DB::select('EXEC [ServicePackage.Redeem.FinancialEntries] @jobnumber = "'.$this->job_number.'", @packagenumber = "'.$package_number.'", @doneby = "'.auth()->user('user')->id.'" ');
                } catch (\Exception $e) {
                    //dd($e->getMessage());
                    //return $e->getMessage();
                }



            }


            WorkOrderJob::create(
                [
                    "DocumentCode"=>$this->job_number,
                    "DocumentDate"=>$customerjobData['job_date_time'],
                    "Status"=>"A",
                    "LandlordCode"=>auth()->user('user')->station_code,
                ]
            );
            if($passmetrialRequest==true )
            {
                try {
                    $meterialRequestResponse = DB::select("EXEC [Inventory].[MaterialRequisition.Update.Operation] @companyCode = '".auth()->user('user')->stationName['PortfolioCode']."', @documentCode = null, @documentDate = '".$customerjobData['job_date_time']."', @SessionId = '".$this->job_number."', @sourceType = 'J', @sourceCode = '".$this->job_number."', @locationId = '0', @referenceNo = '".$this->job_number."', @LandlordCode = '".auth()->user('user')->station_code."', @propertyCode = '".$propertyCodeMR."', @UnitCode = '".$unitCodeMR."', @IsApprove = '1', @doneby = 'admin', @documentCode_out = null ", [
                            auth()->user('user')->stationName['PortfolioCode'],
                            null,
                            $customerjobData['job_date_time'],
                            $this->job_number,
                            "J",
                            $this->job_number,
                            "0",
                            $this->job_number,
                            auth()->user('user')->station_code,
                            $propertyCodeMR,
                            $unitCodeMR,
                             "1",
                             "admin",
                             null
                        ]);

                    $meterialRequestResponse = json_encode($meterialRequestResponse[0],true);
                    $meterialRequestResponse = json_decode($meterialRequestResponse,true);
                    CustomerJobCards::where(['id'=>$customerjobId])->update(['meterialRequestResponse'=>$meterialRequestResponse['refCode']]);

                    /*'division_code'=>"LL/00004",
                    'department_code'=>"PP/00037",
                    'section_code'=>"U-000225",*/


                } catch (\Exception $e) {
                    //dd($e->getMessage());
                    //return $e->getMessage();
                }


            }
        }
        else
        {
            if($passmetrialRequest==true )
            {
                try {
                    $meterialRequestResponseNew = DB::select('EXEC [Inventory].[MaterialRequisition.Update.Operation] @companyCode = ?, @documentCode = ?, @documentDate = ?, @SessionId = ?, @sourceType = ?, @sourceCode = ?, @locationId = ?, @referenceNo = ?, @LandlordCode = ?, @propertyCode = ?, @UnitCode = ?, @IsApprove = ?, @doneby = ?, @documentCode_out = ? ', [
                            auth()->user('user')->stationName['PortfolioCode'],
                            $this->jobDetails->meterialRequestResponse,
                            $this->jobDetails->job_date_time,
                            $this->job_number,
                            "J",
                            $this->job_number,
                            "0",
                            $this->job_number,
                            auth()->user('user')->station_code,
                            $propertyCodeMR,
                            $unitCodeMR,
                             "1",
                             "admin",
                             null
                        ]);

                    $meterialRequestResponseNew = json_encode($meterialRequestResponseNew[0],true);
                    $meterialRequestResponseNew = json_decode($meterialRequestResponseNew,true);
                    CustomerJobCards::where(['job_number'=>$this->job_number])->update(['meterialRequestResponse'=>$meterialRequestResponseNew['refCode']]);

                    /*'division_code'=>"LL/00004",
                    'department_code'=>"PP/00037",
                    'section_code'=>"U-000225",*/


                } catch (\Exception $e) {
                    //dd($e->getMessage());
                    //return $e->getMessage();
                }
            }
            else if($this->jobDetails->meterialRequestResponse)
            {
                
            }
        }
        
  
        TempCustomerSignature::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->vehicle_id,'is_active'=>1])->delete();
        $this->customerSignature=null;

        $this->showCheckList=false;
        $this->showvehicleImage=false;
        $this->showTermsandCondition=false;
        $this->showCheckout =false;
        $this->showSignaturePad=false;
        $this->customerSignature=null;
        
    }

    public function sendPaymentLink($customerjobs)
    {
        $exp_date = Carbon::now('+10:00')->format('Y-m-d\TH:i:s\Z');
        $order_billing_name = $customerjobs->customerInfo['TenantName'];
        $order_billing_phone = $customerjobs->customerInfo['Mobile'];
        if($customerjobs->customerInfo['Email']==''){
            $order_billing_email = 'it.web@buhaleeba.ae';
        }else{
            $order_billing_email = $customerjobs->customerInfo['Email'];
        }
        $total = custom_round(($customerjobs->grand_total));
        $merchant_reference = $customerjobs->job_number;
        $order_billing_phone = str_replace(' ', '', $order_billing_phone);
        /*dd(str_replace(" ","",$order_billing_phone));
        if($order_billing_phone[0] != 0 and $order_billing_phone[1] != 0)
        {
            if($order_billing_phone[0] == '+')
            {
                $order_billing_phone = substr_replace($order_billing_phone, '00', 0, 1);
            }
            else
            {
               $order_billing_phone = preg_replace('/0/', '00971', $order_billing_phone, 1);
            }
        }*/
        $order_billing_phone = "00971".$order_billing_phone;

        /*$arrData    = [
            'service_command'=>'PAYMENT_LINK',
            'access_code'=>'CIjX6aY6Yc0FgGktyo4I',
            'merchant_identifier'=>'WQNoWgPx',
            'merchant_reference'=>$merchant_reference,
            'amount'=>$total,
            'currency'=>'AED',
            'language'=>'en',
            'customer_email'=>$order_billing_email,
            'request_expiry_date'=>$exp_date,
            'notification_type'=>'EMAIL,SMS',
            'order_description'=>'GSS Service #'.$merchant_reference,
            'customer_name'=>$order_billing_name,
            'customer_phone'=>$order_billing_phone,
            'return_url'=>url('order-response'),
        ];*/

        $arrData = [
                "paymnet_link_expiry"=>Carbon::now()->addDays(1)->format('Y-m-d H:i:s'),
                "amount"=>$total,
                //"amount"=>1,
                "emailAddress"=>isset($order_billing_email)?$order_billing_email:'it.web@buhaleeba.ae',
                "firstName"=>$order_billing_name,
                "customer_mobile"=>$order_billing_phone,
                "lastName"=>$order_billing_name,
                "address1"=>"Dubai",
                "city"=>"Bur Dubai",
                "countryCode"=>"UAE",
                "orderReference"=>$merchant_reference,
                "description"=>"GSS Service #".$merchant_reference,
                "station"=>$customerjobs->stationInfo['StationID'],
            ];
            //dd(json_encode($arrData));
            //dd(config('global.paymenkLink_payment_url'));
        $response = Http::withBasicAuth('onlinewebtutor', 'admin123')->post(config('global.paymenkLink_payment_url'),$arrData);
        //dd($response);
        return $response;
    }

    public function payLater()
    {
        $this->createJobEntry();
        CustomerJobCards::where(['job_number'=>$this->job_number])->update(['job_create_status'=>0]);
        CustomerServiceCart::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->vehicle_id])->delete();
        $this->successPage=true;
        $this->showCheckout =false;
        $this->cardShow=false;
        $this->showServiceGroup=false;
        $this->showPayLaterCheckout=false;
        $this->selectedCustomerVehicle=false;
    }

    public function dashCustomerJobUpdate($job_number)
    {
        return redirect()->to('/customer-job-update/'.$job_number);
    }
}
