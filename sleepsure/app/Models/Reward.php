<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    use HasFactory;

    protected $table = 'rewards';
    
    protected $fillable = [
        'title',
        'created_date'
    ];

    public $timestamps = false;

    /**
     * Get all reward types for this reward category
     */
    public function rewardTypes()
    {
        return $this->hasMany(RewardType::class, 'reward_id');
    }
}
