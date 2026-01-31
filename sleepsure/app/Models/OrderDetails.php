<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    protected $table = 'order_details';
    public $timestamps = false;
    
    protected $fillable = [
        'order_details_id',
        'order_id',
        'product_id',
        'variant_id',
        'variant_color',
        'store_id',
        'quantity',
        'rate',                           
        'supplier_rate',                  
        'total_price',                    
        'discount',                       
        'product_discount',               
        'status',                         
    ];
}
