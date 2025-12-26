
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
    DealerController
};

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
// Login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/login-otp', [AuthController::class, 'loginOtp'])->name('login.otp');


// Signup
Route::get('/signup', [AuthController::class, 'showSignup'])->name('signup');
Route::post('/signup', [AuthController::class, 'signup'])->name('signup.submit');

// OTP Verification
Route::get('/verify-otp', [AuthController::class, 'showOtpVerify'])->name('otp.verify');
Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('otp.verify.submit');
Route::post('/resend-otp', [AuthController::class, 'resendOtp'])->name('otp.resend');
Route::post('/send-otp', [AuthController::class, 'proxySendOtp'])->name('otp.proxy.send');
Route::post('/verify-otp-proxy', [AuthController::class, 'proxyVerifyOtp'])->name('otp.proxy.verify');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Dealer Registration
|--------------------------------------------------------------------------
*/
Route::post('/dealer/register', [DealerController::class, 'register'])
    ->name('dealer.register');

/*
|--------------------------------------------------------------------------
| Home page
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');

/*
|--------------------------------------------------------------------------
| All Categories page
|--------------------------------------------------------------------------
*/
Route::get('/categories', [HomeController::class, 'allCategories'])
    ->name('categories.index');

/*
|--------------------------------------------------------------------------
| Product details
|--------------------------------------------------------------------------
*/
Route::get('/product/{id}', [ProductController::class, 'productDetails'])
    ->name('product.details');

/*
|--------------------------------------------------------------------------
| Blog routes
|--------------------------------------------------------------------------
*/
Route::get('/blogs', [BlogController::class, 'getAllBlogs'])
    ->name('blogs.index');

Route::get('/blog/{id}', [BlogController::class, 'blogDetails'])
    ->name('blog.details');

/*
|--------------------------------------------------------------------------
| Contact routes
|--------------------------------------------------------------------------
*/
Route::get('/contact', [ContactController::class, 'index']) 
    ->name('contact.index');

Route::post('/contact', [ContactController::class, 'submit'])
    ->name('contact.submit');

/*
|--------------------------------------------------------------------------
| Stores and Bulk Orders pages
|--------------------------------------------------------------------------
*/
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

