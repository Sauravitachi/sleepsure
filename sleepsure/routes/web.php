
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    HomeController,
    ProductController,
    BlogController,
    AuthController,
    ContactController,
    PageController,
    CartController,
    BulkOrderController,
    DealerController,
    ProductReviewController
};

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/login-otp', [AuthController::class, 'loginOtp'])->name('login.otp');

Route::get('/signup', [AuthController::class, 'showSignup'])->name('signup');
Route::post('/signup', [AuthController::class, 'signup'])->name('signup.submit');

Route::get('/verify-otp', [AuthController::class, 'showOtpVerify'])->name('otp.verify');
Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('otp.verify.submit');
Route::post('/resend-otp', [AuthController::class, 'resendOtp'])->name('otp.resend');
Route::post('/send-otp', [AuthController::class, 'proxySendOtp'])->name('otp.proxy.send');
Route::post('/verify-otp-proxy', [AuthController::class, 'proxyVerifyOtp'])->name('otp.proxy.verify');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::post('/dealer/register', [DealerController::class, 'register'])
    ->name('dealer.register');


Route::get('/', [HomeController::class, 'index'])->name('home');


Route::get('/categories', [HomeController::class, 'allCategories'])
    ->name('categories.index');


Route::get('/product/{id}', [ProductController::class, 'productDetails'])
    ->name('product.details');
 
Route::post('/product/review', [ProductReviewController::class, 'store'])->name('product.review.store'); 

Route::post('/check-delivery', [ProductController::class, 'checkDelivery'])->name('product.checkDelivery');


Route::post('/product/variant-price', [ProductController::class, 'getVariantPrice'])->name('product.variantPrice');
Route::get('/blogs', [BlogController::class, 'getAllBlogs'])
    ->name('blogs.index');

Route::get('/blog/{id}', [BlogController::class, 'blogDetails'])
    ->name('blog.details');


Route::get('/contact', [ContactController::class, 'index']) 
    ->name('contact.index');

Route::post('/contact', [ContactController::class, 'submit'])
    ->name('contact.submit');


Route::get('/stores', [PageController::class, 'stores'])
    ->name('stores.index');

Route::get('/bulk-orders', [BulkOrderController::class, 'index'])
    ->name('bulk-orders.index');

Route::post('/bulk-orders', [BulkOrderController::class, 'store'])
    ->name('bulk-order.store');


Route::get('/about-us', [PageController::class, 'aboutUs'])
    ->name('about-us.index');

    Route::get('/faq', [PageController::class, 'faq'])
        ->name('faq.index');

Route::get('/offer', [PageController::class, 'offer'])
    ->name('offer.index');

Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('cart.index');
    Route::post('/add', [CartController::class, 'add'])->name('cart.add');
});
Route::get('/view-products', [HomeController::class, 'viewProducts'])->name('view.products');

Route::get('/products/category/{categoryId}', 
    [PageController::class, 'category']
)->name('products.categories');
