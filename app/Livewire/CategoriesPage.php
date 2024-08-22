<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;
use Livewire\Attributes\Title;

#[Title('Categories | GR SHOPPING')]
class CategoriesPage extends Component
{
    public function render()
    {
        $categories = Category::where('is_active', 1)->orderby('created_at', 'desc')->get();
        return view('livewire.categories-page', [
            'categories' => $categories,
        ]);
    }
}
