<?php

namespace App\Http\Controllers;

use App\Models\ProductInformation;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Http\Controllers\HomeController;
use App\Models\CartItem;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index(){
        $cart = Auth::check()
            ? Cart::where('customer_id', Auth::id())->where('status', 'active')->first()
            : Cart::where('session_id', session()->getId())->where('status', 'active')->first();

        $cartItems = $cart
            ? $cart->items()->with(['product', 'variant', 'thickness'])->get()
            : collect();

        $global = [
            'base_url' => 'https://sleepauth.kodesoft.store',
            'fallback_slider' => asset('assets/images/default.jpg'),
        ];

        foreach ($cartItems as $item) {
            if ($item->product) {
                $this->applyImageAndWarranty($item->product, $global);
            }
        }

            $homeController = app(HomeController::class);
            $featured_products = $homeController->getProducts('is_featured', $global, 8);

        return view('frontend.cart', compact('cartItems', 'featured_products'));
    }

   public function add(Request $request)
    {
    Log::info('🛒 Add to cart request received', [
        'ip' => $request->ip(),
        'session_id' => session()->getId(),
        'user_id' => Auth::id(),
        'payload' => $request->all(),
    ]);

    $input = $request->all();
    if (isset($input['price'])) {
        $input['price'] = preg_replace('/[^0-9.]/', '', $input['price']);
    }

    $validated = \Validator::make($input, [
        'product_id' => 'required',
        'variant_id' => 'required',
        'thickness_id' => 'required',
        'quantity' => 'required|integer|min:1',
        'price' => 'required|numeric|min:0',
        'custom_length' => 'nullable|integer|min:1',
        'custom_breadth' => 'nullable|integer|min:1',
    ])->validate();

    $isCustom = !empty($validated['custom_length']) && !empty($validated['custom_breadth']);
    if (!$isCustom) {
        if (empty($validated['variant_id']) || empty($validated['thickness_id'])) {
            return back()->withErrors(['variant_id' => 'Please select a valid size and thickness.'])->withInput();
        }
    }

    if (Auth::check()) {
        Log::info('👤 Logged-in user cart detected', [
            'user_id' => Auth::id(),
        ]);
        $cart = Cart::firstOrCreate(
            [
                'customer_id' => Auth::id(),
                'status' => 'active',
            ],
            [
                'session_id' => null,
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
public function remove(Request $request, $id)
    {
        $cartItem = CartItem::find($id);
        if ($cartItem) {
            $cartItem->delete();
            return back()->with('success', 'Item removed from cart.');
        }
        return back()->with('error', 'Item not found in cart.');
    }

public function productsCount()
{
    if (Auth::check()) {
$cart = Cart::where('customer_id', Auth::id())
                    ->where('status', 'active')
                    ->first();
    } else {
        $cart = Cart::where('session_id', session()->getId())
                    ->where('status', 'active')
                    ->first();
    }


    $count = $cart ? $cart->items()->sum('quantity') : 0;
    return response()->json(['count' => $count]);
}
public function quantityUpdate(Request $request, $id)
{
    $cartItem = CartItem::findOrFail($id);
        $cartItem->quantity = $request->quantity;
    $cartItem->save();
    Log::info('🔄 Cart item quantity updated', [
        'cart_item_id' => $cartItem->id,
        'quantity' => $cartItem->quantity,
    ]);
    return response()->json(['success' => true]);
}

private function applyImageAndWarranty($product, $global)
    {
        if (is_iterable($product)) {
            foreach ($product as $item) {
                $this->applyImageAndWarranty($item, $global);
            }
            return;
        }
        $image = (isset($product->image_thumb) && $product->image_thumb)
            ? $product->image_thumb
            : (isset($product->image_large_details) ? $product->image_large_details : null);

          
         $product->image_url = $this->setImageOrPlaceholder(
            $image,
            $global['base_url'],
            $global['fallback_slider']
        );
        $months = (int) ($product->warrantee ?? 0);
        $product->warranty_text = $months >= 12
            ? floor($months / 12) . ' Years'
            : $months . ' Months';
    }

    private function setImageOrPlaceholder($path, $baseUrl, $fallback)
    {
        if (!empty($path)) {
            if (filter_var($path, FILTER_VALIDATE_URL)) {
                return $path;
            }
            return rtrim($baseUrl, '/') . '/' . ltrim($path, '/');
        }
        return $fallback;
    }
}
