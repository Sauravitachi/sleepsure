<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PayWith extends Model
{
    protected $table = 'pay_withs';
    protected $fillable = ['name', 'image', 'link','status'];
    
}
