
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    HomeController,
    AccountController,
    ProductController,
    BlogController,
    AuthController,
    ContactController,
    PageController,
    CartController,
    BulkOrderController,
    DealerController,
    ProductReviewController,
    WishListController,
    ShippingInfoController,
    CheckOutController,
    PaymentController,
    OrderController
};


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/signup', [AuthController::class, 'showSignup'])->name('signup');
Route::post('/signup', [AuthController::class, 'signup'])->name('signup.submit');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/send-otp', [AuthController::class, 'sendOtp'])->name('otp.send');
Route::get('/verify-otp', [AuthController::class, 'showOtpVerify'])->name('otp.verify');
Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('otp.verify.submit');
Route::post('/resend-otp', [AuthController::class, 'sendOtp'])->name('otp.resend');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/dealer/register', [DealerController::class, 'register'])->name('dealer.register');


// Shipping Info Submission
Route::middleware('check.auth')->group(function () {
    Route::post('/shipping-info', [ShippingInfoController::class, 'store'])->name('shipping-info.store');
});

Route::get('/categories', [HomeController::class, 'allCategories'])->name('categories.index');
Route::get('/product/{id}', [ProductController::class, 'productDetails'])->name('product.details');
Route::post('/product/review', [ProductReviewController::class, 'store'])->name('product.review.store'); 
Route::post('/check-delivery', [ProductController::class, 'checkDelivery'])->name('product.checkDelivery');
Route::post('/product/variant-price', [ProductController::class, 'getVariantPrice'])->name('product.variantPrice');

Route::get('/blogs', [BlogController::class, 'getAllBlogs'])->name('blogs.index');
Route::get('/blog/{id}', [BlogController::class, 'blogDetails'])->name('blog.details');
Route::get('/contact', [ContactController::class, 'index']) ->name('contact.index');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');
Route::get('/stores', [PageController::class, 'stores'])->name('stores.index');
Route::get('/bulk-orders', [BulkOrderController::class, 'index'])->name('bulk-orders.index');
Route::post('/bulk-orders', [BulkOrderController::class, 'store'])->name('bulk-order.store');
Route::get('/about-us', [PageController::class, 'aboutUs'])->name('about-us.index');
Route::get('/faq', [PageController::class, 'faq'])->name('faq.index');
Route::get('/offer', [PageController::class, 'offer'])->name('offer.index');
Route::get('/privacy-policy', [PageController::class, 'privacyPolicy'])->name('privacy-policy.index');
Route::get('/terms-and-conditions', [PageController::class, 'terms'])->name('terms.index');
Route::get('/careers', [PageController::class, 'careers'])->name('careers.index');
Route::get('/our-guarantees', [PageController::class, 'guarantees'])->name('guarantees.index');

//apply auth middleware to cart routes
Route::prefix('cart')->middleware('check.auth')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('cart.index');
    Route::post('/add', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::get('/count', [CartController::class, 'productsCount'])->name('cart.products.count');
    Route::put('/quantity/{id}', [CartController::class, 'quantityUpdate'])->name('cart.quantityUpdate');
    Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
});

// Checkout order placement with check:auth middleware
Route::middleware('check.auth')->group(function () {
    Route::post('/checkout', [CheckOutController::class, 'store'])->name('checkout.store');
});

// Account dashboard
Route::middleware('check.auth')->group(function () {
    Route::get('/my-account', [AccountController::class, 'index'])->name('account.index');
});

// Payment routes
Route::prefix('payment')->group(function () {
    Route::post('/create-order', [PaymentController::class, 'createPaymentOrder'])->name('payment.create-order');
    Route::post('/verify', [PaymentController::class, 'verifyPayment'])->name('payment.verify');
    Route::post('/failed', [PaymentController::class, 'paymentFailed'])->name('payment.failed');
});

Route::get('/view-products', [HomeController::class, 'viewProducts'])->name('view.products');
Route::get('/products/category/{categoryName}', [PageController::class, 'category'])->name('products.categories');
Route::get('/search/products', [ProductController::class, 'globalSearch'])->name('products.globalSearch');

// Wishlist routes and check check:auth middleware
Route::middleware('check.auth')->group(function () {
    Route::get('/wishlist', [WishListController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/add', [WishListController::class, 'add'])->name('wishlist.add');
    Route::post('/wishlist/remove', [WishListController::class, 'remove'])->name('wishlist.remove');
});

// Orders - authenticated customers only
Route::middleware('check.auth')->group(function () {
    Route::get('/my-orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/my-orders/{order_id}', [OrderController::class, 'show'])->name('order.details');
    Route::get('/my-orders/{order_id}/invoice', [OrderController::class, 'downloadInvoice'])->name('order.invoice');
});
