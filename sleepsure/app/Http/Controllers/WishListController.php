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
        if (!$user) {
            return redirect()->route('login');
        }
        $wishlist = WishList::where('user_id', $user->id)->get();
        $products = ProductInformation::whereIn('product_id', $wishlist->pluck('product_id'))->get();
        return view('frontend.wishlist', compact('products'));
    }

    public function add(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Not authenticated'], 401);
        }
        $productId = $request->input('product_id');
        $exists = WishList::where('user_id', $user->id)->where('product_id', $productId)->exists();
        if (!$exists) {
            WishList::create([
                'user_id' => $user->id,
                'product_id' => $productId,
            ]);
        }
        return response()->json(['success' => true]);
    }

    public function remove(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Not authenticated'], 401);
        }
        $productId = $request->input('product_id');
        WishList::where('user_id', $user->id)->where('product_id', $productId)->delete();
        return response()->json(['success' => true]);
    }
}
