<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\ServicesType;
use Livewire\WithPagination;

class Servicestypes extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $modalTitle, $manageServicetype = false;
    public $service_type_search = '';

    public function render()
    {
        $data['serviceTypeList'] = ServicesType::
            select(
                'services_types.*',
                'services_groups.service_group_name',
                'departments.department_name',
                'sections.section_name',
                'stationcodes.station_name')
            ->leftjoin('services_groups','services_groups.id','=','services_types.service_group_id')
            ->leftjoin('departments','departments.id','=','services_types.department_id')
            ->leftjoin('sections','sections.id','=','services_types.station_id')
            ->leftjoin('stationcodes','stationcodes.id','=','services_types.station_id')
            ->where('services_types.service_type_name','like',"%{$this->service_type_search}%")
            ->paginate(20);
        return view('livewire.servicestype',$data);
    }
}
