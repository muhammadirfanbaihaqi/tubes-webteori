<?php

namespace App\Livewire;

use App\Models\order;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title("My Orders")]

class MyOrdersPage extends Component
{
    use WithPagination;
    public function render()
    {
        $my_orders = order::where('user_id',auth()->id())->latest()->paginate(4);
        return view('livewire.my-orders-page',[
            'orders' => $my_orders
        ]);
    }
}
