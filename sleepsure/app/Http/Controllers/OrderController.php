<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\{OrderTaxColSummary,SoftSetting};
use App\Models\OrderTaxColDetails;
use App\Models\ShippingInfo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class OrderController extends Controller
{
    public function index()
    {
        $customer = Auth::user();
        $global = globalData();

        if (!$customer) {
            return redirect()->route('login')->with('error', 'Please login to view your orders');
        }

        $orders = Order::with([
            'orderDetails.product.categoryDetails',
            'orderDetails.variant',
            'delivery',
            'payments',
        ])
        ->where('customer_id', $customer->customer_id)
        ->orderByDesc('created_at')
        ->orderByDesc('date')
        ->get();

        $statusLabels = [
            0 => 'Pending',
            1 => 'Placed',
            2 => 'Processing',
            3 => 'Shipped',
            4 => 'Delivered',
            5 => 'Cancelled',
            6 => 'Refunded',
        ];

        $baseUrl = SoftSetting::pluck('web_base_url')->first();

        return view('frontend.my-orders', array_merge($global, [
            'orders' => $orders,
            'statusLabels' => $statusLabels,
            'baseUrl' => $baseUrl,
        ]));
    }

    /**
     * Show order details
     */
    public function show($order_id)
    {
        $customer = Auth::user();
        $global = globalData();

        if (!$customer) {
            return redirect()->route('login')->with('error', 'Please login to view order details');
        }

        $order = Order::with([
            'orderDetails.product.categoryDetails',
            'orderDetails.variant',
            'delivery',
            'payments',
            'shippingInfo',
            'taxSummaries',
            'taxDetails'
        ])
        ->where('order_id', $order_id)
        ->where('customer_id', $customer->customer_id)
        ->first();

        if (!$order) {
            return redirect()->route('my-orders')->with('error', 'Order not found');
        }

        $statusLabels = [
            0 => 'Pending',
            1 => 'Placed',
            2 => 'Processing',
            3 => 'Shipped',
            4 => 'Delivered',
            5 => 'Cancelled',
            6 => 'Refunded',
        ];

        // Calculate totals
        $subtotal = $order->orderDetails->sum('total_price');
        $taxAmount = $order->taxSummaries->sum('tax_amount');
        $totalAmount = $order->total_amount;
        $baseUrl = SoftSetting::pluck('web_base_url')->first();

        return view('frontend.order-details', array_merge($global, [
            'order' => $order,
            'statusLabels' => $statusLabels,
            'subtotal' => $subtotal,
            'taxAmount' => $taxAmount,
            'totalAmount' => $totalAmount,
            'baseUrl' => $baseUrl,
        ]));
    }

    /**
     * View invoice as HTML (printable) - No PDF library needed
     */
    public function viewInvoice($order_id)
    {
        $customer = Auth::user();
        $global = globalData();

        if (!$customer) {
            return redirect()->route('login')->with('error', 'Please login to view invoice');
        }

        $order = Order::with([
            'orderDetails.product.categoryDetails',
            'orderDetails.variant',
            'delivery',
            'payments',
            'shippingInfo',
            'taxSummaries',
            'taxDetails'
        ])
        ->where('order_id', $order_id)
        ->where('customer_id', $customer->customer_id)
        ->first();

        if (!$order) {
            return redirect()->route('my-orders')->with('error', 'Order not found');
        }

        $statusLabels = [
            0 => 'Pending',
            1 => 'Placed',
            2 => 'Processing',
            3 => 'Shipped',
            4 => 'Delivered',
            5 => 'Cancelled',
            6 => 'Refunded',
        ];

        // Calculate totals
        $subtotal = $order->orderDetails->sum('total_price');
        $taxAmount = $order->taxSummaries->sum('tax_amount');
        $totalAmount = $order->total_amount;
        $baseUrl = SoftSetting::pluck('web_base_url')->first();
        return view('pdf.invoice', [
            'order' => $order,
            'statusLabels' => $statusLabels,
            'subtotal' => $subtotal,
            'taxAmount' => $taxAmount,
            'totalAmount' => $totalAmount,
            'company' => $global,
            'customer' => $customer,
            'baseUrl' => $baseUrl,
        ]);
    }
}