<?php

namespace App\Livewire;

use App\Models\Kategori;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Categories - Trendstore')]
class KategoriPage extends Component
{
    public function render()
    {
        $kategoris = Kategori::where('is_active', 1)->get();
        return view('livewire.kategori-page', [
            'kategoris' => $kategoris,
        ]);

    }
}