<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    protected $table = 'product_review';
    protected $primaryKey = 'product_review_id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'product_review_id',
        'product_id',
        'reviewer_id',
        'rate',
        'comments',
            'media',
        'date_time',
        'status',
    ];

    public function reviewer()
    {
        return $this->belongsTo(CustomerInformation::class, 'reviewer_id', 'customer_id');
    }
}
