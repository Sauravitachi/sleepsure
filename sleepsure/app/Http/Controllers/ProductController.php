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

$dimensionVariants = Variant::query()
    ->where('variant_type', 'size')
    ->where('status', 1)
    ->orderBy('variant_name', 'asc')
    ->get(['variant_id', 'variant_name']);


$thicknessVariants = Thickness::query()
    ->orderBy('thick', 'asc')
    ->get(['id', 'thick', 'map']);
$variantCat = Variant::query()
    ->where('status', 1)
    ->whereNotNull('variant_cat')
    ->where('variant_cat', '!=', '')
    ->selectRaw('MIN(variant_id) as variant_id, MIN(variant_name) as variant_name, LOWER(variant_cat) as variant_cat')
    ->groupBy(DB::raw('LOWER(variant_cat)'))
    ->orderBy('variant_cat', 'asc')
    ->get()
    ->map(function($item) {
        $item->variant_cat = lcfirst(str_replace(' ', '', ucwords(strtolower($item->variant_cat))));
        return $item;
    });

        return view('frontend.product_details', [
            'product'            => $productObj,
            'variantName'        => $transformed['variant_name'] ?? null,
            'productModel'       => $product,
            'dimensionVariants'  => $dimensionVariants,
            'thicknessVariants'  => $thicknessVariants,
            'variantCat'         => $variantCat,
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
        \Log::info('Variant price request', [
            'request_all' => $request->all(),
            'user_id' => auth()->id(),
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        $productId      = $request->product_id;
        $variantId      = $request->variant_id;
        $thicknessId    = $request->thickness_id;
        $customLength   = (float) $request->custom_length;
        $customBreadth  = (float) $request->custom_breadth;
        \Log::info('Parsed input', compact('productId', 'variantId', 'thicknessId', 'customLength', 'customBreadth'));

        $home = app(\App\Http\Controllers\HomeController::class);

        $baseVariant = $home->getVariantDetails($productId);
        \Log::info('Base variant details', ['baseVariant' => $baseVariant]);

        $sizeVariant = Variant::where('variant_id', $variantId)->first();
        \Log::info('Size variant details', ['sizeVariant' => $sizeVariant]);

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
            \Log::info('Extracted dimensions', ['dimensions' => $dimensions]);
            $sqft = $home->calculateSqft(
                $dimensions['dim1'] ?? 0,
                $dimensions['dim2'] ?? 0
            );
            $isCustom = false;
        }

        \Log::info('SQFT calculated', compact('sqft', 'isCustom'));

        if (!$isCustom && $variantId && $thicknessId) {
            $fixedPrice = \DB::table('product_variants')
                ->where('product_id', $productId)
                ->where('var_size_id', $variantId)
                ->where('var_thickness_id', $thicknessId)
                ->value('price');
            \Log::info('Fixed price lookup', [
                'product_id' => $productId,
                'variant_id' => $variantId,
                'thickness_id' => $thicknessId,
                'fixedPrice' => $fixedPrice
            ]);
            if (!is_null($fixedPrice)) {
                return response()->json([
                    'success' => true,
                    'sqft'    => $sqft,
                    'price'   => $home->formatRupee($fixedPrice),
                    'type'    => 'fixed'
                ]);
            }
        }

        if (!$isCustom && $variantId && !$thicknessId) {
            $minPrice = \DB::table('product_variants')
                ->where('product_id', $productId)
                ->where('var_size_id', $variantId)
                ->min('price');
            \Log::info('Min price lookup', [
                'product_id' => $productId,
                'variant_id' => $variantId,
                'minPrice' => $minPrice
            ]);
            if (!is_null($minPrice)) {
                return response()->json([
                    'success' => true,
                    'sqft'    => $sqft,
                    'price'   => $home->formatRupee($minPrice),
                    'type'    => 'dimension-only'
                ]);
            }
        }

        $default_rate = $baseVariant->default_rate ?? 0;
        $oddsize_rate = $baseVariant->oddsize_rate ?? 0;
        $sizeGroup = $sizeVariant->variant_cat ?? null;
        if ($thicknessId) {
            $rateRow = \DB::table('product_oddsizerate')
                ->where('product_id', $productId)
                ->where('var_thickness_id', $thicknessId)
                ->first();
            if ($rateRow) {
                $default_rate = $rateRow->default_rate ?? $default_rate;
                $oddsize_rate = $rateRow->oddsize_rate ?? $oddsize_rate;
            }
            \Log::info('Thickness-specific rates', [
                'thicknessId' => $thicknessId,
                'default_rate' => $default_rate,
                'oddsize_rate' => $oddsize_rate
            ]);
        } else {
            \Log::info('Rates for fallback', compact('default_rate', 'oddsize_rate'));
        }

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
            'price' => $price,
            'baseVariant' => $baseVariant,
            'input' => [
                'productId' => $productId,
                'variantId' => $variantId,
                'thicknessId' => $thicknessId,
                'customLength' => $customLength,
                'customBreadth' => $customBreadth,
            ]
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
