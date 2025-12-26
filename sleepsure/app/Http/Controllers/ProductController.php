<?php

namespace App\Http\Controllers;

use App\Models\ProductInformation;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function productDetails($id)
    {
        $global = globalData();

        // Fetch product
        $product = ProductInformation::with([
            'productVariants.sizeVariant',
            'reviews',
            'categoryDetails',
            'categoryDetails.parentCategoryDetails'
        ])->where('product_id', $id)->firstOrFail();

        // Transform product (same as home page)
        $homeController = app(\App\Http\Controllers\HomeController::class);
        $transformed = $homeController->transformProduct($product);

        // Convert transformed array → object for Blade
        $productObj = (object) $transformed;

        // ✅ APPLY IMAGE + WARRANTY USING YOUR HELPER
        $this->applyImageAndWarranty($productObj, $global);

        return view('frontend.product_details', [
            'product'     => $productObj,
            'variantName' => $transformed['variant_name'] ?? null,
        ]);
    }

    /**
     * Apply image URL & warranty text safely
     */
    private function applyImageAndWarranty($product, $global)
    {
        $image = $product->image_thumb ?? null;

        $product->image_url = $this->setImageOrPlaceholder(
            $image,
            $global['base_url'],
            $global['fallback_slider']
        );

        // Warranty text
        $months = (int) ($product->warrantee ?? 0);

        if ($months >= 12) {
            $product->warranty_text = floor($months / 12) . ' Years';
        } else {
            $product->warranty_text = $months . ' Months';
        }
    }

    /**
     * Return image URL if exists, otherwise fallback
     */
    private function setImageOrPlaceholder($path, $baseUrl, $fallback)
    {
        if (!empty($path)) {
            $fullPath = public_path($path);

            if (file_exists($fullPath)) {
                return rtrim($baseUrl, '/') . '/' . ltrim($path, '/');
            }
        }

        return $fallback;
    }
}
