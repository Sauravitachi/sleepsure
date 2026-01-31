<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentHistory extends Model
{
    protected $table = 'payment_history';
    public $timestamps = false;

    protected $fillable = [
        'payment_id',
        'order_id',
        'payment_method',
        'payment_gateway_order_id',
        'payment_gateway_payment_id',
        'amount',
        'currency',
        'status',
        'gateway_response',
        'created_at'
    ];

    protected $casts = [
        'gateway_response' => 'array'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }
}
