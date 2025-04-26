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

use App\Models\ServicePackage;
use App\Models\ServicePackageDetail;
use App\Models\CustomerVehicle;
use App\Models\PackageBookings;
use App\Models\PackageBookingServices;
use App\Models\PackageBookingServiceLogs;

class PackagesBookings extends Component
{
    use WithFileUploads;
    public $selectedCustomerVehicle=true, $showCheckout=true, $successPage=false, $showCustomerSignature=false, $showOtpVerify=false, $otpVerified=false;
    public $package_number, $total, $totalDiscount, $grand_total, $tax;
    public $customer_id, $vehicle_id, $package_id, $selectedVehicleInfo, $mobile, $name, $email, $customerSignature, $packageInfo;
    public $package_otp, $otp_message;
    

    function mount( Request $request) {
        $this->customer_id = $request->customer_id;
        $this->vehicle_id = $request->vehicle_id;
        $this->package_id = $request->package_id;        
    }

    public function render()
    {
        if($this->vehicle_id && $this->customer_id)
        {
            $customers = CustomerVehicle::with(['customerInfoMaster','makeInfo','modelInfo','customerDiscountLists'])->where(['is_active'=>1,'id'=>$this->vehicle_id,'customer_id'=>$this->customer_id])->first();
            $this->selectedVehicleInfo=$customers;

            $this->mobile = $customers->customerInfoMaster['Mobile'];
            $this->name = $customers->customerInfoMaster['TenantName'];
            $this->email = $customers->customerInfoMaster['Email'];
        }
        if($this->package_id)
        {
             $packageInfoResult = ServicePackage::with(['packageDetails'])->where(['Status'=>'A','Division'=>auth()->user('user')['station_code'],'Id'=>$this->package_id])->first();
             //dd($packageInfoResult);
             
             $totalPrice=0;
             $unitPrice=0;
             $discountedPrice=0;
             foreach($packageInfoResult->packageDetails as $packgInfo)
             {
                $totalPrice = $totalPrice+($packgInfo->UnitPrice*$packgInfo->Quantity);
                $discountedPrice = $discountedPrice+($packgInfo->DiscountedPrice*$packgInfo->Quantity);
             }
             $this->total = custom_round($totalPrice);
             $this->totalDiscount = custom_round($discountedPrice);
             $this->tax = custom_round($discountedPrice * (config('global.TAX_PERCENT') / 100));
             $this->grand_total = round($this->tax+$this->totalDiscount);
             $this->packageInfo = $packageInfoResult;
             //dd($this->packageInfo);
        }
        return view('livewire.packages-bookings');
    }

    

    public function confirmPackage(){
        $stationPKGNumber = PackageBookings::where(['station'=>auth()->user('user')->station_code])->count();
        $this->package_number = 'PKG-'.auth()->user('user')->stationName['Abbreviation'].'-'.sprintf('%08d', $stationPKGNumber+1);
        $customerPackageData = [
            'package_number'=>$this->package_number,
            'package_name'=>$this->packageInfo->PackageName,
            'package_code'=>$this->packageInfo->Code,
            'package_id'=>$this->packageInfo->Id,
            'package_duration'=>$this->packageInfo->Duration,
            'package_description'=>$this->packageInfo->Description,
            'package_type'=>$this->packageInfo->PackageType,
            'package_km'=>$this->packageInfo->PackageKM,
            'package_date_time'=>Carbon::now(),
            'customer_id'=>$this->customer_id,
            'otp_code'=>fake()->randomNumber(6),
            'otp_verify'=>0,
            'customer_name'=>isset($this->name)?$this->name:'Walking Customer',
            'customer_mobile'=>$this->mobile,
            'customer_email'=>$this->email,
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
            'created_by'=>auth()->user('user')->id,
            'payment_updated_by'=>auth()->user('user')->id,
        ];
        $packageId = PackageBookings::create($customerPackageData);
        
        
        foreach($this->packageInfo->packageDetails as $packageDetails)
        {
            $customerPkgServiceData = [
                'package_number'=>$this->package_number,
                'package_id'=>$packageId->id,
                'package_code'=>$this->packageInfo->Code,
                'item_id'=>$packageDetails->ItemId,
                'item_code'=>$packageDetails->ItemCode,
                'unit_price'=>$packageDetails->UnitPrice,
                'discounted_price'=>$packageDetails->DiscountedPrice,
                //'discount_percentage'=>$packageDetails->DiscountPercentage,
                'item_type'=>$packageDetails->ItemType,
                'frequency'=>$packageDetails->Frequency,
                'is_default'=>$packageDetails->isDefault,
                'company_code'=>$packageDetails->labourItemDetails['CompanyCode'],
                'category_id'=>$packageDetails->labourItemDetails['CategoryId'],
                'sub_category_id'=>$packageDetails->labourItemDetails['SubCategoryId'],
                'brand_id'=>$packageDetails->labourItemDetails['BrandId'],
                'bar_code'=>$packageDetails->labourItemDetails['BarCode'],
                'item_name'=>$packageDetails->labourItemDetails['ItemName'],
                'description'=>$packageDetails->labourItemDetails['Description'],
                'service_item_type'=>1,
                'division_code'=>$packageDetails->labourItemDetails['DivisionCode'],
                'department_code'=>$packageDetails->labourItemDetails['DepartmentCode'],
                'section_code'=>$packageDetails->labourItemDetails['SectionCode'],
                'section_name'=>$packageDetails->labourItemDetails['CompanyCode'],
                'department_name'=>$packageDetails->labourItemDetails['CompanyCode'],
                'station'=>auth()->user('user')->stationName['LandlordCode'],
                'total_price'=>$this->total,
                'quantity'=>$packageDetails->Quantity,
                'vat'=>$this->tax,
                'grand_total'=>$this->grand_total,
                'package_status'=>1,
                'job_status'=>1,
                'job_departent'=>1,
                'is_added'=>0,
                'is_removed'=>0,
                'created_by'=>auth()->user('user')->id,
            ];
            $customerPackageServiceId = PackageBookingServices::create($customerPkgServiceData);
            
            PackageBookingServiceLogs::create([
                'package_number'=>$this->package_number,
                'customer_package_service_id'=>$customerPackageServiceId->id,
                'package_status'=>1,
                'package_description'=>json_encode($customerPkgServiceData),
                'created_by'=>auth()->user('user')->id,
                'created_at'=>Carbon::now(),
            ]);

            
        }
        if($this->mobile)
        {
            $this->sendOTPSMS($customerPackageData['otp_code']);
        }
        
    }

