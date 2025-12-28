<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductReview;
use Illuminate\Support\Facades\Validator;

class ProductReviewController extends Controller
{
    // Store a new review
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:product_information,product_id',
            'rate' => 'required|integer|min:1|max:5',
            'comments' => 'required|string',
            'media.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }


        // Prevent multiple reviews per user per product
        $userId = auth()->id() ?? null;
        $existing = ProductReview::where('product_id', $request->product_id)
            ->where('reviewer_id', $userId)
            ->first();
        if ($existing) {
            return response()->json(['success' => false, 'message' => 'You have already reviewed this product.'], 409);
        }

        $mediaPaths = [];
        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $file) {
                $mediaPaths[] = $file->store('review_media', 'public');
            }
        }

        $review = ProductReview::create([
            'product_review_id' => uniqid('pr_'),
            'product_id' => $request->product_id,
            'reviewer_id' => $userId,
            'rate' => $request->rate,
            'comments' => $request->comments,
            'media' => $mediaPaths ? json_encode($mediaPaths) : null,
            'date_time' => now(),
            'status' => 1,
        ]);

        return response()->json(['success' => true, 'review' => $review]);
    }
}
