  @extends('layouts.app')

@section('title', 'Premium Mattress & Sleep Solutions')
<style>
      /* ============ CSS Variables ============ */
        /* :root {
            --sleepsure-blue: #1b4e9b;
            --sleepsure-green: #429e39;
            --light-blue-bg: #e5f0ff;
            --text-dark: #333;
            --text-light: #fff;
            --border-radius-md: 8px;
            --border-radius-lg: 12px;
            --spacing-sm: 8px;
            --spacing-md: 16px;
            --spacing-lg: 24px;
            --spacing-xl: 32px;
            --shadow-medium: 0 4px 12px rgba(0, 0, 0, 0.08);
        } */

        /* ============ Base Styles ============ */
        body {
            font-family: 'Segoe UI', sans-serif;
            color: var(--text-dark);
            background-color: #fff;
        }

        /* ============ Breadcrumb ============ */
        .breadcrumb-nav {
            padding: 0 12px;
        }

        .breadcrumb-nav span {
            font-size: 9px !important;
            line-height: 110%;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--sleepsure-blue);
        }

        /* ============ Product Gallery ============ */
        .main-img-box {
            background: #f8f8f8;
            border-radius: var(--border-radius-lg);
            overflow: hidden;
            height: 400px;
            position: relative;
        }

        .main-img-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .arrow-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(255, 255, 255, 0.7);
            border: none;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            z-index: 10;
        }

        .arrow-btn.left { left: 15px; }
        .arrow-btn.right { right: 15px; }

        .thumb-gallery {
            display: flex;
            gap: 8px;
            margin-top: 12px;
            flex-wrap: wrap;
        }

        .thumb {
            width: 80px;
            height: 60px;
            border: 2px solid #eee;
            border-radius: 4px;
            overflow: hidden;
            cursor: pointer;
        }

        .thumb.active { border-color: var(--sleepsure-blue); }
        .thumb img { width: 100%; height: 100%; object-fit: cover; }

        /* ============ Product Info ============ */
        .product-heading {
            font-size: 22px;
            font-weight: 600 !important;
        }

        .product-price {
            font-size: 22px;
        }

        .bottom-text {
            height: 4px;
            width: 100%;
            background: linear-gradient(90deg, #407dc9 0%, rgba(64, 125, 201, 0) 100.55%), #ffffff;
            border-radius: 4px;
        }

        /* ============ Gift Banner ============ */
        .gift-banner {
            background: var(--light-blue-bg);
            padding: 15px;
            border-radius: var(--border-radius-md);
            font-size: 14px;
            display: flex;
            align-items: center;
        }

        .plus-sign {
            font-size: 24px;
            color: var(--sleepsure-blue);
            margin-right: 10px;
        }

        /* ============ Buttons & Tabs ============ */
        .btn-tab {
            flex: 1;
            border: 1px solid #ddd;
            background: #f9f9f9;
            color: #666;
            font-weight: 500;
        }

        .btn-tab.active {
            background: #94b7e5;
            color: white;
            border-color: #94b7e5;
        }

        .product-btn {
            padding: 12px 12px 9px 13px !important;
        }

        .btn-buy-now {
            background-color: var(--sleepsure-green);
            color: var(--text-light);
            font-weight: bold;
            border: none;
            padding: 10px 0 !important;
        }

        .btn-buy-now:hover {
            background-color: var(--sleepsure-green);
            color: var(--text-light);
        }

        .btn-add-to-cart {
            background-color: var(--sleepsure-blue);
            color: var(--text-light);
            font-weight: bold;
            border: none;
            padding: 10px 0 !important;
        }

        .btn-add-to-cart:hover {
            background-color: var(--sleepsure-blue);
            color: var(--text-light);
        }

        /* ============ Input Fields ============ */
        .custom-field {
            border-radius: 6px;
            padding: 10px;
            border: 1px solid #94b7e5;
            font-size: 16px;
            font-weight: 600;
        }

        .qty-group {
            background: #f1f3f5;
            border-radius: 6px;
            overflow: hidden;
        }

        /* ============ Snap Widget ============ */
        .snap-widget-container {
            width: 100%;
            margin: 15px 0;
            padding: 10px 15px;
            background: #efefef;
            border-radius: 5px;
            cursor: pointer;
            font-family: inherit;
            display: flex;
            align-items: center;
            box-sizing: border-box;
        }

        .snap-main-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
        }

        .snap-emi-info {
            font-size: 14px;
            color: #000;
            display: flex;
            align-items: center;
        }

        .snap-emi-info .currency,
        .snap-emi-info .amount {
            color: #27803b;
            font-weight: 700;
        }

        .snap-slogan {
            display: flex;
            align-items: center;
            font-size: 12px;
            margin-top: 2px;
        }

        .upi-icon { width: 25px; margin: 0 5px; }
        .snap-brand-logo { width: 80px; margin-left: 5px; }
        .buy-emi-btn { width: 100px; display: block; }

        /* ============ Features Section ============ */
        .product-detail-last-section.mid-section {
            margin-bottom: 40px;
            padding: 40px 0;
        }

        .reviews-slider-pointer-ul {
            display: flex;
            justify-content: space-around;
            text-align: center;
            flex-wrap: wrap;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .reviews-slider-pointer-ul li {
            display: flex;
            justify-content: space-around;
            text-align: center;
            position: relative;
            font-family: "Intelo Bold", sans-serif;
            font-size: 14px;
            line-height: 158.8%;
            letter-spacing: 0.11em;
            text-transform: uppercase;
            color: #407DC9;
            padding: 18px 7px;
            flex-grow: 1;
        }

        .reviews-slider-pointer-ul li:after {
            content: '';
            position: absolute;
            left: 0px !important;
            top: 50%;
            transform: translateY(-50%);
            height: 100%;
            width: 1px;
            background: #E5E5E5;
        }

        /* ============ Why Choose Section ============ */
        .whychoose { background-color: #f5f5f5; }

        .whychooseheading {
            padding: 40px 0;
            border-bottom: 1px solid var(--sleepsure-blue);
        }

        .whychoosefeature {
            padding: 80px 0;
            border-bottom: 1px solid var(--sleepsure-blue);
        }

        .whychoosefeature i {
            border: 1px solid var(--sleepsure-blue);
            padding: 4px;
            border-radius: 99px;
        }

        .whychoosefeature .small {
            font-size: 18px;
            color: var(--sleepsure-blue);
        }

        .spec-para { font-size: 18px; }

        /* ============ Policy Tabs ============ */
        .policy-tabs-container {
            display: flex;
            flex-wrap: wrap;
            font-family: sans-serif;
            color: var(--text-dark);
            border-radius: var(--border-radius-lg);
            overflow: hidden;
            
        }

        .policy-tabs-container input[type="radio"] { display: none; }

        .policy-tabs-container label {
            padding: var(--spacing-md) var(--spacing-lg);
            cursor: pointer;
            background: #f5f5f5;
            font-weight: bold;
            flex-grow: 1;
            text-align: center;
            transition: all 0.3s ease;
            border-bottom: 2px solid transparent;
        }

        .policy-tabs-container label:hover {
            background: var(--sleepsure-blue);
            color: var(--text-light);
        }

        .policy-tabs-container input:checked + label {
            background: var(--sleepsure-blue);
            color: var(--text-light);
            border-bottom: 2px solid var(--sleepsure-green);
        }

        .tab-content {
            display: none;
            width: 100%;
            padding: var(--spacing-xl);
            background: var(--text-light);
            animation: fadeIn 0.4s ease;
        }

        .tab-content ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .tab-content li {
            padding: var(--spacing-sm) 0;
            border-bottom: 1px solid #eee;
        }

        .tab-content li:last-child { border-bottom: none; }

        /* Show content based on checked radio */
        #tab-delivery:checked ~ .delivery-content,
        #tab-terms:checked ~ .terms-content,
        #tab-return:checked ~ .return-content,
        #tab-warranty:checked ~ .warranty-content,
        #tab-support:checked ~ .support-content { display: block; }

        /* ============ FAQ Section ============ */
        .faq-section {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 15px;
        }

        .faq-title {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 30px;
            text-align: center;
        }

        /* ============ Animations ============ */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(5px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* ============ Responsive ============ */
        @media (max-width: 768px) {
            .btn-tab { font-size: 12px; padding: 5px; }
            .pricing h5 { font-size: 1.2rem; }
            
            .snap-widget-container { padding: 8px; }
            .snap-emi-info { font-size: 3.2vw; }
            .snap-slogan { font-size: 2.8vw; }
            .buy-emi-btn { width: 20vw; }
            
            .reviews-slider-pointer-ul li {
                flex: 0 0 50%;
                margin-bottom: 10px;
            }
            
            .whychoosefeature {
                padding: 40px 0;
            }
        }

        @media (max-width: 576px) {
            .main-img-box { height: 300px; }
            .thumb { width: 60px; height: 45px; }
            .product-heading { font-size: 18px; }
            
            .policy-tabs-container label {
                flex: 0 0 100%;
                border-bottom: 1px solid #ddd;
            }
        }

</style>

@section('content')

 
    {{-- <!-- Breadcrumb Navigation -->
    <nav class="breadcrumb-nav mb-4">
        <span>HOME > MATTRESS > PRO FITREST LUXURY MATTRESS</span>
    </nav> --}}

    <!-- Main Product Section -->
    <div class="container py-4">
        <div class="row g-5">
            <!-- Product Images -->
            <div class="col-lg-7">

                <div class="main-img-box">
                    <img src="{{ $product->images[0]->image_url ?? $product->image_url }}" id="mainImg" class="img-fluid rounded" alt="{{ $product->product_name }}">
                    <div class="nav-arrows">
                        <button class="arrow-btn left"><i class="fas fa-chevron-left"></i></button>
                        <button class="arrow-btn right"><i class="fas fa-chevron-right"></i></button>
                    </div>
                </div>

                <div class="thumb-gallery d-flex gap-2 mt-2">
                    @if (!empty($product->images) && count($product->images) > 0)
                        @foreach ($product->images as $idx => $img)
                            <div class="thumb @if($idx === 0) active @endif" data-index="{{ $idx }}">
                                <img src="{{ $img->image_url }}" alt="{{ $product->product_name }}" />
                            </div>
                        @endforeach
                    @else
                        <div class="thumb active"><img src="{{ $product->image_url }}" alt="{{ $product->product_name }}" /></div>
                    @endif
                </div>
                <p class="text-muted small mt-2">The colour of the actual product may vary from the images shown here.</p>

                <!-- Gift Banner -->
                <div class="gift-banner mt-4">
                    <div class="gift-icon-container">
                        <span class="plus-sign">+</span>
                        <img src="https://mysleepwell.s3.ap-south-1.amazonaws.com/uploads/productfreegift/free-gift_3_-1721584073302-1725520482614.webp"
                            alt="gift" width="40">
                    </div>
                    <p class="mb-0 ms-3 fw-bold">1 Cloud pillow with single mattress. 2 Cloud pillows with double size mattress</p>
                </div>
            </div>

            <!-- Product Details -->
            <div class="col-lg-5">
                <div class="d-flex justify-content-between">
                    <h1 class="product-heading fw-bold">{{ $product->product_name }}</h1>
                    <div class="share-icons d-flex flex-column gap-1">
                        <i class="fas fa-share-alt text-muted"></i>
                    </div>
                </div>

                <!-- Pricing -->
                <div class="pricing mt-2">
                    <span class="h5 product-price fw-bold">{{ $product->price }}</span>
                    {{-- <span class="text-muted text-decoration-line-through ms-2">{{ $product->previous_price }}</span> --}}
                    <div class="discount-label d-flex justify-content-between small fw-bold mt-1">
                        {{-- @if($product->onsale && $product->onsale_price)
                            <span class="old-price" id="mainOldPrice">{{ $product->price }}</span>
                            <span class="discount-percent">
                                @if((float)$product->original_price > 0)
                                    {{ round(((float)$product->original_price - (float)$product->discount_price) / (float)$product->original_price * 100) }}%
                                @else
                                    0%
                                @endif
                            </span>
                        @endif --}}
                        <p class="text-primary small mt-1">@if((float)$product->original_price > 0)
                                    {{ round(((float)$product->original_price - (float)$product->discount_price) / (float)$product->original_price * 100) }}%
                                @else
                                    0%
                                @endif</p>
                        <p class="text-primary small mt-1">* {{ $product->default_variant }}</p>
                    </div>
                    <div class="bottom-text"></div>
                </div>

                <!-- Size Tabs -->
                <div class="size-tabs d-flex gap-2 mt-4">
                    <div class="size-group-options">
                    @foreach ($sizeGroups as $group)
                        <button class="size-group-btn" data-group="{{ $group }}">{{ ucfirst($group) }}</button>
                    @endforeach
                    <button class="size-group-btn" id="customSizeBtn">Custom</button>
                </div>
              
                <!-- Custom size input fields, hidden by default -->
                <div id="customSizeInputs" style="display:none; margin-top:16px; padding:14px 10px; background:#f8f8f8; border-radius:8px; border:1px solid #e0e0e0; max-width:340px;">
                    <div style="display:flex; gap:16px; align-items:center; justify-content:space-between;">
                        <div style="flex:1;">
                            <label for="customLength" style="font-weight:500; font-size:14px; color:#333;">Length (inches)</label>
                            <input type="number" min="1" id="customLength" name="custom_length" class="custom-size-input" style="width:100%; padding:7px 10px; border:1px solid #ccc; border-radius:5px; margin-top:4px; font-size:15px;" placeholder="e.g. 75" />
                        </div>
                        <div style="flex:1;">
                            <label for="customBreadth" style="font-weight:500; font-size:14px; color:#333;">Breadth (inches)</label>
                            <input type="number" min="1" id="customBreadth" name="custom_breadth" class="custom-size-input" style="width:100%; padding:7px 10px; border:1px solid #ccc; border-radius:5px; margin-top:4px; font-size:15px;" placeholder="e.g. 60" />
                        </div>
                    </div>
                </div>              
                </div>

                <!-- EMI Widget -->
                <div class="snap-widget-container" id="sm-widget-btn" onclick="startPop()" data-widget="10503">
                    <div class="snap-main-content">
                        <div class="snap-details">
                            <div class="snap-emi-info">
                                <span class="currency">₹</span>
                                <b class="amount" id="dp">904</b>
                                <span class="label">/month,</span>
                                <span class="tenure"> rest in 3/6/9 months</span>
                            </div>
                            <div class="snap-slogan">
                                <span class="no-cost-text"><b>0% EMI</b> on</span>
                                <img src="https://assets.snapmint.com/assets/merchant/UPI_logo_grey__.svg"
                                    class="upi-icon" alt="UPI">
                                <span class="via-text">via</span>
                                <img src="https://assets.snapmint.com/assets/merchant/snapmint_logo_black_text.svg"
                                    class="snap-brand-logo" alt="Snapmint">
                            </div>
                        </div>
                        <div class="snap-action-section">
                            <img src="https://assets.snapmint.com/assets/merchant/sleepywell-buyonemi.png"
                                class="buy-emi-btn" alt="Buy on EMI">
                        </div>
                    </div>
                </div>

                <!-- Size & Thickness Selection -->

                <div class="mt-4">
                    <div class="d-flex justify-content-between mb-1">
                        <label class="fw-bold small">Size</label>
                        <a href="#" class="text-primary small text-decoration-none">Size guide <i class="far fa-question-circle"></i></a>
                    </div>
                    <select class="form-select custom-field" id="variantSelect">
                        @foreach($dimensionsByGroup as $group => $dimensions)
                            @foreach($dimensions as $dimensionName => $thicknessArr)
                                <option value="{{ $thicknessArr[array_key_first($thicknessArr)]['variant_id'] ?? '' }}" @if($thicknessArr[array_key_first($thicknessArr)]['variant_id'] == ($product->default_variant_id ?? '')) selected @endif>{{ $dimensionName }}</option>
                            @endforeach
                        @endforeach
                    </select>
                </div>

                <div class="mt-3">
                    <label class="fw-bold small mb-1">Thickness</label>
                    <select class="form-select custom-field" id="thicknessSelect">
                        @foreach($thicknesses as $thickness)
                            <option value="{{ $thickness->id }}" @if($thickness->id == ($product->default_thickness_id ?? '')) selected @endif>{{ $thickness->thick }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Hidden fields for AJAX price update -->
                <input type="hidden" id="variant_id" value="{{ $product->default_variant_id ?? '' }}">
                <input type="hidden" id="thickness_id" value="{{ $product->default_thickness_id ?? '' }}">
                <input type="hidden" id="hiddenProductPrice" value="{{ $product->price }}">
                <input type="hidden" id="hiddenCustomLength" name="custom_length" value="">
                <input type="hidden" id="hiddenCustomBreadth" name="custom_breadth" value="">

                <!-- Selection Summary -->
                <div class="selection-details mt-3 p-2">
                    <div class="text-muted small">Final size selected</div>
                    <div class="fw-bold text-primary small" id="selectedSizeDisplay">
                        {{ $product->default_variant_name ?? '' }} x {{ $product->default_thickness_name ?? '' }}
                    </div>
                </div>

                <!-- Quantity & Delivery -->
                <form id="addToCartForm" action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <div class="row mt-4">
                        <div class="col-5">
                            <label class="small fw-bold mb-1">Quantity</label>
                            <div class="input-group qty-group">
                                <button type="button" id="qtyMinus" class="btn product-btn border">-</button>
                                <input type="number" id="quantityInput" class="form-control text-center border-0" name="quantity" value="1" min="1" style="background-color: #f1f3f5;" readonly>
                                <button type="button" id="qtyPlus" class="btn product-btn border">+</button>
                            </div>
                        </div>
                        <div class="col-7">
                            <label class="small fw-bold mb-1">Check for the delivery details</label>
                            <input type="text" class="form-control custom-field" name="pincode" placeholder="Enter pincode">
                        </div>
                    </div>
                    <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                    <input type="hidden" name="variant_id" id="formVariantId" value="{{ $product->default_variant_id ?? ($variants[0]->variant_id ?? '') }}">
                    <input type="hidden" name="thickness_id" id="formThicknessId" value="{{ $product->default_thickness_id ?? ($thicknesses[0]->id ?? '') }}">
                    <input type="hidden" name="price" id="formProductPrice" value="{{ $product->price }}">
                    <div class="row mt-4 g-2">
                        <div class="col-6">
                            <button type="submit" class="btn btn-add-to-cart w-100 py-3">ADD TO CART</button>
                        </div>
                        <div class="col-6">
                            <button type="button" class="btn btn-buy-now w-100 py-3" id="buyNowBtn">BUY NOW</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <section class="product-detail-last-section customisation-section mid-section">
        <div class="container">
            <ul class="reviews-slider-pointer-ul">
                <li style="color:#8C4799"><a href="/store"><img loading="lazy" alt="BRAND OUTLETS" decoding="async" src="https://mysleepwell.s3.ap-south-1.amazonaws.com/uploads/benifits/groupone%20(1)-1672931221569.svg"> BRAND OUTLETS</a></li>
                <li style="color:#FF8230"><a href="/no-cost-emi"><img loading="lazy" alt="NO COST EMI" decoding="async" src="https://mysleepwell.s3.ap-south-1.amazonaws.com/uploads/benifits/No%20cost%20Emi_S%20(1)%202-1673871768155-1691068740147.svg"> NO COST EMI</a></li>
                <li style="color:#588DD0"><a href="/newTermsandcondition"><img loading="lazy" alt="FREE DELIVERY" decoding="async" src="https://mysleepwell.s3.ap-south-1.amazonaws.com/uploads/benifits/Free%20Delivery%20&amp;%20Returns_-1632806416567-1691134584370.svg"> FREE DELIVERY</a></li>
                <li style="color:#385572"><a href="/newTermsandcondition"><img loading="lazy" alt="CUSTOM SIZE" decoding="async" src="https://mysleepwell.s3.ap-south-1.amazonaws.com/uploads/benifits/Coustom%20Size%20(7)-1691395248062.svg"> CUSTOM SIZE</a></li>
                <li style="color:#FFA500"><a href="/mattresses/all-mattress"><img loading="lazy" alt="WIDE RANGE" decoding="async" src="https://mysleepwell.s3.ap-south-1.amazonaws.com/uploads/benifits/wide-1632115174468.svg"> WIDE RANGE</a></li>
                <li style="color:#FF6F0F"><a href="/newWarrancy-policy"><img loading="lazy" alt="25 YEARS WARRANTY*" decoding="async" src="https://mysleepwell.s3.ap-south-1.amazonaws.com/uploads/benifits/warranty-1629908552318%20(1)-1696917148396.svg"> 25 YEARS WARRANTY*</a></li>
            </ul>
        </div>
    </section>   
    <!-- Why Choose Section -->
<section class="whychoose">
        <div class="container mt-5 py-4 border-top">
            <div class="row mb-5">
                <div class="col-12">
                    <div class="whychooseheading">
                        <h3 class="fw-bold mb-4">Why Choose Bond Tuff?</h3>
                    </div>
                    <div class="whychoosefeature row g-4">
                        <div class="col-md-3">
                            <h2>Features</h2>
                        </div>
                        <div class="col-md-9">
                            <div class="row g-4">
                                <div class="col-md-4 col-6 d-flex align-items-start">
                                    <i class="fas fa-layer-group text-primary me-3 mt-1"></i>
                                    <p class="small mb-0">High Density Premium Bonded Foam Core</p>
                                </div>
                                <div class="col-md-4 col-6 d-flex align-items-start">
                                    <i class="fas fa-bone text-primary me-3 mt-1"></i>
                                    <p class="small mb-0">Superior Spine Alignment Support</p>
                                </div>
                                <div class="col-md-4 col-6 d-flex align-items-start">
                                    <i class="fas fa-wind text-primary me-3 mt-1"></i>
                                    <p class="small mb-0">Breathable Premium Knitted Fabric</p>
                                </div>
                                <div class="col-md-4 col-6 d-flex align-items-start">
                                    <i class="fas fa-thumbs-up text-primary me-3 mt-1"></i>
                                    <p class="small mb-0">Medium-Firm Support Feel</p>
                                </div>
                                <div class="col-md-4 col-6 d-flex align-items-start">
                                    <i class="fas fa-certificate text-primary me-3 mt-1"></i>
                                    <p class="small mb-0">HD Foam Quilting Layer</p>
                                </div>
                                <div class="col-md-4 col-6 d-flex align-items-start">
                                    <i class="fas fa-shield-alt text-primary me-3 mt-1"></i>
                                    <p class="small mb-0">Durable Construction</p>
                                </div>
                                <div class="col-md-4 col-6 d-flex align-items-start">
                                    <i class="fas fa-calendar-check text-primary me-3 mt-1"></i>
                                    <p class="small mb-0">60-month warranty</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Specifications -->
            <div class="row align-items-center">
                <h3 class="fw-bold mb-4">Mattress Specifications</h3>
                <div class="col-md-7">
                    <div class="position-relative">
                        <img src="assets/img2/P4 (1).jpg" class="img-fluid" alt="Bond Tuff Layers"
                            style="aspect-ratio: 3/2;object-fit: contain;">
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="spec-list ps-md-4">
                        <div class="spec-item mb-4 d-flex">
                            <span class="step-num me-3">1</span>
                            <div>
                                <h5 class="fw-bold mb-1">Premium Knitted Fabric</h5>
                                <p class="text-muted spec-para mb-0">Soft, breathable, and skin-friendly for enhanced sleep comfort.</p>
                            </div>
                        </div>
                        <div class="spec-item mb-4 d-flex">
                            <span class="step-num me-3">2</span>
                            <div>
                                <h5 class="fw-bold mb-1">HD Foam Quilting</h5>
                                <p class="text-muted spec-para mb-0">Adds cushioning and improves pressure distribution.</p>
                            </div>
                        </div>
                        <div class="spec-item mb-4 d-flex">
                            <span class="step-num me-3">3</span>
                            <div>
                                <h5 class="fw-bold mb-1">High Density PU Foam</h5>
                                <p class="text-muted spec-para mb-0">Improves comfort and support transition.</p>
                            </div>
                        </div>
                        <div class="spec-item mb-4 d-flex">
                            <span class="step-num me-3">4</span>
                            <div>
                                <h5 class="fw-bold mb-1">High Density Rebonded Foam</h5>
                                <p class="text-muted spec-para mb-0">Strong base layer that ensures firmness, durability, and spinal support.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Policy Tabs -->
    <div class="policy-tabs-container">
        <input type="radio" name="policy-tabs" id="tab-delivery" checked>
        <label for="tab-delivery">Delivery Policy</label>

        <input type="radio" name="policy-tabs" id="tab-terms">
        <label for="tab-terms">Terms & Conditions</label>

        <input type="radio" name="policy-tabs" id="tab-return">
        <label for="tab-return">Return Policy</label>

        <input type="radio" name="policy-tabs" id="tab-warranty">
        <label for="tab-warranty">Warranty Claims</label>

        <input type="radio" name="policy-tabs" id="tab-support">
        <label for="tab-support">Customer Support</label>

        <div class="tab-content delivery-content">
            <ul>
                <li><strong>Free shipping</strong> across India</li>
                <li>Delivery within <strong>3–7 business days</strong></li>
                <li>Real-time order tracking provided after dispatch</li>
            </ul>
        </div>
        <div class="tab-content terms-content">
            <ul>
                <li>Lorem ipsum dolor sit amet consectetur.</li>
                <li>Lorem ipsum dolor sit, amet consectetur adipisicing.</li>
                <li>Lorem ipsum dolor sit amet consectetur adipisicing.</li>
            </ul>
        </div>

        <div class="tab-content return-content">
            <ul>
                <li><strong>100-night risk-free trial</strong> - Try the mattress in the comfort of your home</li>
                <li>Full refund if not satisfied</li>
                <li>Simple, no questions asked return policy</li>
            </ul>
        </div>

        <div class="tab-content warranty-content">
            <ul>
                <li><strong>10-year manufacturer warranty</strong> against manufacturing defects</li>
                <li>Covers issues related to foam sagging and material defects</li>
                <li>Easy online warranty claim process</li>
                <li>Dedicated support team with <strong>48-hour response time</strong></li>
            </ul>
        </div>

        <div class="tab-content support-content">
            <ul>
                <li><strong>24/7 customer support</strong> via phone, email, and live chat</li>
                <li>Access to dedicated <strong>sleep experts</strong> for guidance</li>
                <li>Quick resolution support for delivery, returns, and warranty claims</li>
            </ul>
        </div>
    </div>

    <!-- FAQ Section -->
    <section class="faq-section">
        <h1 class="faq-title">Frequently Asked Questions</h1>

          <div class="accordion" id="faqAccordion">

            <div class="accordion-item">
                <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        Is the Bond Tuff mattress good for back pain?
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                    data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Yes. Bond Tuff is made using high density bonded foam that provides firm support and helps
                        maintain proper spinal alignment. This reduces pressure on the lower back and joints, making it
                        suitable for people experiencing back pain or body aches.
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" id="headingThree">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        What type of firmness does the Bond Tuff mattress offer?
                    </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                    data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        The Bond Tuff mattress offers medium-firm to firm support. It is ideal for sleepers who prefer a
                        stable surface that does not sink and provides consistent body support throughout the night.
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" id="headingFour">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                        Is this mattress suitable for spinal cord or posture-related issues?
                    </button>
                </h2>
                <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
                    data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Yes. The firm rebonded foam core helps keep the spine in a neutral position while sleeping,
                        which is beneficial for posture correction and spinal support.
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" id="headingFive">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                        What materials are used in the Bond Tuff mattress?
                    </button>
                </h2>
                <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive"
                    data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Bond Tuff is constructed using premium knitted fabric, HD foam quilting, high density PU foam,
                        and a high density rebonded foam base for durability and firmness.
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" id="headingSix">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                        Does the mattress feel hard?
                    </button>
                </h2>
                <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix"
                    data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        No. While the support is firm, the HD foam quilting and premium knitted fabric add surface
                        comfort, so the mattress does not feel hard or uncomfortable.
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" id="headingSeven">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                        Is this mattress good for heavier individuals?
                    </button>
                </h2>
                <div id="collapseSeven" class="accordion-collapse collapse" aria-labelledby="headingSeven"
                    data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Yes. The firm bonded foam structure provides strong support and evenly distributes body weight,
                        making it suitable for heavier sleepers.
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" id="headingEight">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
                        Does the Bond Tuff mattress come with a warranty?
                    </button>
                </h2>
                <div id="collapseEight" class="accordion-collapse collapse" aria-labelledby="headingEight"
                    data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Yes. The mattress comes with a 60-month manufacturer warranty covering manufacturing defects.
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" id="headingNine">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseNine" aria-expanded="false" aria-controls="collapseNine">
                        Is Bond Tuff a good budget mattress?
                    </button>
                </h2>
                <div id="collapseNine" class="accordion-collapse collapse" aria-labelledby="headingNine"
                    data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Yes. Bond Tuff offers premium materials, firm support, and long-term durability at a
                        value-driven price, making it one of the best options in the budget firm mattress category.
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" id="headingTen">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseTen" aria-expanded="false" aria-controls="collapseTen">
                        Is the mattress breathable?
                    </button>
                </h2>
                <div id="collapseTen" class="accordion-collapse collapse" aria-labelledby="headingTen"
                    data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Yes. The fabric allows better air circulation, helping reduce heat buildup and improving sleep
                        comfort.
                    </div>
                </div>
            </div>


            <div class="accordion-item">
                <h2 class="accordion-header" id="headingTen">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseTen" aria-expanded="false" aria-controls="collapseTen">
                        What thickness should I choose?
                    </button>
                </h2>
                <div id="collapseTen" class="accordion-collapse collapse" aria-labelledby="headingTen"
                    data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        • 4 inches is suitable for guest rooms or occasional use
                        • 5 inches is ideal for daily use with balanced support
                        • 6 inches offers enhanced comfort while retaining firmness

                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" id="headingTen">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseTen" aria-expanded="false" aria-controls="collapseTen">
                      Can this mattress be used on any type of bed?
                    </button>
                </h2>
                <div id="collapseTen" class="accordion-collapse collapse" aria-labelledby="headingTen"
                    data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Yes. It works well on wooden cots, metal frames, and flat surfaces. It is suitable for most standard Indian bed frames.

                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" id="headingTen">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseTen" aria-expanded="false" aria-controls="collapseTen">
                    Is this mattress suitable for all sleeping positions?
                    </button>
                </h2>
                <div id="collapseTen" class="accordion-collapse collapse" aria-labelledby="headingTen"
                    data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        It is best suited for back sleepers and stomach sleepers who need firm support. Side sleepers who prefer firm mattresses may also find it comfortable.

                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" id="headingTen">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseTen" aria-expanded="false" aria-controls="collapseTen">
                  Does the mattress sag over time?
                    </button>
                </h2>
                <div id="collapseTen" class="accordion-collapse collapse" aria-labelledby="headingTen"
                    data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                       No. The high density rebonded foam is designed to resist sagging and maintain shape even with long-term daily use.

                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

    <script src="assets/js/script.js"></script>

    <script>
                        // Debounce utility (define at top level)
                        function debounce(func, wait) {
                            let timeout;
                            return function(...args) {
                                clearTimeout(timeout);
                                timeout = setTimeout(() => func.apply(this, args), wait);
                            };
                        }

                        // Sync hidden form fields with selection
                        function syncFormFields() {
                            const variantSelect = document.getElementById('variantSelect');
                            const thicknessSelect = document.getElementById('thicknessSelect');
                            const formVariantId = document.getElementById('formVariantId');
                            const formThicknessId = document.getElementById('formThicknessId');
                            if (formVariantId && variantSelect) {
                                formVariantId.value = variantSelect.value;
                            }
                            if (formThicknessId && thicknessSelect) {
                                formThicknessId.value = thicknessSelect.value;
                            }
                        }

                        document.addEventListener('DOMContentLoaded', function() {
                            const variantSelect = document.getElementById('variantSelect');
                            const thicknessSelect = document.getElementById('thicknessSelect');
                            const formVariantId = document.getElementById('formVariantId');
                            const formThicknessId = document.getElementById('formThicknessId');
                            const formProductPrice = document.getElementById('formProductPrice');
                            const hiddenProductPrice = document.getElementById('hiddenProductPrice');
                            // Set default values if not selected
                            syncFormFields();
                            if (variantSelect && formVariantId) {
                                variantSelect.addEventListener('change', function() {
                                    syncFormFields();
                                });
                            }
                            if (thicknessSelect && formThicknessId) {
                                thicknessSelect.addEventListener('change', function() {
                                    syncFormFields();
                                });
                            }
                            if (hiddenProductPrice && formProductPrice) {
                                // Update price field whenever price changes
                                const observer = new MutationObserver(function() {
                                    formProductPrice.value = hiddenProductPrice.value;
                                });
                                observer.observe(hiddenProductPrice, { attributes: true, childList: true, subtree: true });
                            }
                            // Ensure form fields are synced before form submit
                            const addToCartForm = document.getElementById('addToCartForm');
                            if (addToCartForm) {
                                addToCartForm.addEventListener('submit', function(e) {
                                    syncFormFields();
                                });
                            }
                        });
                        // Buy Now button submits form
                        document.addEventListener('DOMContentLoaded', function() {
                            const buyNowBtn = document.getElementById('buyNowBtn');
                            const addToCartForm = document.getElementById('addToCartForm');
                            if (buyNowBtn && addToCartForm) {
                                buyNowBtn.addEventListener('click', function() {
                                    addToCartForm.submit();
                                });
                            }
                        });
                // Quantity increment/decrement logic
                document.addEventListener('DOMContentLoaded', function() {
                    const qtyInput = document.getElementById('quantityInput');
                    const qtyMinus = document.getElementById('qtyMinus');
                    const qtyPlus = document.getElementById('qtyPlus');
                    if (qtyInput && qtyMinus && qtyPlus) {
                        qtyMinus.addEventListener('click', function() {
                            let val = parseInt(qtyInput.value, 10) || 1;
                            if (val > 1) {
                                qtyInput.value = val - 1;
                            }
                        });
                        qtyPlus.addEventListener('click', function() {
                            let val = parseInt(qtyInput.value, 10) || 1;
                            qtyInput.value = val + 1;
                        });
                    }
                });
        // Image Gallery Functionality (Dynamic)
        document.addEventListener('DOMContentLoaded', function() {
            const mainImg = document.getElementById('mainImg');
            const thumbs = document.querySelectorAll('.thumb-gallery .thumb');
            const leftBtn = document.querySelector('.arrow-btn.left');
            const rightBtn = document.querySelector('.arrow-btn.right');

            let currentIndex = 0;
            const images = Array.from(thumbs).map(t => t.querySelector('img').getAttribute('src'));

            function updateImgByIndex(idx) {
                if (images.length === 0) return;
                currentIndex = idx;
                mainImg.src = images[idx];
                thumbs.forEach(t => t.classList.remove('active'));
                if (thumbs[idx]) thumbs[idx].classList.add('active');
            }

            thumbs.forEach((thumb, idx) => {
                thumb.addEventListener('click', function() {
                    updateImgByIndex(idx);
                });
            });

            function changeImage(direction) {
                if (direction === 'next') {
                    currentIndex = (currentIndex + 1) % images.length;
                } else {
                    currentIndex = (currentIndex - 1 + images.length) % images.length;
                }
                updateImgByIndex(currentIndex);
            }

            if (rightBtn) rightBtn.addEventListener('click', () => changeImage('next'));
            if (leftBtn) leftBtn.addEventListener('click', () => changeImage('prev'));

            // Set initial image
            updateImgByIndex(0);
        });

        // Dynamic Size & Thickness Price Update
        function updateProductPrice(variantId, thicknessId, productId) {
            // Get custom size values if present
            const customLength = document.getElementById('hiddenCustomLength')?.value || '';
            const customBreadth = document.getElementById('hiddenCustomBreadth')?.value || '';
            fetch("{{ route('product.variantPrice') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    variant_id: variantId,
                    thickness_id: thicknessId,
                    product_id: productId,
                    custom_length: customLength,
                    custom_breadth: customBreadth
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    document.querySelector('.product-price').textContent = data.price;
                    document.getElementById('hiddenProductPrice').value = data.price;
                    var formPrice = document.getElementById('formProductPrice');
                    if (formPrice) formPrice.value = data.price;
                } else {
                    document.querySelector('.product-price').textContent = 'N/A';
                    alert(data.message);
                }
            })
            .catch(err => {
                console.error(err);
                alert('Error fetching price');
            });
        }

        // Debounced version (define at top level)
        const debouncedUpdateProductPrice = debounce(updateProductPrice, 350);

        document.addEventListener('DOMContentLoaded', function() {
            const variantSelect = document.getElementById('variantSelect');
            const thicknessSelect = document.getElementById('thicknessSelect');
            const productId = '{{ $product->product_id }}';
            const selectedSizeDisplay = document.getElementById('selectedSizeDisplay');

            function updateSelectionDisplay() {
                // If custom size is selected, show custom length and breadth
                const customLength = document.getElementById('hiddenCustomLength')?.value;
                const customBreadth = document.getElementById('hiddenCustomBreadth')?.value;
                const customBtn = document.getElementById('customSizeBtn');
                if (customBtn && customBtn.classList.contains('active') && customLength && customBreadth) {
                    selectedSizeDisplay.textContent = `Custom: ${customLength} x ${customBreadth}`;
                } else {
                    const variantText = variantSelect.options[variantSelect.selectedIndex].text;
                    const thicknessText = thicknessSelect.options[thicknessSelect.selectedIndex].text;
                    selectedSizeDisplay.textContent = variantText + ' x ' + thicknessText;
                }
            }

            variantSelect.addEventListener('change', function() {
                document.getElementById('variant_id').value = this.value;
                updateProductPrice(this.value, thicknessSelect.value, productId);
                updateSelectionDisplay();
            });
            thicknessSelect.addEventListener('change', function() {
                document.getElementById('thickness_id').value = this.value;
                updateProductPrice(variantSelect.value, this.value, productId);
                updateSelectionDisplay();
            });

            // Set initial display
            updateSelectionDisplay();
        });

        // Custom size price update logic
        function triggerCustomPriceUpdate() {
            const customBtn = document.getElementById('customSizeBtn');
            const customLength = document.getElementById('customLength')?.value;
            const customBreadth = document.getElementById('customBreadth')?.value;
            const productId = '{{ $product->product_id }}';
            if (customBtn && customBtn.classList.contains('active') && customLength && customBreadth) {
                document.getElementById('hiddenCustomLength').value = customLength;
                document.getElementById('hiddenCustomBreadth').value = customBreadth;
                // Call price update with custom values
                updateProductPrice('', '', productId);
                // Update selection summary
                document.getElementById('selectedSizeDisplay').textContent = `Custom: ${customLength} x ${customBreadth}`;
            }
        }
        ['input', 'change'].forEach(evt => {
            document.getElementById('customLength')?.addEventListener(evt, triggerCustomPriceUpdate);
            document.getElementById('customBreadth')?.addEventListener(evt, triggerCustomPriceUpdate);
        });
        document.addEventListener('DOMContentLoaded', function() {
                    const customBtn = document.getElementById('customSizeBtn');
                    const customInputs = document.getElementById('customSizeInputs');
                    const sizeBtns = document.querySelectorAll('.size-group-btn');
                    const variantSelect = document.getElementById('variantSelect');
                    const thicknessSelect = document.getElementById('thicknessSelect');
                    const selectedSizeDisplay = document.getElementById('selectedSizeDisplay');
                    // Hide variant/thickness selects when custom is active
                    function updateSizeTabDisplay() {
                        if (customBtn.classList.contains('active')) {
                            if (variantSelect) variantSelect.style.display = 'none';
                            if (thicknessSelect) thicknessSelect.style.display = '';
                            if (customInputs) customInputs.style.display = 'block';
                        } else {
                            if (variantSelect) variantSelect.style.display = '';
                            if (thicknessSelect) thicknessSelect.style.display = '';
                            if (customInputs) customInputs.style.display = 'none';
                        }
                    }
                    sizeBtns.forEach(btn => {
                        btn.addEventListener('click', function() {
                            sizeBtns.forEach(b => b.classList.remove('active'));
                            this.classList.add('active');
                            updateSizeTabDisplay();
                            syncFormFields();
                            if (this === customBtn) {
                                const customLength = document.getElementById('customLength').value;
                                const customBreadth = document.getElementById('customBreadth').value;
                                document.getElementById('hiddenCustomLength').value = customLength;
                                document.getElementById('hiddenCustomBreadth').value = customBreadth;
                                if (selectedSizeDisplay) {
                                    selectedSizeDisplay.textContent = customLength && customBreadth ? `Custom: ${customLength} x ${customBreadth}` : 'Custom Size';
                                }
                                // Always require thickness for custom
                                const thicknessId = thicknessSelect?.value || '';
                                const productId = '{{ $product->product_id }}';
                                debouncedUpdateProductPrice('', thicknessId, productId);
                            } else {
                                if (selectedSizeDisplay) selectedSizeDisplay.textContent = this.textContent;
                                const productId = '{{ $product->product_id }}';
                                debouncedUpdateProductPrice(variantSelect.value, thicknessSelect.value, productId);
                            }
                        });
                    });
                    // Initial display
                    updateSizeTabDisplay();
                    function triggerCustomPriceUpdate() {
                        if (!customBtn.classList.contains('active')) return;
                        const customLength = document.getElementById('customLength').value;
                        const customBreadth = document.getElementById('customBreadth').value;
                        document.getElementById('hiddenCustomLength').value = customLength;
                        document.getElementById('hiddenCustomBreadth').value = customBreadth;
                        if (selectedSizeDisplay) {
                            selectedSizeDisplay.textContent = customLength && customBreadth ? `Custom: ${customLength} x ${customBreadth}` : 'Custom Size';
                        }
                        // Always require thickness for custom
                        const thicknessId = thicknessSelect?.value || '';
                        const productId = '{{ $product->product_id }}';
                        updateProductPrice('', thicknessId, productId);
                    }
                    ['input', 'change'].forEach(evt => {
                        document.getElementById('customLength')?.addEventListener(evt, triggerCustomPriceUpdate);
                        document.getElementById('customBreadth')?.addEventListener(evt, triggerCustomPriceUpdate);
                    });
                });


                 const dimensionsByGroup = @json($dimensionsByGroup);
                document.addEventListener('DOMContentLoaded', function() {
                    const sizeBtns = document.querySelectorAll('.size-group-btn');
                    const variantSelect = document.getElementById('variantSelect');
                    const thicknessSelect = document.getElementById('thicknessSelect');
                    const priceDisplay = document.querySelector('.product-price');
                    const productId = '{{ $product->product_id }}';
                    sizeBtns.forEach(btn => {
                        btn.addEventListener('click', function() {
                            sizeBtns.forEach(b => b.classList.remove('active'));
                            this.classList.add('active');
                            const group = this.dataset.group;
                            if (this.id === 'customSizeBtn') {
                                priceDisplay.textContent = document.getElementById('hiddenProductPrice').value;
                                updateProductPrice('', thicknessSelect.value, productId);
                                return;
                            }
                            if (!group || !dimensionsByGroup[group]) return;
                            variantSelect.innerHTML = '';
                            Object.entries(dimensionsByGroup[group]).forEach(([dimensionName, thicknessArr]) => {
                                const variantId = thicknessArr[Object.keys(thicknessArr)[0]].variant_id;
                                const option = document.createElement('option');
                                option.value = variantId;
                                option.textContent = dimensionName;
                                variantSelect.appendChild(option);
                            });
                            thicknessSelect.innerHTML = '';
                            const firstDimension = Object.values(dimensionsByGroup[group])[0];
                            if (firstDimension) {
                                Object.values(firstDimension).forEach(thicknessObj => {
                                    const option = document.createElement('option');
                                    option.value = thicknessObj.id;
                                    option.textContent = thicknessObj.thick;
                                    thicknessSelect.appendChild(option);
                                });
                            }                            
                            debouncedUpdateProductPrice(variantSelect.value, thicknessSelect.value, productId);
                        });
                    });
                    variantSelect.addEventListener('change', function() {
                        syncFormFields();
                        debouncedUpdateProductPrice(this.value, thicknessSelect.value, productId);
                    });
                    thicknessSelect.addEventListener('change', function() {
                        syncFormFields();
                        debouncedUpdateProductPrice(variantSelect.value, this.value, productId);
                    });
                });
    </script>
