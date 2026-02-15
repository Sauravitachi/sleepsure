<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\OrderPayment;

class Order extends Model
{
    protected $table = 'order';
    protected $primaryKey = 'order_id';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false; // set true if you have created_at/updated_at

    protected $fillable = [
        'order_id',
        'customer_id',
        'store_id',
        'user_id',
        'date',
        'total_amount',
        'order',
        'details',
        'total_discount',
        'order_discount',
        'service_charge',
        'paid_amount',
        'due_amount',
        'file_path',
        'coupon',
        'order_notes',
        'status',
        'created_at',
    ];

    public function orderDetails()
    {
        return $this->hasMany(OrderDetails::class, 'order_id', 'order_id');
    }   
    public function taxSummaries()
    {
        return $this->hasMany(OrderTaxColSummary::class, 'order_id', 'order_id');
    }
    public function delivery()
    {
        return $this->hasOne(OrderDelivery::class, 'order_id', 'order_id');
    }

    public function payments()
    {
        return $this->hasMany(OrderPayment::class, 'order_id', 'order_id');
    }
    public function customer(){
        return $this->belongsTo(CustomerInformation::class, 'customer_id', 'customer_id');
    }
}
