<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\ProductCategory;
use App\Models\ProductInformation;
use App\Models\Reward;
use App\Models\RewardType;
use App\Models\StoreSet;
use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;

class PageController extends Controller
{
    //Display the stores page
    public function stores()
    {
        $global = globalData();
        $store_sets = StoreSet::get();

        return view('frontend.stores', array_merge($global, compact('store_sets')));
    }

    //Display the bulk orders page
    public function bulkOrders()
    {
        $global = globalData();
        return view('frontend.bulk_order', $global);
    }

    //Display the privacy policy page
    public function privacyPolicy()
    {
        return view('frontend.privacy_policy');
    }

    //display the terms and conditions page
    public function terms()
    {
        return view('frontend.term_conditions');
    }

    //careers page
    public function careers()
    {
        $global = globalData();
        return view('frontend.career', $global);
    }

    //our guarantees page
    public function guarantees()
    {
        $global = globalData();
        return view('frontend.our_gurranty', $global);
    }

    //Display the FAQ page
    public function faq()
    {
        $global = globalData();
        $faqCategories = \App\Models\ProductFaqCat::with(['faqs' => function($q) {
            $q->where('status', 1);
        }])->where('status', 1)->get();
        return view('frontend.faq', array_merge($global, compact('faqCategories')));
    }

    //Display the about us page
    public function aboutUs()
    {
        $global = globalData();
        return view('frontend.about-us', $global);
    }

    //Display the offers page
    public function offer()
    {
        $global = globalData();
                
        $rewards = Reward::with('rewardTypes')->get();
        
        $rewardTypes = RewardType::with('reward')->get();

        $coupons = \Illuminate\Support\Facades\DB::table('coupon')->where('status', 1)->get();
        
        return view('frontend.offer', array_merge($global, compact('rewards', 'rewardTypes', 'coupons')));
    }

    public function category($categoryName)
    {
    $global = globalData();
    $categories = $global['categories'];

    $category = ProductCategory::where('category_name', $categoryName)
        ->where('status', 1)
        ->firstOrFail();

    $categoryIds = $this->getCategoryTreeIds($category);

    $paginatedProducts = ProductInformation::whereIn('category_id', $categoryIds)
        ->where('status', 1)
        ->paginate(12);

    $products = $paginatedProducts->map(function ($product) use ($global) {
        $homeController = app(HomeController::class);
        $homeController->applyImageAndWarranty($product, $global);
        $homeController->calculateReview($product);
        return $homeController->transformProduct($product);
    });

    $variantCat = \App\Models\Variant::query()
        ->where('status', 1)
        ->whereNotNull('variant_cat')
        ->where('variant_cat', '!=', '')
        ->selectRaw('MIN(variant_id) as variant_id, MIN(variant_name) as variant_name, LOWER(variant_cat) as variant_cat')
        ->groupBy(\DB::raw('LOWER(variant_cat)'))
        ->orderBy('variant_cat', 'asc')
        ->get()
        ->map(function($item) {
            $item->variant_cat = strtolower(str_replace(' ', '', $item->variant_cat));
            return $item;
        });

    $allMaterials = ProductInformation::where('status', 1)
        ->pluck('tag')
        ->flatMap(function ($tags) {
            return array_map('trim', explode(',', $tags));
        })
        ->unique()
        ->filter()
        ->values();


    $selectedMaterials = request()->input('materials', []);

    return view('frontend.categories', compact(
        'products',
        'paginatedProducts',
        'categories',
        'category',
        'variantCat',
        'allMaterials',
        'selectedMaterials'
    ));
    }

    private function getCategoryTreeIds($category)
    {
        $ids = [$category->category_id];

        foreach ($category->subcategories as $sub) {
            $ids[] = $sub->category_id;

            foreach ($sub->models as $model) {
                $ids[] = $model->category_id;
            }
        }

        return $ids;
    }

}
