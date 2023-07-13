<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\ServicesGroup;


class Servicesgroups extends Component
{
    public $modalTitle, $manageServiceGroup = false, $serviceGroupList;

    public function render()
    {
        $this->serviceGroupList = ServicesGroup::
            select('services_groups.*','stationcodes.station_name','stationcodes.station_code')
            ->join('stationcodes','stationcodes.id','=','services_groups.station_id')
            ->get();
        return view('livewire.servicesgroup');
    }

    
}
