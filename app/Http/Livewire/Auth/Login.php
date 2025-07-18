<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;
use App\Models\User;
use Session;
class Login extends Component
{
    public $email = '';
    public $password = '';
    public $remember_me = false;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required',
    ];

    public function mount() {
        if(auth()->user()){
            redirect('dashboard');
        }
        $this->fill(['email' => '', 'password' => '']);
    }

    public function login() {
        $credentials = $this->validate();
        if(auth()->attempt(['email' => $this->email, 'password' => $this->password], $this->remember_me)) {
            $user = User::with(['stationName'])->where(["email" => $this->email])->first();
            auth()->login($user, $this->remember_me);
            Session::put('user', $user);
            return redirect()->intended('dashboard');        
        }
        else{
            return $this->addError('email', trans('auth.failed')); 
        }
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
