<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\CustomerJobCards;
use App\Models\CustomerJobCardServices;
use App\Models\CustomerJobCardServiceLogs;

class Jobcards extends Controller
{
    public function show($job_number){
        //dd($job_number);
        $customerjobs = CustomerJobCards::with(['customerInfo'])->where(['job_number'=>$job_number])->first();

        return response()->json([
            'status' => true,
            'message' => 'Customers retrieved successfully',
            'data' => $customerjobs
        ], 200);
    }
}

