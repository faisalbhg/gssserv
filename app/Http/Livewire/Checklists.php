<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\ServiceChecklist;
use App\Models\ServicesGroup;

class Checklists extends Component
{
    public $checklists=[];
    public $service_group=[];
    public $managecheckListModel=false;
    public $checklist_id,$title,$checklist_label,$service_group_id,$is_active;

    public function render()
    {
        $this->checklists = ServiceChecklist::with('service_group')->where(['is_active'=>1])->get();
        //dd($this->checklists);
        return view('livewire.checklists');
    }

    public function addCheckList(){
        $this->service_group = ServicesGroup::where(['is_active'=>1])->get();
        $this->managecheckListModel=true;
        $this->checklist_id=null;
        $this->checklist_label='';
        $this->service_group_id=null;
        $this->is_active=0;
        $this->title = 'Add New Check List';
        //dd($this);
        $this->dispatchBrowserEvent('showCheckListModel');
    }

    public function editCheckList($id)
    {
        $this->service_group = ServicesGroup::where(['is_active'=>1])->get();
        $checkListSingle = ServiceChecklist::find($id);
        $this->managecheckListModel=true;
        $this->checklist_id=$checkListSingle->id;
        $this->checklist_label=$checkListSingle->checklist_label;
        $this->service_group_id=$checkListSingle->service_group_id;
        $this->is_active=$checkListSingle->is_active;
        $this->title = 'Update '.$checkListSingle->checklist_label;
        $this->dispatchBrowserEvent('showCheckListModel');
    }

    public function updateCheckList(){
        if($this->checklist_id!=null){
            ServiceChecklist::find($this->checklist_id)->update([
                'checklist_label'=>$this->checklist_label,
                'service_group_id'=>$this->service_group_id,
                'is_active'=>$this->is_active,
            ]);
            session()->flash('success', 'Checklist updated successfully !');
        }
        else
        {
            ServiceChecklist::create([
                'checklist_label'=>$this->checklist_label,
                'service_group_id'=>$this->service_group_id,
                'is_active'=>1,
            ]);
            session()->flash('success', 'Checklist added successfully !');
        }
        $this->dispatchBrowserEvent('hideCheckListModel');
    }
}
