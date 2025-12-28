<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Thickness extends Model
{
    protected $table = 'thickness';

    protected $primaryKey = 'id';  
    public $timestamps = false;

    protected $fillable = [
        'thick',
        'map',
    ];
}
