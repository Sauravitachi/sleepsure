<?php

use App\Models\{WebSetting,PayWith,ProductCategory};

function globalData()
{
    // $base_url = "http://127.0.0.1:8000/";
    $base_url = "https://sleepauth.kodesoft.store/";

    // fixed fallback URL
    $fallback_logo = "https://sleepsure-new.netlify.app/assets/images/logo.png";
    $fallback_slider = "https://sleepsure-new.netlify.app/assets/images/banner2.png";

    $web_setting = WebSetting::first();

    $pay_with = PayWith::all()->map(function ($item) use ($base_url, $fallback_logo) {

    if (!empty($item->image)) {
        $item->image_url = rtrim($base_url, '/') 
            . '/my-assets/image/pay_with/' 
            . ltrim($item->image, '/');
    } else {
        $item->image_url = $fallback_logo;
    }

    return $item;
});


    // Product Categories (3 level dynamic)
    $categories = ProductCategory::where(function($q) {
            $q->whereNull('parent_category_id')
            ->orWhere('parent_category_id', '');
        })
        ->where('cat_type', 1)
        ->where('status', 1)
        ->orderBy('menu_pos', 'asc')
        ->get()
        ->map(function ($main) {
            // Sub Categories
            $main->subcategories = ProductCategory::where('parent_category_id', $main->category_id)
                ->where('cat_type', 2)
                ->where('top_menu', 0)
                ->where('status', 1)
                ->orderBy('menu_pos', 'asc')
                ->get()
                ->map(function ($sub) {
                    // Third Level Category (Model)
                    $sub->models = ProductCategory::where('parent_category_id', $sub->category_id)
                        ->where('cat_type', 2)
                        ->where('top_menu', 0)
                        ->where('status', 1)
                        ->orderBy('menu_pos', 'asc')
                        ->get();

                    return $sub;
                });

            return $main;
        });


    return [
        'web_setting' => $web_setting,
        'base_url'    => $base_url,

        'favicon_url' => !empty($web_setting->favicon)
            ? rtrim($base_url, '/') . '/' . ltrim($web_setting->favicon, '/')
            : $fallback_logo,

        'logo_url' => !empty($web_setting->logo)
            ? rtrim($base_url, '/') . '/' . ltrim($web_setting->logo, '/')
            : $fallback_logo,

        'pay_with'    => $pay_with,
        'fallback_slider'    => $fallback_slider,
        'categories' => $categories,
    ];
}
