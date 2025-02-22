<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Stripe\Checkout\Session;
use Stripe\Stripe;

#[Title('Order Success | GR SHOPPING')]
class SuccessPage extends Component
{
    #[Url()]
    public $session_id;

    public function render()
    {
        $last_order = Order::with('address')->where('user_id', auth()->user()->id)->latest()->first();
        if ($this->session_id) {
            Stripe::setApiKey(env('STRIPE_SECRET'));
            $session_info = Session::retrieve($this->session_id);
            //dd($session_info);
            if ($session_info != 'paid') {
                $last_order->payment_status = 'failed';
                $last_order->save();
                return redirect('/cancel');
            } else if ($session_info == 'paid') {
                $last_order->payment_status = 'paid';
                $last_order->save();
            }
        }
        return view('livewire.success-page', [
            'order' => $last_order,
        ]);
    }
}
