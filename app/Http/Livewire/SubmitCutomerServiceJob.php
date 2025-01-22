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

class SubmitCutomerServiceJob extends Component
{
    public $customer_id, $vehicle_id, $mobile, $name, $email, $selectedVehicleInfo;
    public $selectedCustomerVehicle=true, $showCheckout=true, $successPage=false, $showCheckList=false, $showQLCheckList=false, $showFuelScratchCheckList=false;
    public $cartItemCount, $cartItems=[], $job_number, $total, $totalAfterDisc, $grand_total, $tax, $vImageR1, $vImageR2, $vImageF, $vImageB, $vImageL1, $vImageL2, $customerSignature, $checklistLabels = [], $checklistLabel = [], $fuel, $scratchesFound, $scratchesNotFound;
    public $turn_key_on_check_for_fault_codes, $start_engine_observe_operation, $reset_the_service_reminder_alert, $stick_update_service_reminder_sticker_on_b_piller, $interior_cabin_inspection_comments, $check_power_steering_fluid_level, $check_power_steering_tank_cap_properly_fixed, $check_brake_fluid_level, $brake_fluid_tank_cap_properly_fixed, $check_engine_oil_level, $check_radiator_coolant_level, $check_radiator_cap_properly_fixed, $top_off_windshield_washer_fluid, $check_windshield_cap_properly_fixed, $underHoodInspectionComments, $check_for_oil_leaks_engine_steering, $check_for_oil_leak_oil_filtering, $check_drain_lug_fixed_properly, $check_oil_filter_fixed_properly, $ubi_comments;

    function mount( Request $request) {
        $this->customer_id = $request->customer_id;
        $this->vehicle_id = $request->vehicle_id;
        if($this->vehicle_id && $this->customer_id)
        {
            $this->getCustomerCart();
            $this->selectVehicle();
        }

    }

    public function render()
    {
        if($this->showCheckList)
        {
            $this->showFuelScratchCheckList=true;

        }
        return view('livewire.submit-cutomer-service-job');
    }

