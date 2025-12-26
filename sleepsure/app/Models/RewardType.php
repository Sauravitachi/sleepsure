<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RewardType extends Model
{
    use HasFactory;

    protected $table = 'rewards_type';
    
    protected $fillable = [
        'reward_id',
        'logo',
        'title',
        'message',
        'created_date'
    ];

    public $timestamps = false;

    /**
     * Get the reward category that owns the reward type
     */
    public function reward()
    {
        return $this->belongsTo(Reward::class, 'reward_id');
    }
}
