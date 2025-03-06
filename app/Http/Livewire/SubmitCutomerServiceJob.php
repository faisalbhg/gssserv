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
use App\Models\CustomerJobCardLive;
use App\Models\CustomerJobCardServices;
use App\Models\CustomerJobCardServiceLogs;
use App\Models\MaterialRequest;
use App\Models\WorkOrderJob;
use App\Models\JobcardChecklistEntries;
use App\Models\ServiceChecklist;
use App\Models\PackageBookings;
use App\Models\PackageBookingServices;
use App\Models\PackageBookingServiceLogs;

class SubmitCutomerServiceJob extends Component
{
    use WithFileUploads;
    public $customer_id, $vehicle_id, $mobile, $name, $email, $selectedVehicleInfo;
    public $selectedCustomerVehicle=true, $showCheckout=true, $successPage=false, $showCheckList=false, $showQLCheckList=false, $showFuelScratchCheckList=false, $showCustomerSignature=false, $discountApply=false;
    public $cartItemCount, $cartItems=[], $job_number, $total, $totalAfterDisc, $grand_total, $tax, $vImageR1, $vImageR2, $vImageF, $vImageB, $vImageL1, $vImageL2, $customerSignature, $checklistLabels = [], $checklistLabel = [], $fuel, $scratchesFound, $scratchesNotFound;
    public $turn_key_on_check_for_fault_codes, $start_engine_observe_operation, $reset_the_service_reminder_alert, $stick_update_service_reminder_sticker_on_b_piller, $interior_cabin_inspection_comments, $check_power_steering_fluid_level, $check_power_steering_tank_cap_properly_fixed, $check_brake_fluid_level, $brake_fluid_tank_cap_properly_fixed, $check_engine_oil_level, $check_radiator_coolant_level, $check_radiator_cap_properly_fixed, $top_off_windshield_washer_fluid, $check_windshield_cap_properly_fixed, $underHoodInspectionComments, $check_for_oil_leaks_engine_steering, $check_for_oil_leak_oil_filtering, $check_drain_lug_fixed_properly, $check_oil_filter_fixed_properly, $ubi_comments;
    public $staff_id,$staff_number,$show_staff_details=false;

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
            $this->dispatchBrowserEvent('scrollto', [
                'scrollToId' => 'checkoutSignature',
            ]);
        }
        return view('livewire.submit-cutomer-service-job');
    }

    public function customerJobDetails(){
        //dd(JobcardChecklistEntries::where(['job_number'=>'JOB-GWW-00000028'])->get());
        $customerJobCardsQuery = CustomerJobCards::with(['customerInfo','customerJobServices','checklistInfo','makeInfo','modelInfo']);
        $customerJobCardsQuery = $customerJobCardsQuery->where(['job_number'=>$this->job_number]);
        $this->jobDetails =  $customerJobCardsQuery->first();
        //dd($this->jobDetails);
        $this->showFuelScratchCheckList=true;
        $this->checklistEntry = JobcardChecklistEntries::where(['job_number'=>$this->job_number])->first();
        //dd($this->checklistEntry);
        if($this->checklistEntry){
            //dd($this->checklistEntry);
            $this->checklistLabel = json_decode($this->checklistEntry->checklist,true);
            $this->fuel = $this->checklistEntry->fuel;
            $this->vehicle_image = json_decode($this->checklistEntry->vehicle_image,true);
            /*$this->vImageR1 = $this->vehicle_image['vImageR1'];
            $this->vImageR2 = $this->vehicle_image['vImageR1'];
            $this->vImageF = $this->vehicle_image['vImageF'];
            $this->vImageB = $this->vehicle_image['vImageB'];
            $this->vImageL1 = $this->vehicle_image['vImageL1'];
            $this->vImageL2 = $this->vehicle_image['vImageL2'];*/
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

    public function getCustomerCart(){
        $customerServiceCartQuery = CustomerServiceCart::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->vehicle_id]);
        if($this->job_number)
        {
            $customerServiceCartQuery = $customerServiceCartQuery->where(['job_number'=>$this->job_number]);
        }
        $this->cartItemCount = $customerServiceCartQuery->count();
        if($this->cartItemCount>0){
            $this->cartItems = $customerServiceCartQuery->get();
            
            $total=0;
            $totalDiscount=0;
            $serviceIncludeArray=[];
            $gsQlIn = false;
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
                if($item->department_name=='Quick Lube'  || $item->department_name=='General Service')
                {
                    $this->showCheckout =false;
                    $this->showCheckList=true;
                    $this->dispatchBrowserEvent('imageUpload');
                }
            }
            $this->total = $total;
            $this->totalAfterDisc = $this->total - $totalDiscount;
            $this->tax = $this->totalAfterDisc * (config('global.TAX_PERCENT') / 100);
            $this->grand_total = $this->totalAfterDisc+$this->tax;
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
            $validatedData = $this->validate([
                'staff_id' => 'required',
                'staff_number' => 'required'
            ]);
        }
        

        $this->showCustomerSignature=true;
        $this->dispatchBrowserEvent('showSignature');

    }

    public function completePaymnet($mode){
        $this->createJob();
        $this->job_number;
        
        $customerjobs = CustomerJobCards::with(['customerInfo','customerVehicle','stationInfo'])->where(['job_number'=>$this->job_number])->first();
        //$mobileNumber = isset($customerjobs->customerInfo['Mobile'])?'971'.substr($customerjobs->customerInfo['Mobile'], -9):null;
        $mobileNumber = isset(auth()->user('user')->phone)?'971'.substr(auth()->user('user')->phone, -9):null;
        $customerName = isset($customerjobs->customerInfo['TenantName'])?$customerjobs->customerInfo['TenantName']:null;
        $plate_number = $customerjobs->plate_number;
        //dd($mobileNumber);
        //$mobileNumber = substr($customerjobs->mobile, -9);
        $paymentmode = null;
        if($mode=='link')
        {
            $paymentmode = "O";
            $paymentLink = $this->sendPaymentLink($customerjobs);
            //dd($paymentLink);
            $paymentResponse = json_decode((string) $paymentLink->getBody()->getContents(), true);
            //dd($paymentResponse);
            $merchant_reference = $paymentResponse['merchant_reference'];
            //dd($merchant_reference);
            if(array_key_exists('payment_redirect_link', $paymentResponse))
            {
                //dd(SMS_URL."?user=".SMS_PROFILE_ID."&pwd=".SMS_PASSWORD."&senderid=".SMS_SENDER_ID."&CountryCode=971&mobileno=".$mobileNumber."&msgtext=".urlencode('Job Id #'.$this->job_number.' is processing, Please click complete payment '.$paymentResponse['payment_redirect_link']));
                if($customerjobs->customerInfo['Mobile']!=''){
                    //if($mobileNumber=='971566993709'){
                        $msgtext = urlencode('Dear '.$customerName.', we have received your vehicle '.$plate_number.' Job No. '.$this->job_number.' at '.auth()->user('user')->stationName['CorporateName'].'. Our team will update you shortly. To avoid waiting at the cashier, you can pay online using this link: '.$paymentResponse['payment_redirect_link'].'.  Alternatively, you can pay at the cashier via card or cash. https://gsstations.ae/qr/'.$this->job_number.' get your vehicle service status, For assistance, call 800477823.');
                        $response = Http::get(config('global.sms')[1]['sms_url']."&mobileno=".$mobileNumber."&msgtext=".$msgtext."&CountryCode=ALL");
                    //}
                }

                $customerjobId = CustomerJobCards::where(['job_number'=>$this->job_number])->update(['payment_type'=>1,'payment_link'=>$paymentResponse['payment_redirect_link'],'payment_response'=>json_encode($paymentResponse),'payment_request'=>'link_send','job_create_status'=>1]);

                CustomerServiceCart::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->vehicle_id])->delete();

                $this->successPage=true;
                $this->showCheckout =false;
                $this->cardShow=false;
                $this->showServiceGroup=false;
                $this->showPayLaterCheckout=false;
                $this->selectedCustomerVehicle=false;
                
            }
            else
            {
                session()->flash('error', $paymentResponse['response_message']);

            }
            
        }
        else if($mode=='card')
        {
            $paymentmode = "O";
            $customerjobId = CustomerJobCards::where(['job_number'=>$this->job_number])->update(['payment_type'=>2,'payment_request'=>'card payment','job_create_status'=>1]);
            if($customerjobs->customerInfo['Mobile']!=''){
                //if($mobileNumber=='971566993709'){
                    $msgtext = urlencode('Dear '.$customerName.', we have received your vehicle '.$plate_number.' Job No. '.$this->job_number.' at '.auth()->user('user')->stationName['CorporateName'].'. Our team will update you shortly. You can pay at the cashier via card or cash. https://gsstations.ae/qr/'.$this->job_number.' get your vehicle service status, For assistance, call 800477823.');
                    $response = Http::get(config('global.sms')[1]['sms_url']."&mobileno=".$mobileNumber."&msgtext=".$msgtext."&CountryCode=ALL");
                //}
            }

            

            $this->successPage=true;
            $this->showCheckout =false;
            $this->cardShow=false;
            $this->showServiceGroup=false;
            $this->showPayLaterCheckout=false;
            $this->selectedCustomerVehicle=false;
            
        }
        else if($mode=='cash')
        {
            $paymentmode = "C";
            $customerjobId = CustomerJobCards::where(['job_number'=>$this->job_number])->update(['payment_type'=>3,'payment_request'=>'cash payment','job_create_status'=>1]);

            if($customerjobs->customerInfo['Mobile']!=''){
                //if($mobileNumber=='971566993709'){
                    $msgtext = urlencode('Dear '.$customerName.', we have received your vehicle '.$plate_number.' Job No. '.$this->job_number.' at '.auth()->user('user')->stationName['CorporateName'].'. Our team will update you shortly. You can pay at the cashier via card or cash. https://gsstations.ae/qr/'.$this->job_number.' get your vehicle service status, For assistance, call 800477823.');
                    $response = Http::get(config('global.sms')[1]['sms_url']."&mobileno=".$mobileNumber."&msgtext=".$msgtext."&CountryCode=ALL");
                //}
            }

            

            $this->successPage=true;
            $this->showCheckout =false;
            $this->cardShow=false;
            $this->showServiceGroup=false;
            $this->showPayLaterCheckout=false;
            $this->selectedCustomerVehicle=false;
        }
        else if($mode=='empty')
        {
            $customerjobId = CustomerJobCards::where(['job_number'=>$this->job_number])->update(['payment_type'=>6,'payment_status'=>1,'payment_request'=>'package','job_create_status'=>1]);

            if($customerjobs->customerInfo['Mobile']!=''){
                //if($mobileNumber=='971566993709'){
                    $msgtext = urlencode('Dear '.$customerName.', we have received your vehicle '.$plate_number.' Job No. '.$this->job_number.' at '.auth()->user('user')->stationName['CorporateName'].'. Our team will update you shortly. You can pay at the cashier via card or cash. https://gsstations.ae/qr/'.$this->job_number.' get your vehicle service status, For assistance, call 800477823.');
                    $response = Http::get(config('global.sms')[1]['sms_url']."&mobileno=".$mobileNumber."&msgtext=".$msgtext."&CountryCode=ALL");
                //}
            }
            

            

            $this->successPage=true;
            $this->showCheckout =false;
            $this->cardShow=false;
            $this->showServiceGroup=false;
            $this->showPayLaterCheckout=false;
            $this->selectedCustomerVehicle=false;
        }

        $customerServiceCartQuery = CustomerServiceCart::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->vehicle_id,'job_number'=>$this->job_number]);
        if($customerServiceCartQuery->exists()){
            $customerServiceCartQuery = $customerServiceCartQuery->delete();
        }
        else
        {
            CustomerServiceCart::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->vehicle_id])->delete();
        }

        


    }

    

    public function createJob(){
        $job_update = false;
        if($this->job_number){
            $job_update = true;
            MaterialRequest::where(['sessionId'=>$this->job_number])->delete();
        }
        $customerjobData = [
            
            'job_date_time'=>Carbon::now(),
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
        if($this->job_number)
        {
            $customerjobData['updated_by']=auth()->user('user')->id;
            CustomerJobCards::where(['job_number'=>$this->job_number])->update($customerjobData);
            CustomerJobCardLive::where(['job_number'=>$this->job_number])->update($customerjobData);

            $customerjobId = $this->jobDetails->id;
        }
        else
        {
            $customerjobData['created_by']=auth()->user('user')->id;
            $createdCustomerJob = CustomerJobCards::create($customerjobData);
            $createdCustomerJobLive = CustomerJobCardLive::create($customerjobData);
            $customerjobId = $createdCustomerJob->id;
            $customerjobIdLive = $createdCustomerJobLive->id;
            $stationJobNumber = CustomerJobCards::where(['station'=>auth()->user('user')->station_code])->count();
            $this->job_number = 'JOB-'.auth()->user('user')->stationName['Abbreviation'].'-'.sprintf('%08d', $stationJobNumber+1);
            CustomerJobCards::where(['id'=>$customerjobId])->update(['job_number'=>$this->job_number]);
            CustomerJobCardLive::where(['id'=>$customerjobIdLive])->update(['job_number'=>$this->job_number]);
        }
        
        

        $meterialRequestItems=[];
        $passmetrialRequest = false;
        $totalDiscountInJob=0;
        $is_package=false;
        $package_code=null;
        $package_number=null;
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
            if($cartData->cart_item_type==3){
                $customerJobServiceData['is_package']=1;
                $customerJobServiceData['package_number']=$cartData->package_number;
                $customerJobServiceData['package_code']=$cartData->package_code;
            }

            
            $total = $cartData->unit_price*$cartData->quantity;
            $totalAfterDisc = $total - $customerJobServiceDiscountAmount;
            $tax = $totalAfterDisc * (config('global.TAX_PERCENT') / 100);
            $grand_total = $totalAfterDisc+$tax;

            $customerJobServiceData['total_price']=$cartData->unit_price;
            $customerJobServiceData['quantity']=$cartData->quantity;
            $customerJobServiceData['vat']=$tax;
            $customerJobServiceData['grand_total']=$grand_total;

            if($job_update==true){
                $customerJobServiceData['updated_by']=auth()->user('user')->id;
                $customerJobServiceQuery = CustomerJobCardServices::where([
                    'job_number'=>$this->job_number,
                    'job_id'=>$customerjobId,
                    'item_id'=>$cartData->item_id,
                    'item_code'=>$cartData->item_code,
                ]);
                if($customerJobServiceQuery->exists()){
                    $customerJobServiceQuery->update($customerJobServiceData);
                    $customerJobServiceId = $customerJobServiceQuery->first();    
                }
                else
                {
                    $customerJobServiceData['created_by']=auth()->user('user')->id;
                    $customerJobServiceId = CustomerJobCardServices::create($customerJobServiceData);
                }
                
            }
            else
            {
                $customerJobServiceData['created_by']=auth()->user('user')->id;
                $customerJobServiceId = CustomerJobCardServices::create($customerJobServiceData);
            }
            //dd($customerJobServiceId);
            
            CustomerJobCardServiceLogs::create([
                'job_number'=>$this->job_number,
                'job_status'=>1,
                'job_departent'=>1,
                'job_description'=>json_encode($customerJobServiceId),
                'customer_job__card_service_id'=>$customerJobServiceId->id,
                'created_by'=>auth()->user('user')->id,
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
                    'Activity2Code'=>auth()->user('user')->station_code
                ]);
            }


            if($cartData->cart_item_type==3){
                //dd(PackageBookings::with(['customerPackageServices'])->where(['customer_id'=>$cartData->customer_id,'package_code'=>$cartData->customer_group_code])->first());
                PackageBookingServices::where([
                    'item_id'=>$cartData->item_id,
                    'item_code'=>$cartData->item_code,
                    'package_code'=>$cartData->customer_group_code,
                ])->update([
                    'package_service_use_count'=>$cartData->quantity
                ]);

                $is_package=true;
                $package_code=$cartData->package_code;
                $package_number=$cartData->package_number;

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
            ];
            if($job_update==true){
                $checkListEntryData['updated_by']=auth()->user('user')->id;
                $checkListEntryInsert = JobcardChecklistEntries::where(['job_number'=>$this->job_number])->update($checkListEntryData);
            }
            else
            {
                $checkListEntryData['job_number']=$this->job_number;
                $checkListEntryData['job_id']=$customerjobId;
                $checkListEntryData['created_by']=auth()->user('user')->id;

                $checkListEntryInsert = JobcardChecklistEntries::create($checkListEntryData);
            }
        }

        if($job_update!=true){

            if($is_package==true)
            {
                try {
                    DB::select('EXEC [ServicePackage.Redeem.FinancialEntries] @jobnumber = "'.$this->job_number.'", @packagenumber = "'.$package_number.'", @doneby = "'.auth()->user('user')->id.'" ');
                } catch (\Exception $e) {
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
            try {
                $meterialRequestResponse = DB::select('EXEC [Inventory].[MaterialRequisition.Update.Operation] @companyCode = ?, @documentCode = ?, @documentDate = ?, @SessionId = ?, @sourceType = ?, @sourceCode = ?, @locationId = ?, @referenceNo = ?, @LandlordCode = ?, @propertyCode = ?, @UnitCode = ?, @IsApprove = ?, @doneby = ?, @documentCode_out = ? ', [
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

                $meterialRequestResponse = json_encode($meterialRequestResponse[0],true);
                $meterialRequestResponse = json_decode($meterialRequestResponse,true);
                CustomerJobCards::where(['job_number'=>$this->job_number])->update(['meterialRequestResponse'=>$meterialRequestResponse['refCode']]);

                /*'division_code'=>"LL/00004",
                'department_code'=>"PP/00037",
                'section_code'=>"U-000225",*/


            } catch (\Exception $e) {
                //dd($e->getMessage());
                //return $e->getMessage();
            }
        }
        
        

        


        $this->showCheckList=false;
        $this->showCheckout =true;


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
        if($this->job_number==Null){
            $this->createJob();
        }
        CustomerJobCards::where(['job_number'=>$this->job_number])->update(['job_create_status'=>0]);
        CustomerServiceCart::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->vehicle_id])->delete();
        $this->successPage=true;
        $this->showCheckout =false;
        $this->cardShow=false;
        $this->showServiceGroup=false;
    }

    public function dashCustomerJobUpdate($job_number)
    {
        return redirect()->to('/customer-job-update/'.$job_number);
    }
}
