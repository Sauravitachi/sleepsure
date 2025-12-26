<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    protected $table = 'product_review';
    
    protected $fillable = [
        'product_id',
        'reviewer_id',
        'rate',
        'comments',
        'date_time',
        'status',
    ];
}
