<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produks';

    protected $fillable = [
        'kategori_id',
        'brand_id',
        'nama',
        'slug',
        'gambar',
        'deskripsi',
        'harga',
        'is_active',
        'is_popular',
        'in_stock',
        'on_sale'
    ];

    public function kategori() {
        return $this->belongsTo(Kategori::class);
    }

    public function brand() {
        return $this->belongsTo(Brand::class);
    }
    
    public function orderItems() {
        return $this->hasMany(OrderItem::class);
    }
}
