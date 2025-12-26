<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\Reward;
use App\Models\RewardType;
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
}
