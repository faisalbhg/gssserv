<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

use App\Models\CustomerJobCards;

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
        
        $customerJobs = CustomerJobCards::with(['stationInfo'])->where(['payment_status'=>0,'payment_type'=>1])->where('payment_link','!=',Null)->where('payment_response','!=',null)->get();
        if (!empty($customerJobs)) {
            foreach ($customerJobs as $key => $jobs) {
                $arrData['job_number'] = $jobs->job_number;
                $paymentResponse = json_decode($jobs->payment_response,true);
                $paymentResponseOrderResponse =json_decode(json_decode($paymentResponse['order_response'],true),true);
                $arrData['order_number'] = $paymentResponseOrderResponse['orderReference'];
                $arrData['station'] = $jobs->stationInfo['StationID'];
                $response = Http::withBasicAuth('onlinewebtutor', 'admin123')->post(config('global.synchronize_single_paymenkLink_url'),$arrData);
                $paymentResponse = json_decode($response,true);
                $orderResponseAmount = str_replace("د.إ.\u{200F} ","",$paymentResponse['order_response']['amount']);
                //dd($paymentResponse);
                if($paymentResponse['order_response']['status']=='PURCHASED' || $paymentResponse['order_response']['status']=='CAPTURED' )
                {
                    CustomerJobCards::where(['job_number'=>$paymentResponse['order_response']['orderReference']])->update(['payment_status'=>1]);
                    try {
                        DB::select('EXEC [dbo].[Job.CashierAcceptPayment] @jobId = "'.$arrData['job_number'].'", @paymentmode = "L", @doneby = "admin", @paymentDate="'.Carbon::now().'",@amountcollected='.$orderResponseAmount.',@advanceInvoice=NULL ');
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
