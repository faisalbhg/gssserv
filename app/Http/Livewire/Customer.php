<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\Customers;

use Carbon\Carbon;
use Livewire\WithPagination;

class Customer extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $title, $customer_id, $name, $email, $mobile, $customer_type, $is_active, $manageCustomers = false;

    public $search_customer = "";

    public function render()
    {
        $customersList = Customers::latest()->with('customertype','customervehicle')->where('name', 'like', "%{$this->search_customer}%")->paginate(10);
        $data['customersList'] = $customersList;
        return view('livewire.customers',$data);
    }

    public function showCustomer($customerId){
        $customer = Customers::latest()->with('customertype')->where('name', 'like', "%{$this->search_customer}%")->find($customerId);
        dd($customer);
    }
}

