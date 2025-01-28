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
        $customerjobs = CustomerJobCards::with(['customerInfo','customerVehicle','makeInfo','modelInfo'])->where(['job_number'=>$job_number])->first();
        $data['qrdata'] = $customerjobs;
        //dd($data); 
        return view('qrcode',$data);
    }
}
