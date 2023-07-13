<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\Department;

use Carbon\Carbon;

class Departments extends Component
{

    public $modalTitle, $department_id, $department_code, $department_name, $department_description , $is_active, $manageDepartment = false,$departments;


    public function render()
    {
        $this->departments = Department::all();
        return view('livewire.department');
    }

    public function addNewDepartment(){
        $this->manageDepartment = true;
        $this->department_code = '';
        $this->department_name = '';
        $this->department_id = null;
        $this->departmentTitle = 'Add New Department';
        $this->dispatchBrowserEvent('showDepartmentModel');
    }

    public function editDepartment($id)
    {
        $departmentSingle = Department::find($id);
        $this->department_code = $departmentSingle->department_code;
        $this->department_name = $departmentSingle->department_name;
        $this->department_id = $departmentSingle->id;
        $this->manageDepartment = true;
        $this->departmentTitle = 'Update '.$departmentSingle->department_name;
        $this->dispatchBrowserEvent('showDepartmentModel');
    }

    public function manageDepartment()
    {
        if($this->department_id!=null){
            Department::find($this->department_id)->update([
                'department_code'=>$this->department_code,
                'department_name'=>$this->department_name,
            ]);
            session()->flash('success', 'Department updated successfully !');
        }
        else
        {
            Department::create([
                'department_code'=>$this->department_code,
                'department_name'=>$this->department_name,
            ]);
            session()->flash('success', 'Department added successfully !');
        }
        $this->departments = Department::all();
        $this->dispatchBrowserEvent('hideDepartmentModel');
    }
}