    public function getCustomerCart(){
        $customerServiceCartQuery = CustomerServiceCart::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->vehicle_id]);
        $this->cartItemCount = $customerServiceCartQuery->count();
        if($this->cartItemCount>0){
            $this->cartItems = $customerServiceCartQuery->get();

            $total=0;
            $totalDiscount=0;
            $serviceIncludeArray=[];
            $gsQlIn = false;
            $discountApply=false;
            foreach($this->cartItems as $item)
            {
                $total = $total+($item->quantity*$item->unit_price);
                if($item->discount_perc){
                    $discountApply=true;
                    $discountGroupId = $item->customer_group_id;
                    $discountGroupCode = $item->customer_group_code;
                    $discountGroupDiscountPercentage = $item->discount_perc;
                    $discountGroupPrice = $item->customer_id;
                    $totalDiscount = $totalDiscount+round((($item->discount_perc/100)*($item->unit_price*$item->quantity)),2);
                }
                if($item->department_name=='Quick Lube'  || $item->department_name=='General Service')
                {
                    $this->showCheckout =false;
                    $this->showCheckList=true;
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
        return redirect()->to('customer-service-job/'.$this->customer_id.'/'.$this->vehicle_id);
    }

    public function completePaymnet($mode){
        if($this->job_number==Null){
            $this->createJob();
        }
        $job_number = $this->job_number;
        
        $customerjobs = CustomerJobCards::with(['customerInfo','customerVehicle','stationInfo'])->where(['job_number'=>$this->job_number])->first();
        //dd($customerjobs->customerInfo['Mobile']);
        $mobileNumber = isset($customerjobs->customerInfo['Mobile'])?'971'.substr($customerjobs->customerInfo['Mobile'], -9):null;
        //dd($mobileNumber);
        //$mobileNumber = substr($customerjobs->mobile, -9);
        $paymentmode = null;
        if($mode=='link')
        {
            $paymentmode = "O";
            $paymentLink = $this->sendPaymentLink($customerjobs);
            $paymentResponse = json_decode((string) $paymentLink->getBody()->getContents(), true);
            $merchant_reference = $paymentResponse['merchant_reference'];
            //dd($merchant_reference);
            if(array_key_exists('payment_redirect_link', $paymentResponse))
            {
                //dd(SMS_URL."?user=".SMS_PROFILE_ID."&pwd=".SMS_PASSWORD."&senderid=".SMS_SENDER_ID."&CountryCode=971&mobileno=".$mobileNumber."&msgtext=".urlencode('Job Id #'.$job_number.' is processing, Please click complete payment '.$paymentResponse['payment_redirect_link']));
                if($customerjobs->customerInfo['Mobile']!=''){
                    //$response = Http::get("https://mshastra.com/sendurlcomma.aspx?user=20092622&pwd=buhaleeba@123&senderid=BuhaleebaRE&mobileno=".$mobileNumber."&msgtext=".urlencode('Job Id #'.$job_number.' is processing, Please click complete payment '.$paymentResponse['payment_redirect_link'])."&CountryCode=ALL");
                }

                $customerjobId = CustomerJobCards::where(['job_number'=>$job_number])->update(['payment_type'=>1,'payment_link'=>$paymentResponse['payment_redirect_link'],'payment_response'=>json_encode($paymentResponse),'payment_request'=>'link_send','job_create_status'=>1]);

                CustomerServiceCart::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->selected_vehicle_id])->delete();

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
            $customerjobId = CustomerJobCards::where(['job_number'=>$job_number])->update(['payment_type'=>2,'payment_request'=>'card payment','job_create_status'=>1]);
            if($customerjobs->customerInfo['Mobile']!=''){
                //$response = Http::get("https://mshastra.com/sendurlcomma.aspx?user=20092622&pwd=buhaleeba@123&senderid=BuhaleebaRE&mobileno=".$mobileNumber."&msgtext=".urlencode('Job Id #'.$job_number.' is processing, Complete your payment and proceed. Visit '.url('qr/'.$job_number).' for the updates and gate pass')."&CountryCode=ALL");
            }

            CustomerServiceCart::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->vehicle_id])->delete();

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
            $customerjobId = CustomerJobCards::where(['job_number'=>$job_number])->update(['payment_type'=>3,'payment_request'=>'cash payment','job_create_status'=>1]);

            if($customerjobs->customerInfo['Mobile']!=''){
                //$response = Http::get("https://mshastra.com/sendurlcomma.aspx?user=20092622&pwd=buhaleeba@123&senderid=BuhaleebaRE&mobileno=".$mobileNumber."&msgtext=".urlencode('Job Id #'.$job_number.' is processing, Visit '.url('qr/'.$job_number).' for the updates and gate pass')."&CountryCode=ALL");
            }

            CustomerServiceCart::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->selected_vehicle_id])->delete();

            $this->successPage=true;
            $this->showCheckout =false;
            $this->cardShow=false;
            $this->showServiceGroup=false;
            $this->showPayLaterCheckout=false;
            $this->selectedCustomerVehicle=false;
        }
        try {
            //DB::select('EXEC [dbo].[CreateFinancialEntries_Operation] @jobnumber = "'.$job_number.'", @doneby = "'.Session::get('user')->id.'", @stationcode  = "'.Session::get('user')->station_code.'", @paymentmode = "'.$paymentmode.'", @customer_id = "'.$customerjobs->customer_id.'" ');
        } catch (\Exception $e) {
            //return $e->getMessage();
        }


    }

    public function createJob(){

        $total=0;
        $totalDiscount=0;
        $serviceIncludeArray=[];
        $gsQlIn = false;
        $discountApply=false;
        foreach($this->cartItems as $item)
        {

            $total = $total+($item->quantity*$item->unit_price);
            if($item->discount_perc){
                //dd($item);
                $discountApply=true;
                $discountGroupId = $item->customer_group_id;
                $discountGroupCode = $item->customer_group_code;
                $discountGroupDiscountPercentage = $item->discount_perc;
                $discountGroupPrice = $item->customer_id;
                $totalDiscount = $totalDiscount+round((($item->discount_perc/100)*($item->unit_price*$item->quantity)),2);
            }
            if($item->department_code=='PP/00036'  || $item->department_code=='PP/00037')
            {
                //$gsQlIn=true;
            }
        }
        if($gsQlIn==true)
        {
            /*$validatedData = $this->validate([
                'fuel' => 'required',
                'scratchesFound' => 'required',
                'scratchesNotFound' => 'required',
                'vImageR1' => 'required',
                'vImageR2' => 'required',
                'vImageF' => 'required',
                'vImageB' => 'required',
                'vImageL1' => 'required',
                'vImageL2' => 'required',
            ]);*/

            //$checkListEntryInsert = JobcardChecklistEntries::create($checkListEntryData);

            $this->showCheckList=false;
        }
        $totalAfterDisc = $total - $totalDiscount;
        $tax = $totalAfterDisc * (config('global.TAX_PERCENT') / 100);
        $grand_total = $totalAfterDisc+$tax;
        
        $this->tax = $tax;
        $this->grand_total = $grand_total;
        $customerjobData = [
            'job_number'=>Carbon::now()->format('y').Carbon::now()->format('m').Carbon::now()->format('d').rand(1,1000),
            'job_date_time'=>Carbon::now(),
            'customer_id'=>$this->customer_id,
            //'customer_type'=>$this->customer_type,
            'vehicle_id'=>$this->selectedVehicleInfo['id'],
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
            'total_price'=>$total,
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
        if($discountApply)
        {
            //$customerjobData['customer_discount_id']=$this->customerSelectedDiscountGroup['id'];
            $customerjobData['discount_id']=$discountGroupId;
            $customerjobData['discount_unit_id']=$discountGroupId;
            $customerjobData['discount_code']=$discountGroupCode;
            $customerjobData['discount_title']=$discountGroupCode;
            $customerjobData['discount_percentage']=$discountGroupDiscountPercentage;
            $customerjobData['discount_amount']=$totalDiscount;
        }
        //dd($customerjobData);
        $customerjobId = CustomerJobCards::create($customerjobData);
        $stationJobNumber = CustomerJobCards::where(['station'=>Session::get('user')->station_code])->count();
        $this->job_number = 'JOB-'.Session::get('user')->stationName['Abbreviation'].'-'.sprintf('%08d', $stationJobNumber+1);
        CustomerJobCards::where(['id'=>$customerjobId->id])->update(['job_number'=>$this->job_number]);

        $meterialRequestItems=[];
        $passmetrialRequest = false;
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
        if(!empty($this->checklistLabel))
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
            Session::get('user')->stationName['PortfolioCode'];
            try {
                $meterialRequestResponse = DB::select("EXEC [Inventory].[MaterialRequisition.Update] @companyCode = 'PF/00001', @documentCode = null, @documentDate = '".$customerjobData['job_date_time']."', @SessionId = '".$this->job_number."', @sourceType = 'J', @sourceCode = '".$this->job_number."', @locationId = '0', @referenceNo = '".$this->job_number."', @LandlordCode = '".Session::get('user')->station_code."', @propertyCode = '".$propertyCodeMR."', @UnitCode = '".$unitCodeMR."', @IsApprove = '1', @doneby = 'admin', @documentCode_out = null ");

                dd($meterialRequestResponse);

                /*'division_code'=>"LL/00004",
                'department_code'=>"PP/00037",
                'section_code'=>"U-000225",*/


            } catch (\Exception $e) {
                //return $e->getMessage();
            }
        }


        $this->showCheckList=false;
        $this->showCheckout =true;


    }

    public function sendPaymentLink($customerjobs)
    {
        //dd($customerjobs);
        $exp_date = Carbon::now('+10:00')->format('Y-m-d\TH:i:s\Z');
        $order_billing_name = $customerjobs->customerInfo['TenantName'];
        $order_billing_phone = $customerjobs->customerInfo['Mobile'];
        $order_billing_email = $customerjobs->customerInfo['Email']; 
        $total = round(($customerjobs->grand_total),2);
        $merchant_reference = $customerjobs->job_number;
        $order_billing_phone = str_replace(' ', '', $order_billing_phone);
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
        }

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
                "emailAddress"=>$order_billing_email,
                "firstName"=>$order_billing_name,
                "customer_mobile"=>$order_billing_phone,
                "lastName"=>$order_billing_name,
                "address1"=>"Dubai",
                "city"=>"Bur Dubai",
                "countryCode"=>"UAE",
                "orderReference"=>$merchant_reference,
                "description"=>"GSS Service #".$merchant_reference,
                "station"=>3,
            ];
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
        CustomerServiceCart::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->selected_vehicle_id])->delete();
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
