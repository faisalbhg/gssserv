<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\ServiceMaster;
use Livewire\WithPagination;

use Illuminate\Http\Request;
use URL;
use App\Exports\ServicesMasterExport;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\ServicesSectionsGroup;
use App\Models\ServicesGroup;

class ServicesMasterList extends Component
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $service_master_search='';
    public $isAddedNew=false, $isAvailable=false, $showManualForm=false, $serviceSectionGroupList=[], $serviceGroupList=[];
    public $new_service_name, $new_service_code, $new_cost_price, $new_service_section_group_code, $new_service_group_code;

    public function render()
    {
        $serviceMasterList = ServiceMaster::with(['serviceSectionGroup']);
        if($this->service_master_search){
            $serviceMasterList = $serviceMasterList->orWhere('service_name','like',"%{$this->service_master_search}%")->orWhere('service_code','like',"%{$this->service_master_search}%");
        }

        $data['serviceMasterList'] = $serviceMasterList->paginate(20);
        return view('livewire.services-master-list',$data);
    }

    public function exportServiceMaster(){
        $serviceMasterQuery = ServiceMaster::select('id', 'service_name', 'service_code', 'sale_price')->where(['is_active'=>1])->get();
        return Excel::download(new ServicesMasterExport($serviceMasterQuery), 'service_report'.date('YmdHis').'.xlsx');
    }

    public function addNewServiceMastter(){
        $this->showManualForm=true;
        $this->serviceSectionGroupList = ServicesSectionsGroup::where(['is_active'=>1])->get();
        $this->serviceGroupList = ServicesGroup::where(['is_active'=>1])->get();
    }

    public function saveNewServiceMaster(){
        $serviceCodeAvail = ServiceMaster::where('service_code', '=', $this->new_service_code)->get();
        dd($serviceCodeAvail);
        $serviceCodeAvailCount = $serviceCodeAvail->count();
        if($serviceCodeAvailCount==0){
            $saveManualInsert = [
                'service_name'=>$this->new_service_name,
                'service_code'=>$this->new_service_code,
                'service_description'=>$this->new_service_name,
                'cost_price'=>$this->new_cost_price,
                'sale_price'=>$this->new_cost_price,
                'vat_included'=>$this->new_cost_price,
                'service_section_group_id'=>ServicesSectionsGroup::where('service_section_group_code', $this->new_service_section_group_code)->pluck('id')->first(),
                'service_section_group_code'=>$this->new_service_section_group_code,
                'service_group_id'=>ServicesGroup::where('service_group_code', $this->new_service_group_code)->pluck('id')->first(),
                'service_group_code'=>$this->new_service_group_code,
                'created_by'=>Session::get('user')->station_id,
                'is_active'=>1,
                'created_at'=>Carbon::now(),
            ];
            dd($saveManualInsert);
            ServiceMaster::create($saveManualInsert);
            $this->isAddedNew = true;
        }
        else
        {
                $this->isAvailable = true;
        }
    }

    
}
