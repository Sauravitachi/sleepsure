@extends('layouts.app')

@section('title', 'Premium Mattress & Sleep Solutions')

@section('content')
<style>
    /* ===== SLIDER CORE ===== */
.slider-wrapper {
    position: relative;
    width: 100%;
}

.slider-container {
    display: flex;
    gap: 20px;
    overflow-x: auto;
    scroll-behavior: smooth;
    padding: 10px 40px;
    cursor: grab;
    -webkit-overflow-scrolling: touch;
}

/* Hide scrollbar */
.slider-container::-webkit-scrollbar {
    display: none;
}
.slider-container {
    -ms-overflow-style: none;
    scrollbar-width: none;
}

/* Product card width */
.slider-container .wrapper {
    flex: 0 0 280px;
    min-width: 240px;
}

.slider-container .testimonial-card,
.slider-container .award-item {
    min-width: 220px;
    max-width: 320px;
    flex: 0 0 80vw;
}

/* ===== ARROWS ===== */
.slider-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    z-index: 10;
    background: #0b3b8c;
    color: #fff;
    border: none;
    width: 42px;
    height: 42px;
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
}

.slider-btn.left {
    left: 0;
}

.slider-btn.right {
    right: 0;
}

.slider-btn:hover {
    background: #092f6e;
}

/* Mobile tweaks */
@media (max-width: 768px) {
    .slider-container {
        padding: 10px 0;
        gap: 12px;
    }
    .slider-btn {
        display: none; /* swipe only */
    }
    .slider-container .wrapper,
    .slider-container .testimonial-card,
    .slider-container .award-item {
        min-width: 80vw;
        max-width: 90vw;
    }
    /* Optional: add a scroll hint gradient */
    .slider-wrapper::after {
        content: '';
        position: absolute;
        right: 0;
        top: 0;
        width: 40px;
        height: 100%;
        pointer-events: none;
        background: linear-gradient(to left, #fff 60%, transparent 100%);
        z-index: 2;
        display: block;
    }
}

.category-slider {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: center;
}
.category-item {
    text-align: center;
    box-sizing: border-box;
    margin-bottom: 10px;
}
.category-image {
    display: flex;
    justify-content: center;
    align-items: center;
}
@media (max-width: 768px) {
    .category-slider {
        gap: 12px;
    }
    .category-item {
        flex: 0 0 48%;
        max-width: 48%;
    }
}
.slider-container#awards-slider {
    justify-content: center;
}
.slider-container#awards-slider {
    /* Ensure first card is fully visible on mobile */
    padding-left: 16px;
    box-sizing: border-box;
}
@media (max-width: 768px) {
    .slider-container#awards-slider {
        padding-left: 24px;
        padding-right: 8px;
    }
}
.award-item {
    flex: 0 0 220px;
    margin: 0 10px;
    text-align: center;
}
</style>
<main class="main-content">
    <section class="hero-section">
        <div id="carouselExampleIndicators" class="carousel slide">
            <div class="carousel-indicators">
                @foreach($sliders as $key => $slide)
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="{{ $key }}"
                        class="{{ $key == 0 ? 'active' : '' }}" {{ $key == 0 ? 'aria-current="true"' : '' }} aria-label="Slide {{ $key + 1 }}"></button>
                @endforeach
            </div>
            <div class="carousel-inner">
                @foreach($sliders as $key => $slide)
                    <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                        <a href="{{ $slide->slider_link }}">
                            <img src="{{ $slide->image_url }}" class="d-block w-100" alt="Slider Image">
                        </a>
                    </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </section>

    <section class="mobile-section">

        <div id="carouselExampleIndicators" class="carousel slide">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
                    aria-current="true" aria-label="Slide 1"></button>

            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="assets/images/mobile-bg.png" class="d-block w-100" alt="...">
                </div>

            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </section>

    {{-- dynamic --}}
    <section class="category-slider-section">
    <div class="section-header">
        <h2>Explore Our Range</h2>
        <a href="{{ route('categories.index') }}" class="view-all">View All</a>
    </div>
    <div class="category-slider-wrapper">
        <div class="category-slider">
            @foreach($categories as $main)
                <div class="category-item">
                    <div class="category-image">
                        <img src="{{ $main->image }}" alt="{{ $main->category_name }}">
                    </div>
                    <h3>{{ Str::title($main->category_name) }}</h3>
                    <p>{{ $main->subcategories->count() }} Items</p>
                </div>
            @endforeach
        </div>
    </div>
