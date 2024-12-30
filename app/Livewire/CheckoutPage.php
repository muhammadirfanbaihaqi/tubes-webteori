<?php

namespace App\Livewire;

use App\Helpers\CartManagement;
use App\Mail\OrderPlaced;
use App\Models\Address;
use App\Models\order;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title("Checkout Page")]
class CheckoutPage extends Component
{
    public $first_name;
    public $last_name;

    public $phone;
    public $jalan;
    public $kecamatan;
    public $kabkota;
    public $provinsi;
    // public $kode_pos;
    public $payment_method;

    public function mount(){
        $cart_items = CartManagement::getCartItemsFromCookies();
        if(count($cart_items)==0){
            return redirect('/products');
        }
    }

    public function placeOrder(){
        $this->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'jalan' => 'required',
            'kecamatan' => 'required',
            'kabkota' => 'required',
            'provinsi' => 'required',
            // 'kode_pos' => 'required',
            'payment_method' => 'required',
        ]);

        $cart_items = CartManagement::getCartItemsFromCookies();
        $line_items = [];
        foreach($cart_items as $item){
            $line_items[] = [
                'price_data' => [
                    'currency' => 'IDR',
                    'product_data' => [
                        'name' => $item['name'],
                    ],
                    'unit_amount' => $item['unit_amount'] * 100,
                ],
                'quantity' => $item['quantity'],
            ];
        }
        $order = new order();
        $order->user_id = auth()->user()->id;
        $order->grand_total = CartManagement::calculateGrandTotal($cart_items);
        $order->payment_method = $this->payment_method;
        $order->payment_status = 'pending';
        $order->status = 'Pending';
        $order->currency = 'IDR';
        $order->shipping_amount = 0;
        $order->shipping_method = 'None';
        $order->notes = 'Order placed by' . auth()->user()->name;

        $address = new Address();
        $address->first_name = $this->first_name;
        $address->last_name = $this->last_name;
        $address->phone = $this->phone;
        $address->jalan = $this->jalan;
        $address->kecamatan = $this->kecamatan;
        $address->kabkota = $this->kabkota;
        $address->provinsi = $this->provinsi;

        $redirect_url = '';

        if($this->payment_method == 'cod'){
            $redirect_url = route('success');
        }else{
            // bisa direct wa juga bisa
            // Payment gateway integration here
            $redirect_url = route('success');
        }

        $order->save();
        $address->order_id = $order->id;
        $address->save();
        $order->items()->createMany($cart_items);
        CartManagement::clearCartItems();
        // Mail::to(request()->user()->send(new OrderPlaced($order)));
        Mail::to(request()->user())->send(new OrderPlaced($order));

        return redirect($redirect_url);                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 

    }


    public function render()
    {
        $cart_items = CartManagement::getCartItemsFromCookies();
        $grand_total = CartManagement::calculateGrandTotal($cart_items);
        return view('livewire.checkout-page',[
            'cart_items' => $cart_items,
            'grand_total' => $grand_total
        ]);
    }
}
