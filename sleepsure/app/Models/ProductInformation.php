<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductInformation extends Model
{
    protected $table = 'product_information';
    protected $fillable = [
        'product_id',
        'bar_code',
        'code',
        'supplier_id',
        'category_id',
        'warrantee',
        'product_name',
        'price',
        'supplier_price',
        'unit',
        'product_model',
        'product_details',
        'image_thumb',
        'brand_id',
        'thicknesses',
        'variants',
        'default_variant',
        'variant_price',
        'odd_price',
        'type',
        'best_sale',
        'is_featured',
        'top_rated',
        'onsale',
        'onsale_price',
        'invoice_details',
        'image_large_details',
        'review',
        'description',
        'tag',
        'specification',
        'video',
        'status',
        'is_assemble',
    ];
    

    //product category details   
    public function categoryDetails()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id', 'category_id');
    }

    //reviews relation
    public function reviews()
    {
        return $this->hasMany(ProductReview::class, 'product_id', 'product_id')
                    ->where('status', 1);
    }

    //thickness relation
    public function getThicknessDetailsAttribute()
    {
        if (!$this->thicknesses) {
            return collect();
        }

        $ids = explode(',', $this->thicknesses);

        return Thickness::whereIn('id', $ids)->get();
    }
    public function productVariants()
    {
        return $this->hasMany(ProductVariant::class, 'product_id', 'product_id');
    }
}