<?php

namespace App\Http\Controllers;
use App\Models\{WebSetting,Slider,ProductInformation,ProductCategory,StoreSet,
    ProductReview,Thickness,ProductVariant,ProductOddSizeRate,Award,Faq,Reward,RewardType};
use DB;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    // function for home page
    public function index()
    {
        $global = globalData();

        $sliders = $this->getSliders($global);
        $featured_products = $this->getProducts('is_featured', $global);
        $best_seller = $this->getProducts('best_sale', $global);
        $top_rated = $this->getProducts('top_rated', $global);
        $store_sets = StoreSet::get();
        $awards = $this->getAwardsWithImage();
        $faqs = Faq::all();
        $testimonials = DB::table('testinomials')
            ->select('reviwes', 'name', 'city', 'country')
            ->orderByDesc('created_date')
            ->take(10)
            ->get();

        // Fetch rewards and reward types for offers section
        $rewards = Reward::with('rewardTypes')->get();
        $rewardTypes = $this->getRewardTypesWithImage();
        $categories = $this->getCategoriesWithImage();

        return view('frontend.home', compact(
            'sliders',
            'featured_products',
            'best_seller',
            'top_rated',
            'store_sets',
            'awards',
            'faqs',
            'testimonials',
            'rewards',
            'rewardTypes',
            'categories'
        ));
    }

    private function getAwardsWithImage()
    {
        $baseUrl = 'https://sleepauth.kodesoft.store/';
        $placeholder = 'https://sleepauth.kodesoft.store/my-assets/image/product.png';
        return Award::all()->map(function ($award) use ($baseUrl, $placeholder) {
            $award->img = !empty($award->img)
                ? rtrim($baseUrl, '/') . '/' . ltrim($award->img, '/')
                : $placeholder;
            return $award;
        });
    }

    private function getRewardTypesWithImage()
    {
        $baseUrl = 'https://sleepauth.kodesoft.store/';
        $placeholder = 'https://sleepauth.kodesoft.store/my-assets/image/product.png';
        return RewardType::with('reward')->get()->map(function ($rewardType) use ($baseUrl, $placeholder) {
            $rewardType->logo = !empty($rewardType->logo)
                ? rtrim($baseUrl, '/') . '/' . ltrim($rewardType->logo, '/')
                : $placeholder;
            return $rewardType;
        });
    }

    private function getCategoriesWithImage()
    {
        $baseUrl = 'https://sleepauth.kodesoft.store/';
        $placeholder = 'https://sleepauth.kodesoft.store/my-assets/image/product.png';
        $global = globalData();
        return collect($global['categories'])->map(function ($cat) use ($baseUrl, $placeholder) {
            $cat->image = !empty($cat->image)
                ? rtrim($baseUrl, '/') . '/' . ltrim($cat->image, '/')
                : $placeholder;
            return $cat;
        });
    }




    // function for all categories page
    public function allCategories(Request $request)
    {
        $global = globalData();
        
        // $categories = ProductCategory::where('parent_category_id', null)
        //     ->with('subcategories')
         // Use the same category structure used globally (includes null/empty parent handling,
        // status/cat_type filters, ordering and nested subcategories/models)
        $categories = $global['categories'];
        
        $productsQuery = ProductInformation::with([
                'categoryDetails',
                'categoryDetails.parentCategoryDetails',
                'reviews'
            ])
            ->where('product_information.status', 1);
        
        $joinedVariants = false;
        
        // Apply category filter
        $selectedCategories = $request->input('categories', []);
        if (!empty($selectedCategories)) {
            $productsQuery->whereIn('product_information.category_id', $selectedCategories);
        }
        
        // Apply price filter
        $priceMax = $request->input('price_max');
        if ($priceMax !== null && $priceMax < 100000) {
            $productsQuery->leftJoin('product_variants', 'product_information.product_id', '=', 'product_variants.product_id')
                ->where('product_variants.price', '<=', $priceMax)
                ->select('product_information.*');
            $joinedVariants = true;
        }
        
        // Apply sorting
        $sortBy = $request->input('sort', 'featured');
        switch ($sortBy) {
            case 'price_low':
                if (!$joinedVariants) {
                    $productsQuery->leftJoin('product_variants', 'product_information.product_id', '=', 'product_variants.product_id')
                        ->select('product_information.*');
                    $joinedVariants = true;
                }
                $productsQuery->orderBy('product_variants.price', 'asc');
                break;
            case 'price_high':
                if (!$joinedVariants) {
                    $productsQuery->leftJoin('product_variants', 'product_information.product_id', '=', 'product_variants.product_id')
                        ->select('product_information.*');
                    $joinedVariants = true;
                }
                $productsQuery->orderBy('product_variants.price', 'desc');
                break;
            case 'rating':
                // Sorting by rating would require aggregate function
                break;
            case 'newest':
                $productsQuery->orderBy('product_information.created_at', 'desc');
                break;
            case 'featured':
            default:
                $productsQuery->orderBy('product_information.is_featured', 'desc');
                break;
        }
        
        // Paginate products - 12 per page
        $paginatedProducts = $productsQuery->distinct()->paginate(12);
        
        $products = $paginatedProducts->map(function ($product) use ($global) {
            $this->applyImageAndWarranty($product, $global);
            $this->calculateReview($product);
            return $this->transformProduct($product);
        });

        return view('frontend.categories', compact(
            'categories',
            'products',
            'paginatedProducts'
        ));
    }

    //   public function viewProducts(Request $request)
    // {
    //     $global = globalData();
    //     $type = $request->input('type');
    //     $products = collect();
    //     $title = '';
    //     if ($type === 'featured') {
    //         $products = $this->getProducts('is_featured', $global, 1000);
    //         $title = 'All Featured Products';
    //     } elseif ($type === 'best_seller') {
    //         $products = $this->getProducts('best_sale', $global, 1000);
    //         $title = 'All Best Seller Products';
    //     }
    //     return view('frontend.viewproducts', compact('products', 'title'));
    // }
     public function viewProducts(Request $request)
    {
        $global = globalData();
        $categories = $global['categories'];
        $type = $request->input('type');
        $title = '';
        $productsQuery = ProductInformation::with([
            'categoryDetails',
            'categoryDetails.parentCategoryDetails',
            'reviews'
        ])->where('status', 1);

        // If no type, show all products
        if ($type === 'featured') {
            $productsQuery->where('is_featured', 1);
            $title = 'All Featured Products';
        } elseif ($type === 'best_seller' || $type === 'best_sale') {
            $productsQuery->where('best_sale', 1);
            $title = 'All Best Seller Products';
        } elseif ($type === 'top_rated') {
            $productsQuery->where('top_rated', 1);
            $title = 'All Top Rated Products';
        } else {
            $title = 'All Products';
        }

        // Price filter
        $priceMax = $request->input('price_max');
        $joinedVariants = false;
        if ($priceMax !== null && $priceMax < 100000) {
            $productsQuery->leftJoin('product_variants', 'product_information.product_id', '=', 'product_variants.product_id')
                ->where('product_variants.price', '<=', $priceMax)
                ->select('product_information.*');
            $joinedVariants = true;
        }

        // Size filter
        $sizes = $request->input('sizes', []);
        if (!empty($sizes)) {
            $productsQuery->where(function($q) use ($sizes) {
                foreach ($sizes as $size) {
                    $q->orWhere('product_information.size', 'like', "%$size%")
                      ->orWhere('product_information.product_name', 'like', "%$size%")
                      ->orWhere('product_information.tag', 'like', "%$size%")
                      ;
                }
            });
        }

        // Firmness filter
        $firmness = $request->input('firmness', []);
        if (!empty($firmness)) {
            $productsQuery->where(function($q) use ($firmness) {
                foreach ($firmness as $firm) {
                    $q->orWhere('product_information.tag', 'like', "%$firm%")
                      ->orWhere('product_information.product_name', 'like', "%$firm%")
                      ;
                }
            });
        }

        // Sorting
        $sortBy = $request->input('sort', 'featured');
        switch ($sortBy) {
            case 'price_low':
                if (!$joinedVariants) {
                    $productsQuery->leftJoin('product_variants', 'product_information.product_id', '=', 'product_variants.product_id')
                        ->select('product_information.*');
                    $joinedVariants = true;
                }
                $productsQuery->orderBy('product_variants.price', 'asc');
                break;
            case 'price_high':
                if (!$joinedVariants) {
                    $productsQuery->leftJoin('product_variants', 'product_information.product_id', '=', 'product_variants.product_id')
                        ->select('product_information.*');
                    $joinedVariants = true;
                }
                $productsQuery->orderBy('product_variants.price', 'desc');
                break;
            case 'rating':
                // Sorting by rating would require aggregate function
                break;
            case 'newest':
                $productsQuery->orderBy('product_information.created_at', 'desc');
                break;
            case 'featured':
            default:
                $productsQuery->orderBy('product_information.is_featured', 'desc');
                break;
        }

        // Paginate products - 12 per page
        $paginatedProducts = $productsQuery->distinct()->paginate(12);
        $products = $paginatedProducts->map(function ($product) use ($global) {
            $this->applyImageAndWarranty($product, $global);
            $this->calculateReview($product);
            return $this->transformProduct($product);
        });

        return view('frontend.viewproducts', compact('products', 'title', 'paginatedProducts','categories'));
    }


    private function getSliders($global)
    {
        return Slider::where('status', 1)
            ->orderBy('slider_position', 'asc')
            ->get()
            ->map(function ($slider) use ($global) {
                $slider->image_url = $this->setImageOrPlaceholder(
                    $slider->slider_image,
                    $global['base_url'],
                    $global['fallback_slider']
                );
                return $slider;
            });
    }


    private function getProducts(string $filterField, array $global, int $limit = 10)
    {
        return ProductInformation::with([
                'categoryDetails',
                'categoryDetails.parentCategoryDetails',
                'reviews'
            ])
            ->where('status', 1)
            ->where($filterField, 1)
                ->inRandomOrder() // Randomize the order
                ->limit($limit)
            ->get()
            ->map(function ($product) use ($global) {
                $this->applyImageAndWarranty($product, $global);
                $this->calculateReview($product);
                return $this->transformProduct($product);
            });
    }

    public function applyImageAndWarranty($product, $global)
    {
        $image = $product->image_thumb ?: $product->image_large_details;

        $product->image_url = $this->setImageOrPlaceholder(
            $image,
            $global['base_url'],
            $global['fallback_slider']
        );

        // Use the same formatWarranty logic for warranty_text
        $months = $product->warrantee ?? 0;
        $product->warranty_text = $this->formatWarranty($months);
    }

    public function calculateReview($product)
    {
        $totalRates = $product->reviews->sum('rate');
        $totalReviewers = $product->reviews->count();

        $product->review = $totalReviewers
            ? round($totalRates / $totalReviewers, 1)
            : 0;

        $product->total_reviewers = $totalReviewers;
    }

    public function setImageOrPlaceholder($path, $baseUrl, $fallback)
    {
        if (!empty($path)) {
            return rtrim($baseUrl, '/') . '/' . ltrim($path, '/');
        }

        return $fallback;
    }

    public function getVariantDetails($productId)
    {
        $variant = DB::selectOne("
            SELECT 
                pv.product_id, 
                pv.var_size_id, 
                pv.var_thickness_id, 
                pv.price, 
                t.thick, 
                t.map, 
                v.variant_name, 
                v.variant_cat,

                COALESCE(
                    po.default_rate,
                    (
                        SELECT por.default_rate
                        FROM product_oddsizerate por
                        WHERE por.product_id = pv.product_id
                        ORDER BY por.var_thickness_id DESC
                        LIMIT 1
                    )
                ) AS default_rate,

                COALESCE(
                    po.oddsize_rate,
                    (
                        SELECT por.oddsize_rate
                        FROM product_oddsizerate por
                        WHERE por.product_id = pv.product_id
                        ORDER BY por.var_thickness_id DESC
                        LIMIT 1
                    )
                ) AS oddsize_rate

            FROM product_variants pv
            LEFT JOIN thickness t ON t.id = pv.var_thickness_id 
            LEFT JOIN variant v ON v.variant_id = pv.var_size_id
            LEFT JOIN product_oddsizerate po 
                ON po.product_id = pv.product_id 
                AND po.var_thickness_id = pv.var_thickness_id
            WHERE pv.product_id = :product_id
            AND v.status = 1
            ORDER BY pv.var_thickness_id DESC
            LIMIT 1
        ", ['product_id' => $productId]);

        if ($variant) {
            return $variant;
        }

        //Fallback → thickness + default size
        return DB::selectOne("
            SELECT 
                pi.product_id,

                -- Size from default_variant
                v.variant_id   AS var_size_id,
                v.variant_name,
                v.variant_cat,

                -- Thickness
                t.id AS var_thickness_id,
                t.thick,
                t.map,

                -- Rates
                po.default_rate,
                po.oddsize_rate,

                NULL AS price

            FROM product_information pi
            LEFT JOIN variant v
                ON v.variant_id = pi.default_variant
                AND v.status = 1
            LEFT JOIN product_oddsizerate po
                ON po.product_id = pi.product_id
            LEFT JOIN thickness t
                ON t.id = po.var_thickness_id
            WHERE pi.product_id = :product_id
            ORDER BY po.var_thickness_id DESC
            LIMIT 1
        ", ['product_id' => $productId]);



    }
    public function transformProduct($product)
    {
        $variant = $this->getVariantDetails($product->product_id);
        $sizeValue  = $variant->variant_name ?? '';
        $thickValue = $variant->thick ?? '';

        $dimensions = $this->extractDimensions($sizeValue);
        $dim1 = $dimensions['dim1'] ?? 0;
        $dim2 = $dimensions['dim2'] ?? 0;

        $dimension_display = ($dim1 > 0 && $dim2 > 0)
            ? $dim1 . '" x ' . $dim2 . '"'
            : ($sizeValue ?: '');

        $thickness_display = $thickValue ? $thickValue . '"' : '';

        // Use variant warranty_months if available, else product warrantee
        $warrantyMonths = $variant->warranty_months ?? $product->warrantee ?? 0;
        $warranty_display = $this->formatWarranty($warrantyMonths);

        $variant_full_display = trim(
            ucfirst(strtolower($variant->variant_cat ?? '')) .
            ($dimension_display ? ' | ' . $dimension_display : '') .
            ($thickness_display ? ' x ' . $thickness_display : '') .
            ($warranty_display ? ' | ' . $warranty_display : '')
        );

        $default_variant = trim(
            ucfirst(strtolower($variant->variant_cat ?? '')) .
            ($dimension_display ? ' | ' . $dimension_display : '').
            ($thickness_display ? ' x ' . $thickness_display : '')
        );

        // Calculate SQFT
        $sqft = $this->calculateSqft($dim1, $dim2);
        // Convert inches to cm
        $dim1_cm = $this->inchToCm($dim1);
        $dim2_cm = $this->inchToCm($dim2);
        $thickNum = (float) preg_replace('/[^0-9.]/', '', $thickValue);

        // If both oddsize_rate and default_rate are NULL, fetch via fallback query
        $default_rate = $variant->default_rate ?? null;
        $oddsize_rate = $variant->oddsize_rate ?? null;
        $variant_found = $variant !== null;
        $variant_thickness_id = $variant->var_thickness_id ?? null;
        $fallback_thickness = null;
        if (!$variant_found) {
            $row = DB::selectOne("SELECT po.*, t.thick FROM product_oddsizerate po LEFT JOIN thickness t ON t.id = po.var_thickness_id WHERE po.product_id = ? LIMIT 1", [
                $product->product_id
            ]);
            if ($row) {
                $default_rate = $row->default_rate ?? null;
                $oddsize_rate = $row->oddsize_rate ?? null;
                $variant_thickness_id = $row->var_thickness_id ?? null;
                $fallback_thickness = $row->thick ?? null;
            }
        } else if (is_null($default_rate) && is_null($oddsize_rate)) {
            $row = DB::selectOne("SELECT po.*, t.thick FROM product_oddsizerate po LEFT JOIN thickness t ON t.id = po.var_thickness_id WHERE po.product_id = ? AND po.var_thickness_id = ? LIMIT 1", [
                $product->product_id,
                $variant_thickness_id
            ]);
            if ($row) {
                $default_rate = $row->default_rate ?? null;
                $oddsize_rate = $row->oddsize_rate ?? null;
                $fallback_thickness = $row->thick ?? null;
            }
        }

        // Calculate price using oddsize_rate and SQFT as per business logic
        $price = $this->calculatePrice($sqft, $default_rate, $oddsize_rate, $variant);

        $default_price_calculated = $default_rate ?? 0;
        $oddsize_price_calculated = $oddsize_rate ?? 0;

        return [
            'product_id' => $product->product_id,
            'product_name' => $product->product_name ?? '',
            'name' => $product->product_name ?? '', // Alias for blade template
            'type' => $product->type ?? 'N/A',
            'material' => $product->tag ? str_replace(',', ', ', $product->tag) : 'N/A',
            'image_url' => $product->image_url ?? '',
            'warranty_text' => $warranty_display,
            'variant_cat' => $variant->variant_cat ?? '',
            'review' => $product->review ?? 0,
            'total_reviewers' => $product->total_reviewers ?? 0,
            'description' => $product->description ?? '',
            'onsale' => $product->onsale ?? false,
            'onsale_price' => $product->onsale_price ?? null,
            'price' => $this->formatRupee($price),
            'specification' => $product->specification ?? '',
            'category_id' => $product->categoryDetails->category_id ?? 'N/A',
            'category_name' =>
                $product->categoryDetails->parentCategoryDetails->category_name
                ?? $product->categoryDetails->category_name
                ?? 'N/A',

            // If no variant, show 'Custom Size' and fallback thickness
            'product_size' => ($variant && $variant->variant_name && $variant->map)
                ? $variant->variant_name . ' ' . $variant->map
                : 'N/A',

            // Variant details
            'variant_name' => $variant->variant_name ?? 'N/A',
            'variant_price' => $this->formatRupee($variant->price ?? ($oddsize_rate ?? 0)),
            'default_rate' => $default_rate,
            'oddsize_rate' => $oddsize_rate,
            'variant_thickness' => $variant->thick ?? ($fallback_thickness ?? ($variant_thickness_id ?? '')),
            'variant_measure' => $variant->map ?? '',

            // Display formats for blade template
            'size_display' => ($variant && $variant->variant_name)
                ? $variant->variant_name
                : 'N/A',
            'size_display_mm' => ($dim1_cm > 0 && $dim2_cm > 0)
                ? $dim1_cm . ' x ' . $dim2_cm . ' cm'
                : 'N/A',
            'thick_display' => ($variant && $variant->thick && $variant->map)
                ? $variant->thick . ' ' . $variant->map
                : ($fallback_thickness ?? ($variant_thickness_id ? $variant_thickness_id : 'N/A')),
            'dim1' => $dim1,
            'dim2' => $dim2,
            'default_price_calculated' => $default_price_calculated,
            'oddsize_price_calculated' => $oddsize_price_calculated,
            'discount_price' => $this->formatRupee($variant->price ?? ($oddsize_rate ?? 0)),
            'original_price' => $this->formatRupee($variant->default_rate ?? ($default_rate ?? 0)),
            'discount_percent' => ($variant && $variant->default_rate > 0 && $variant->price > 0)
                ? round((($variant->default_rate - $variant->price) / $variant->default_rate) * 100)
                : 0,
            'size' => ($variant && $variant->variant_name && $variant->thick && $variant->map)
                ? $variant->variant_name . 'x' . $variant->thick . ' ' . $variant->map
                : 'N/A',
            'size_cm' => ($dim1_cm > 0 && $dim2_cm > 0 && $thickNum > 0)
                ? $dim1_cm . 'x' . $dim2_cm . 'x' . number_format($thickNum * 2.54, 1) . ' cm'
                : 'N/A',
            'thickness' => ($variant && $variant->thick && $variant->map)
                ? $variant->thick . ' ' . $variant->map
                : ($fallback_thickness ?? ($variant_thickness_id ? $variant_thickness_id : 'N/A')),
            'variant_full_display' => $variant_full_display,
            'default_variant' => $default_variant,
        ];

    }

    /**
     * Format a number as Indian Rupee with 2 decimals and comma grouping
     */
    public function formatRupee($amount)
    {
        if (!is_numeric($amount)) return '';
        $formatted = number_format((float)$amount, 2, '.', ',');
        return '₹ ' . $formatted;
    }

    /**
     * Calculate SQFT from inches
     * @param float $lengthInch
     * @param float $widthInch
     * @return float
     */
    public function calculateSqft($lengthInch, $widthInch)
    {
        if ($lengthInch > 0 && $widthInch > 0) {
            return round(($lengthInch * $widthInch) / 144, 2);
        }
        return 0;
    }

    /**
     * Convert inches to centimeters
     * @param float $inch
     * @return float
     */
    public function inchToCm($inch)
    {
        return $inch > 0 ? round($inch * 2.54, 1) : 0;
    }

    /**
     * Calculate price based on SQFT and rates
     * @param float $sqft
     * @param float|null $default_rate
     * @param float|null $oddsize_rate
     * @param object|null $variant
     * @return float
     */
    public function calculatePrice($sqft, $default_rate, $oddsize_rate, $variant)
    {
        if ($variant) {
            if ($oddsize_rate && $sqft > 0) {
                return round($oddsize_rate * $sqft, 2);
            } elseif ($default_rate && $sqft > 0) {
                return round($default_rate * $sqft, 2);
            } elseif (isset($variant->price)) {
                return $variant->price;
            }
        } else {
            if ($oddsize_rate) {
                return $oddsize_rate;
            } elseif ($default_rate) {
                return $default_rate;
            }
        }
        return 0;
    }
private function formatWarranty($months)
{
    if (!$months || $months <= 0) {
        return '';
    }

    $years  = intdiv($months, 12);
    $remain = $months % 12;

    if ($years > 0 && $remain === 0) {
        return $years . ' Year' . ($years > 1 ? 's' : '');
    }

    if ($years > 0 && $remain > 0) {
        return $years . ' Year' . ($years > 1 ? 's' : '') . ' ' .
               $remain . ' Month' . ($remain > 1 ? 's' : '');
    }

    return $months . ' Month' . ($months > 1 ? 's' : '');
}

public function extractDimensions($variantName)
{
    preg_match('/(\d+(?:\.\d+)?)\s*[xX×]\s*(\d+(?:\.\d+)?)/', $variantName, $matches);
    return [
        'dim1' => isset($matches[1]) ? (float) $matches[1] : 0,
        'dim2' => isset($matches[2]) ? (float) $matches[2] : 0,
    ];
}




}
