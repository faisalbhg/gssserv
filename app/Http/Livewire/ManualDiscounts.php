<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\ManualDiscountAprovals;
use App\Models\ManualDiscountServices;
use App\Models\CustomerServiceCart;

class ManualDiscounts extends Component
{
    public function render()
    {
        dd(ManualDiscountAprovals::orderBy('id','DESC')->first());
        return view('livewire.manual-discounts');
    }
}
