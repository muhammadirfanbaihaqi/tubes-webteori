<?php

namespace App\Livewire;

use App\Helpers\CartManagement;
use App\Livewire\Partials\Navbar;
use App\Models\product;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Product Detail')]
class ProductDetailPage extends Component
{
    use LivewireAlert;
    public $slug;
    public $quantity = 1;

    public function mount($slug){
        $this->slug = $slug;
    }
    public function increaseQty(){
        $this->quantity++;
    }
    public function decreaseQty(){
        if ($this->quantity > 1){
            $this->quantity--;
        }
    }

    // aku rubah dari addToCart ke addToCartWithQty
    public function addToCartWithQty($product_id){
        $total_count = CartManagement::addItemToCartWithQty($product_id, $this->quantity);
        $this->dispatch("update-cart-count", total_count : $total_count)->to(Navbar::class);

        $this->alert('success', 'Product added to cart!', [
            'position' => 'top-end',
            'timer' => 3000,
            'toast' => true,
        ]);
    }

    public function render()
    {
        return view('livewire.product-detail-page',[
            'product' => product::where('slug', $this->slug)->firstOrFail() // Assuming Product model exists and has slug field
        ]);
    }
}
