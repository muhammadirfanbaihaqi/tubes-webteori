<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Home Page - BG')]
class HomePage extends Component
{
    public function render()
    {
        $categories = Category::where('is_active', true)->get();
        return view('livewire.home-page',[
            'categories' => $categories,
        ] 
    );

    }
}
