/*dd(CustomerJobCards::where('job_status','!=',4)->where('job_date_time', '<=', Carbon::yesterday())->get());
        foreach(CustomerJobCards::where('job_status','!=',4)->where('job_date_time', '<=', Carbon::yesterday())->get() as $job_status)
        {
            
            $customer_id = $job_status->customer_id;
            CustomerJobCards::where(['job_number'=>$job_status->job_number])->update(['job_status'=>4]);
            try {
                DB::select('EXEC [dbo].[CreateCashierFinancialEntries_2] @jobnumber = "'.$job_status->job_number.'", @doneby = "'.auth()->user('user')->id.'", @stationcode  = "'.auth()->user('user')->station_code.'", @paymentmode = "C", @customer_id = "'.$customer_id.'" ');
            } catch (\Exception $e) {
                //dd($e->getMessage());
                //return $e->getMessage();
            }
        }
        dd();*/
        //dd(CustomerJobCards::where(['payment_status'=>0])->where('job_date_time', '<=', Carbon::yesterday())->get());
        /*foreach(CustomerJobCards::where(['payment_status'=>0])->where('job_date_time', '<=', Carbon::yesterday())->get() as $payment_status)
        {
            switch ($payment_status->payment_type) {
                case '1':
                    $paymentmode="L";
                    break;

                case '2':
                    $paymentmode="O";
                    break;
                
                case '3':
                    $paymentmode="C";
                    break;
            }
            CustomerJobCards::where(['job_number'=>$payment_status->job_number])->update(['payment_status'=>1]);
            try {
                DB::select('EXEC [dbo].[Job.CashierAcceptPayment] @jobId = "'.$payment_status->job_number.'", @paymentmode = "'.$paymentmode.'", @doneby = "admin", @paymentDate="'.Carbon::now().'",@amountcollected='.$payment_status->grand_total.',@advanceInvoice=NULL ');
            } catch (\Exception $e) {
                //dd($e->getMessage());
                //return $e->getMessage();
            }
        }*/
        //dd(CustomerJobCards::with(['stationInfo'])->where(['payment_status'=>0,'payment_type'=>1])->where('payment_link','!=',Null)->where('payment_response','!=',null)->get());
        //if($this->jobcardDetails->payment_type==1 && $this->jobcardDetails->payment_status == 0){