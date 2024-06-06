<?php

namespace App\Livewire;

use App\Helpers\CartManagement;
use App\Livewire\Partials\Navbar;
use App\Models\Brand;
use App\Models\Kategori;
use App\Models\Produk;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Produk - TrendStore')]
class ProdukPage extends Component
{
    use LivewireAlert;
    use WithPagination;

    #[Url]
    public $selected_kategoris = [];

    #[Url]
    public $selected_brands = [];

    #[Url]
    public $popular;

    #[Url]
    public $on_sale;

    #[Url]
    public $price_range = 2000000;
    
    #[Url]
    public $sort = 'latest';

    // add produk to cart method
    public function addToCart($produk_id) {
        $total_count = CartManagement::addItemToCart($produk_id);

        $this->dispatch('update-cart-count', total_count: $total_count)->to(Navbar::class);

        $this->alert('success', 'Added to the cart successfully!', [
            'position' => 'bottom-end',
            'timer' => 3000,
            'toast' => true,
           ]);
    }

    public function render()
    {
        $produkQuery = Produk::query()->where('is_active', 1);

        if(!empty($this->selected_kategoris)) {
            $produkQuery->whereIn('kategori_id', $this->selected_kategoris);
        }

        if(!empty($this->selected_brands)) {
            $produkQuery->whereIn('brand_id', $this->selected_brands);
        }

        if($this->popular) {
            $produkQuery->where('is_popular', 1);
        }

        if($this->on_sale) {
            $produkQuery->where('on_sale', 1);
        }

        if($this->price_range) {
            $produkQuery->whereBetween('harga', [0, $this->price_range]);
        }

        if($this->sort == 'latest') {
            $produkQuery->latest();
        }

        if($this->sort == 'price') {
            $produkQuery->orderBy('harga');
        }

        return view('livewire.produk-page', [
            'produks' => $produkQuery->paginate(6),
            'brands' => Brand::where('is_active', 1)->get(['id', 'nama', 'slug']),
            'kategoris' => Kategori::where('is_active', 1)->get(['id', 'nama', 'slug']),
        ]);
    }
}
