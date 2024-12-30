<?php

namespace App\Helpers;

use App\Models\product;
use Illuminate\Support\Facades\Cookie;

class CartManagement{
    // tambah item ke cart
    static public function addItemToCart($product_id){
        $cart_items = self::getCartItemsFromCookies();
        $existing_items = null;
        foreach ($cart_items as $key => $item){
            if ($item['product_id'] == $product_id){
                $existing_items = $key;
                break;
            }
        }
        if($existing_items !== null){
            $cart_items[$existing_items]['quantity']++;
            $cart_items[$existing_items]['total_amount'] = $cart_items[$existing_items]['quantity']  
            * $cart_items[$existing_items]['unit_amount'];
        
        } else{
            $product = product::where('id', $product_id)->first(['id', 'name', 'price', 'images']);
            if ($product){
                $cart_items[] = [
                    'product_id' => $product_id,
                    'name' => $product->name,
                    'images' => $product->images,
                    'quantity' => 1,
                    'unit_amount' => $product->price,
                    'total_amount' => $product->price,
                ];
            }
        }
        self::addCartItemsToCookies($cart_items);
        return count($cart_items);
    }

    // add item to cart with qty
    static public function addItemToCartWithQty($product_id, $qty){
        $cart_items = self::getCartItemsFromCookies();
        $existing_items = null;
        foreach ($cart_items as $key => $item){
            if ($item['product_id'] == $product_id){
                $existing_items = $key;
                break;
            }
        }
        if($existing_items !== null){
            $cart_items[$existing_items]['quantity'] = $qty + $item['quantity'];
            $cart_items[$existing_items]['total_amount'] = $cart_items[$existing_items]['quantity']  
            * $cart_items[$existing_items]['unit_amount'];
        
        } else{
            $product = product::where('id', $product_id)->first(['id', 'name', 'price' ,'images']);
            if ($product){
                $cart_items[] = [
                    'product_id' => $product_id,
                    'name' => $product->name,
                    'images' => $product->images,
                    'quantity' => $qty,
                    'unit_amount' => $product->price,
                    'total_amount' => $product->price * $qty,
                ];
            }
        }
        self::addCartItemsToCookies($cart_items);
        return count($cart_items);
    }

    // hapus item dari cart
    static public function removeItemFromCart($product_id){
        $cart_items = self::getCartItemsFromCookies();
        foreach ($cart_items as $key => $item){
            if ($item['product_id'] == $product_id){
                unset($cart_items[$key]);
                // break;
            }
        }

        self::addCartItemsToCookies($cart_items);
        return $cart_items;
    }


    // add cart item to cookies
    static public function addCartItemsToCookies($cart_items){
        Cookie::queue('cart_items', json_encode($cart_items), 60 * 24 *30 ); # 24 hours  for 30 days
    }

    // clear cart item from cookies
    static public function clearCartItems(){
        Cookie::queue(Cookie::forget('cart_items'));
    }
    // get all cart items from cookies
    static public function getCartItemsFromCookies(){
        $cart_items = json_decode(Cookie::get('cart_items'), true);
        if (!$cart_items) {
            $cart_items = [];
        }
        return $cart_items;
    }


    // increment cart item quantity
    static public function incrementQuantityToCartItem($product_id){
        $cart_items = self::getCartItemsFromCookies();
        foreach ($cart_items as $key => $item){
            if ($item['product_id'] == $product_id){
                $cart_items[$key]['quantity']++;
                $cart_items[$key]['total_amount'] = $cart_items[$key]['quantity']
                * $cart_items[$key]['unit_amount'];
                // break;
            }
        }
        self::addCartItemsToCookies($cart_items);
        return $cart_items;
    }


    // decrement cart item quantity
    static public function decrementQuantityToCartItem($product_id){
        $cart_items = self::getCartItemsFromCookies();
        foreach ($cart_items as $key => $item){
            if ($item['product_id'] == $product_id){
                if ($cart_items[$key]['quantity'] > 1){
                    $cart_items[$key]['quantity']--;
                    $cart_items[$key]['total_amount'] = $cart_items[$key]['quantity']
                    * $cart_items[$key]['unit_amount'];
                }
            }
        }
        self::addCartItemsToCookies($cart_items);
        return $cart_items;
    }


    // calcullate grand total
    static public function calculateGrandTotal($items){
        return array_sum(array_column($items, 'total_amount'));
    }
}