<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\ItemProductGroup;

use Carbon\Carbon;
use Livewire\WithPagination;

class ItemProductGroups extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $data['itemProductGroup'] = ItemProductGroup::with('sub_group')->paginate(20);
        //dd($data);
        return view('livewire.item-product-groups', $data);
    }
}
