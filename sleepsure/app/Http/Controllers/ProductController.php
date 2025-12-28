<?php

namespace App\Http\Controllers;

use App\Models\ProductInformation;
use Illuminate\Http\Request;
use App\Models\Variant;
use App\Models\Thickness;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function productDetails($id)
    {
        $global = globalData();

        $product = ProductInformation::with([
            'productVariants.sizeVariant',
            'reviews.reviewer',
            'categoryDetails',
            'categoryDetails.parentCategoryDetails'
        ])->where('product_id', $id)->firstOrFail();

        $homeController = app(\App\Http\Controllers\HomeController::class);
        $transformed = $homeController->transformProduct($product);
        $productObj = (object) $transformed;

        $this->applyImageAndWarranty($productObj, $global);

        // ✅ SIZE VARIANTS
        $dimensionVariants = Variant::where('variant_type', 'size')
            ->where('status', 1)
            ->orderBy('variant_name')
            ->get(['variant_id', 'variant_name']);

        // ✅ THICKNESS VARIANTS (ID FIX)
        $thicknessVariants = Thickness::orderBy('thick', 'asc')
            ->get(['id', 'thick', 'map']); // 🔥 IMPORTANT

        return view('frontend.product_details', [
            'product'            => $productObj,
            'variantName'        => $transformed['variant_name'] ?? null,
            'productModel'       => $product,
            'dimensionVariants'  => $dimensionVariants,
            'thicknessVariants'  => $thicknessVariants,
        ]);
    }

    private function applyImageAndWarranty($product, $global)
    {
        $image = $product->image_thumb ?? null;

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
        if (!empty($path) && file_exists(public_path($path))) {
            return rtrim($baseUrl, '/') . '/' . ltrim($path, '/');
        }
        return $fallback;
    }

    public function checkDelivery(Request $request)
    {
        $pincode = $request->pincode;
        return preg_match('/^[1-8][0-9]{5}$/', $pincode)
            ? response()->json(['success' => true, 'message' => 'Delivery available'])
            : response()->json(['success' => false, 'message' => 'Delivery not available']);
    }

   public function getVariantPrice(Request $request)
{
    $variantId   = $request->variant_id;
    $thicknessId = $request->thickness_id;
    $productId   = $request->product_id;

    $variant = Variant::where('variant_id', $variantId)->first();
    if (!$variant) {
        return response()->json(['success' => false, 'message' => 'Invalid size']);
    }

    preg_match('/(\d+)\s*[xX]\s*(\d+)/', $variant->variant_name, $m);
    $dim1 = (float) ($m[1] ?? 0);
    $dim2 = (float) ($m[2] ?? 0);

    if ($dim1 <= 0 || $dim2 <= 0) {
        return response()->json(['success' => false, 'message' => 'Invalid dimension format']);
    }

    $sqft = round(($dim1 * $dim2) / 144, 2);

    $row = DB::selectOne("
        SELECT default_rate, oddsize_rate
        FROM product_oddsizerate
        WHERE product_id = ?
        AND var_thickness_id = ?
        LIMIT 1
    ", [$productId, $thicknessId]);

    if (!$row) {
        $row = DB::selectOne("
            SELECT default_rate, oddsize_rate
            FROM product_oddsizerate
            WHERE product_id = ?
            LIMIT 1
        ", [$productId]);
    }

    if (!$row) {
        return response()->json(['success' => false, 'message' => 'Rate configuration missing']);
    }

    $standardVariant = DB::table('product_variants')
        ->where('product_id', $productId)
        ->where('var_size_id', $variantId)
        ->where('var_thickness_id', $thicknessId)
        ->whereNotNull('price')
        ->first();

    $isOddSize = !$standardVariant;

    $rate = $isOddSize
        ? ($row->oddsize_rate ?? $row->default_rate)
        : $row->default_rate;

    if (!$rate) {
        return response()->json(['success' => false, 'message' => 'Rate not available']);
    }

    $price = round($sqft * $rate, 2);

    return response()->json([
        'success' => true,
        'sqft'    => $sqft,
        'rate'    => $rate,
        'price'   => '₹ ' . number_format($price, 2),
        'type'    => $isOddSize ? 'odd' : 'default'
    ]);
}


}
