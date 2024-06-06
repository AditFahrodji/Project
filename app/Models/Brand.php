<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $table = 'brands';

    protected $fillable = [
        'nama',
        'slug',
        'logo',
        'is_active'
    ];

    public function produk() {
        return $this->hasMany(Produk::class);
    }
}
