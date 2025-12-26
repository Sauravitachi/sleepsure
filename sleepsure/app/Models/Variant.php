<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    protected $table = 'variant';
   
    protected $fillable = [
        'variant_id',
        'variant_type',
        'color_code',
        'variant_name',
        'variant_cat',
        'status',
    ];
}
