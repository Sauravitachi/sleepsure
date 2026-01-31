<?php

namespace App\Services;

use App\Models\PaymentGateway;
use Razorpay\Api\Api;
use Exception;

class RazorpayService
{
    private $api;
    private $config;

    public function __construct()
    {
        $this->config = PaymentGateway::getRazorpayConfig();
        if (!$this->config) {
            throw new Exception('Razorpay configuration not found');
        }

        $key = $this->config->r_pay_marchantid
            ?? $this->config->public_key
            ?? $this->config->shop_id;

        $secret = $this->config->r_pay_password
            ?? $this->config->private_key
            ?? $this->config->secret_key;

        if (!$key || !$secret) {
            throw new Exception('Razorpay keys are missing: need Key ID and Key Secret');
        }

        $this->api = new Api($key, $secret);
    }

    /**
     * Create Razorpay order
     */
    public function createOrder($amountRupees, $orderId, $customerData = [])
    {
        try {
            $orderData = [
                'receipt'         => (string) $orderId,
                'amount'          => (int) round($amountRupees * 100), // in paise
                'currency'        => $this->config->currency ?? 'INR',
                'payment_capture' => 1,
                'notes'           => [
                    'order_id'        => $orderId,
                    'customer_email'  => $customerData['email']  ?? '',
                    'customer_mobile' => $customerData['mobile'] ?? '',
                ],
            ];

            $razorpayOrder = $this->api->order->create($orderData);

            return [
                'success'  => true,
                'order_id' => $razorpayOrder['id'],
                'amount'   => $razorpayOrder['amount'],
                'currency' => $razorpayOrder['currency'],
                'receipt'  => $razorpayOrder['receipt'],
            ];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Verify Razorpay payment signature
     */
    public function verifyPayment($razorpayOrderId, $razorpayPaymentId, $razorpaySignature)
    {
        try {
            $this->api->utility->verifyPaymentSignature([
                'razorpay_order_id'   => $razorpayOrderId,
                'razorpay_payment_id' => $razorpayPaymentId,
                'razorpay_signature'  => $razorpaySignature,
            ]);
            return ['success' => true];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Get Razorpay configuration for frontend
     */
    public function getConfigForFrontend()
    {
        $key = $this->config->r_pay_marchantid
            ?? $this->config->public_key
            ?? $this->config->shop_id;

        return [
            'key'         => $key,
            'currency'    => $this->config->currency ?? 'INR',
            'name'        => config('app.name', 'SleepSure'),
            'description' => 'Payment for your order',
            'image'       => asset('assets/images/logo.png'),
            'theme'       => ['color' => '#3399cc'],
        ];
    }
}