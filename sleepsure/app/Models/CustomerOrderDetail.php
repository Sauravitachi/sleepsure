<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerOrderDetail extends Model
{
    use HasFactory;

    protected $table = 'customer_order_details';

    protected $primaryKey = 'c_o_d_id';

    protected $fillable = [
        'customer_order_id',
        'product_id',
        'variant_id',
        'quantity',
        'discount',
        'tax',
        'vat',
        'sell_price',
        'supplier_price',
    ];

    public function order()
    {
        return $this->belongsTo(CustomerOrder::class, 'customer_order_id');
    }
}
