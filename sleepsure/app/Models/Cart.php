<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'carts';

    protected $fillable = [
        'customer_id',
        'session_id',
        'status',
    ];

    public function items()
    {
        return $this->hasMany(CartItem::class, 'cart_id');
    }
}
