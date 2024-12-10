<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\CustomerJobCards;
use App\Models\CustomerJobCardServices;
use App\Models\CustomerJobCardServiceLogs;


class QrCodeController extends Controller
{
    public function qrcode($job_number)
    {
        $customerjobs = CustomerJobCards::
            select('customer_job_cards.*','customers.name','customers.email','customers.mobile')
            ->join('customers','customers.id','=','customer_job_cards.customer_id')
            ->where(['customer_job_cards.job_number'=>$job_number])
            ->take(5)->first();
        $data['qrdata'] = $customerjobs;
        //dd($data); 
        return view('qrcode',$data);
    }
}
