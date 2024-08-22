<?php

namespace App\Livewire;

use App\Models\Brand;
use App\Models\Category;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Home | GR SHOPPING')]
class HomePage extends Component
{
    public function render()
    {
        $brands = Brand::where('is_active', 1)->orderby('created_at', 'desc')->get();
        $categories = Category::where('is_active', 1)->orderby('created_at', 'desc')->get();
        return view('livewire.home-page', [
            'brands' => $brands,
            'categories' => $categories,
        ]);
    }
}
