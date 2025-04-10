<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

use App\Models\CustomerJobCards;
use App\Models\PackageBookings;

use Carbon\Carbon;
use Session;
use Livewire\WithPagination;
use Illuminate\Http\Request;
use DB;

class PaymentCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payment:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check Payment Link Synchronisation';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        info("Cron Job running at ". now());
        /*--------------------------------------------------------------------------------------
        Write Your Logic Here....
        I am getting users and create new users if not exist....
        ----------------------------------------------------------------------------------------*/
        
        $customerJobs = CustomerJobCards::with(['stationInfo'])->where(['payment_status'=>0,'payment_type'=>1])->where('payment_link_order_ref','!=',Null)->get();
        if (!empty($customerJobs)) {
            foreach ($customerJobs as $key => $jobs) {
                $arrData['job_number'] = $jobs->job_number;
                $arrData['order_number'] = $jobs->payment_link_order_ref;
                $arrData['station'] = $jobs->stationInfo['StationID'];

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
                            $msgtext = urlencode('Dear '.$customerName.', your payment of AED'.$orderResponseAmount.' for service on vehicle '.$jobs->plate_number.' at '.$jobs->stationInfo['ShortName'].' has been received. Receipt No:'.$jobs->job_number.', click here to access your gate pass for vehicle exit https://gsstations.ae/qr/'.$jobs->job_number.'. Thank you for your trust in GSS');
                            $response = Http::get(config('global.sms')[1]['sms_url']."&mobileno=".$mobileNumber."&msgtext=".$msgtext."&CountryCode=ALL");
                        //}
                    }

                    try {
                        DB::select('EXEC [dbo].[Job.CashierAcceptPayment] @jobId = "'.$arrData['job_number'].'", @paymentmode = "L", @doneby = "admin", @paymentDate="'.Carbon::now().'",@amountcollected='.$orderResponseAmount.',@advanceInvoice=NULL ');
                    } catch (\Exception $e) {
                        //dd($e->getMessage());
                        //return $e->getMessage();
                    }
                }
            }
        }


        $customerPackageBookings = PackageBookings::with(['stationInfo'])->where(['payment_status'=>0,'payment_type'=>1])->where('payment_link_order_ref','!=',Null)->get();
        if (!empty($customerPackageBookings)) {
            foreach ($customerPackageBookings as $key => $package) {
                $arrData['job_number'] = $package->package_number;
                $arrData['order_number'] = $package->payment_link_order_ref;
                $arrData['station'] = $package->stationInfo['StationID'];

                $mobileNumber=null;
                if($arrData['station']==4)
                {
                    $mobileNumber = isset($package->customer_mobile)?'971'.substr($package->customer_mobile, -9):null;
                }
                $customerName = isset($package->customer_name)?$package->customer_name:null;

                $response = Http::withBasicAuth('onlinewebtutor', 'admin123')->post(config('global.synchronize_single_paymenkLink_url'),$arrData);
                $paymentResponse = json_decode($response,true);
                $orderResponseAmount = str_replace("د.إ.\u{200F} ","",$paymentResponse['order_response']['amount']);
                //dd($paymentResponse);
                if($paymentResponse['order_response']['status']=='PURCHASED' || $paymentResponse['order_response']['status']=='CAPTURED' )
                {
                    PackageBookings::where(['package_number'=>$paymentResponse['order_response']['orderReference']])->update(['payment_status'=>1]);

                    if($mobileNumber!=null){
                        //dd($mobileNumber);  
                        //if($mobileNumber=='971566993709'){
                            $msgtext = urlencode('Dear '.$customerName.', your payment of AED'.$orderResponseAmount.' for package at '.$package->stationInfo['ShortName'].' has been received. Receipt No:'.$package->package_number.', click here to access your invoice https://gsstations.ae/qr/package/'.$package->package_number.'. Thank you for your trust in GSS');
                            $response = Http::get(config('global.sms')[1]['sms_url']."&mobileno=".$mobileNumber."&msgtext=".$msgtext."&CountryCode=ALL");
                        //}
                    }

                    try {
                        DB::select('EXEC [dbo].[AcceptPayment_ServicePackage] @packagenumber = "'.$arrData['job_number'].'", @paymentmode = "L", @doneby = "admin", @paymentDate="'.Carbon::now().'",@amountcollected='.$orderResponseAmount.' ');
                    } catch (\Exception $e) {
                        //dd($e->getMessage());
                        //return $e->getMessage();
                    }
                }
            }
        }
        return 0;
    }
}
