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

use App\Models\TempCustomerServiceCart;
use App\Models\CustomerServiceCart;
use App\Models\CustomerVehicle;
use App\Models\CustomerJobCards;
use App\Models\CustomerJobCardServices;
use App\Models\CustomerJobCardServiceLogs;
use App\Models\MaterialRequest;
use App\Models\WorkOrderJob;
use App\Models\JobcardChecklistEntries;
use App\Models\ServiceChecklist;

class UpdateJobCardSubmit extends Component
{

    use WithFileUploads;
    public $customer_id, $vehicle_id, $mobile, $name, $email, $selectedVehicleInfo;
    public $selectedCustomerVehicle=true, $showCheckout=true, $successPage=false, $showCheckList=false, $showQLCheckList=false, $showFuelScratchCheckList=false, $showCustomerSignature=false, $discountApply=false;
    public $cartItemCount, $cartItems=[], $job_number, $total, $totalAfterDisc, $grand_total, $tax, $vImageR1, $vImageR2, $vImageF, $vImageB, $vImageL1, $vImageL2, $customerSignature, $checklistLabels = [], $checklistLabel = [], $fuel, $scratchesFound, $scratchesNotFound;
    public $turn_key_on_check_for_fault_codes, $start_engine_observe_operation, $reset_the_service_reminder_alert, $stick_update_service_reminder_sticker_on_b_piller, $interior_cabin_inspection_comments, $check_power_steering_fluid_level, $check_power_steering_tank_cap_properly_fixed, $check_brake_fluid_level, $brake_fluid_tank_cap_properly_fixed, $check_engine_oil_level, $check_radiator_coolant_level, $check_radiator_cap_properly_fixed, $top_off_windshield_washer_fluid, $check_windshield_cap_properly_fixed, $underHoodInspectionComments, $check_for_oil_leaks_engine_steering, $check_for_oil_leak_oil_filtering, $check_drain_lug_fixed_properly, $check_oil_filter_fixed_properly, $ubi_comments;
    public $checklistEntry;

    function mount( Request $request) {
        $this->job_number = $request->job_number;
        if($this->job_number)
        {
            $this->customerJobDetails();
            $this->selectVehicle();
            $this->getTempCustomerCart();
        }

    }


    public function render()
    {
        if($this->showCheckList)
        {
            $this->showFuelScratchCheckList=true;
            $this->checklistEntry = JobcardChecklistEntries::where(['job_number'=>$this->job_number])->first();
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
            $this->checklistLabels= ServiceChecklist::get();

        }
        if($this->customerSignature){
            $this->dispatchBrowserEvent('scrollto', [
                'scrollToId' => 'checkoutSignature',
            ]);
        }
        $this->cartItems = TempCustomerServiceCart::where(['customer_id'=>$this->jobDetails->customer_id,'vehicle_id'=>$this->jobDetails->vehicle_id,'job_number'=>$this->job_number])->get();
        return view('livewire.update-job-card-submit');
    }

