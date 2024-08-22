<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Login | GR SHOPPING')]
class LoginPage extends Component
{
    public $email;
    public $password;

    public function loginform()
    {
        $this->validate([
            'email' => 'required|email|max:255|exists:users,email',
            'password' => 'required|min:6|max:255',
        ]);

        if (!Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            session()->flash('error', 'Invalid credentials.');
            return;
        }

        return redirect()->intended('/'); // Redirect to the intended page or a default one
    }

    public function render()
    {
        return view('livewire.auth.login-page');
    }
}
