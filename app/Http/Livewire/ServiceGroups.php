<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Carbon\Carbon;
use Session;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

use App\Models\Development;
use App\Models\Sections;

class ServiceGroups extends Component
{
    public $servicesGroupList, $service_group_id, $service_group_name, $service_group_code, $sectionsLists, $sectionServiceLists=[], $station,$service_sort=1, $selectServiceItems, $selectPackageMenu=false, $showServiceSectionsList=false;
    public $jobCardDetails;
    public $showSectionsList=false, $qlFilterOpen=false, $qlBrandsLists=[];

    public $quickLubeItemsList=[],$serviceItemsList=[], $quickLubeItemSearch='', $showQlItems=false, $showQlEngineOilItems=false, $showQlCategoryFilterItems=false, $showQuickLubeItemSearchItems=false, $itemQlCategories=[],  $ql_search_category, $ql_search_subcategory, $ql_search_brand, $ql_km_range;
    public $item_search_category, $itemCategories=[], $item_search_subcategory, $itemSubCategories =[], $item_search_brand, $itemBrandsLists=[], $itemSearchName, $ql_item_qty;

    public function mount($jobDetails)
    {
        $this->jobCardDetails = $jobDetails;
    }

    public function render()
    {
        
        $this->servicesGroupList = Development::select('DevelopmentCode as department_code','DevelopmentName as department_name','id','LandlordCode as station_code')->where(['Operation'=>true,'LandlordCode'=>auth()->user('user')->station_code])->get();

        if($this->service_group_code)
        {
            $this->showSectionsList=true;
            $this->sectionsLists = Sections::select('id','PropertyCode','DevelopmentCode','PropertyNo','PropertyName','Operation')
                ->where([
                    'DevelopmentCode'=>$this->service_group_code,
                    'Operation'=>true
                ])
                ->get();
        }
        //dd($this);
        return view('livewire.service-groups');
    }

    public function serviceGroupForm($service){
        $this->service_group_id = $service['id'];
        $this->service_group_name = $service['department_name'];
        $this->service_group_code = $service['department_code'];
        $this->station = $service['station_code'];

        $this->showSectionsList=true;

        /*if($this->service_group_name =='Quick Lube')
        {
            $sectionDetails = Sections::select('id','PropertyCode','DevelopmentCode','PropertyNo','PropertyName','Operation')
                ->where([
                    'DevelopmentCode'=>$this->service_group_code,
                    'Operation'=>true,
                    'PropertyName'=>'Quick Lube',
                ])->first();
            $this->propertyCode=$sectionDetails->PropertyCode;
            $this->selectedSectionName = $sectionDetails->PropertyName;
        }

        if($this->service_group_name !='Quick Lube' || $this->showQlItems == true)
        {
            $this->showQlItems=false;
        }*/
    }
}
