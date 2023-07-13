<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\ServiceItemCategory;

use Carbon\Carbon;
use Livewire\WithPagination;

class ItemCategories extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $data['serviceItemCategory'] = ServiceItemCategory::with('sub_category')->paginate(20);
        //dd($data);
        return view('livewire.item-categories', $data);
    }
}
