<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\ServiceItemBrand;

use Carbon\Carbon;
use Livewire\WithPagination;

class Brands extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $data['serviceItemBrand'] = ServiceItemBrand::paginate(20);
        return view('livewire.brands', $data);
    }
}
