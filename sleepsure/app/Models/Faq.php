<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $table = 'faq';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'que',
        'ans',
        'created_on'
    ];
}
