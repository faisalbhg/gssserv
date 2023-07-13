<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\Services;
use App\Models\ServicesType;
use App\Models\ServicesGroup;

use Carbon\Carbon;
use Livewire\WithPagination;

class Service extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $modalTitle, $manageServices = false;

    public $service_code = '';
    public $service_type_name = '';
    public $customerType = '';
    public $department_name = '';
    public $station_name = '';

    public function render()
    {
        $data['servicesList'] = ServicesType::select(
            'services.*',
            'services_types.service_type_name',
            'services_types.service_type_code',
            'services_groups.service_group_name',
            'services_groups.service_group_code',

            /*'services_types.id AS service_type_id',
            'services_types.service_type_name',
            'services_types.service_type_code',
            'services_types.service_type_description',
            'services_types.service_group_id',
            'services_types.department_id',
            'services_types.section_id',
            'services_types.station_id',
            'services_groups.service_group_name',
            'services_groups.service_group_code',*/

            'departments.department_name',
            'sections.section_name',
            'stationcodes.station_name',
            'customertypes.customer_type as customerType'
        )
        ->leftjoin('services', 'services_types.id', '=', 'services.service_type_id')
        ->leftjoin('services_groups', 'services_groups.id', '=', 'services_types.service_group_id')
        ->leftjoin('departments','departments.id','=','services_types.department_id')
        ->leftjoin('sections','sections.id','=','services_types.station_id')
        ->leftjoin('stationcodes','stationcodes.id','=','services_types.station_id')
        ->leftjoin('customertypes','customertypes.id','=','services.customer_type')
        ->where('services_types.service_type_code','like',"%{$this->service_code}%")
        ->where('services_types.service_type_name','like',"%{$this->service_type_name}%")
        ->where('customertypes.customer_type','like',"%{$this->customerType}%")
        ->where('departments.department_name','like',"%{$this->department_name}%")
        ->where('stationcodes.station_name','like',"%{$this->station_name}%")
        ->paginate(20);
        
        return view('livewire.servicelist',$data);
    }

    public function brandList()
    {
        return view('livewire.brands');
    }


}
