<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductThickness extends Model
{
    protected $table = 'product_thickness';

    protected $fillable = [
        'product_id',
        'thickness_id',
    ];
}
