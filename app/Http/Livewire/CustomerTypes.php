<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\Customertype;

use Carbon\Carbon;
use Session;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class CustomerTypes extends Component
{
    public $customerTypes=[];
    
    public function render()
    {
        $this->customerTypes = Customertype::get();
        return view('livewire.customer-types');
    }
}
