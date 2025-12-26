<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    protected $table = 'product_variants';

    protected $fillable = [
        'product_id',
        'var_size_id',
        'var_color_id',
        'var_thickness_id',
        'price',
    ];

    public function sizeVariant()
{
    return $this->belongsTo(Variant::class, 'var_size_id', 'variant_id');
}
}
