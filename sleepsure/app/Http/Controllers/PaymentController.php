<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\RazorpayService;
use App\Models\Order; 
use App\Models\Cart;
use App\Models\CartItem;
use Log;

class PaymentController extends Controller
{
    private $razorpay;

    public function __construct(RazorpayService $razorpay)
    {
        $this->razorpay = $razorpay;
    }

    public function createOrder(Request $request)
    {
        try {
            $amountRupees = (float) $request->input('amount');
            $orderId      = $request->input('order_id');

            if ($amountRupees <= 0 || !$orderId) {
                return response()->json(['success' => false, 'message' => 'Invalid amount or order id'], 422);
            }

            $result = $this->razorpay->createOrder($amountRupees, $orderId, [
                'email'  => $request->input('customer_email'),
                'mobile' => $request->input('customer_mobile'),
            ]);

            if (!$result['success']) {
                return response()->json(['success' => false, 'message' => $result['message'] ?? 'Failed to create order'], 500);
            }

            return response()->json([
                'success'           => true,
                'config'            => $this->razorpay->getConfigForFrontend(),
                'currency'          => $result['currency'],
                'amount'            => $result['amount'],
                'razorpay_order_id' => $result['order_id'],
            ]);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function createPaymentOrder(Request $request)
    {
        return $this->createOrder($request);
    }

    public function verifyPayment(Request $request)
    {
        return $this->verify($request);
    }

    public function verify(Request $request)
    {
        $res = $this->razorpay->verifyPayment(
            $request->input('razorpay_order_id'),
            $request->input('razorpay_payment_id'),
            $request->input('razorpay_signature')
        );

        if ($res['success']) {
            $orderId = $request->input('order_id'); // must be sent from frontend
            if (!$orderId) {
                return response()->json(['success' => false, 'message' => 'order_id missing'], 400);
            }

            $order = Order::where('order_id', $orderId)->first();
            if (!$order) {
                return response()->json(['success' => false, 'message' => 'Order not found'], 404);
            }

            $order->paid_amount = $order->total_amount;
            $order->due_amount  = 0;
            $order->status      = 1; // adjust to your “paid” status
            $order->save();

            // Clear the shopper's active cart (auth user or current session) so items disappear after payment
            $cart = null;

            if ($request->filled('cart_id')) {
                $cart = Cart::whereKey($request->input('cart_id'))->first();
            }

            if (!$cart && Auth::check()) {
                $cart = Cart::where('customer_id', Auth::id())
                    ->where('status', 'active')
                    ->first();
            }

            if (!$cart) {
                $cart = Cart::where('session_id', $request->session()->getId())
                    ->where('status', 'active')
                    ->first();
            }
            Log::info('Clearing cart for order ' . $orderId . ', found cart: ' . ($cart ? $cart->id : 'none'));

            if ($cart) {
                CartItem::where('cart_id', $cart->id)->delete();
                $cart->status = 'checked_out';
                $cart->save();
            }
            Log::info('Cart cleared for order ' . $orderId);

        }

        return response()->json($res, $res['success'] ? 200 : 400);
    }

    public function failed(Request $request)
    {
        // Optionally log $request->all()
        return response()->json(['success' => true]);
    }
}