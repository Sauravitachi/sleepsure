<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $table = 'coupon';

    protected $fillable = [
        'coupon_id',
        'coupon_name',
        'coupon_msg',
        'coupon_discount_code',
        'discount_amount',
        'discount_percentage',
        'start_date',
        'end_date',
        'discount_type',
        'is_popular',
        'status'
    ];
}
