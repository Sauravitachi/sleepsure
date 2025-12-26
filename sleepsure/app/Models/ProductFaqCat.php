<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductFaqCat extends Model
{
    protected $table = 'product_faq_cat';
    public $timestamps = false;

    protected $fillable = [
        'title',
        'icon',
        'status',
        'created_on',
    ];

    // Relationship: One category has many FAQs
    public function faqs()
    {
        return $this->hasMany(ProductFaqList::class, 'faq_cat_id');
    }
}
