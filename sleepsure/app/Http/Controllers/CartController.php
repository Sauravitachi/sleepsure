<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index(){
        return view('frontend.cart');
    }

   public function add(Request $request)
{
    Log::info('🛒 Add to cart request received', [
        'ip' => $request->ip(),
        'session_id' => session()->getId(),
        'user_id' => Auth::id(),
        'payload' => $request->all(),
    ]);

    $validated = $request->validate([
        'product_id' => 'required',
        'variant_id' => 'nullable',
        'thickness_id' => 'nullable',
        'quantity' => 'required|integer|min:1',
        'price' => 'required|numeric|min:0',
        'custom_length' => 'nullable|integer|min:1',
        'custom_breadth' => 'nullable|integer|min:1',
    ]);

    // -----------------------------
    // Decide cart owner
    // -----------------------------
    if (Auth::check()) {

        Log::info('👤 Logged-in user cart detected', [
            'user_id' => Auth::id(),
        ]);

        $cart = Cart::firstOrCreate(
            [
                'customer_id' => Auth::id(),
                'status' => 'active',
            ]
        );

    } else {

        Log::info('👥 Guest cart detected', [
            'session_id' => session()->getId(),
        ]);

        $cart = Cart::firstOrCreate(
            [
                'session_id' => session()->getId(),
                'status' => 'active',
            ]
        );
    }

            Log::info('🛒 Cart resolved', [
                'cart_id' => $cart->id,
                'customer_id' => $cart->customer_id,
                'session_id' => $cart->session_id,
            ]);

        $item = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $validated['product_id'])
            ->where('variant_id', $validated['variant_id'])
            ->where('thickness_id', $validated['thickness_id'])
            ->where(function($q) use ($validated) {
                if (!empty($validated['custom_length']) && !empty($validated['custom_breadth'])) {
                    $q->where('custom_length', $validated['custom_length'])
                      ->where('custom_breadth', $validated['custom_breadth']);
                } else {
                    $q->whereNull('custom_length')->whereNull('custom_breadth');
                }
            })
            ->first();

        if ($item) {
            $item->increment('quantity', $validated['quantity']);
        } else {
            $item = CartItem::create([
                'cart_id'      => $cart->id,
                'product_id'   => $validated['product_id'],
                'variant_id'   => $validated['variant_id'],
                'thickness_id' => $validated['thickness_id'],
                'quantity'     => $validated['quantity'],
                'price'        => $validated['price'],
                'custom_length' => $validated['custom_length'] ?? null,
                'custom_breadth' => $validated['custom_breadth'] ?? null,
            ]);
        }

    Log::info('📦 Cart item added/updated', [
        'cart_item_id' => $item->id,
        'cart_id' => $cart->id,
        'product_id' => $validated['product_id'],
        'quantity' => $validated['quantity'],
        'price' => $validated['price'],
    ]);

    return back()->with('success', 'Product added to cart!');
}


}
