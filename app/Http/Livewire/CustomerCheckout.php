<?php

namespace App\Http\Livewire;

use Livewire\Component;

use Illuminate\Http\Request;
use Livewire\WithFileUploads;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use LaravelPayfort\Facades\Payfort;
use Illuminate\Support\Facades\Hash;

use Session;
use DB;

use App\Models\CustomerVehicle;
use App\Models\CustomerServiceCart;

class CustomerCheckout extends Component
{
    use WithFileUploads;
    public $customerDetails, $customerServiceDetails;

    function mount( Request $request) {
        $vehicle_id = $request->vehicle_id;
        $customer_id = $request->customer_id;
        $job_number = $request->job_number;
        if($vehicle_id && $customer_id)
        {
            $this->openCustomerSelection($customer_id, $vehicle_id);
        }
    }

    public function render()
    {
        return view('livewire.customer-checkout');
    }

    public function openCustomerSelection($customer_id, $vehicle_id){
        $this->customerDetails = CustomerVehicle::with('customerInfoMaster')->where(['is_active'=>1,'id'=>$vehicle_id,'customer_id'=>$customer_id])->first();

        $this->customerServiceDetails = CustomerServiceCart::where(['customer_id'=>$customer_id,'vehicle_id'=>$vehicle_id])->get();

        $cartDetails = $this->cartItems;
        $this->cartItemCount = count($this->cartItems); 
        $this->total=0;
        
        $generalservice=false;
        $quicklubeservice=false;
        $showchecklist=false;
        foreach($this->cartItems as $items)
        {
            if($this->station==null){
                $this->station = $items->division_code;
            }

            if($items->department_code=='PP/00036' && $generalservice==false){
                $generalservice=true;
                $showchecklist=true;
            }
            else if($items->department_code=='PP/00037' && $quicklubeservice==false){
                $quicklubeservice=true;
                $showchecklist=true;
            }
            $this->total = $this->total+($items->quantity*$items->price);
        }
        
        if($showchecklist==true)
        {
            $this->showCheckList=true;
            $this->showFuelScratchCheckList=true;
            $this->showServiceGroup=false;
            $this->cardShow=false;
            $this->showCheckout=false;
            $this->checklistLabels = ServiceChecklist::get();
            if($quicklubeservice==true)
            {
                $this->showQLCheckList=true;
            }
            else
            {
                $this->showQLCheckList=false;
            }
        }
        else
        {
            $this->showCheckList=false;
            $this->showFuelScratchCheckList=false;
            $this->showServiceGroup=false;
            $this->cardShow=false;
            //$this->createJob();
            $this->showCheckout=true;
        }

        //dd($this->showQLCheckList);

        

            
        $this->tax = $this->total * (config('global.TAX_PERCENT') / 100);
        $this->grand_total = $this->total  * ((100 + config('global.TAX_PERCENT')) / 100);


        $this->dispatchBrowserEvent('imageUpload');
    }
}
