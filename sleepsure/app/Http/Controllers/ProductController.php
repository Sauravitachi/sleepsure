<?php

namespace App\Http\Controllers;

use App\Models\ProductInformation;
use Illuminate\Http\Request;
use App\Models\Variant;
use App\Services\SearchService;    
use App\Http\Controllers\HomeController;
use App\Models\Thickness;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    protected $searchService;

    public function __construct(SearchService $searchService)
    {
        $this->searchService = $searchService;
    }

    public function productDetails($id)
    {
        $global = globalData();

        $product = ProductInformation::with([
            'productVariants.sizeVariant',
            'reviews.reviewer',
            'categoryDetails',
            'categoryDetails.parentCategoryDetails'
        ])->where('product_id', $id)->firstOrFail();

        $homeController = app(HomeController::class);
        $transformed = $homeController->transformProduct($product);
        $productObj = (object) $transformed;

        $this->applyImageAndWarranty($productObj, $global);

        $dimensionVariants = Variant::query()
            ->where('variant_type', 'size')
            ->where('status', 1)
            ->orderBy('variant_name', 'asc')
            ->get(['variant_id', 'variant_name']);

        $thicknessIds = [];
        if ($product && $product->thicknesses) {
            $thicknessIds = explode(',', $product->thicknesses);
        }
        $thicknessVariants = Thickness::whereIn('id', $thicknessIds)
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
    

        $productVariants = $product->productVariants()->get();
        $variantIds = $productVariants->pluck('var_size_id')->unique()->toArray();
        $thicknessIds = $productVariants->pluck('var_thickness_id')->unique()->toArray();

        $grouped = [];
        if ($productVariants->count() > 0) {
            $variants = Variant::whereIn('variant_id', $variantIds)->get();
            $thicknesses = Thickness::whereIn('id', $thicknessIds)->get();
            foreach ($productVariants as $pv) {
                $variant = $variants->firstWhere('variant_id', $pv->var_size_id);
                $thickness = $thicknesses->firstWhere('id', $pv->var_thickness_id);
                if (!$variant || !$thickness) {
                    continue;
                }
                $cat = $variant->variant_cat ? strtolower(str_replace(' ', '', $variant->variant_cat)) : 'other';
                if (!isset($grouped[$cat])) {
                    $grouped[$cat] = [];
                }
                $dimName = $variant->variant_name;
                if (!isset($grouped[$cat][$dimName])) {
                    $grouped[$cat][$dimName] = [];
                }
                $grouped[$cat][$dimName][$thickness->id] = [
                    'id' => $thickness->id,
                    'thick' => $thickness->thick,
                    'map' => $thickness->map,
                    'variant_id' => $variant->variant_id
                ];
            }
        } else {
            $fallbackVariantIds = [];
            $fallbackThicknessIds = [];
            if (!empty($product->variants)) {
                $fallbackVariantIds = explode(',', $product->variants);
            } elseif (!empty($product->default_variant)) {
                $fallbackVariantIds = explode(',', $product->default_variant);
            }
            if (!empty($product->thicknesses)) {
                $fallbackThicknessIds = explode(',', $product->thicknesses);
            }
            $variants = Variant::whereIn('variant_id', $fallbackVariantIds)->get();
            $thicknesses = Thickness::whereIn('id', $fallbackThicknessIds)->get();
            foreach ($variants as $variant) {
                $cat = $variant->variant_cat ? strtolower(str_replace(' ', '', $variant->variant_cat)) : 'other';
                if (!isset($grouped[$cat])) {
                    $grouped[$cat] = [];
                }
                $dimName = $variant->variant_name;
                if (!isset($grouped[$cat][$dimName])) {
                    $grouped[$cat][$dimName] = [];
                }
                foreach ($thicknesses as $thickness) {
                    $grouped[$cat][$dimName][$thickness->id] = [
                        'id' => $thickness->id,
                        'thick' => $thickness->thick,
                        'map' => $thickness->map,
                        'variant_id' => $variant->variant_id
                    ];
                }
            }
        }
        $displayGrouped = [];
        foreach ($grouped as $key => $val) {
            $displayKey = ($key === 'other') ? 'Other' : $key;
            $displayGrouped[$displayKey] = $val;
        }
        $sizeGroups = array_keys($displayGrouped);
        $dimensionsByGroup = $displayGrouped;
        
        return view('frontend.product_details', [
            'product'            => $productObj,
            'variantName'        => $transformed['variant_name'] ?? null,
            'productModel'       => $product,
            'sizeGroups'         => $sizeGroups,
            'dimensionsByGroup'  => $dimensionsByGroup,
            'variantCat'         => $variantCat,
            'dimensionVariants'  => $dimensionVariants,
            'thicknessVariants'  => $thicknessVariants,
        ]);
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
        $productId      = $request->product_id;
        $variantId      = $request->variant_id;
        $thicknessId    = $request->thickness_id;
        $customLength   = (float) $request->custom_length;
        $customBreadth  = (float) $request->custom_breadth;
        \Log::info('Parsed input', compact('productId', 'variantId', 'thicknessId', 'customLength', 'customBreadth'));

        $home = app(HomeController::class);

        $baseVariant = $home->getVariantDetails($productId);

        $sizeVariant = Variant::where('variant_id', $variantId)->first();

        if (!$sizeVariant) {
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


        if (!$isCustom && $variantId && $thicknessId) {
            $fixedPrice = \DB::table('product_variants')
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

        if (!$isCustom && $variantId && !$thicknessId) {
            $minPrice = \DB::table('product_variants')
                ->where('product_id', $productId)
                ->where('var_size_id', $variantId)
                ->min('price');
            
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
            
        } else {
            \Log::info('Rates for fallback', compact('default_rate', 'oddsize_rate'));
        }

        $price = $home->calculatePrice(
            $sqft,
            $default_rate,
            $oddsize_rate,
            $baseVariant
        );

       
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


    public function formatRupee($amount): string
    {
        if (!is_numeric($amount)) return '';
        $formatted = number_format((float)$amount, 2, '.', ',');
        return '₹ ' . $formatted;
    }


   
    public function globalSearch(Request $request)
    {
        $query = $request->input('q', '');
        $limit = (int) $request->input('limit', 20);
        $results = $this->searchService->searchProducts($query, $limit);
        $global = globalData();
        $transformed = $results->map(function ($item) use ($global) {
            if (isset($item->search_type) && $item->search_type === 'category') {
                $image = $item->image ?? $global['fallback_slider'] ?? '';
                return [
                    'search_type' => 'category',
                    'category_id' => $item->category_id,
                    'category_name' => $item->title ?? $item->category_name ?? '',
                    'image_url' => $image,
                    'slug' => $item->slug ?? null,
                    'link' => route('products.categories', ['categoryId' => $item->category_id]),
                ];
            } else {
                $image = $item->image_url ?? $item->image_thumb ?? null;
                if (!$image || !filter_var($image, FILTER_VALIDATE_URL)) {
                    $image = $global['fallback_slider'] ?? '';
                }
                return [
                    'search_type' => 'product',
                    'product_id' => $item->product_id,
                    'product_name' => $item->product_name,
                    'image_url' => $image,
                    'categoryDetails' => $item->categoryDetails ? [
                        'category_id' => $item->categoryDetails->category_id ?? null,
                        'category_name' => $item->categoryDetails->category_name ?? null,
                    ] : null,
                    'link' => url('/product/' . $item->product_id),
                ];
            }
        });
        return response()->json([
            'success' => true,
            'results' => $transformed,
        ]);
    }

    private function applyImageAndWarranty($product, $global)
    {
        if (is_iterable($product)) {
            foreach ($product as $item) {
                $this->applyImageAndWarranty($item, $global);
            }
            return;
        }
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
}