    public function getTempCustomerCart(){
        $customerServiceCartQuery = TempCustomerServiceCart::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->vehicle_id,'job_number'=>$this->job_number]);
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

    public function customerJobDetails(){
        $this->jobDetails = CustomerJobCards::with(['customerInfo','customerJobServices','checklistInfo','makeInfo','modelInfo','tempServiceCart','checklistInfo'])->where(['job_number'=>$this->job_number])->first();
        $this->customer_id = $this->jobDetails->customer_id;
        $this->vehicle_id = $this->jobDetails->vehicle_id;
    }

    public function selectVehicle(){
        $customers = CustomerVehicle::with(['customerInfoMaster','makeInfo','modelInfo','customerDiscountLists'])->where(['is_active'=>1,'id'=>$this->jobDetails->vehicle_id,'customer_id'=>$this->jobDetails->customer_id])->first();
        $this->selectedVehicleInfo=$customers;
    }

    public function updateServiceItem(){
        return redirect()->to('update_jobcard/'.$this->job_number);
    }

    public function clickShowSignature()
    {
        $this->showCustomerSignature=true;
        $this->dispatchBrowserEvent('showSignature');

    }
    public function completePaymnet($mode){
        $this->updateJob();

        
        //$mobileNumber = isset($this->selectedVehicleInfo->customerInfoMaster['Mobile'])?'971'.substr($this->selectedVehicleInfo->customerInfoMaster['Mobile'], -9):null;
        $mobileNumber = isset(auth()->user('user')->phone)?'971'.substr(auth()->user('user')->phone, -9):null;
        $paymentmode = null;
        if($mode=='link')
        {
            $paymentmode = "O";
            $paymentLink = $this->sendPaymentLink($this->jobDetails);
            $paymentResponse = json_decode((string) $paymentLink->getBody()->getContents(), true);
            $merchant_reference = $paymentResponse['merchant_reference'];
            //dd($merchant_reference);
            if(array_key_exists('payment_redirect_link', $paymentResponse))
            {
                //dd(SMS_URL."?user=".SMS_PROFILE_ID."&pwd=".SMS_PASSWORD."&senderid=".SMS_SENDER_ID."&CountryCode=971&mobileno=".$mobileNumber."&msgtext=".urlencode('Job Id #'.$job_number.' is processing, Please click complete payment '.$paymentResponse['payment_redirect_link']));
                $msgtext = urlencode('Dear '.$customerName.', we have received your vehicle '.$plate_number.' Job No. '.$job_number.' at '.auth()->user('user')->stationName['CorporateName'].'. Our team will update you shortly. To avoid waiting at the cashier, you can pay online using this link: '.$paymentResponse['payment_redirect_link'].'. Alternatively, you can pay at the cashier via card or cash. For assistance, call 800477823.');
                        $response = Http::get(config('global.sms')[1]['sms_url']."&mobileno=".$mobileNumber."&msgtext=".$msgtext."&CountryCode=ALL");

                $customerjobId = CustomerJobCards::where(['job_number'=>$this->job_number])->update(['payment_type'=>1,'payment_link'=>$paymentResponse['payment_redirect_link'],'payment_response'=>json_encode($paymentResponse),'payment_request'=>'link_send','job_create_status'=>1]);

                TempCustomerServiceCart::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->vehicle_id])->delete();

                $this->successPage=true;
                $this->showCheckout =false;
                $this->showCheckList =false;
                $this->selectedCustomerVehicle=false;
                $this->showCustomerSignature=false;
                
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
            if($mobileNumber!=null){
                //$response = Http::get("https://mshastra.com/sendurlcomma.aspx?user=20092622&pwd=buhaleeba@123&senderid=BuhaleebaRE&mobileno=".$mobileNumber."&msgtext=".urlencode('Job Id #'.$job_number.' is processing, Complete your payment and proceed. Visit '.url('qr/'.$job_number).' for the updates and gate pass')."&CountryCode=ALL");
            }

            CustomerServiceCart::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->vehicle_id])->delete();

            $this->successPage=true;
            $this->showCheckout =false;
            $this->showCheckList =false;
            $this->selectedCustomerVehicle=false;
            $this->showCustomerSignature=false;
            
        }
        else if($mode=='cash')
        {
            $paymentmode = "C";
            $customerjobId = CustomerJobCards::where(['job_number'=>$this->job_number])->update(['payment_type'=>3,'payment_request'=>'cash payment','job_create_status'=>1]);

            if($mobileNumber!=null){
                //$response = Http::get("https://mshastra.com/sendurlcomma.aspx?user=20092622&pwd=buhaleeba@123&senderid=BuhaleebaRE&mobileno=".$mobileNumber."&msgtext=".urlencode('Job Id #'.$job_number.' is processing, Visit '.url('qr/'.$job_number).' for the updates and gate pass')."&CountryCode=ALL");
            }

            CustomerServiceCart::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->vehicle_id])->delete();

            $this->successPage=true;
            $this->showCheckout =false;
            $this->showCheckList =false;
            $this->selectedCustomerVehicle=false;
            $this->showCustomerSignature=false;
        }
        try {
            //DB::select('EXEC [dbo].[CreateFinancialEntries_Operation] @jobnumber = "'.$job_number.'", @doneby = "'.auth()->user('user')->id.'", @stationcode  = "'.auth()->user('user')->station_code.'", @paymentmode = "'.$paymentmode.'", @customer_id = "'.$customerjobs->customer_id.'" ');
        } catch (\Exception $e) {
            //return $e->getMessage();
        }
    }
    public function updateJob(){
        //dd($this->jobDetails->job_date_time);
        //start temp cart loop
        $passmetrialRequest = false;
        $totalDiscountInJob=0;
        //dd($this->jobDetails->meterialRequestResponse);
        MaterialRequest::where([
                    'sessionId'=>$this->job_number
                ])->delete();
        foreach($this->cartItems as $cartData)
        {
            $getCustomerJobCardServiceQuery = CustomerJobCardServices::where(['job_number'=>$this->job_number,'item_id'=>$cartData->item_id,'item_code'=>$cartData->item_code]);
            if($getCustomerJobCardServiceQuery->exists())
            {
                $getCustomerJobCardServiceFirst = $getCustomerJobCardServiceQuery->first();
                //dd($getCustomerJobCardServiceFirst);
                $customerJobServiceDataUpdate = [
                    'is_updated'=>1,
                    'updated_by'=>auth()->user('user')->id,
                ];

                $customerJobServiceDiscountAmount=0;
                if($cartData->discount_perc){
                    
                    //$customerJobServiceData['customer_discount_id']=$this->customerSelectedDiscountGroup['id'];
                    $customerJobServiceDataUpdate['discount_id']=$cartData->customer_group_id;
                    $customerJobServiceDataUpdate['discount_unit_id']=$cartData->customer_group_id;
                    $customerJobServiceDataUpdate['discount_code']=$cartData->customer_group_code;
                    $customerJobServiceDataUpdate['discount_title']=$cartData->customer_group_code;
                    $customerJobServiceDataUpdate['discount_percentage'] = $cartData->discount_perc;
                    $customerJobServiceDiscountAmount = custom_round((($cartData->discount_perc/100)*($cartData->unit_price*$cartData->quantity)));
                    $customerJobServiceDataUpdate['discount_amount'] = $customerJobServiceDiscountAmount;
                    $customerJobServiceDataUpdate['discount_start_date']=$cartData->start_date;
                    $customerJobServiceDataUpdate['discount_end_date']=$cartData->end_date;
                    $totalDiscountInJob = $totalDiscountInJob+$customerJobServiceDiscountAmount;
                }


                $total = $cartData->unit_price*$cartData->quantity;
                $totalAfterDisc = $total - $customerJobServiceDiscountAmount;
                $tax = $totalAfterDisc * (config('global.TAX_PERCENT') / 100);
                $grand_total = $totalAfterDisc+$tax;

                $customerJobServiceDataUpdate['total_price']=$cartData->unit_price;
                $customerJobServiceDataUpdate['quantity']=$cartData->quantity;
                $customerJobServiceDataUpdate['vat']=$tax;
                $customerJobServiceDataUpdate['grand_total']=$grand_total;
                //dd($customerJobServiceData);
                $customerJobServiceUpdate = $getCustomerJobCardServiceQuery->update($customerJobServiceDataUpdate);

                CustomerJobCardServiceLogs::create([
                    'job_number'=>$this->job_number,
                    'job_status'=>1,
                    'job_departent'=>1,
                    'job_description'=>json_encode($customerJobServiceDataUpdate),
                    'customer_job__card_service_id'=>$getCustomerJobCardServiceFirst->id,
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

                

            }
            else
            {
                $customerJobServiceData = [
                    'job_number'=>$this->job_number,
                    'job_id'=>$this->jobDetails->id,
                    'job_status'=>1,
                    'job_departent'=>1,
                    'is_added'=>1,
                    'created_by'=>auth()->user('user')->id,
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

                
                $total = $cartData->unit_price*$cartData->quantity;
                $totalAfterDisc = $total - $customerJobServiceDiscountAmount;
                $tax = $totalAfterDisc * (config('global.TAX_PERCENT') / 100);
                $grand_total = $totalAfterDisc+$tax;

                $customerJobServiceData['total_price']=$cartData->unit_price;
                $customerJobServiceData['quantity']=$cartData->quantity;
                $customerJobServiceData['vat']=$tax;
                $customerJobServiceData['grand_total']=$grand_total;
                //dd($customerJobServiceData);
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
            }
        }

        //CustomerJobCardServices::where(['job_number'=>$this->job_number,'is_removed'=>1])->delete();

        //end temp cart loop
        $updateJobCardHeader = [
            'vehicle_type'=>isset($this->selectedVehicleInfo['vehicle_type'])?$this->selectedVehicleInfo['vehicle_type']:0,
            'make'=>$this->selectedVehicleInfo['make'],
            'vehicle_image'=>$this->selectedVehicleInfo['vehicle_image'],
            'model'=>$this->selectedVehicleInfo['model'],
            'plate_number'=>$this->selectedVehicleInfo['plate_number_final'],
            'chassis_number'=>$this->selectedVehicleInfo['chassis_number'],
            'vehicle_km'=>$this->selectedVehicleInfo['vehicle_km'],
            'total_price'=>$this->total,
            'vat'=>$this->tax,
            'grand_total'=>$this->grand_total,
            'updated_by'=>auth()->user('user')->id,
        ];
        if($totalDiscountInJob>0)
        {
            $updateJobCardHeader['discount_amount']=$totalDiscountInJob;
            
        }
        CustomerJobCards::where(['job_number'=>$this->job_number])->update($updateJobCardHeader);

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
                'job_id'=>$this->jobDetails->id,
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
                'updated_by'=>auth()->user('user')->id,
            ];
            $checkListEntryInsert = JobcardChecklistEntries::where(['job_number'=>$this->job_number,'job_id'=>$this->jobDetails->id])->update($checkListEntryData);
        }
        
        if($passmetrialRequest==true)
        {
            //dd($this->jobDetails->meterialRequestResponse);
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


    }

    public function dashCustomerJobUpdate($job_number)
    {
        return redirect()->to('/customer-job-update/'.$job_number);
    }
}
