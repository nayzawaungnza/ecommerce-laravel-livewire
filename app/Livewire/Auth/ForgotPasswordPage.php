<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Password;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Forgot Password | GR SHOPPING')]
class ForgotPasswordPage extends Component
{

    public $email;

    public function forgotPassword()
    {
        $this->validate(['email' => 'required|email|exists:users,email|max:255']);
        $status = Password::sendResetLink(['email' => $this->email]);
        if ($status === Password::RESET_LINK_SENT) {
            session()->flash('success', 'Password Reset Link has been sent to your email address.');
            $this->email = '';
        }
    }
    public function render()
    {
        return view('livewire.auth.forgot-password-page');
    }
}
