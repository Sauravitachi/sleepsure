<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\WishList;
use App\Models\ProductInformation;

class WishListController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $global = globalData();
        $wishlist = WishList::where('user_id', $user->customer_id)->get();
        $rawProducts = ProductInformation::with(['categoryDetails'])
            ->whereIn('product_id', $wishlist->pluck('product_id'))
            ->get();
        
        // Transform products to get proper image URLs and pricing
        $homeController = app(HomeController::class);
        $products = $rawProducts->map(function ($product) use ($homeController, $global) {
            $transformed = $homeController->transformProduct($product);
            $merged = array_merge($product->toArray(), $transformed);
            $productObj = (object) $merged;
            
            // Apply image and warranty like in ProductController
            $homeController->applyImageAndWarranty($productObj, $global);
            
            return $productObj;
        });
        
        return view('frontend.wishlist', compact('products'));
    }

    public function add(Request $request)
    {
        $user = Auth::user();
        $productId = $request->input('product_id');
        $exists = WishList::where('user_id', $user->customer_id)->where('product_id', $productId)->exists();
        if (!$exists) {
            WishList::create([
                'user_id' => $user->customer_id,
                'product_id' => $productId,
                    'status' => 1,
            ]);
        }
        return response()->json(['success' => true]);
    }

    public function remove(Request $request)
    {
        $user = Auth::user();
        $productId = $request->input('product_id');
        WishList::where('user_id', $user->customer_id)->where('product_id', $productId)->delete();
        return response()->json(['success' => true]);
    }
}
