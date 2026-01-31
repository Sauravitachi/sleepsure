<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PaymentGateway;

class PaymentGatewaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Razorpay payment gateway entry
        // Update these values with your actual Razorpay credentials
        PaymentGateway::updateOrCreate(
            ['gateway_name' => 'razorpay'],
            [
                'gateway_name' => 'razorpay',
                'r_pay_merchantid' => 'rzp_test_your_key_here', // Replace with your Razorpay Key ID
                'r_pay_password' => 'your_secret_key_here',     // Replace with your Razorpay Secret
                'status' => 1,
                'created_date' => date('Y-m-d H:i:s')
            ]
        );

        // Create COD payment method
        PaymentGateway::updateOrCreate(
            ['gateway_name' => 'cash_on_delivery'],
            [
                'gateway_name' => 'cash_on_delivery',
                'r_pay_merchantid' => null,
                'r_pay_password' => null,
                'status' => 1,
                'created_date' => date('Y-m-d H:i:s')
            ]
        );
    }
}