<?php

namespace App\Http\Controllers;
use App\Models\{WebSetting,Slider,ProductInformation,ProductCategory,StoreSet,ProductReview,Thickness,Blog};
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    //functon for blog page
    public function getAllBlogs()
    {
        $global = globalData();
        $base_url = $global['base_url'];
        $fallback_slider = $global['fallback_slider'];

        // Fetch all blogs
        $blogs = Blog::where('status', 1)
            ->orderBy('id', 'DESC')
            ->take(6)
            ->get()
            ->map(function ($blog) use ($base_url, $fallback_slider) {

                $image = $blog->cover_image;
                $localPath = !empty($image) ? public_path($image) : null;

                if (!empty($image) && file_exists($localPath)) {
                    $blog->image_url = $base_url . '/' . ltrim($image, '/');
                } else {
                    $blog->image_url = $fallback_slider;
                }

                // Limit content for listing card view
                $blog->short_content = Str::limit(strip_tags($blog->content), 150, '...');

                return $blog;
            });

        return view('frontend.blogs', compact('blogs'));
    }

    // function for blog details page
    public function blogDetails($id)
    {
        $global = globalData();
        $base_url = $global['base_url'];
        $fallback_slider = $global['fallback_slider'];

        // Fetch blog by ID
        $blog = Blog::findOrFail($id);

        // Process image URL
        $image = $blog->cover_image;
        $localPath = !empty($image) ? public_path($image) : null;

        if (!empty($image) && file_exists($localPath)) {
            $blog->image_url = $base_url . '/' . ltrim($image, '/');
        } else {
            $blog->image_url = $fallback_slider;
        }

        return view('frontend.blog_details', compact('blog'));
    }
}
