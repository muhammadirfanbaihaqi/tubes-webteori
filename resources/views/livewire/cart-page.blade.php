<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto bg-gray-50">
  <div class="container mx-auto px-4">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Shopping Cart</h1>
    <div class="flex flex-col md:flex-row gap-6">
      <!-- Products Section -->
      <div class="md:w-3/4">
        <div class="bg-white rounded-lg shadow-md p-6 mb-6 border border-gray-200">
          <table class="w-full text-sm text-gray-700">
            <thead class="bg-gray-100 border-b border-gray-200">
              <tr>
                <th class="text-left font-semibold py-2 px-4">Product</th>
                <th class="text-left font-semibold py-2 px-4">Price</th>
                <th class="text-left font-semibold py-2 px-4">Quantity</th>
                <th class="text-left font-semibold py-2 px-4">Total</th>
                <th class="text-left font-semibold py-2 px-4">Remove</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($cart_items as $item)
              <tr wire:key="{{ $item['product_id'] }}" class="hover:bg-gray-50">
                <td class="py-4 px-4">
                  <div class="flex items-center">
                    <img class="h-16 w-16 mr-4 rounded-lg border border-gray-200" src="{{ Url('storage', $item['images']) }}" alt="{{ $item['name'] }}">
                    <span class="font-semibold text-gray-800">{{ $item['name'] }}</span>
                  </div>
                </td>
                <td class="py-4 px-4 text-gray-800"> {{ Number::currency($item['unit_amount'], 'IDR') }} </td>
                <td class="py-4 px-4">
                  <div class="flex items-center">
                    <button wire:click="decreaseQty({{ $item['product_id'] }})" class="border rounded-md py-1 px-3 bg-gray-100 hover:bg-gray-200">-</button>
                    <span class="text-center w-8 mx-2">{{ $item['quantity'] }}</span>
                    <button wire:click="increaseQty({{ $item['product_id'] }})" class="border rounded-md py-1 px-3 bg-gray-100 hover:bg-gray-200">+</button>
                  </div>
                </td>
                <td class="py-4 px-4 text-gray-800">{{ Number::currency($item['total_amount'], 'IDR') }}</td>
                <td class="py-4 px-4">
                  <button wire:click="removeItem({{ $item['product_id'] }})" class="bg-red-500 text-white px-3 py-1 rounded-lg hover:bg-red-600">
                    <span wire:loading.remove wire:target="removeItem({{ $item['product_id'] }})">Remove</span>
                    <span wire:loading wire:target="removeItem({{ $item['product_id'] }})">Removing</span>
                  </button>
                </td>
              </tr>
              @empty
              <tr>
                <td class="py-6 px-4 text-center" colspan="5">
                  <span class="text-gray-600">Cart is empty</span>
                </td>
              </tr>

              @endforelse

              
              <!-- More product rows -->
            </tbody>
          </table>
        </div>
      </div>

      <!-- Summary Section -->
      <div class="md:w-1/4">
        <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200">
          <h2 class="text-lg font-semibold mb-4 text-gray-800">Order Summary</h2>
          <div class="flex justify-between mb-4">
            <span class="text-gray-600">Subtotal</span>
            <span class="text-gray-800">{{ Number::currency($grand_total, 'IDR') }}</span>
          </div>
          <div class="flex justify-between mb-4">
            <span class="text-gray-600">Taxes</span>
            <span class="text-gray-800">{{ Number::currency(0, 'IDR') }}</span>
          </div>
          <div class="flex justify-between mb-4">
            <span class="text-gray-600">Shipping</span>
            <span class="text-gray-800">{{ Number::currency(0, 'IDR') }}</span>
          </div>
          <hr class="my-4">
          <div class="flex justify-between mb-4">
            <span class="font-semibold text-gray-800">Grand Total</span>
            <span class="font-semibold text-gray-800">{{ Number::currency($grand_total, 'IDR') }}</span>
          </div>
          @if ($cart_items)
            <a href="/checkout" class="bg-blue-600 block text-center text-white py-2 px-4 rounded-lg w-full hover:bg-blue-700 transition">Proceed to Checkout</a href="/checkout">
          @endif
        </div>
      </div>
    </div>
  </div>
</div>
