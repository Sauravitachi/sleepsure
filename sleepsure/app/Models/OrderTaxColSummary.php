<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderTaxColSummary extends Model
{
    protected $table = 'order_tax_col_summary'; // Change from 'order_tax_col_summaries' to 'order_tax_col_summary'
    protected $primaryKey = 'order_tax_col_id';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'order_tax_col_id',
        'order_id',
        'tax_amount',
        'tax_id',
        'date',
        'created_at',
        'updated_at'
    ];

    /**
     * Get the order for this tax summary
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }
}