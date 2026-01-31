<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderPayment extends Model
{
    protected $table = 'order_payment';
    public $timestamps = false;
    protected $fillable = [
        'order_payment_id',
        'order_id',
        'payment_id',
        'details' 
        ];
    
}
