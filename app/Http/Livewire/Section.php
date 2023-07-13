<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\Sections;

use Carbon\Carbon;
use Livewire\WithPagination;

class Section extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $sectionTitle, $section_id, $section_code, $section_name, $section_description , $is_active, $manageSection = false;

    public function render()
    {
        $sectionList = Sections::paginate(10);
        $data['sectionList'] = $sectionList;
        return view('livewire.section',$data);
    }

    public function addNewSection(){
        $this->manageSection = true;
        $this->section_code = '';
        $this->section_name = '';
        $this->section_description = '';
        $this->is_active = '';
        $this->section_id = null;
        $this->sectionTitle = 'Add New Section';
        $this->dispatchBrowserEvent('showSectionModel');
    }

    public function editSection($id)
    {
        $sectionSingle = Sections::find($id);
        $this->section_code = $sectionSingle->section_code;
        $this->section_name = $sectionSingle->section_name;
        $this->section_description = $sectionSingle->section_description;
        $this->section_id = $sectionSingle->id;
        $this->is_active = $sectionSingle->is_active;
        $this->manageSection = true;
        $this->sectionTitle = 'Update '.$sectionSingle->section_name;
        $this->dispatchBrowserEvent('showSectionModel');
    }

    public function manageSection()
    {
        if($this->section_id!=null){
            Sections::find($this->section_id)->update([
                'section_code'=>$this->section_code,
                'section_name'=>$this->section_name,
                'section_description'=>$this->section_description,
                'is_active'=>$this->is_active,
            ]);
            session()->flash('success', 'Section updated successfully !');
        }
        else
        {
            Sections::create([
                'section_code'=>$this->section_code,
                'section_name'=>$this->section_name,
                'section_description'=>$this->section_description,
                'is_active'=>$this->is_active,
            ]);
            session()->flash('success', 'Section added successfully !');
        }
        $this->dispatchBrowserEvent('hideSectionModel');
    }
}
