<?php

namespace App\Services;

use App\Models\ProductCategory;
use App\Models\ProductInformation;
use Illuminate\Database\Eloquent\Builder;

class SearchService
{
    /**
     * Perform a global product search by name, category, type, and tags.
     *
     * @param string $query
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function searchProducts(string $query, int $limit = 20)
    {
        $q = trim($query);
        if (!$q) return collect();

        // Search products
        $products = ProductInformation::with(['categoryDetails', 'productVariants.sizeVariant', 'ticknesses'])
            ->where(function (Builder $builder) use ($q) {
                $builder->where('product_name', 'like', "%$q%")
                    ->orWhere('code', 'like', "%$q%")
                    ->orWhereHas('categoryDetails', function ($cat) use ($q) {
                        $cat->where('category_name', 'like', "%$q%")
                            ->orWhere('category_id', $q);
                    })
                    ->orWhereHas('productVariants.sizeVariant', function ($variant) use ($q) {
                        $variant->where('variant_name', 'like', "%$q%")
                                ->orWhere('variant_type', 'like', "%$q%")
                                ->orWhere('variant_id', $q);
                    })
                    ->orWhereHas('ticknesses', function ($thick) use ($q) {
                        $thick->where('thick', 'like', "%$q%")
                            ->orWhere('map', 'like', "%$q%") ;
                    });
            })
            ->limit($limit)
            ->get()
            ->map(function ($product) {
                $product->search_type = 'product';
                return $product;
            });

        $categories = ProductCategory::where(function ($catQ) use ($q) {
                $catQ->where('category_name', 'like', "%$q%");                    
            })
            ->where('status', 1)
            ->limit($limit)
            ->get()
            ->map(function ($cat) {
                $cat->search_type = 'category';
                return $cat;
            });

        $results = $products->concat($categories)->take($limit);
        return $results;
    }
    
}
