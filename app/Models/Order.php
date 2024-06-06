<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'order_id',
        'total',
        'metode_pembayaran',
        'status_pembayaran',
        'status',
        'mata_uang',
        'jumlah_pengiriman',
        'metode_pengiriman',
        'catatan'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

     public function items() {
        return $this->hasMany(OrderItem::class);
     }

    //public function orderItem() : HasMany
    //{
    //    return $this->hasMany(OrderItem::class, 'order_id');
    //}

    public function address() {
        return $this->hasOne(Address::class);
    }
}
