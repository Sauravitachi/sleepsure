<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingInfo extends Model
{
    protected $table = 'shipping_info';
    
    protected $primaryKey = 'shiping_info_id'; // Change this to match your actual primary key
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'shiping_info_id',  // Add this if you're generating the ID
        'customer_id',
        'order_id',
        'customer_name',
        'first_name',
        'last_name',
        'customer_short_address',
        'customer_address_1',
        'customer_address_2',
        'customer_mobile',
        'customer_email',
        'city',
        'state',
        'country',
        'zip',
        'company'
    ];

    /**
     * Get the order for this shipping info
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }

    /**
     * Get the customer for this shipping info
     */
    public function customer()
    {
        return $this->belongsTo(CustomerInformation::class, 'customer_id', 'customer_id');
    }
}