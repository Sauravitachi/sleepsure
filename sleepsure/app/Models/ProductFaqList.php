<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductFaqList extends Model
{
    protected $table = 'product_faq_list';
    public $timestamps = false;

    protected $fillable = [
        'faq_cat_id',
        'que',
        'ans',
        'icon',
        'status',
        'created_date',
    ];

    // Relationship: Each FAQ belongs to a category
    public function category()
    {
        return $this->belongsTo(ProductFaqCat::class, 'faq_cat_id');
    }
}
