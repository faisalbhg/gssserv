<?php

namespace App\Http\Livewire;

use Livewire\Component;

use Livewire\WithPagination;
use Illuminate\Http\Request;
use Livewire\WithFileUploads;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\Http;
use LaravelPayfort\Facades\Payfort;
use Illuminate\Support\Facades\Hash;
use DB;

use App\Models\Landlord;
use App\Models\ServicePackage;
use App\Models\ServicePackageDetail;
use App\Models\CustomerVehicle;
use App\Models\PackageBookings;
use App\Models\PackageBookingServices;
use App\Models\PackageBookingServiceLogs;

class Packages extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search_package_number, $search_package_date_from, $search_package_date_to, $search_plate_number, $search_payment, $search_station, $search_paymentStatus;
    public $selectedPackage, $showPackageDetails=false;

    public function render()
    {
        $this->stationsList = Landlord::all();

        $getCountSalesPackage = PackageBookings::select(
            array(
                \DB::raw('count(DISTINCT(customer_id)) customers'),
                \DB::raw('count(package_number) packages'),
                \DB::raw('count(case when payment_status = 0 then payment_status end) pending'),
                \DB::raw('count(case when payment_status = 1 then payment_status end) paid'),
                \DB::raw('count(case when payment_status = 2 then payment_status end) failed'),
                \DB::raw('count(case when payment_status = 3 then payment_status end) cancelled'),
                \DB::raw('count(case when package_status = 2 then payment_status end) active'),
                \DB::raw('count(case when package_status != 2 then payment_status end) notactive'),
                \DB::raw('count(case when payment_status in (0,1,2,3) then payment_status end) total'),
                \DB::raw('SUM(grand_total) as saletotal'),
            )
        );

        $getSumSalesPackage = PackageBookings::select(
            array(
                \DB::raw('SUM(case when payment_type = 0 then grand_total end) pay_later'),
                \DB::raw('SUM(case when payment_type = 1 then grand_total end) payment_link'),
                \DB::raw('SUM(case when payment_type = 2 then grand_total end) pay_by_card'),
                \DB::raw('SUM(case when payment_type = 3 then grand_total end) cash_payment'),
                \DB::raw('SUM(case when payment_type = 4 then grand_total end) pay_by_credit'),
                \DB::raw('SUM(case when payment_type = 5 then grand_total end) discount'),
                \DB::raw('SUM(case when payment_type = 6 then grand_total end) cash_in_advance'),
                \DB::raw('SUM(case when payment_type in (0,1,2,3,4,5,6) then grand_total end) total'),
                \DB::raw('SUM(grand_total) as saletotal'),
            )
        );

        //dd($getCountSalesPackage);


        $customerPackage = PackageBookings::with(['makeInfo','modelInfo','createdInfo','customerPackageServices','packageHistory']);
        
        
        if($this->search_package_number)
        {
            $customerPackage = $customerPackage->where('package_number', 'like', "%{$this->search_package_number}%");
            $getCountSalesPackage = $getCountSalesPackage->where('package_number', 'like', "%{$this->search_package_number}%");
            $getSumSalesPackage = $getSumSalesPackage->where('package_number', 'like', "%{$this->search_package_number}%");
        }
        /*if($this->search_package_date){
            $customerPackage = $customerPackage->whereBetween('package_date_time', [$this->search_package_date." 00:00:00",$this->search_package_date." 23:59:59"]);
            $getCountSalesPackage = $getCountSalesPackage->whereBetween('job_date_time', [$this->search_package_date." 00:00:00",$this->search_package_date." 23:59:59"]);
            $getSumSalesPackage = $getSumSalesPackage->whereBetween('job_date_time', [$this->search_package_date." 00:00:00",$this->search_package_date." 23:59:59"]);
        }*/

        if($this->search_package_date_from){

            $customerPackage = $customerPackage->whereBetween('package_date_time', [$this->search_package_date_from." 00:00:00",$this->search_package_date_to." 23:59:59"]);
            $getCountSalesPackage = $getCountSalesPackage->whereBetween('package_date_time', [$this->search_package_date_from." 00:00:00",$this->search_package_date_to." 23:59:59"]);
            $getSumSalesPackage = $getSumSalesPackage->whereBetween('package_date_time', [$this->search_package_date_from." 00:00:00",$this->search_package_date_to." 23:59:59"]);
        }

        if($this->search_plate_number)
        {
            $customerPackage = $customerPackage->where('plate_number', 'like',"%$this->search_plate_number%");
        }
        if($this->search_payment)
        {
            $customerPackage = $customerPackage->where('payment_type', '=',$this->search_payment);
        }
        if($this->search_station){
            $customerPackage = $customerPackage->where(['station'=>$this->search_station]);
            $getCountSalesPackage = $getCountSalesPackage->where(['station'=>$this->search_station]);
            $getSumSalesPackage = $getSumSalesPackage->where(['station'=>$this->search_station]);
        }
        if($this->search_paymentStatus){
            $customerPackage = $customerPackage->where(['payment_status'=>$this->search_paymentStatus]);
            $getCountSalesPackage = $getCountSalesPackage->where(['payment_status'=>$this->search_paymentStatus]);
            $getSumSalesPackage = $getSumSalesPackage->where(['payment_status'=>$this->search_paymentStatus]);
        }
        if(auth()->user('user')->user_type!=1){
            $customerPackage = $customerPackage->where(['station'=>auth()->user('user')['station_code']]);
            $getCountSalesPackage = $getCountSalesPackage->where(['station'=>auth()->user('user')['station_code']]); 
            $getSumSalesPackage = $getSumSalesPackage->where(['station'=>auth()->user('user')['station_code']]); 
        }
        $customerPackage = $customerPackage->where(['package_status'=>1])->orderBy('id','DESC')->paginate(10);
        //dd($customerPackage);
        
        
        $getCountSalesPackage = $getCountSalesPackage->where(['package_status'=>1])->first();
        $getSumSalesPackage = $getSumSalesPackage->where(['package_status'=>1])->first();
        //dd($customerPackage);
        
        $data['getCountSalesPackages'] = $getCountSalesPackage;
        $data['getSumSalesPackages'] = $getSumSalesPackage;
        $data['customerPackages'] = $customerPackage;
        return view('livewire.packages',$data);
    }

    public function customerPackageDetails($package_number)
    {
        $packageDetails = PackageBookings::with(['customerPackageServices'])->where(['package_number'=>$package_number])->first();
        //dd($packageDetails);
        $packageDetails->customer_id;
        $packageDetails->vehicle_id;
        return redirect()->to('customer-service-job/'.$packageDetails->customer_id.'/'.$packageDetails->vehicle_id);
        
    }

    public function packageDetails($package){
        $this->selectedPackage = json_decode($package,true);
        //dd($this->selectedPackage);
        $this->showPackageDetails=true;
        $this->dispatchBrowserEvent('openPackageDetails');
    }

    /*public function filterJobListPage($statusFilter)
    {
        switch($statusFilter){
            case 'total': $this->filter = [0,1,2,3,4];break;
            case 'working_progress': $this->filter = [1];break;
            case 'work_finished': $this->filter = [2,3];break;
            case 'ready_to_deliver': $this->filter = [3];break;
            case 'delivered': $this->filter = [4];break;
        }
        $this->filterTab = $statusFilter;
        $this->dispatchBrowserEvent('filterTab',['tabName'=>$this->filterTab]);
    }*/
}
