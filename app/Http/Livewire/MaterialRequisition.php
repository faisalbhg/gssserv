<?php

namespace App\Http\Livewire;

use Livewire\Component;

use Illuminate\Http\Request;
use Livewire\WithFileUploads;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\Http;
use LaravelPayfort\Facades\Payfort;
use Illuminate\Support\Facades\Hash;
use DB;
use Spatie\Image\Image;
use Livewire\WithPagination;

use App\Models\Development;
use App\Models\Sections;
use App\Models\InventoryItemMaster;
use App\Models\ItemCategories;


class MaterialRequisition extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $showServiceGroup=true, $showQWServiceMRItems=false;
    public $servicesGroupList, $service_group_id, $service_group_name, $service_group_code, $station;
    public $mt_serive_item_search, $serviceItemsList=[];
    public function render()
    {
        dd(ItemCategories::where(['Active'=>1])->get());
        $this->servicesGroupList = Development::select('DevelopmentCode as department_code','DevelopmentName as department_name','id','LandlordCode as station_code')->where(['Operation'=>true,'LandlordCode'=>auth()->user('user')['station_code']])->get();
        if($this->showQWServiceMRItems)
        {
            $this->showQWServiceMRItemsResults=true;
            $inventoryItemMasterLists = InventoryItemMaster::where('Active','=',1);
            if($this->mt_serive_item_search){
                $inventoryItemMasterLists = $inventoryItemMasterLists->where('ItemName','like',"%{$this->mt_serive_item_search}%");
            }
            $data['serviceItemsList']=$inventoryItemMasterLists->paginate(20);
            dd($data);

        }

        return view('livewire.material-requisition',$data);
    }

    public function serviceGroupForm($service){
        $this->service_group_id = $service['id'];
        $this->service_group_name = $service['department_name'];
        $this->service_group_code = $service['department_code'];
        $this->station = $service['station_code'];
        $this->showQWServiceMRItems=true;
    }

    
}
