<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Razorpay\Api\Api;
use App\Models\PaymentGateway;

class PaymentGatewayController extends Controller
{
    /**
     * Display the payment gateway settings
     */
    public function index()
    {
        $razorpayConfig = PaymentGateway::where('gateway_name', 'razorpay')->first();
        
        return view('admin.payment-gateway', compact('razorpayConfig'));
    }

    /**
     * Update Razorpay configuration
     */
    public function updateRazorpay(Request $request)
    {
        $request->validate([
            'razorpay_key' => 'required|string',
            'razorpay_secret' => 'required|string',
            'status' => 'boolean'
        ]);

        PaymentGateway::updateOrCreate(
            ['gateway_name' => 'razorpay'],
            [
                'gateway_name' => 'razorpay',
                'r_pay_merchantid' => $request->razorpay_key,
                'r_pay_password' => $request->razorpay_secret,
                'status' => $request->has('status') ? 1 : 0,
                'created_date' => date('Y-m-d H:i:s')
            ]
        );

        return redirect()->back()->with('success', 'Razorpay configuration updated successfully!');
    }

    /**
     * Test Razorpay connection
     */
    public function testRazorpay()
    {
        try {
            $config = PaymentGateway::getRazorpayConfig();
            
            if (!$config) {
                return response()->json([
                    'success' => false,
                    'message' => 'Razorpay configuration not found'
                ]);
            }

            // Simple API test - create a test order for ₹1
            $api = new Api($config->r_pay_merchantid, $config->r_pay_password);
            
            $testOrder = $api->order->create([
                'receipt' => 'test_' . time(),
                'amount' => 100, // ₹1 in paisa
                'currency' => 'INR'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Razorpay connection successful!',
                'test_order_id' => $testOrder['id']
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Razorpay connection failed: ' . $e->getMessage()
            ]);
        }
    }
}