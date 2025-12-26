<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerOrder extends Model
{
    use HasFactory;

    protected $table = 'customer_order';

    protected $primaryKey = 'customer_order_id';

    protected $fillable = [
        'customer_id',
        'shiping_id',
        'order_date',
        'payment_method',
        'total_bill',
        'order_status',
    ];

    public function details()
    {
        return $this->hasMany(CustomerOrderDetail::class, 'customer_order_id');
    }
}
