<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('My Orders | GR SHOPPING')]
class MyOrdersPage extends Component
{

    public function render()
    {
        $orders = Order::where('user_id', auth()->user()->id)->latest()->paginate(5);
        return view('livewire.my-orders-page', [
            'orders' => $orders,
        ]);
    }
}
