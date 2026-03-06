<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class WishList extends Model
{
    protected $table = 'wishlist';

    protected $primaryKey = 'wishlist_id';

    protected $keyType = 'string';

    /**
     * Disable auto-incrementing for string primary key.
     */
    public $incrementing = false;

    /**
     * Disable automatic timestamp management.
     */
    public $timestamps = false;

    /**
     * Allow mass assignment for wishlist entries.
     */
    protected $fillable = [
        'user_id',
        'product_id',
        'status'
    ];

    /**
     * Boot method to auto-generate wishlist_id.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = strtoupper(Str::random(15));
            }
        });
    }
}
