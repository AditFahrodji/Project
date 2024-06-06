<?php

namespace App\Livewire;

use App\Helpers\CartManagement;
use App\Livewire\Partials\Navbar;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Cart - TrendStore')]
class KeranjangPage extends Component
{
    public $cart_items = [];
    public $total;

    public function mount(){
        $this->cart_items = CartManagement::getCartItemsFromCookie();
        $this->total = CartManagement::calculateCartTotal($this->cart_items);
    }

    public function removeItem($produk_id){
        $this->cart_items = CartManagement::removeCartItem($produk_id);
        $this->total = CartManagement::calculateCartTotal($this->cart_items);
        $this->dispatch('update-cart-count', total_count: count($this->cart_items))->to(Navbar::class);
    }

    public function increaseQty($produk_id){
        $this->cart_items = CartManagement::incrementQuantityToCartItem($produk_id);
        $this->total = CartManagement::calculateCartTotal($this->cart_items);
    }

    public function decreaseQty($produk_id){
        $this->cart_items = CartManagement::decrementQuantityToCartItem($produk_id);
        $this->total = CartManagement::calculateCartTotal($this->cart_items);
    }

    public function render()
    {
        return view('livewire.keranjang-page');
    }
}