</section>


    <section class="commitment-section">

        <div class="commitment-section-header">
            <h2>Our Commitment & Values</h2>
            <p>Your quality sleep is our absolute mission. Discover why we're the right choice for your home.</p>
        </div>

        <div class="modern-two-col-card">

            <div class="card-column why-choose-us-content">
                <h3>Why Choose Us?</h3>

                <div class="feature-item-modern">
                    <i class="fa-solid fa-circle-check"></i>
                    <div>
                        <h4>100% Quality Assurance</h4>
                        <p>Only certified, non-toxic materials are used, ensuring a safe and healthy sleep
                            environment.</p>
                    </div>
                </div>

                <div class="feature-item-modern">
                    <i class="fa-solid fa-circle-check"></i>
                    <div>
                        <h4>10-Year Warranty</h4>
                        <p>Confidence in our durability, backed by a comprehensive decade-long guarantee.</p>
                    </div>
                </div>

                <div class="feature-item-modern">
                    <i class="fa-solid fa-circle-check"></i>
                    <div>
                        <h4>Free Delivery & Setup</h4>
                        <p>Enjoy hassle-free service with doorstep delivery and professional setup.</p>
                    </div>
                </div>
            </div>

            <div class="card-column mission-vision-content">
                <h3>Our Mission & Vision</h3>

                <div class="mv-item-modern">
                    <div class="mv-heading-modern">
                        <i class="fa-solid fa-rocket"></i> Mission
                    </div>
                    <p>To deliver **superior sleep solutions** through innovative, orthopedic, and sustainable
                        mattress technology.</p>
                </div>

                <div class="mv-item-modern">
                    <div class="mv-heading-modern">
                        <i class="fa-solid fa-eye"></i> Vision
                    </div>
                    <p>To be the **leading trusted name** in the sleep industry, recognized for product excellence
                        and health dedication.</p>
                </div>
            </div>

        </div>
    </section>

    {{-- dynamic --}}
   <section class="featured-products">
    <div class="section-header">
        <h2>Featured Products</h2>
        <a href="{{ route('view.products', ['type' => 'featured']) }}" class="view-all">View All</a>
    </div>

    <!-- NEW WRAPPER -->
    <div class="slider-wrapper">

        <!-- LEFT BUTTON -->
        <button class="slider-btn left" data-target="featured-slider">
            <i class="fa-solid fa-chevron-left"></i>
        </button>

        <!-- EXISTING SLIDER -->
        <div class="slider-container" id="featured-slider">
            @forelse($featured_products as $product)
            <div class="wrapper">
                <div class="container">
                    <a href="{{ route('product.details', ['id' => $product['product_id']]) }}">
                        <div class="top"
                            style="background-image:url('{{ $product['image_url'] ?? asset('assets/images/noimage.png') }}')">
                            <div class="rating-badge">
                                {{ $product['review'] ?? '0.0' }} <i class="fa-solid fa-star"></i>
                            </div>
                            <button class="wishlist-icon"><span>♡</span></button>
                        </div>
                    </a>
                    <div class="bottom">
                        <div class="left">
                            <div class="details">
                                <h1>{{ $product['product_name'] ?? 'N/A' }}</h1>
                                <p>({{ $product['size']}})</p>
                                <p>({{ $product['size_cm']}})</p>
                                <div class="price-group">
                                    <span class="price">
                                        ₹{{ number_format($product['variant_price'] ?? 0) }}
                                    </span>
                                </div>
                            </div>
                            <div class="buy"><i class="fa-solid fa-cart-shopping"></i></div>
                        </div>
                    </div>
                </div>
                <div class="inside">
                    <div class="icon"><i class="fa-solid fa-info"></i></div>
                    <div class="contents">
                        <table>
                            <tr>
                                <th>Category</th>
                                <th>Type</th>
                            </tr>
                            <tr>
                                <td>{{ $product['category_name'] ?? 'N/A' }}</td>
                                <td>{{ $product['type'] ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Size</th>
                                <th>Thickness</th>
                            </tr>
                            <tr>
                                <td>{{ $product['product_size'] ?? ($product['size_display'] ?? 'N/A') }}</td>
                                <td>{{ $product['thickness'] ?? ($product['thick_display'] ?? 'N/A') }}</td>
                            </tr>
                            <tr>
                                <th>Warranty</th>
                                <th>Material</th>
                            </tr>
                            <tr>
                                <td>{{ $product['warranty_text'] ?? 'N/A' }}</td>
                                <td>{{ $product['material'] ?? 'N/A' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            @empty
                <p>No featured products available.</p>
            @endforelse
        </div>

        <!-- RIGHT BUTTON -->
        <button class="slider-btn right" data-target="featured-slider">
            <i class="fa-solid fa-chevron-right"></i>
        </button>

    </div>
</section>

    <section class="complain">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <img src="assets/images/frame.png" alt="" width="100%">
                </div>
                <div class="col-md-6 text-col">
                    <h2>Does your Parents keep complaining about their back?</h2>
                    <p>As a parent, you’re worried about how that impacts their physical health and quality of sleep
                        — both of which are vital to their development.</p>
                    <button class="shop-button">Find out more →</button>
                </div>
            </div>
            <div class="row main-col">
                <div class="col-md-4 text-col-2">
                    <div class="card-1">
                        <img src="assets/images/image 6 (1).png" alt="" width="100%">
                        <p>Traditional mattresses and beds aren't conducive to how today's kids spend their time.
                        </p>
                    </div>
                </div>
                <div class="col-md-4 text-col-2">
                    <div class="card-2">
                        <img src="assets/images/image 7.png" alt="" width="100%">
                        <p>Beds and mattresses that lie flat don't promote proper posture.</p>
                    </div>
                </div>
                <div class="col-md-4 text-col-2">
                    <div class="card-3">
                        <img src="assets/images/image 8.png" alt="" width="100%">
                        <p>Your child complains of an aching neck, shoulders and back.</p>
                    </div>
                </div>
            </div>

        </div>
    </section>

    {{-- dynamic best seller --}}
 <section class="featured-products" id="bestSeller">
    <div class="section-header">
        <h2>Best Seller Products</h2>
        <a href="{{ route('view.products', ['type' => 'best_seller']) }}" class="view-all">View All</a>
    </div>

    <!-- NEW WRAPPER -->
    <div class="slider-wrapper">

        <!-- LEFT BUTTON -->
        <button class="slider-btn left" data-target="best-seller-slider">
            <i class="fa-solid fa-chevron-left"></i>
        </button>

        <!-- EXISTING SLIDER -->
        <div class="slider-container" id="best-seller-slider">
            @forelse($best_seller as $product)
            <div class="wrapper">
                <div class="container">
                    <a href="{{ route('product.details', ['id' => $product['product_id']]) }}">
                        <div class="top"
                            style="background-image:url('{{ $product['image_url'] ?? asset('assets/images/noimage.png') }}')">
                            <div class="rating-badge">
                                {{ $product['review'] ?? '0.0' }} <i class="fa-solid fa-star"></i>
                            </div>
                            <button class="wishlist-icon"><span>♡</span></button>
                        </div>
                    </a>
                    <div class="bottom">
                        <div class="left">
                            <div class="details">
                                <h1>{{ $product['product_name'] ?? 'N/A' }}</h1>
                                <p>({{ $product['size']}})</p>
                                <p>({{ $product['size_cm']}})</p>
                                <div class="price-group">
                                    <span class="price">
                                        ₹{{ number_format($product['variant_price'] ?? 0) }}
                                    </span>
                                </div>
                            </div>
                            <div class="buy"><i class="fa-solid fa-cart-shopping"></i></div>
                        </div>
                    </div>
                </div>
                <div class="inside">
                    <div class="icon"><i class="fa-solid fa-info"></i></div>
                    <div class="contents">
                        <table>
                            <tr>
                                <th>Category</th>
                                <th>Type</th>
                            </tr>
                            <tr>
                                <td style="font-size: 10px">{{ $product['category_name'] ?? 'N/A' }}</td>
                                <td>{{ $product['type'] ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Size</th>
                                <th>Thickness</th>
                            </tr>
                            <tr>
                                <td>{{ $product['product_size'] ?? ($product['size_display'] ?? 'N/A') }}</td>
                                <td>{{ $product['thickness'] ?? ($product['thick_display'] ?? 'N/A') }}</td>
                            </tr>
                            <tr>
                                <th>Warranty</th>
                                <th>Material</th>
                            </tr>
                            <tr>
                                <td>{{ $product['warranty_text'] ?? 'N/A' }}</td>
                                <td>{{ $product['material'] ?? 'N/A' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            @empty
                <p>No best seller products available.</p>
            @endforelse
        </div>

        <!-- RIGHT BUTTON -->
        <button class="slider-btn right" data-target="best-seller-slider">
            <i class="fa-solid fa-chevron-right"></i>
        </button>

    </div>
</section>


    {{-- dynamic --}}
    <section class="stores-section">
        <div class="stores-container">
            <!-- Left Side: Stores Cards -->
            <div class="stores-box">
                <h2 class="stores-heading">Explore Our Stores</h2>

                <div class="stores-grid">
                    @foreach($store_sets as $store)
                        <div class="store-card">
                            <div class="store-icon">
                                <i class="fa-solid fa-store"></i>
                            </div>
                            <h3>{{ $store->store_name }}</h3>
                        </div>
                    @endforeach
                </div>

                <a href="#" class="view-stores-link">View {{ $store_sets->count() }}+ Stores</a>
            </div>

            <!-- Right Side: Image -->
            <div class="image-box">
                <img src="https://adyourdream.com/images/portfolio/relaxon%20banner.webp" alt="Stores Showcase">
            </div>
        </div>
    </section>

    <!-- bank offer -->
    <div class="offers-section">
        <div class="filter-buttons">
            @foreach($rewards as $index => $reward)
                <button class="{{ $index === 0 ? 'active' : '' }}" data-type="{{ strtolower($reward->title) }}">{{ $reward->title }}</button>
            @endforeach
        </div>

        <div class="offers-cards">
            @foreach($rewardTypes as $rewardType)
                <div class="offer-card" data-type="{{ strtolower($rewardType->reward->title) }}">
                    <img src="{{ $rewardType->logo }}" alt="{{ $rewardType->title }}">
                    <p>{{ $rewardType->message }}</p>
                </div>
            @endforeach
        </div>
    </div>

    <section class="find-mattress-banner">
        <div class="content">
            <h2 class="headline">Tired of Sleepless Nights? Stop Guessing!</h2>
            <p class="subtext">The mattress market is overwhelming. <strong>Don't settle for average sleep!</strong>
                Take our quick, personalized quiz and instantly find the perfect mattress tailored to your unique
                sleeping style, body type, and comfort preferences.</p>

            <button id="openMattressQuiz" class="cta-button">
                FIND MY MATTRESS <span class="arrow">→</span>
            </button>
        </div>
        <div class="mattress-image-placeholder">
            <img src="assets/images/sleepless.jpg" alt="Breathable mattress layers showing comfort and support"
                width="100%">
        </div>
    </section>

    <div id="mattressQuizModal" class="modal-overlay">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Find My Mattress</h3>
                <span id="closeMattressQuiz" class="close-button">&times;</span>
            </div>

            <form class="quiz-form">
                <fieldset class="question-group">
                    <legend>1. What disrupts your sleep, in your opinion?</legend>
                    <label><input type="radio" name="disruption" value="sweat"> Night Sweat</label>
                    <label><input type="radio" name="disruption" value="backpain"> Backpain</label>
                    <label><input type="radio" name="disruption" value="restless"> Restless Sleep</label>
                    <label><input type="radio" name="disruption" value="other"> Something Else</label>
                </fieldset>

                <fieldset class="question-group">
                    <legend>2. What is your preferred sleeping position?</legend>
                    <label><input type="radio" name="position" value="left"> On Left Side</label>
                    <label><input type="radio" name="position" value="right"> On Right Side</label>
                    <label><input type="radio" name="position" value="back"> On Back</label>
                    <label><input type="radio" name="position" value="tummy"> On Tummy</label>
                    <label><input type="radio" name="position" value="turning"> Keep on turning</label>
                </fieldset>

                <fieldset class="question-group">
                    <legend>3. What would you describe as your ideal mattress?</legend>
                    <label><input type="radio" name="ideal" value="extra-soft"> Extra Soft Mattress</label>
                    <label><input type="radio" name="ideal" value="plushy"> Plushy Mattress</label>
                    <label><input type="radio" name="ideal" value="bouncy"> Bouncy Mattress</label>
                    <label><input type="radio" name="ideal" value="firm"> Firm Mattress</label>
                    <label><input type="radio" name="ideal" value="supportive"> Comfortable and
                        Supportive</label>
                </fieldset>

                <button type="submit" class="submit-button">Submit</button>
            </form>
        </div>
    </div>

    <section class="new-shop-by-size-section">
        <div class="new-section-header">
            <h2>Shop by Mattress Size</h2>
        </div>

        <div class="size-category-grid">

            <a href="#" class="size-category-card"
                style="background-image: url('https://m.media-amazon.com/images/I/71rNXU5sXKL._UF894,1000_QL80_.jpg');">
                <div class="card-content">
                    <h3>Single Bed</h3>
                    <p>Perfect for solo sleepers or small rooms.</p>
                    <span class="shop-now-btn">Shop Now <i class="fa-solid fa-arrow-right"></i></span>
                </div>
            </a>

            <a href="#" class="size-category-card"
                style="background-image: url('https://m.media-amazon.com/images/I/91uOk4qaYVL._UF894,1000_QL80_.jpg');">
                <div class="card-content">
                    <h3>Double Bed</h3>
                    <p>Ideal for teenagers or budget couples.</p>
                    <span class="shop-now-btn">Shop Now <i class="fa-solid fa-arrow-right"></i></span>
                </div>
            </a>

            <a href="#" class="size-category-card recommended-card"
                style="background-image: url('https://www.nismaayadecor.in/cdn/shop/collections/nismaaya-engla-king-size-bed-rattan_1.webp?v=1715083470');">
                <div class="card-content">
                    <span class="badge">Most Popular</span>
                    <h3>Queen Bed</h3>
                    <p>Spacious comfort for most couples.</p>
                    <span class="shop-now-btn">Shop Now <i class="fa-solid fa-arrow-right"></i></span>
                </div>
            </a>

            <a href="#" class="size-category-card"
                style="background-image: url('https://sonaarts.in/wp-content/uploads/2024/12/81bFcMiU33L._SL1500_.jpg');">
                <div class="card-content">
                    <h3>King Bed</h3>
                    <p>Maximum space for luxury and family sleepers.</p>
                    <span class="shop-now-btn">Shop Now <i class="fa-solid fa-arrow-right"></i></span>
                </div>
            </a>

        </div>
    </section>

    <section class="layer">
        <div class="mattress-features-container">

            <header class="features-header">
                <div class="feature-point" data-number="1">
                    <span class="green-dot"></span>
                    <h2>Cover</h2>
                    <p>The cover's blend of fabrics and fibers adjusts to your body temperature and pulls moisture
                        away.
                    </p>
                </div>
                <div class="feature-point" data-number="2">
                    <span class="green-dot"></span>
                    <h2>Layers</h2>
                    <p>This mattress is designed to fit your body and eliminate unwanted temperature changes
                        enabling
                        you to sleep comfortably.</p>
                </div>
                <div class="feature-point" data-number="3">
                    <span class="green-dot"></span>
                    <h2>Foam Layers</h2>
                    <p>The mattress is equipped with layers of softness to mold to your body so you can wake up
                        feeling
                        refreshed without that achy feeling. There is an added layer of exceptional-quality foam for
                        constant support while sleeping.</p>
                </div>
            </header>

            <div class="mattress-diagram-section-image">
                <img src="assets/images/layer.png" alt="Mattress Layers Diagram" class="mattress-image">
            </div>

            <div class="features-footer">
                <div class="feature-point" data-number="4">
                    <span class="green-dot"></span>
                    <h2>Additional support layer</h2>
                    <p>Unlike most mattresses where deep dips in the foam eventually occur, this mattress has
                        built-in
                        springs to prevent causing motion upon movement. It stays the same, including support for
                        the
                        bed edges and comfortable temperature adjustments.</p>
                </div>
                <div class="feature-point" data-number="5">
                    <span class="green-dot"></span>
                    <h2>Foam base</h2>
                    <p>The high quality of the foam base improves its strength, contour ability, and support for all
                        body types. Softness/Hardness – Medium to medium-firm comfort</p>
                </div>
            </div>

        </div>
    </section>

    <section class="money-back-guarantee-section">
        <div class="content-container">
            <p class="tagline">ZERO RISK | ZERO OBLIGATION</p>
            <h1>Love Sleepsure or Your Money Back</h1>
            <p class="subtitle">If Your Child Doesn't Love Their Sleepsure Bed After 100 Nights, Return It For Free.
            </p>

            <div class="feature-grid new-feature-grid">

                <div class="feature-item">
                    <div class="icon-wrapper icon-wrapper-1">
                        <img src="assets/images/icon/i1.png" alt="100-Night Home Trial Icon">
                    </div>
                    <h3>100-Night Home Trial</h3>
                    <p>Try the Sleepsure at home for 100 nights and if you're not satisfied, return it for free.</p>

                </div>

                <div class="feature-item">
                    <div class="icon-wrapper icon-wrapper-2">
                        <img src="assets/images/icon/i2.png" alt="Delivery & Setup Icon">
                    </div>
                    <h3>Delivery & Setup</h3>
                    <p>We deliver and install your Sleepsure bed at no extra charge.</p>

                </div>

                <div class="feature-item">
                    <div class="icon-wrapper icon-wrapper-3">
                        <img src="assets/images/icon/i3.png" alt="Free Shipping Icon">
                    </div>
                    <h3>Free Shipping</h3>
                    <p>Shipping is free - even if you decide to return your Sleepsure bed during the 100-night
                        trial.
                    </p>

                </div>

                <div class="feature-item">
                    <div class="icon-wrapper icon-wrapper-4">
                        <img src="assets/images/icon/i4.png" alt="Financing Available Icon">
                    </div>
                    <h3>Financing Available</h3>
                    <p>Make monthly payments with 0% interest when you pay with a credit card.</p>

                </div>

            </div>
        </div>
    </section>

    <section class="deal-section">
        <div class="ghost-text">DEAL</div>
        <div class="content-container">
            <div class="text-content">
                <p class="deal-tag">LIMITED TIME OFFER</p>
                <h1>The Ultimate Comfort Mattress Deal</h1>
                <p class="description">Stop losing sleep over low-quality bedding. Upgrade to our award-winning
                    mattress—engineered with cooling technology and tailored support to deliver your best night's
                    rest yet.</p>
            </div>

            <div class="countdown-timer">
                <div class="timer-box">
                    <span id="days">90</span>
                    <span class="label">DAYS</span>
                </div>
                <div class="timer-box">
                    <span id="hours">13</span>
                    <span class="label">HOURS</span>
                </div>
                <div class="timer-box">
                    <span id="minutes">33</span>
                    <span class="label">MINUTES</span>
                </div>
                <div class="timer-box">
                    <span id="seconds">49</span>
                    <span class="label">SECONDS</span>
                </div>
            </div>

            <button class="shop-button">Shop Now &rarr;</button>
        </div>

        <div class="image-container">
            <img src="https://static.vecteezy.com/system/resources/previews/065/587/966/non_2x/comfortable-mattresses-stacked-on-a-transparent-background-ideal-for-rest-and-relaxation-mattresses-isolated-on-background-free-png.png"
                alt="Bright Green Sofa" width="100%">
            <div class="discount-badge">
                <span class="percent">45%</span>
                <span class="off">OFF</span>
            </div>
        </div>
    </section>

    {{--  Top Rated --}}
    <section class="featured-products">
        <div class="section-header">
            <h2>Top Rated Products</h2>
            <a href="{{ route('view.products', ['type' => 'top_rated']) }}" class="view-all">View All</a>
        </div>

        <div class="slider-wrapper">
            <!-- LEFT BUTTON -->
            <button class="slider-btn left" data-target="top-rated-slider">
                <i class="fa-solid fa-chevron-left"></i>
            </button>

            <div class="slider-container" id="top-rated-slider">
                @forelse($top_rated as $product)
                <div class="wrapper">
                    <div class="container">
                        <a href="{{ route('product.details', ['id' => $product['product_id']]) }}">
                            <div class="top"
                                style="background-image:url('{{ $product['image_url'] ?? asset('assets/images/noimage.png') }}')">
                                <div class="rating-badge">
                                    {{ $product['review'] ?? '0.0' }} <i class="fa-solid fa-star"></i>
                                </div>
                                <button class="wishlist-icon"><span>♡</span></button>
                            </div>
                        </a>

                        <div class="bottom">
                            <div class="left">
                                <div class="details">
                                    <h1>{{ $product['product_name'] ?? 'N/A' }}</h1>

                                    <p>({{ $product['size']}})</p>
                                    <p>({{ $product['size_cm']}})</p>

                                    <div class="price-group">
                                        <span class="price">
                                            ₹{{ number_format($product['variant_price'] ?? 0) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="buy"><i class="fa-solid fa-cart-shopping"></i></div>
                            </div>

                            <div class="right">
                                <div class="done"><i class="material-icons">done</i></div>
                                <div class="details">
                                    <h1>Added to cart</h1>
                                    <p>{{ $product['product_name'] ?? 'N/A' }}</p>
                                </div>
                                <div class="remove"><i class="material-icons">clear</i></div>
                            </div>
                        </div>
                    </div>

                   <div class="inside">
							<div class="icon"><i class="fa-solid fa-info"></i></div>
							<div class="contents">
								<table>
									<tr>
										<th>Category</th>
										<th>Type</th>
									</tr>
									<tr>
										<td style="font-size: 10px">{{ $product['category_name'] ?? 'N/A' }}</td>
										<td>{{ $product['type'] ?? 'N/A' }}</td>
									</tr>
									<tr>
										<th>Size</th>
										<th>Thickness</th>
									</tr>
									<tr>
										<td>{{ $product['product_size'] ?? ($product['size_display'] ?? 'N/A') }}</td>
										<td>{{ $product['thickness'] ?? ($product['thick_display'] ?? 'N/A') }}</td>
									</tr>
									<tr>
										<th>Warranty</th>
										<th>Material</th>
									</tr>
									<tr>
										<td>{{ $product['warranty_text'] ?? 'N/A' }}</td>
										<td>{{ $product['material'] ?? 'N/A' }}</td>
									</tr>
								</table>
							</div>
						</div>
                </div>
                @empty
                    <p>No featured products available.</p>
                @endforelse
            </div>

            <!-- RIGHT BUTTON -->
            <button class="slider-btn right" data-target="top-rated-slider">
                <i class="fa-solid fa-chevron-right"></i>
            </button>
        </div>
    </section>

    <section class="reviews-section">
        <div class="reviews-header">
            <p class="section-tag">
                <span class="tag-line"></span>
                REVIEWS
            </p>
            <h2>These Families are Raving About Sleepsure</h2>
        </div>
        <div class="slider-wrapper" style="margin-top: 20px;">
            <button class="slider-btn left" data-target="reviews-slider">
                <i class="fa-solid fa-chevron-left"></i>
            </button>
            <div class="slider-container" id="reviews-slider">
                @forelse($testimonials as $review)
                    <div class="testimonial-card" style="flex: 0 0 320px; margin: 0 10px;">
                        <span class="quote-icon">"</span>
                        <p class="review-text">{{ Str::limit($review->reviwes, 180) }}</p>
                        <h3 class="reviewer-name">{{ $review->name }}</h3>
                        <p class="reviewer-location">
                            {{ Str::upper(trim($review->city ?? '')) }}
                            @if(!empty($review->country))
                                , {{ Str::upper(trim($review->country)) }}
                            @endif
                        </p>
                    </div>
                @empty
                    <p>No reviews available right now.</p>
                @endforelse
            </div>
            <button class="slider-btn right" data-target="reviews-slider">
                <i class="fa-solid fa-chevron-right"></i>
            </button>
        </div>
    </section>

    <section class="faq-section">
        <h1 class="faq-title">Frequently Asked Questions</h1>

        <div class="accordion" id="faqAccordion">
            @forelse($faqs as $key => $faq)
            <div class="accordion-item">
                <h2 class="accordion-header" id="heading{{ $key + 1 }}">
                    <button class="accordion-button @if($key !== 0) collapsed @endif" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapse{{ $key + 1 }}" aria-expanded="@if($key === 0) true @else false @endif" aria-controls="collapse{{ $key + 1 }}">
                        {{ $faq->que }}
                    </button>
                </h2>
                <div id="collapse{{ $key + 1 }}" class="accordion-collapse collapse @if($key === 0) show @endif" aria-labelledby="heading{{ $key + 1 }}"
                    data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        {{ $faq->ans }}
                    </div>
                </div>
            </div>
            @empty
                <p>No FAQs available.</p>
            @endforelse
        </div>
    </section>

    <section class="award-section">
        <h2>Our Recognitions and Awards</h2>
        <div class="slider-wrapper" style="margin-top: 20px;">
            {{-- <button class="slider-btn left" data-target="awards-slider">
                <i class="fa-solid fa-chevron-left"></i>
            </button> --}}
            <div class="slider-container" id="awards-slider">
                @forelse($awards as $award)
                <div class="award-item" style="flex: 0 0 220px;  margin: 0 10px; text-align: center;">
                    <img src="{{ $award->img }}" alt="{{ $award->title }}" class="award-image">
                    <p class="award-title">{{ $award->title }}</p>
                    <p class="award-source">{{ $award->sub_title }}</p>
                </div>
                @empty
                    <p>No awards available.</p>
                @endforelse
            </div>
            {{-- <button class="slider-btn right" data-target="awards-slider">
                <i class="fa-solid fa-chevron-right"></i>
            </button> --}}
        </div>
    </section>


    <section class="find-mattress-banner">
        <div class="content">
            <h2 class="headline">SleepSure Bulk Bedding</h2>
            <p class="subtext">Hotels . Serviced Apartments . Hospitals . Employee Housing</p>
            <button class="cta-button">
                Inquire About Bulk Pricing <span class="arrow">→</span>
            </button>
        </div>
        <div class="mattress-image-placeholder">
            <img src="assets/images/bg2.png" alt="" width="100%">
        </div>
    </section>

</main>

@endsection

@push('scripts')
<script>
document.querySelectorAll('.slider-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        const slider = document.getElementById(btn.dataset.target);
        if (!slider) return;
        const scrollAmount = slider.offsetWidth * 0.8;
        slider.scrollBy({
            left: btn.classList.contains('left') ? -scrollAmount : scrollAmount,
            behavior: 'smooth'
        });
    });
});
</script>

@endpush