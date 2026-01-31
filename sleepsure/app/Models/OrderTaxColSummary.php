<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderTaxColSummary extends Model
{
    protected $table = 'order_tax_col_summaries'; // or your actual table name
    protected $primaryKey = 'order_tax_col_id';   // or your actual primary key
    public $timestamps = false;                   // set true if your table has timestamps

    protected $fillable = [
        'order_tax_col_id',
        'order_id',
        'tax_amount',
        'tax_id',
        'date',
        // add other fields if needed
    ];
}