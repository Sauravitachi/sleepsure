<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentGateway extends Model
{
    protected $table = 'payment_gateway'; // fix table name
    public $timestamps = false;

    protected $fillable = [
        'agent',
        'public_key',
        'private_key',
        'secret_key',
        'r_pay_marchantid',
        'r_pay_password',
        'shop_id',
        'r_pay_email',
        'paypal_email',
        'paypal_client_id',
        'currency',
        'is_live',
        'image',
        'status',
    ];

    public static function getRazorpayConfig()
    {
        return self::where('agent', 'razorpay')
            ->where('status', 1)
            ->first();
    }
}
