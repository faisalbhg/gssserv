<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Hash;

use Livewire\Component;
use App\Models\User;
use App\Models\Stationcode;
use App\Models\Department;

use Carbon\Carbon;
use Session;
use Livewire\WithPagination;

class UserManagement extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $title, $buttonName, $user_id, $name, $email, $password, $showpasswordinput=false, $phone, $user_type, $station_id, $created_by, $updated_by, $is_active, $is_blocked, $userId, $manageUser = false,$users, $stationsList, $departmentsList;


    public function render()
    {
        $data['usersList'] = User::with('stationName')->paginate(10);
        $this->stationsList = Stationcode::all();
        $this->departmentsList = Department::all();
        return view('livewire.user-management',$data);
    }

    /**
     * Open Add Post form
     * @return void
     */
    public function addUser()
    {
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->showpasswordinput=true;
        $this->phone = '';
        $this->station_id = null;
        $this->user_id = null;
        $this->is_active = 1;
        $this->manageUser = true;
        $this->user_type = true;
        $this->title = 'Add New User';
        $this->buttonName = 'Save';
        $this->dispatchBrowserEvent('showUserModel');
    }
    
    /**
     * show existing post data in edit post form
     * @param mixed $id
     * @return void
     */
    public function editUser($id){
        $user = User::findOrFail($id);
        $this->name = $user->name;
        $this->email = $user->email;
        $this->showpasswordinput=false;
        $this->password = '';
        $this->phone = $user->phone;
        $this->station_id = $user->station_id;
        $this->station_id = $user->user_type;
        $this->user_id = $user->id;
        $this->is_active = $user->is_active;
        $this->manageUser = true;
        $this->title = 'Edit User';
        $this->buttonName = 'Update';
        $this->dispatchBrowserEvent('showUserModel');
    }
 
    /**
     * update the post data
     * @return void
     */
    public function storeUserData()
    {
        $validatedData = $this->validate([
            'name' => 'required',
            'email' => 'required|email',
            'user_type' => 'required',
            'password' => 'required',
        ]);
        //dd($this);
        if($this->user_id!=null){
            User::find($this->user_id)->update([
                'name'=>$this->name,
                'email'=>$this->email,
                'phone'=>$this->phone,
                'user_type'=>$this->station_id,
                'station_id'=>$this->user_type,
                'is_active'=>$this->is_active,
            ]);
            session()->flash('success', 'User updated successfully !');
        }
        else
        {
            User::create([
                'name'=>$this->name,
                'email'=>$this->email,
                'password'=>Hash::make($this->password),
                'phone'=>$this->phone,
                'user_type'=>$this->user_type,
                'station_id'=>$this->station_id,
                'is_active'=>$this->is_active,
                'created_by'=>Session::get('user')->id,
            ]);
            session()->flash('success', 'User added successfully !');
        }
        $this->dispatchBrowserEvent('hideUserModel');
    }
 
    /**
     * Cancel Add/Edit form and redirect to post listing page
     * @return void
     */
    public function cancelPost()
    {
        $this->addPost = false;
        $this->updatePost = false;
        $this->resetFields();
    }
 
    /**
     * delete specific post data from the posts table
     * @param mixed $id
     * @return void
     */
    public function deletePost($id)
    {
        try{
            Posts::find($id)->delete();
            session()->flash('success',"Post Deleted Successfully!!");
        }catch(\Exception $e){
            session()->flash('error',"Something goes wrong!!");
        }
    }

    
}
