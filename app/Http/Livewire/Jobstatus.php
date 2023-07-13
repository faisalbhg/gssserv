<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\Customerjobs;
use App\Models\Customerjobservices;
use App\Models\Customerjoblogs;

use Carbon\Carbon;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Http;

class Jobstatus extends Component
{
    
    public $job_number;

    public function mount()
    {
        $job_number = \Route::current()->parameter('name');
        $job = Customerjobs::
            select('customerjobs.*','customers.name','customers.email','customers.mobile','customertypes.customer_type as customerType')
            ->join('customers','customers.id','=','customerjobs.customer_id')
            ->join('customertypes','customertypes.id','=','customerjobs.customer_type')
            ->where(['customerjobs.job_number'=>$job_number])
            ->take(5)->first();
            //dd($job);
        $this->job_number = $job->job_number;
        $this->job_date_time = $job->job_date_time;
        $this->customerDetails = true;
        $this->vehicle_image = $job->vehicle_image;
        $this->vehicle_name = $job->vehicle_name;
        $this->make = $job->make;
        $this->model = $job->model;
        $this->plate_number = $job->plate_number;
        $this->chassis_number = $job->chassis_number;
        $this->vehicle_km = $job->vehicle_km;
        $this->name = $job->name;
        $this->email = $job->email;
        $this->mobile = $job->mobile;
        $this->customerType = $job->customerType;
        $this->payment_status = $job->payment_status;
        $this->payment_type = $job->payment_type;
        $this->job_status = $job->job_status;
        $this->job_departent = $job->job_departent;
        $this->total_price = $job->total_price;
        $this->vat = $job->vat;
        $this->grand_total = $job->grand_total;

        $this->customerjobservices = Customerjobservices::where(['job_number'=>$job->job_number])->get();
        $this->customerjoblogs = Customerjoblogs::where(['job_number'=>$job->job_number])->orderBy('id','DESC')->get();
    }


    public function render()
    {
        return view('livewire.jobstatus');
    }
}
