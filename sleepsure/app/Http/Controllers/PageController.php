<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\ProductCategory;
use App\Models\ProductInformation;
use App\Models\Reward;
use App\Models\RewardType;
use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display the stores page
     */
    public function stores()
    {
        $global = globalData();
        return view('frontend.stores', $global);
    }

    /**
     * Display the bulk orders page
     */
    public function bulkOrders()
    {
        $global = globalData();
        return view('frontend.bulk_order', $global);
    }

    /**
     * Display the FAQ page
     */
    public function faq()
    {
        $global = globalData();
        $faqCategories = \App\Models\ProductFaqCat::with(['faqs' => function($q) {
            $q->where('status', 1);
        }])->where('status', 1)->get();
        return view('frontend.faq', array_merge($global, compact('faqCategories')));
    }

    /**
     * Display the about us page
     */
    public function aboutUs()
    {
        $global = globalData();
        return view('frontend.about-us', $global);
    }

    /**
     * Display the offers page
     */
    public function offer()
    {
        $global = globalData();
        
        // Fetch all reward categories with their reward types
        $rewards = Reward::with('rewardTypes')->get();
        
        // Fetch all reward types for the offer cards
        $rewardTypes = RewardType::with('reward')->get();
        
        return view('frontend.offer', array_merge($global, compact('rewards', 'rewardTypes')));
    }

   public function category($categoryId)
{
    $global = globalData();
    $categories = $global['categories'];

    $category = ProductCategory::where('category_id', $categoryId)
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

    return view('frontend.categories', compact('products', 'paginatedProducts', 'categories', 'category'));
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
