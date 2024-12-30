<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;


use App\Models\CustomerJobCards;
use App\Models\CustomerJobCardServices;
use App\Models\CustomerJobCardServiceLogs;

class JobCards extends Controller
{
    public function show($job_number){
        
        $customerjobs = CustomerJobCards::with(['customerInfo'])->where(['job_number'=>$job_number])->first();
        $data['qrdata'] = $customerjobs;

        return Response::json($data);
    }
}
