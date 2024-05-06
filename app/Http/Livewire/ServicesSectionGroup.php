<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\ServicesSectionsGroup;
use Livewire\WithPagination;

class ServicesSectionGroup extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $service_section_group_search='';

    public function render()
    {
        $serviceSectionGroupList = ServicesSectionsGroup::with(['serviceGroup']);
        if($this->service_section_group_search){
            $serviceSectionGroupList = $serviceSectionGroupList->where('service_section_group_name','like',"%{$this->service_section_group_search}%");
        }

        $data['serviceSectionGroupList'] = $serviceSectionGroupList->paginate(20);
        return view('livewire.services-section-group',$data);
    }
}
