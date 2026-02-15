<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ProductInformation;
use App\Models\Variant; 

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

    public function product()
    {
        return $this->belongsTo(ProductInformation::class, 'product_id', 'product_id');
    }

    public function variant()
    {
        return $this->belongsTo(Variant::class, 'variant_id', 'variant_id');
    }
}
