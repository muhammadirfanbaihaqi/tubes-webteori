<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Attributes\Title;
use Livewire\Component;


#[Title('Categories Page - BG')]
class CategoriesPage extends Component
{
    public function render()
    {
        $categories = Category::where('is_active', true)->get();
        return view('livewire.categories-page', [
            'categories' => $categories,
        ]);
    }
}
