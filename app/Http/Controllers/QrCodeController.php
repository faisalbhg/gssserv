<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Customerjobs;
use App\Models\Customerjobservices;
use App\Models\Customerjoblogs;


class QrCodeController extends Controller
{
    public function qrcode($job_number)
    {
        $customerjobs = Customerjobs::
            select('customerjobs.*','customers.name','customers.email','customers.mobile','customertypes.customer_type as customerType')
            ->join('customers','customers.id','=','customerjobs.customer_id')
            ->join('customertypes','customertypes.id','=','customerjobs.customer_type')
            ->where(['customerjobs.job_number'=>$job_number])
            ->take(5)->first();
        $data['qrdata'] = $customerjobs;
        return view('qrcode',$data);
    }
}
