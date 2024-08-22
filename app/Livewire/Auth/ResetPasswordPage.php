<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Attributes\Url;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

#[Title('Reset Password | GR SHOPPING')]
class ResetPasswordPage extends Component
{
    public $token;

    #[Url()]
    public $email;
    public $password;
    public $password_confirmation;

    public function mount($token)
    {
        $this->token = $token;
    }

    public function resetpassword()
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required|min:6|max:255|confirmed',
            'password_confirmation' => 'required'
        ]);

        $status = Password::reset(
            [
                'email' => $this->email,
                'password' => $this->password,
                'password_confirmation' => $this->password_confirmation,
                'token' => $this->token,
            ],
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        if ($status == Password::PASSWORD_RESET) {
            session()->flash('success', 'Password reset successfully.');
            return redirect('/login');
        } else {
            session()->flash('error', 'Something went wrong.');
        }
    }

    public function render()
    {
        return view('livewire.auth.reset-password-page');
    }
}
