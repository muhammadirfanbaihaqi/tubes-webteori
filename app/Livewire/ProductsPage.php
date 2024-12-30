<?php

namespace App\Livewire;

use App\Helpers\CartManagement;
use App\Livewire\Partials\Navbar;
use App\Models\Category;
use App\Models\product;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Products Page')]
class ProductsPage extends Component
{
    use LivewireAlert;
    use WithPagination;
    #[Url]
    public $selected_categories = [];

    #[Url]
    public $price_range = 12000;

    #[Url]
    public $sort = 'latest';

    // add product to cart method
    public function addToCart($product_id){
        $total_count = CartManagement::addItemToCart($product_id);
        $this->dispatch("update-cart-count", total_count : $total_count)->to(Navbar::class);

        $this->alert('success', 'Product added to cart!', [
            'position' => 'bottom-end',
            'timer' => 3000,
            'toast' => true,
        ]);
    }

    public function render()
    {
        $productQuery = product::query()->where('is_active', true);
        if(!empty($this->selected_categories)) {
            $productQuery->whereIn('category_id', $this->selected_categories);

        }
        if($this->price_range) {
            $productQuery->whereBetween('price', [0, $this->price_range]);
        }

        if ($this->sort == 'latest') {
            $productQuery->latest();
        }
        if ($this->sort == 'price') {
            $productQuery->orderBy('price');
        }


        return view('livewire.products-page',[
            'products' => $productQuery->paginate(6),
            'categories' => Category::where('is_active', true)->get(['id', 'name','slug']),
        ]);
    }
}
