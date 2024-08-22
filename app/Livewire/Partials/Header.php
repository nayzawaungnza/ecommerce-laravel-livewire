<?php

namespace App\Livewire\Partials;

use App\Models\GeneralSetting;
use Livewire\Component;

class Header extends Component
{
    public function render()
    {
        $sites = GeneralSetting::first();
        return view('livewire.partials.header', compact('sites'));
    }
}
