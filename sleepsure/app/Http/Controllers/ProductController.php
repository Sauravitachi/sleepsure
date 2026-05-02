<?php

namespace App\Http\Controllers;

use App\Models\ProductInformation;
use Illuminate\Http\Request;
use App\Models\Variant;
use App\Services\SearchService;    
use App\Http\Controllers\HomeController;
use App\Models\{Thickness,RewardType,SoftSetting};
use App\Models\WishList;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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
        $merged = array_merge($product->toArray(), $transformed);
        $productObj = (object) $merged;

        $productObj->default_variant_id = $productObj->variant_id
            ?? ($product->default_variant ?? null);
        $productObj->default_thickness_id = $productObj->thickness_id
            ?? ($product->default_thickness_id ?? null);

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
        
        // ========== Get ALL variant categories ==========
        $allVariantCategories = Variant::query()
            ->where('status', 1)
            ->whereNotNull('variant_cat')
            ->where('variant_cat', '!=', '')
            ->select('variant_cat')
            ->distinct()
            ->orderBy('variant_cat', 'asc')
            ->get()
            ->map(function($item) {
                return lcfirst(str_replace(' ', '', ucwords(strtolower($item->variant_cat))));
            })
            ->toArray();

        $productVariants = $product->productVariants()->get();
        $variantIds = $productVariants->pluck('var_size_id')->unique()->toArray();
        $thicknessIds = $productVariants->pluck('var_thickness_id')->unique()->toArray();

        // ==========  Initialize grouped with ALL categories ==========
        $grouped = [];
        foreach ($allVariantCategories as $cat) {
            $grouped[$cat] = [];
        }

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
                //Handle unknown categories
                if (!isset($grouped[$cat])) {
                    $cat = 'other';
                    if (!isset($grouped[$cat])) {
                        $grouped[$cat] = [];
                    }
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
                // Handle unknown categories in else block
                if (!isset($grouped[$cat])) {
                    $cat = 'other';
                    if (!isset($grouped[$cat])) {
                        $grouped[$cat] = [];
                    }
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
        
        // ========== Filter out empty categories - comment if have to remove null dimensions from display ==========
        $grouped = array_filter($grouped, function($category) {
            return !empty($category);
        });

        $displayGrouped = [];
        foreach ($grouped as $key => $val) {
            // ========== Capitalize first letter
            $displayKey = ($key === 'other') ? 'Other' : ucfirst($key);
            $displayGrouped[$displayKey] = $val;
        }
        $sizeGroups = array_keys($displayGrouped);
        $dimensionsByGroup = $displayGrouped;

        $isWishlisted = Auth::check()
            ? WishList::where('user_id', Auth::id())
                ->where('product_id', $id)
                ->exists()
            : false;

        $rewardTypes = RewardType::with('reward')->get();
        $baseUrl = SoftSetting::pluck('web_base_url')->first();

        return view('frontend.product_details', [
            'product'            => $productObj,
            'variantName'        => $transformed['variant_name'] ?? null,
            'productModel'       => $product,
            'sizeGroups'         => $sizeGroups,
            'dimensionsByGroup'  => $dimensionsByGroup,
            'variantCat'         => $variantCat,
            'dimensionVariants'  => $dimensionVariants,
            'thicknessVariants'  => $thicknessVariants,
            'variants'           => $dimensionVariants,
            'thicknesses'        => $thicknessVariants,
            'isWishlisted'       => $isWishlisted,
            'rewardTypes'        => $rewardTypes,
            'baseUrl'            => $baseUrl,
        ]);
    }

    public function checkDelivery(Request $request)
    {
        $pincode = $request->pincode;
        return preg_match('/^[1-8][0-9]{5}$/', $pincode)
            ? response()->json(['success' => true, 'message' => 'Delivery available'])
            : response()->json(['success' => false, 'message' => 'Delivery not available']);
    }

    //fix custom price calculation and fixed price priority
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

        // Check if this is a custom size request
        $isCustom = ($customLength > 0 && $customBreadth > 0);
        
        // Calculate square footage
        if ($isCustom) {
            // Custom size: calculate sqft from entered dimensions
            $sqft = round(($customLength * $customBreadth) / 144, 2);
            \Log::info('Custom size calculation', ['length' => $customLength, 'breadth' => $customBreadth, 'sqft' => $sqft]);
        } else {
            // Standard size: need variant to calculate dimensions
            if (empty($variantId)) {
                return response()->json([
                    'success' => true,
                    'price' => $home->formatRupee(0),
                    'price_value' => 0,
                    'error' => 'No variant selected'
                ]);
            }
            
            $sizeVariant = Variant::where('variant_id', $variantId)->first();
            
            if (!$sizeVariant) {
                return response()->json([
                    'success' => true,
                    'price' => $home->formatRupee(0),
                    'price_value' => 0,
                    'error' => 'Variant not found'
                ]);
            }
            
            $dimensions = $home->extractDimensions($sizeVariant->variant_name);
            $sqft = $home->calculateSqft(
                $dimensions['dim1'] ?? 0,
                $dimensions['dim2'] ?? 0
            );
            \Log::info('Standard size calculation', ['variant_name' => $sizeVariant->variant_name, 'sqft' => $sqft]);
        }

        // Check for fixed price in product_variants table (only for standard sizes)
        if (!$isCustom && $variantId && $thicknessId) {
            $fixedPrice = \DB::table('product_variants')
                ->where('product_id', $productId)
                ->where('var_size_id', $variantId)
                ->where('var_thickness_id', $thicknessId)
                ->value('price');            
            if (!is_null($fixedPrice) && $fixedPrice > 0) {
                $fixedPriceValue = (float) $fixedPrice;
                \Log::info('Fixed price found', ['price' => $fixedPriceValue]);
                return response()->json([
                    'success' => true,
                    'sqft' => $sqft,
                    'price' => $home->formatRupee($fixedPriceValue),
                    'price_value' => $fixedPriceValue,
                    'type' => 'fixed'
                ]);
            }
        }

        // Get rates for calculation
        $default_rate = $baseVariant->default_rate ?? 0;
        $oddsize_rate = $baseVariant->oddsize_rate ?? 0;
        
        // Override rates if specific thickness rates exist
        if ($thicknessId) {
            $rateRow = \DB::table('product_oddsizerate')
                ->where('product_id', $productId)
                ->where('var_thickness_id', $thicknessId)
                ->first();
            if ($rateRow) {
                $default_rate = $rateRow->default_rate ?? $default_rate;
                $oddsize_rate = $rateRow->oddsize_rate ?? $oddsize_rate;
                \Log::info('Thickness specific rates', [
                    'thickness_id' => $thicknessId,
                    'default_rate' => $default_rate,
                    'oddsize_rate' => $oddsize_rate
                ]);
            }
        }
        
        // Calculate price based on size type
        if ($isCustom) {
            // For custom size, use oddsize_rate (custom/odd size pricing)
            $rateToUse = $oddsize_rate > 0 ? $oddsize_rate : $default_rate;
            $priceValue = $sqft * $rateToUse;
            \Log::info('Custom price calculation', [
                'sqft' => $sqft,
                'rate_used' => $rateToUse,
                'oddsize_rate' => $oddsize_rate,
                'default_rate' => $default_rate,
                'price' => $priceValue
            ]);
        } else {
            // For standard size, use the calculate Price method
            $priceValue = $home->calculatePrice(
                $sqft,
                $default_rate,
                $oddsize_rate,
                $baseVariant
            );
            \Log::info('Standard price calculation', [
                'sqft' => $sqft,
                'default_rate' => $default_rate,
                'price' => $priceValue
            ]);
        }
        
        // If price is still 0, try to get any price from product_variants as fallback
        if ($priceValue <= 0 && $thicknessId) {
            $anyPrice = \DB::table('product_variants')
                ->where('product_id', $productId)
                ->where('var_thickness_id', $thicknessId)
                ->value('price');
            
            if ($anyPrice && $anyPrice > 0) {
                $priceValue = (float) $anyPrice;
                \Log::info('Fallback price used', ['price' => $priceValue]);
            }
        }
    
        return response()->json([
            'success' => true,
            'sqft' => $sqft,
            'rate' => $isCustom ? ($oddsize_rate ?: $default_rate) : $default_rate,
            'price' => $home->formatRupee($priceValue),
            'price_value' => $priceValue,
            'type' => $isCustom ? 'custom-rate' : 'default-rate'
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
        
        //show only product no category with image mapping
        $transformed = $results
            ->filter(function ($item) {
                return !isset($item->search_type) || $item->search_type !== 'category';
            })
            ->map(function ($item) use ($global) {

                $rawImage = $item->image_url ?? $item->image_thumb ?? null;

                $image = $this->setImageOrPlaceholder(
                    $rawImage,
                    $global['base_url'],
                    $global['fallback_slider']
                );

                return [
                    'search_type'  => 'product',
                    'product_id'   => $item->product_id,
                    'product_name' => $item->product_name,
                    'image_url'    => $image,
                    'categoryDetails' => $item->categoryDetails ? [
                        'category_id'   => $item->categoryDetails->category_id ?? null,
                        'category_name' => $item->categoryDetails->category_name ?? null,
                    ] : null,
                    'link' => url('/product/' . $item->product_id),
                ];
            })
            ->values(); // reset indexes

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
            // If path is already a full URL, return as is
            if (filter_var($path, FILTER_VALIDATE_URL)) {
                return $path;
            }
            // Always prepend baseUrl for relative paths
            return rtrim($baseUrl, '/') . '/' . ltrim($path, '/');
        }
        return $fallback;
    }
}
