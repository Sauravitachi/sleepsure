<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingInfo extends Model
{
    protected $table = 'shipping_info';

    protected $primaryKey = 'shipping_id';
    public $timestamps = false;

    protected $fillable = [
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
        'state',
        'postal_code',
        'country',
        'city',
        'state',
        'zip',
        'company'
    ];
}
