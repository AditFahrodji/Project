<?php

namespace App\Livewire;

use App\Models\Brand;
use App\Models\Kategori;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Home - Trendstore')]
class HomePage extends Component
{
    public function render()
    {
        $brands = Brand::where('is_active', 1)->get();
        $kategoris = Kategori::where('is_active', 1)->get();
        return view('livewire.home-page', [
            'brands' => $brands,
            'kategoris' => $kategoris
        ]);
    }
}
