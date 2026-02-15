<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $customer = Auth::user();
        $global = globalData();

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

        return view('frontend.my-orders', array_merge($global, [
            'orders' => $orders,
            'statusLabels' => $statusLabels,
        ]));
    }
}
