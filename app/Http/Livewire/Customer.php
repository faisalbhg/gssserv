<?php

namespace App\Http\Livewire;

use Livewire\Component;

use Carbon\Carbon;
use Livewire\WithPagination;

use App\Models\Customers;
use App\Models\TenantMasterCustomers;
use App\Models\CustomerVehicle;

class Customer extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $title, $customer_id, $name, $email, $mobile, $customer_type, $is_active, $manageCustomers = false;

    public $search_customer, $customer_mobile;

    public function render()
    {
        /*$duplicates = TenantMasterCustomers::select('Mobile',\DB::raw('COUNT(*) as count'))
        ->groupBy('Mobile')
        ->havingRaw('COUNT(*) > 1')
        ->limit(5)
        ->where('Mobile','!=','')
        ->orderBy('count','DESC')
        ->get();

        dd($duplicates);*/

        /*foreach(TenantMasterCustomers::where('Mobile','LIKE','05%')->where('Mobile','!=',null)->get() as $customerDtl)
        {
            dd($customerDtl);
        }*/
        /*$duplicateEmails = TenantMasterCustomers::select('Mobile')
            ->groupBy('Mobile')
            ->havingRaw('COUNT(*) > 1')
            ->pluck('Mobile');

        $usersWithDuplicates = TenantMasterCustomers::whereIn('Mobile', $duplicateEmails)->get();*/

        $customersListQuery = TenantMasterCustomers::latest()->with(['customerVehicleDetails']);
        if($this->search_customer){
            $customersListQuery = $customersListQuery->where('TenantName', 'like', "%{$this->search_customer}%");
        }
        if($this->customer_mobile){
            /*if($this->customer_mobile[0]=='0'){
                $this->customer_mobile = ltrim($this->customer_mobile, $this->customer_mobile[0]);
            }*/
            $customersListQuery = $customersListQuery->where('Mobile', 'like', "%{$this->customer_mobile}%");
        }
        $customersList = $customersListQuery->paginate(10);
        /*$customersList = $customersListQuery->get();
        foreach($customersList as $customer)
        {
            if(!CustomerVehicle::where(['customer_id'=>$customer['TenantId']])->exists())
            {
                TenantMasterCustomers::where(['TenantId'=>$customer['TenantId']])->delete();
            }
        }*/

        $data['customersList'] = $customersList;
        //dd($data);
        return view('livewire.customers',$data);
    }

    public function showCustomer($customerId){
        $customer = Customers::latest()->with('customertype')->where('name', 'like', "%{$this->search_customer}%")->find($customerId);
        dd($customer);
    }
}

