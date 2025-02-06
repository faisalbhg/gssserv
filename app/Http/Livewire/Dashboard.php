<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\CustomerJobCards;
use App\Models\CustomerJobCardServices;
use App\Models\CustomerJobCardServiceLogs;
use App\Models\CustomerServiceCart;

use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\Http;
use LaravelPayfort\Facades\Payfort;
use Illuminate\Support\Facades\Hash;


class Dashboard extends Component
{
    public $getCountSalesJob, $customerjobsLists, $selected_date, $filterJobStatus, $jobList, $homeCountIconeBg='bg-gradient-dark';
    protected $listeners = ["selectDate" => 'getSelectedDate'];
    public $pendingCustomersCart;

    function mount(){
        $user = auth()->user();

        if ($user && isset($user->id)) {
            Session::put('user', $user);
        } else {
            return redirect()->to('/login');
        }
    }

    public function render()
    {
        
        //'S255'
        //CustomerJobCardServices::truncate();
        //Get Pending Customer
        $this->pendingCustomersCart =  CustomerServiceCart::with(['customerInfo','vehicleInfo'])->where(['created_by'=>Session::get('user')['id']])->get();
        //dd($this->pendingCustomersCart);

        $getCountSalesJobStatus = CustomerJobCards::select(
            array(
                \DB::raw('count(DISTINCT(customer_id)) customers'),
                \DB::raw('count(job_number) jobs'),
                \DB::raw('count(case when job_status = 0 then job_status end) new'),
                \DB::raw('count(case when job_status = 1 then job_status end) working_progress'),
                \DB::raw('count(case when job_status = 2 then job_status end) work_finished'),
                \DB::raw('count(case when job_status = 3 then job_status end) ready_to_deliver'),
                \DB::raw('count(case when job_status = 4 then job_status end) delivered'),
                \DB::raw('count(case when job_status in (0,1,2,3,4) then job_status end) total'),
                \DB::raw('SUM(grand_total) as saletotal'),
            )
        );
        $customerjobsQuery = CustomerJobCards::with(['customerInfo']);
        if($this->selected_date)
        {
    
            $startDate = Carbon::createFromFormat('Y-m-d H:i:s', $this->selected_date.' 00:00:00');
            $endDate = Carbon::createFromFormat('Y-m-d H:i:s', $this->selected_date.' 23:59:59');
        }
        else
        {
            $this->selected_date = Carbon::now()->format('Y-m-d');
            $startDate = Carbon::createFromFormat('Y-m-d H:i:s', $this->selected_date.' 00:00:00');
            $endDate = Carbon::createFromFormat('Y-m-d H:i:s', $this->selected_date.' 23:59:59');

        }

        $getCountSalesJobStatus = $getCountSalesJobStatus->whereBetween('job_date_time', [$startDate, $endDate]);
        $customerjobsQuery = $customerjobsQuery->whereBetween('job_date_time', [$startDate, $endDate]);

            //$getCountSalesJobStatus = $getCountSalesJobStatus->where(['job_date_time'=>$this->selected_date]);
            //$customerjobsQuery = $customerjobsQuery->where(['job_date_time'=>$this->selected_date]);
        
        $this->getCountSalesJob = $getCountSalesJobStatus->where(['created_by'=>Session::get('user')['id']])->first();

        if($this->filterJobStatus)
        {
            $customerjobsQuery = $customerjobsQuery->where(['job_status'=>$this->filterJobStatus]);
        }
        $this->customerjobsLists = $customerjobsQuery->where(['created_by'=>Session::get('user')['id']])->get();
        return view('livewire.home-page');
    }

    public function getSelectedDate( $date ) {
        if(Carbon::parse($date)->format('Y-m-d')!=$this->selected_date){
            $this->selected_date = Carbon::parse($date)->format('Y-m-d');
            $this->dispatchBrowserEvent('datePicker');
        }
        //dd($this->selected_date);
        
    }

    public function jobListPage($filter){
        switch ($filter) {
            case 'total':
                $this->filterJobStatus=null;
                $this->jobList='Total';
                $this->homeCountIconeBg='bg-gradient-dark';
                break;

            case 'working_progress':
                $this->filterJobStatus=1;
                $this->jobList='Working Progress';
                $this->homeCountIconeBg='bg-gradient-info';
                break;
            
            case 'work_finished':
                $this->filterJobStatus=2;
                $this->jobList='Work Finished';
                $this->homeCountIconeBg='bg-gradient-warning';
                break;

            case 'ready_to_deliver':
                $this->filterJobStatus=3;
                $this->jobList='Ready to Deliver';
                $this->homeCountIconeBg='bg-gradient-success';
                break;

            case 'delivered':
                $this->filterJobStatus=4;
                $this->jobList='Delivered';
                $this->homeCountIconeBg='bg-gradient-success';
                break;

            default:
                $this->filterJobStatus=null;
                break;
        }
        $this->dispatchBrowserEvent('datePicker');
    }

    public function dashCustomerJobUpdate($job_number){
        return redirect()->to('/customer-job-update/'.$job_number);
    }

    public function selectPendingVehicle($customer_id,$vehicle_id){
        return redirect()->to('/customer-service-job/'.$customer_id.'/'.$vehicle_id);
    }
}
