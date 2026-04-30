<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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

    public function updateProfile(Request $request)
    {
        // Validation
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_mobile' => 'nullable|string|max:20|unique:customer_information,customer_mobile,' . auth()->id() . ',customer_id',
        ], [
            'customer_name.required' => 'Name is required',
            'customer_email.required' => 'Email is required',
            // 'customer_email.unique' => 'This email is already registered',
            'customer_mobile.unique' => 'This mobile number is already registered',
        ]);

        try {
            $customer = Auth::user();
            
            $customer->update([
                'customer_name' => $request->customer_name,
                'customer_email' => $request->customer_email,
                'customer_mobile' => $request->customer_mobile,
            ]);

            return redirect()->route('account.index')->with('success', 'Profile updated successfully!');
            
        } catch (\Exception $e) {
            return redirect()->route('account.index')->with('error', 'Failed to update profile');
        }
    }
}
