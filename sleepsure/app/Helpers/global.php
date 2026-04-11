<?php

use App\Models\{WebSetting,PayWith,ProductCategory};

function globalData()
{
    // $base_url = "http://127.0.0.1:8000/";
    $base_url = "https://sleepauth.kodesoft.cloud/";

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


    $categories = ProductCategory::where(function($q) {
        $q->whereNull('parent_category_id')
          ->orWhere('parent_category_id', '');
    })
    ->where('cat_type', 1)
    ->where('status', 1)
    ->orderBy('menu_pos', 'asc')
    ->get()
    ->map(function ($main) use ($base_url, $fallback_logo) {
        $main->image_url = !empty($main->cat_favicon)
            ? rtrim($base_url, '/') . '/' . ltrim($main->cat_favicon, '/')
            : $fallback_logo;

        $main->subcategories = ProductCategory::where('parent_category_id', $main->category_id)
            ->where('cat_type', 2)
            ->where('top_menu', 0)
            ->where('status', 1)
            ->orderBy('menu_pos', 'asc')
            ->get()
            ->map(function ($sub) use ($base_url, $fallback_logo) {
                $sub->image_url = !empty($sub->cat_favicon)
                    ? rtrim($base_url, '/') . '/' . ltrim($sub->cat_favicon, '/')
                    : $fallback_logo;
                $sub->models = ProductCategory::where('parent_category_id', $sub->category_id)
                    ->where('cat_type', 2)
                    ->where('top_menu', 0)
                    ->where('status', 1)
                    ->orderBy('menu_pos', 'asc')
                    ->get()
                    ->map(function ($model) use ($base_url, $fallback_logo) {
                        $model->image_url = !empty($model->cat_favicon)
                            ? rtrim($base_url, '/') . '/' . ltrim($model->cat_favicon, '/')
                            : $fallback_logo;
                        $model->parent_category = null;
                        if (!empty($model->parent_category_id)) {
                            $model->parent_category = ProductCategory::where('category_id', $model->parent_category_id)->first();
                        }
                        return $model;
                    });
                $sub->parent_category = null;
                if (!empty($sub->parent_category_id)) {
                    $sub->parent_category = ProductCategory::where('category_id', $sub->parent_category_id)->first();
                }
                return $sub;
            });
        $main->parent_category = null;
        if (!empty($main->parent_category_id)) {
            $main->parent_category = ProductCategory::where('category_id', $main->parent_category_id)->first();
        }
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