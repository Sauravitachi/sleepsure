<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDelivery extends Model
{
    
    protected $table = 'order_delivery';
    public $timestamps = false;
    protected $fillable = [
        'order_delivery_id',
        'delivery_id',
        'order_id',
        'details',
       
    ];
}