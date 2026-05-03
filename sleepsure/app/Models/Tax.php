<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    protected $table = 'tax';
    //fillable fields
    protected $fillable = [
        'tax_id',
        'tax_name',
    ];

    /**
     * Get the order tax summaries for this tax
     */
    public function orderTaxSummaries()
    {
        return $this->hasMany(OrderTaxColSummary::class, 'tax_id', 'tax_id');
    }
    
    /**
     * Get the order tax details for this tax
     */
    public function orderTaxDetails()
    {
        return $this->hasMany(OrderTaxColDetails::class, 'tax_id', 'tax_id');
    }
}
