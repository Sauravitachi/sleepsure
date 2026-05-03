<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderTaxColDetails extends Model
{
    protected $table = 'order_tax_col_details'; // Make sure this matches your actual table name
    protected $primaryKey = 'order_tax_col_de_id';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'order_tax_col_de_id',
        'order_id',
        'amount',
        'product_id',
        'tax_id',
        'variant_id',
        'date',
        'created_at',
        'updated_at'
    ];

    /**
     * Get the order for this tax detail
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }

    /**
     * Get the product for this tax detail
     */
    public function product()
    {
        return $this->belongsTo(ProductInformation::class, 'product_id', 'product_id');
    }

    /**
     * Get the tax for this detail
     */
    public function tax()
    {
        return $this->belongsTo(Tax::class, 'tax_id', 'tax_id');
    }
    
    /**
     * Get tax name accessor
     */
    public function getTaxNameAttribute()
    {
        return $this->tax ? $this->tax->tax_name : null;
    }
}