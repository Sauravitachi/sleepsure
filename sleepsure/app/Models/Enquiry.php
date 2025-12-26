<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enquiry extends Model
{
    protected $table = 'enquiry';
    protected $fillable = [
        'name',
        'email',
        'phone',
        'business_type',
        'estimated_qty',
        'organisation',
        'requirement',
        'status',        
        'created_at',
    ];
    
    public $timestamps = false;
}
