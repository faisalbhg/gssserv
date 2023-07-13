<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\ServiceItemsPrice;
use App\Models\ServiceItems;

use Carbon\Carbon;
use Livewire\WithPagination;

class SalesItems extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search_items = "";

    public function render()
    {
        $data['salesItems'] = ServiceItemsPrice::with('serviceItems')
                    ->whereRelation('serviceItems', 'item_name', 'like', "%{$this->search_items}%")
                    ->with('customertype')
                    ->where('customer_types','!=',null)
                    ->where('start_date', '<=', Carbon::now())
                    ->where(function ($query) {
                            $query->orWhere('end_date', '>=', Carbon::now())
                        ->orWhere('end_date', '=', null ) ;
                        }
                    )
                    //->where('start >=', [$startDate, $endDate])
                    ->paginate(20);
        
        //dd($data);
        return view('livewire.sales-items',$data);
    }
}
