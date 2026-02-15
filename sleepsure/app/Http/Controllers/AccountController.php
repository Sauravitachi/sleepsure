<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function index()
    {
        $customer = Auth::user();
        $global = globalData();

        $orders = Order::with(['payments', 'delivery'])
            ->where('customer_id', $customer->customer_id)
            ->orderByDesc('created_at')
            ->orderByDesc('date')
            ->get();

        $stats = [
            'total_orders'   => $orders->count(),
            'in_progress'    => $orders->whereIn('status', [0,1,2,3])->count(),
            'delivered'      => $orders->where('status', 4)->count(),
            'cod_pending'    => $orders->filter(function ($order) {
                $payment = $order->payments->first();
                $isCod = $payment && (($payment->payment_id ?? null) === 1 || str_contains(strtolower($payment->details), 'cash on delivery'));
                $hasDue = (float) ($order->due_amount ?? 0) > 0;
                return $isCod && $hasDue;
            })->count(),
        ];

        return view('frontend.my-account', array_merge($global, [
            'customer' => $customer,
            'orders' => $orders,
            'stats' => $stats,
        ]));
    }
}
