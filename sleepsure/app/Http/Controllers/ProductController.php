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
    \Log::info('Variant price request', $request->all());

    $productId      = $request->product_id;
    $variantId      = $request->variant_id;
    $thicknessId    = $request->thickness_id;
    $customLength   = (float) $request->custom_length;
    $customBreadth  = (float) $request->custom_breadth;

    $home = app(\App\Http\Controllers\HomeController::class);

    $baseVariant = $home->getVariantDetails($productId);

    $sizeVariant = Variant::where('variant_id', $variantId)->first();

    if (!$sizeVariant) {
        \Log::warning('Size variant not found', compact('variantId'));
        return response()->json([
            'success' => true,
            'price'   => $home->formatRupee(0)
        ]);
    }

    if ($customLength > 0 && $customBreadth > 0) {
        $sqft = round(($customLength * $customBreadth) / 144, 2);
        $isCustom = true;
    } else {
        $dimensions = $home->extractDimensions($sizeVariant->variant_name);
        $sqft = $home->calculateSqft(
            $dimensions['dim1'] ?? 0,
            $dimensions['dim2'] ?? 0
        );
        $isCustom = false;
    }

    \Log::info('SQFT calculated', compact('sqft', 'isCustom'));

    if (!$isCustom) {
        $fixedPrice = DB::table('product_variants')
            ->where('product_id', $productId)
            ->where('var_size_id', $variantId)
            ->where('var_thickness_id', $thicknessId)
            ->value('price');

        if (!is_null($fixedPrice)) {
            return response()->json([
                'success' => true,
                'sqft'    => $sqft,
                'price'   => $home->formatRupee($fixedPrice),
                'type'    => 'fixed'
            ]);
        }
    }

    $default_rate = $baseVariant->default_rate ?? 0;
    $oddsize_rate = $baseVariant->oddsize_rate ?? 0;

    $price = $home->calculatePrice(
        $sqft,
        $default_rate,
        $oddsize_rate,
        $baseVariant
    );

    \Log::info('Final price', [
        'sqft' => $sqft,
        'default_rate' => $default_rate,
        'oddsize_rate' => $oddsize_rate,
        'price' => $price
    ]);

    return response()->json([
        'success' => true,
        'sqft'    => $sqft,
        'rate'    => $isCustom
            ? ($oddsize_rate ?: $default_rate)
            : $default_rate,
        'price'   => $home->formatRupee($price),
        'type'    => $isCustom ? 'custom-rate' : 'default-rate'
    ]);
}


public function formatRupee($amount)
{
    if (!is_numeric($amount)) return '';
    $formatted = number_format((float)$amount, 2, '.', ',');
    return '₹ ' . $formatted;
}

}
