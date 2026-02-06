<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\HomeController;

class CartController extends Controller
{
    public function index()
    {
        $cart = $this->getActiveCart();
        $cartItems = $this->getCartItems($cart);
        $this->hydrateProducts($cartItems);

        $featured_products = app(HomeController::class)
            ->getProducts('is_featured', [], 8);

        return view('frontend.cart', compact('cartItems', 'featured_products'));
    }

    public function add(Request $request)
    {
        Log::info('🛒 Add to cart request', [
            'user_id' => Auth::id(),
            'session_id' => session()->getId(),
            'payload' => $request->all(),
        ]);

        $input = $request->all();

        if (isset($input['price'])) {
            $input['price'] = preg_replace('/[^0-9.]/', '', $input['price']);
        }

        $validated = \Validator::make($input, [
            'product_id'      => 'required',
            'variant_id'      => 'required',
            'thickness_id'    => 'required',
            'quantity'        => 'required|integer|min:1',
            'price'           => 'required|numeric|min:0',
            'custom_length'   => 'nullable|integer|min:1',
            'custom_breadth'  => 'nullable|integer|min:1',
        ])->validate();

        $cart = $this->resolveCart();

        $item = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $validated['product_id'])
            ->where('variant_id', $validated['variant_id'])
            ->where('thickness_id', $validated['thickness_id'])
            ->where(function ($q) use ($validated) {
                if (!empty($validated['custom_length']) && !empty($validated['custom_breadth'])) {
                    $q->where('custom_length', $validated['custom_length'])
                      ->where('custom_breadth', $validated['custom_breadth']);
                } else {
                    $q->whereNull('custom_length')
                      ->whereNull('custom_breadth');
                }
            })
            ->first();

        if ($item) {
            $item->increment('quantity', $validated['quantity']);
        } else {
            $item = CartItem::create([
                'cart_id'        => $cart->id,
                'product_id'     => $validated['product_id'],
                'variant_id'     => $validated['variant_id'],
                'thickness_id'   => $validated['thickness_id'],
                'quantity'       => $validated['quantity'],
                'price'          => $validated['price'],
                'custom_length'  => $validated['custom_length'] ?? null,
                'custom_breadth' => $validated['custom_breadth'] ?? null,
            ]);
        }

        Log::info('📦 Cart item saved', [
            'cart_item_id' => $item->id,
            'cart_id' => $cart->id,
        ]);

        return back()->with('success', 'Product added to cart!');
    }
    
    public function remove($id)
    {
        $item = CartItem::find($id);

        if (!$item) {
            return back()->with('error', 'Item not found.');
        }

        $item->delete();
        return back()->with('success', 'Item removed from cart.');
    }

    public function quantityUpdate(Request $request, $id)
    {
        $item = CartItem::findOrFail($id);
        $item->quantity = $request->quantity;
        $item->save();

        return response()->json(['success' => true]);
    }

    public function productsCount()
    {
        $cart = $this->getActiveCart();

        return response()->json([
            'count' => $cart ? $cart->items()->sum('quantity') : 0
        ]);
    }

    public function checkout()
    {
        $cart = $this->getActiveCart();
        $cartItems = $this->getCartItems($cart);
        $this->hydrateProducts($cartItems);

        $totals = $this->calculateTotals($cartItems);

        return view('frontend.checkout', array_merge(
            compact('cartItems'),
            $totals
        ));
    }

    private function getActiveCart()
    {
        return Auth::check()
            ? Cart::where('customer_id', Auth::id())->where('status', 'active')->first()
            : Cart::where('session_id', session()->getId())->where('status', 'active')->first();
    }

    private function resolveCart()
    {
        return Auth::check()
            ? Cart::firstOrCreate(
                ['customer_id' => Auth::id(), 'status' => 'active'],
                ['session_id' => null]
            )
            : Cart::firstOrCreate(
                ['session_id' => session()->getId(), 'status' => 'active']
            );
    }

    private function getCartItems($cart)
    {
        return $cart
            ? $cart->items()->with(['product', 'variant', 'thickness'])->get()
            : collect();
    }

    private function hydrateProducts($cartItems)
    {
        $global = [
            'base_url' => 'https://sleepauth.kodesoft.store',
            'fallback_slider' => asset('assets/images/default.jpg'),
        ];

        if (!isset($global['base_url'])) {
            $global['base_url'] = 'https://sleepauth.kodesoft.store';
        }
        if (!isset($global['fallback_slider'])) {
            $global['fallback_slider'] = asset('assets/images/default.jpg');
        }
        foreach ($cartItems as $item) {
            if ($item->product) {
                $this->applyImageAndWarranty($item->product, $global);
            }
        }
    }

    private function calculateTotals($cartItems)
    {
        $subtotal = 0;
        $quantity = 0;

        foreach ($cartItems as $item) {
            $subtotal += $item->price * $item->quantity;
            $quantity += $item->quantity;
        }

        $tax = $subtotal * 0.03;

        return [
            'subtotal' => $subtotal,
            'totalQuantity' => $quantity,
            'tax' => $tax,
            'total' => $subtotal + $tax,
        ];
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

          
         $baseUrl = isset($global['base_url']) ? $global['base_url'] : 'https://sleepauth.kodesoft.store';
         $fallbackSlider = isset($global['fallback_slider']) ? $global['fallback_slider'] : asset('assets/images/default.jpg');

         $product->image_url = $this->setImageOrPlaceholder(
            $image,
            $baseUrl,
            $fallbackSlider
         );
    }

    private function setImageOrPlaceholder($path, $baseUrl, $fallback)
    {
        if (!$path) return $fallback;

        return filter_var($path, FILTER_VALIDATE_URL)
            ? $path
            : rtrim($baseUrl, '/') . '/' . ltrim($path, '/');
    }
}
