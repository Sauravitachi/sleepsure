<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderTaxColDetails extends Model
{
    protected $table = 'order_tax_col_details'; // Ensure this matches your DB table name

    protected $primaryKey = 'order_tax_col_de_id'; // Use your actual primary key

    public $timestamps = false; // Set to true if your table has timestamps

    protected $fillable = [
        'order_tax_col_de_id',
        'order_id',
        'amount',
        'product_id',
        'tax_id',
        'variant_id',
        'date',
        // Add other fields as needed
    ];
}