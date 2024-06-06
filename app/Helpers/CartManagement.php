<?php

namespace App\Helpers;

use App\Models\Produk;
use Illuminate\Support\Facades\Cookie;

class CartManagement
{
    // add item to cart
    static public function addItemToCart($produk_id)
    {
        $cart_items = self::getCartItemsFromCookie();

        $existing_item = null;

        foreach ($cart_items as $key => $item) {
            if ($item['produk_id'] == $produk_id) {
                $existing_item = $key;
                break;
            }
        }

        if ($existing_item !== null) {
            $cart_items[$existing_item]['kuantitas']++;
            $cart_items[$existing_item]['jumlah_total'] = $cart_items[$existing_item]['kuantitas'] * $cart_items[$existing_item]['jumlah_unit'];
        } else {
            $produk = Produk::where('id', $produk_id)->first(['id', 'nama', 'harga', 'gambar']);
            if ($produk) {
                $cart_items[] = [
                    'produk_id' => $produk->id,
                    'nama' => $produk->nama,
                    'gambar' => $produk->gambar,
                    'kuantitas' => 1,
                    'jumlah_unit' => $produk->harga,
                    'jumlah_total' => $produk->harga
                ];
            }
        }

        self::addCartItemsToCookie($cart_items);
        return count($cart_items);
    }

    // add item to cart with quantity
    static public function addItemToCartWithQty($produk_id, $qty = 1)
    {
        $cart_items = self::getCartItemsFromCookie();

        $existing_item = null;

        foreach ($cart_items as $key => $item) {
            if ($item['produk_id'] == $produk_id) {
                $existing_item = $key;
                break;
            }
        }

        if ($existing_item !== null) {
            $cart_items[$existing_item]['kuantitas'] = $qty;
            $cart_items[$existing_item]['jumlah_total'] = $cart_items[$existing_item]['kuantitas'] * $cart_items[$existing_item]['jumlah_unit'];
        } else {
            $produk = Produk::where('id', $produk_id)->first(['id', 'nama', 'harga', 'gambar']);
            if ($produk) {
                $cart_items[] = [
                    'produk_id' => $produk->id,
                    'nama' => $produk->nama,
                    'gambar' => $produk->gambar,
                    'kuantitas' => $qty,
                    'jumlah_unit' => $produk->harga,
                    'jumlah_total' => $produk->harga
                ];
            }
        }

        self::addCartItemsToCookie($cart_items);
        return count($cart_items);
    }


    // remove item from cart
    static public function removeCartItem($produk_id)
    {
        $cart_items = self::getCartItemsFromCookie();

        foreach ($cart_items as $key => $item) {
            if ($item['produk_id'] == $produk_id) {
                unset($cart_items[$key]);
            }
        }

        self::addCartItemsToCookie($cart_items);

        return $cart_items;
    }

    // add cart items to cookie
    static public function addCartItemsToCookie($cart_items)
    {
        Cookie::queue('cart_items', json_encode($cart_items), 60 * 24 * 30);
    }

    // clear cart items from cookie
    static public function clearCartItems()
    {
        Cookie::queue(Cookie::forget('cart_items'));
    }

    // get all cart items from cookie
    static public function getCartItemsFromCookie()
    {
        $cart_items = json_decode(Cookie::get('cart_items'), true);
        if (!$cart_items) {
            $cart_items = [];
        }

        return $cart_items;
    }

    // increment item quantity
    static public function incrementQuantityToCartItem($produk_id)
    {
        $cart_items = self::getCartItemsFromCookie();
        foreach ($cart_items as $key => $item) {
            if ($item['produk_id'] == $produk_id) {
                $cart_items[$key]['kuantitas']++;
                $cart_items[$key]['jumlah_total'] = $cart_items[$key]['kuantitas'] * $cart_items[$key]['jumlah_unit'];
            }
        }

        self::addCartItemsToCookie($cart_items);

        return $cart_items;
    }

    // decrement item quantity
    static public function decrementQuantityToCartItem($produk_id)
    {
        $cart_items = self::getCartItemsFromCookie();
        foreach ($cart_items as $key => $item) {
            if ($item['produk_id'] == $produk_id) {
                // Kurangi jumlah produk jika jumlahnya lebih dari 1
                if ($cart_items[$key]['kuantitas'] > 1) {
                    $cart_items[$key]['kuantitas']--;
                    $cart_items[$key]['jumlah_total'] = $cart_items[$key]['kuantitas'] * $cart_items[$key]['jumlah_unit'];
                } else {
                    // Hapus produk jika jumlahnya 1 atau kurang
                    unset($cart_items[$key]);
                }
                break; // Keluar dari loop setelah menemukan produk
        }
    }

    self::addCartItemsToCookie($cart_items);

    return $cart_items;
}


    // calculate cart total
    static public function calculateCartTotal($items)
    {
        return array_sum(array_column($items, 'jumlah_total'));
    }
}