    public function sendOTPSMS($otpPack){
        $mobileNumber = isset($this->mobile)?'971'.substr($this->mobile, -9):null;
        $customerName = isset($this->name)?$this->name:null;
        if($mobileNumber!=''){
            //if($mobileNumber=='971566993709'){
                //$otpPack = $customerPackageData['otp_code'];
                $msgtext = urlencode('Dear '.$customerName.', please use the OTP '.$otpPack.' of GSS Package creation valid for 10 minutes. Do not share it with anyone. For assistance, call 800477823.');
                $response = Http::get(config('global.sms')[1]['sms_url']."&mobileno=".$mobileNumber."&msgtext=".$msgtext."&CountryCode=ALL");
            //}
        }
        $this->showOtpVerify=true;
        $this->dispatchBrowserEvent('scrollto', [
            'scrollToId' => 'packageOTPVerifyRow',
        ]);

        session()->flash('package_success', 'Package is valid, please enter the OTP shared in the registered mobile number..!');
    }

    public function verifyPackageOtp(){
        $validatedData = $this->validate([
            'package_otp' => 'required',
        ]);
        if(PackageBookings::where(['package_number'=>$this->package_number,'otp_code'=>$this->package_otp])->exists())
        {
            $this->showOtpVerify=false;
            $this->package_otp=null;
            $this->otpVerified=true;
            $this->otp_message=null;
            $this->dispatchBrowserEvent('scrollto', [
                'scrollToId' => 'packagePaymentRow',
            ]);
        }
        else
        {
            $this->shoOtpVerify=true;
            $this->otpVerified=false;
            $this->otp_message='OTP is not matching..!';
            $this->dispatchBrowserEvent('scrollto', [
                'scrollToId' => 'packageOTPVerifyRow',
            ]);
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
        

        $this->showCustomerSignature=true;
        $this->dispatchBrowserEvent('showSignature');
    }

    public function resendPackageOtp(){
        $otpPack = fake()->randomNumber(6);
        PackageBookings::where(['package_number'=>$this->package_number])->update(['otp_code'=>fake()->randomNumber(6)]);
        $this->package_otp=null;
        $this->sendOTPSMS($otpPack);
    }

    public function completePaymnet($mode)
    {
        PackageBookings::where(['package_number'=>$this->package_number])->update(['customer_signature'=>$this->customerSignature,'package_status'=>1]);
        $customerPackageInfo = PackageBookings::with(['customerInfo','customerVehicle','stationInfo'])->where(['package_number'=>$this->package_number])->first();
        if(auth()->user('user')->stationName['StationID']==4)
        {
            $mobileNumber = isset($customerPackageInfo->customerInfo['Mobile'])?'971'.substr($customerPackageInfo->customerInfo['Mobile'], -9):null;
        }
        else
        {
            $mobileNumber = isset(auth()->user('user')->phone)?'971'.substr(auth()->user('user')->phone, -9):null;
        }
        //$mobileNumber = isset($this->mobile)?'971'.substr($this->mobile, -9):null;
        $customerName = isset($customerPackageInfo->customerInfo['TenantName'])?$customerPackageInfo->customerInfo['TenantName']:null;
        //$customerName = isset($this->name)?$this->name:null;
        $paymentmode = null;
        if($mode=='link')
        {
            $paymentmode = "O";
            $paymentLink = $this->sendPaymentLink($customerPackageInfo);
            $paymentResponse = json_decode((string) $paymentLink->getBody()->getContents(), true);
            $merchant_reference = $paymentResponse['merchant_reference'];
            if(array_key_exists('payment_redirect_link', $paymentResponse))
            {
                if($customerPackageInfo->customerInfo['Mobile']!=''){
                    //if($mobileNumber=='971566993709'){
                        $msgtext = urlencode('Dear '.$customerName.', we received your vehicle for package, Refer Package No. #'.$this->package_number.'. To avoid waiting at the cashier, you can pay online using this link: https://gsstations.ae/qr/package/'.$this->package_number.'. For assistance, call 800477823.');
                        $response = Http::get(config('global.sms')[1]['sms_url']."&mobileno=".$mobileNumber."&msgtext=".$msgtext."&CountryCode=ALL");

                    //}
                }

                PackageBookings::where(['package_number'=>$this->package_number])->update(['payment_type'=>1,'payment_link'=>$paymentResponse['payment_redirect_link'],'payment_response'=>json_encode($paymentResponse),'payment_link_order_ref'=>$paymentResponse['payment_link_order_ref'],'payment_request'=>'link_send',]);

                //PackageBookings::where(['package_number'=>$this->package_number])->update(['payment_type'=>1,'payment_link'=>$paymentResponse['payment_redirect_link'],'payment_response'=>json_encode($paymentResponse),'payment_request'=>'link_send']);

                $this->successPage=true;
                $this->otpVerified =false;
                $this->selectedCustomerVehicle=false;
                $this->showCheckout=false;
                
            }
            else
            {
                session()->flash('error', $paymentResponse['response_message']);

            }
            
        }
        else if($mode=='card')
        {
            $paymentmode = "O";
            PackageBookings::where(['package_number'=>$this->package_number])->update(['payment_type'=>2,'payment_request'=>'card payment']);
            if($customerPackageInfo->customerInfo['Mobile']!=''){
                //if($mobileNumber=='971566993709'){
                    $msgtext = urlencode('Dear '.$customerName.', we received your vehicle for package, Refer Package No. #'.$this->package_number.'. To avoid waiting at the cashier, you can pay online using this link: https://gsstations.ae/qr/package/'.$this->package_number.'. For assistance, call 800477823.');
                        $response = Http::get(config('global.sms')[1]['sms_url']."&mobileno=".$mobileNumber."&msgtext=".$msgtext."&CountryCode=ALL");
                //}
            }
            $this->successPage=true;
            $this->otpVerified =false;
            $this->selectedCustomerVehicle=false;
            $this->showCheckout=false;
            
        }
        else if($mode=='cash')
        {
            $paymentmode = "C";
            PackageBookings::where(['package_number'=>$this->package_number])->update(['payment_type'=>3,'payment_request'=>'cash payment']);
            if($customerPackageInfo->customerInfo['Mobile']!=''){
                //if($mobileNumber=='971566993709'){
                    $msgtext = urlencode('Dear '.$customerName.', we received your vehicle for package, Refer Package No. #'.$this->package_number.'. To avoid waiting at the cashier, you can pay online using this link: https://gsstations.ae/qr/package/'.$this->package_number.'. For assistance, call 800477823.');
                        $response = Http::get(config('global.sms')[1]['sms_url']."&mobileno=".$mobileNumber."&msgtext=".$msgtext."&CountryCode=ALL");
                //}
            }

            $this->successPage=true;
            $this->otpVerified =false;
            $this->selectedCustomerVehicle=false;
            $this->showCheckout=false;
        }
        try {
        DB::select('EXEC [dbo].[ServicePackage.Purchase.FinancialEntries] @packagenumber = "'.$this->package_number.'", @doneby = "admin" ');
        } catch (\Exception $e) {
            //return $e->getMessage();
        }


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
        $merchant_reference = $customerjobs->package_number;
        $order_billing_phone = str_replace(' ', '', $order_billing_phone);
        $order_billing_phone = "00971".$order_billing_phone;
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
        $response = Http::withBasicAuth('onlinewebtutor', 'admin123')->post(config('global.paymenkLink_payment_url'),$arrData);
        return $response;
    }

    
}
