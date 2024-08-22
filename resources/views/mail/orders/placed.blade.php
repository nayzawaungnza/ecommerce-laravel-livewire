<x-mail::message>
    # Order placed successfully!.
    Thank you for your order. Your order number is : {{$order->id}}.
    <x-mail::button :url="$url">
        view order
    </x-mail::button>

    Thanks,<br>
    {{ config('app.name') }}
</x-mail::message>
