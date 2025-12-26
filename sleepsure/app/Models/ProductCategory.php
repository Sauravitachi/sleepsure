<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    protected $table = 'product_category';
    public $timestamps = false;

    //one step upper details
    public function parentCategoryDetails()
    {
        return $this->belongsTo(ProductCategory::class, 'parent_category_id', 'category_id');
    }

    //subcategories
    public function subcategories()
    {
        return $this->hasMany(ProductCategory::class, 'parent_category_id', 'category_id');
    }

    //third-level models/categories
    public function models()
    {
        return $this->hasMany(ProductCategory::class, 'parent_category_id', 'category_id');
    }
    
}
