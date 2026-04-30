@extends('layouts.app')

@section('title', 'Premium Mattress & Sleep Solutions')

@section('content')

    <div class="product-page-container">
        <section class="product-view-section">
            <div class="product-gallery">
                <div class="thumbnails">
                    <img src="{{ $product->image_url }}" alt="{{ $product->product_name }}" class="active"
                        data-image="{{ $product->image_url }}">
                </div>
                <div class="main-image-container">
                    <img src="{{ $product->image_url }}" alt="{{ $product->product_name }}" id="mainImage">
                    <i class="fas fa-heart heart-icon" role="button" tabindex="0"
                        data-auth="{{ auth()->check() ? '1' : '0' }}" data-wishlisted="{{ $isWishlisted ? '1' : '0' }}"
                        aria-pressed="{{ $isWishlisted ? 'true' : 'false' }}"
                        aria-label="{{ $isWishlisted ? 'Remove from wishlist' : 'Add to wishlist' }}"></i>
                </div>
            </div>

            <div class="product-details">
                <h1 class="product-name">{{ $product->product_name ?? 'Product' }}</h1>
                <p class="product-variant-info">
                    <span id="selectedSizeDisplayTop">
                        {{ $product->variant_full_display . '  Warranty' }}
                    </span>
                </p>

                <div class="rating-and-cart-info">
                    <span class="rating-stars">{{ $product->review }} ★</span>
                    <span class="cart-info">{{ $product->total_reviewers }} reviews</span>
                </div>

                <div class="price-section">
                    @if ($product->onsale)
                        <div>
                            <span class="sale-badge">SALE</span>
                        </div>
                    @endif
                    <div class="price-figures">
                        <span class="current-price" id="mainProductPrice">{{ $product->price ?? 0 }}</span>
                        @if ($product->onsale && $product->onsale_price)
                            <span class="old-price" id="mainOldPrice">{{ $product->price }}</span>
                            <span class="discount-percent">
                                @if ((float) $product->original_price > 0)
                                    {{ round((((float) $product->original_price - (float) $product->discount_price) / (float) $product->original_price) * 100) }}%
                                @else
                                    0%
                                @endif
                            </span>
                        @endif

                    </div>
                    <div class="tax-info">Incl. of all taxes</div>
                </div>

                <div class="delivery-and-size">
                    <div class="check-delivery">


                        <label>Check Delivery</label>
                        <div class="pincode-input">
                            <input type="text" id="deliveryPincode" placeholder="Enter pincode" maxlength="6">
                            <button type="button" id="checkDeliveryBtn">CHECK</button>
                        </div>
                        <div id="deliveryResult" style="margin-top:8px;font-size:14px;"></div>
                    </div>
                    <div class="choose-size-container">
                        <label>Choose Size</label>
                        <div class="size-dropdown" id="openVariantModal">
                            <span id="selectedSizeDisplayDropdown">
                                @if (!empty($product->default_variant) && $product->default_variant !== 'N/A')
                                    {{ $product->default_variant }}
                                @else
                                    Select Size & Thickness
                                @endif
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Quantity & Delivery Section -->
                {{-- <div class="delivery-and-size">
                    <div class="check-delivery">
                        <label>Quantity</label>
                        <div class="input-group qty-group" style="display: flex; border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden;">
                            <button type="button" id="qtyMinus" class="btn" style="background: #f5f5f5; border: none; padding: 10px 15px; cursor: pointer;">-</button>
                            <input type="number" id="quantityInput" class="form-control" name="quantity" value="1" min="1" style="text-align: center; border: none; background: #f5f5f5; width: 60px;" readonly>
                            <button type="button" id="qtyPlus" class="btn" style="background: #f5f5f5; border: none; padding: 10px 15px; cursor: pointer;">+</button>
                        </div>
                    </div>
                    <div class="check-delivery">
                        <label>Check Delivery</label>
                        <div class="pincode-input">
                            <input type="text" id="deliveryPincode" placeholder="Enter pincode" name="pincode">
                            <button type="button" id="checkDeliveryBtn">Check</button>
                        </div>
                        <div id="deliveryResult"></div>
                    </div>
                </div> --}}

                <form id="addToCartForm" action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                    <input type="hidden" name="variant_id" id="formVariantId"
                        value="{{ $product->default_variant_id ?? '' }}">
                    <input type="hidden" name="thickness_id" id="formThicknessId"
                        value="{{ $product->default_thickness_id ?? '' }}">
                    <input type="hidden" name="quantity" id="hiddenQuantity" value="1">
                    <input type="hidden" name="price" id="formProductPrice" value="{{ $product->price_value ?? 0 }}">
                    <input type="hidden" name="custom_length" id="hiddenCustomLength" value="">
                    <input type="hidden" name="custom_breadth" id="hiddenCustomBreadth" value="">
                    <input type="hidden" name="buy_now" id="buyNowFlag" value="0">

                    <button type="submit" class="add-to-cart-btn">
                        <i class="fas fa-cart-plus"></i> Add to Cart
                    </button>
                </form>

                <button type="button" class="buy-now-btn" id="buyNowBtn">
                    <i class="fas fa-shopping-bag"></i> Buy Now
                </button>
                <div id="actionMessage" class="action-message" aria-live="polite"></div>

                <!-- Hidden fields for variant selection -->
                <input type="hidden" id="variant_id" value="{{ $product->default_variant_id ?? '' }}">
                <input type="hidden" id="thickness_id" value="{{ $product->default_thickness_id ?? '' }}">
                <input type="hidden" id="hiddenProductPrice" value="{{ $product->price_value ?? 0 }}">


                <div class="save-extra-section">
                    <h2>Save with Offers</h2>
                    <div class="offers-container">
                        <div class="offers-track">

                            @foreach($rewardTypes as $rewardType)
                                <div class="offer-card2" data-type="{{ strtolower($rewardType->title ?? '') }}">
                                    <div class="offer-content">

                                        {{-- Logo + Title --}}
                                        <div class="bank-logo">
                                            @if($rewardType->logo)
                                                <img src="{{ "https://sleepauth.kodesoft.cloud/" . $rewardType->logo }}" 
                                                    alt="Logo" 
                                                    style="height:20px;">
                                            @else
                                                <i class="fas fa-gift"></i>
                                            @endif
                                        </div>

                                        {{-- Static text (since no subtitle in DB) --}}
                                        <div class="offer-detail">
                                            <div class="lowest-price">
                                                {{ $rewardType->title }}
                                            </div>

                                            {{-- Optional: extract % from message --}}
                                            <div class="price-value">
                                                {{ $rewardType->message }}
                                            </div>
                                        </div>

                                        {{-- Offer Message --}}
                                        <div class="offer-type">
                                            <i class="fas fa-tags"></i>
                                            {{ $rewardType->message }}
                                        </div>

                                        {{-- Button --}}
                                        {{-- <button class="view-offer-btn">
                                            Apply Now
                                        </button> --}}

                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </section>

        <hr>

        <!-- Why Choose Section -->
        <section class="whychoose">
            <div class="container mt-0 py-4">
                <div class="row mb-5">
                    <div class="col-12">
                        <div class="whychooseheading mb-3">
                            <h2 class="fw-bold mb-4 text-center">Why Choose Bond Tuff?</h2>
                        </div>
                        <div class="whychoosefeature">
                            <div class="row">
                                <div class="col-lg-12 col-md-12">
                                    <div class="row g-4">
                                        <div class="col-md-4 col-12">
                                            <div class="feature-item d-flex">
                                                <div class="feature-icon">
                                                    <i class="fas fa-cubes"></i>
                                                </div>
                                                <div class="feature-text">
                                                    <h4>High Density Foam Core</h4>
                                                    <p>Premium bonded foam for enhanced durability and support</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="feature-item d-flex">
                                                <div class="feature-icon">
                                                    <i class="fas fa-bone"></i>
                                                </div>
                                                <div class="feature-text">
                                                    <h4>Spine Alignment</h4>
                                                    <p>Superior support for proper spinal alignment</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="feature-item d-flex">
                                                <div class="feature-icon">
                                                    <i class="fas fa-wind"></i>
                                                </div>
                                                <div class="feature-text">
                                                    <h4>Breathable Fabric</h4>
                                                    <p>Premium knitted fabric for optimal air circulation</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="feature-item d-flex">
                                                <div class="feature-icon">
                                                    <i class="fas fa-balance-scale"></i>
                                                </div>
                                                <div class="feature-text">
                                                    <h4>Medium-Firm Feel</h4>
                                                    <p>Perfect balance of comfort and support</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="feature-item d-flex">
                                                <div class="feature-icon">
                                                    <i class="fas fa-layer-group"></i>
                                                </div>
                                                <div class="feature-text">
                                                    <h4>HD Foam Quilting</h4>
                                                    <p>Enhanced cushioning and pressure relief</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="feature-item d-flex">
                                                <div class="feature-icon">
                                                    <i class="fas fa-shield-alt"></i>
                                                </div>
                                                <div class="feature-text">
                                                    <h4>Durable Construction</h4>
                                                    <p>Built to last with high-quality materials</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="feature-item d-flex">
                                                <div class="feature-icon">
                                                    <i class="fas fa-calendar-check"></i>
                                                </div>
                                                <div class="feature-text">
                                                    <h4>60-Month Warranty</h4>
                                                    <p>Extended protection for peace of mind</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="feature-item d-flex">
                                                <div class="feature-icon">
                                                    <i class="fas fa-temperature-low"></i>
                                                </div>
                                                <div class="feature-text">
                                                    <h4>Cool Sleep Technology</h4>
                                                    <p>Maintains optimal sleeping temperature</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Specifications -->
                <div class="row align-items-center mt-5 pt-5">
                    <div class="col-12 mb-4">
                        <h2 class="fw-bold text-center">Mattress Specifications</h2>
                    </div>
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
                                    <p class="text-muted spec-para mb-0">Soft, breathable, and skin-friendly for
                                        enhanced sleep comfort.</p>
                                </div>
                            </div>
                            <div class="spec-item mb-4 d-flex">
                                <span class="step-num me-3">2</span>
                                <div>
                                    <h5 class="fw-bold mb-1">HD Foam Quilting</h5>
                                    <p class="text-muted spec-para mb-0">Adds cushioning and improves pressure
                                        distribution.</p>
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
                                    <p class="text-muted spec-para mb-0">Strong base layer that ensures firmness,
                                        durability, and spinal support.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <hr>

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

        <hr>

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
                            maintain proper spinal alignment. This reduces pressure on the lower back and joints, making
                            it
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
                            The Bond Tuff mattress offers medium-firm to firm support. It is ideal for sleepers who
                            prefer a
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
                            Bond Tuff is constructed using premium knitted fabric, HD foam quilting, high density PU
                            foam,
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
                            Yes. The firm bonded foam structure provides strong support and evenly distributes body
                            weight,
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
                            Yes. The mattress comes with a 60-month manufacturer warranty covering manufacturing
                            defects.
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
                            Yes. The fabric allows better air circulation, helping reduce heat buildup and improving
                            sleep
                            comfort.
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingEleven">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseEleven" aria-expanded="false" aria-controls="collapseEleven">
                            What thickness should I choose?
                        </button>
                    </h2>
                    <div id="collapseEleven" class="accordion-collapse collapse" aria-labelledby="headingEleven"
                        data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            • 4 inches is suitable for guest rooms or occasional use
                            • 5 inches is ideal for daily use with balanced support
                            • 6 inches offers enhanced comfort while retaining firmness
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTwelve">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseTwelve" aria-expanded="false" aria-controls="collapseTwelve">
                            Can this mattress be used on any type of bed?
                        </button>
                    </h2>
                    <div id="collapseTwelve" class="accordion-collapse collapse" aria-labelledby="headingTwelve"
                        data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Yes. It works well on wooden cots, metal frames, and flat surfaces. It is suitable for most
                            standard Indian bed frames.
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingThirteen">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseThirteen" aria-expanded="false" aria-controls="collapseThirteen">
                            Is this mattress suitable for all sleeping positions?
                        </button>
                    </h2>
                    <div id="collapseThirteen" class="accordion-collapse collapse" aria-labelledby="headingThirteen"
                        data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            It is best suited for back sleepers and stomach sleepers who need firm support. Side
                            sleepers who prefer firm mattresses may also find it comfortable.
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingFourteen">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseFourteen" aria-expanded="false" aria-controls="collapseFourteen">
                            Does the mattress sag over time?
                        </button>
                    </h2>
                    <div id="collapseFourteen" class="accordion-collapse collapse" aria-labelledby="headingFourteen"
                        data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            No. The high density rebonded foam is designed to resist sagging and maintain shape even
                            with long-term daily use.
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <hr>

        <!-- Features Section -->
        <section class="product-detail-last-section customisation-section mid-section">
            <div class="container">
                <ul class="reviews-slider-pointer-ul">
                    <li style="color:#8C4799"><a href="/store"><img loading="lazy" alt="BRAND OUTLETS"
                                decoding="async"
                                src="https://mysleepwell.s3.ap-south-1.amazonaws.com/uploads/benifits/groupone%20(1)-1672931221569.svg">
                            BRAND OUTLETS</a></li>
                    <li style="color:#FF8230"><a href="/no-cost-emi"><img loading="lazy" alt="NO COST EMI"
                                decoding="async"
                                src="https://mysleepwell.s3.ap-south-1.amazonaws.com/uploads/benifits/No%20cost%20Emi_S%20(1)%202-1673871768155-1691068740147.svg">
                            NO COST EMI</a></li>
                    <li style="color:#588DD0"><a href="/newTermsandcondition"><img loading="lazy" alt="FREE DELIVERY"
                                decoding="async"
                                src="https://mysleepwell.s3.ap-south-1.amazonaws.com/uploads/benifits/Free%20Delivery%20&amp;%20Returns_-1632806416567-1691134584370.svg">
                            FREE DELIVERY</a></li>
                    <li style="color:#385572"><a href="/newTermsandcondition"><img loading="lazy" alt="CUSTOM SIZE"
                                decoding="async"
                                src="https://mysleepwell.s3.ap-south-1.amazonaws.com/uploads/benifits/Coustom%20Size%20(7)-1691395248062.svg">
                            CUSTOM SIZE</a></li>
                    <li style="color:#FFA500"><a href="/mattresses/all-mattress"><img loading="lazy" alt="WIDE RANGE"
                                decoding="async"
                                src="https://mysleepwell.s3.ap-south-1.amazonaws.com/uploads/benifits/wide-1632115174468.svg">
                            WIDE RANGE</a></li>
                    <li style="color:#FF6F0F"><a href="/newWarrancy-policy"><img loading="lazy" alt="25 YEARS WARRANTY*"
                                decoding="async"
                                src="https://mysleepwell.s3.ap-south-1.amazonaws.com/uploads/benifits/warranty-1629908552318%20(1)-1696917148396.svg">
                            25 YEARS WARRANTY*</a></li>
                </ul>
            </div>
        </section>

    </div>

    <!-- Variant Selection Modal -->
    <div class="modal-overlay" id="variantModal">
        <div class="modal-content">
            <button class="modal-close-btn" id="closeVariantModal">&times;</button>
            <h2 class="modal-title">Choose Your Size</h2>

            <div class="modal-product-header">
                <img src="{{ $product->image_url }}" alt="{{ $product->product_name }}" class="modal-thumbnail">
                <div>
                    <div class="modal-product-name">{{ $product->product_name }}</div>
                    <div class="current-price" id="modalProductPrice">{{ $product->price ?? 0 }}</div>
                </div>
            </div>

            <div class="learn-measure-banner">
                <i class="fas fa-ruler-combined"></i> Not sure about size? Learn how to measure
            </div>

            @php
                $defaultVariantId = $product->default_variant_id ?? '';
                $defaultThicknessId = $product->default_thickness_id ?? '';
                $initialGroup = null;
                $initialDimension = null;
                foreach ($dimensionsByGroup as $groupName => $dims) {
                    foreach ($dims as $dimName => $thicks) {
                        foreach ($thicks as $t) {
                            if ((string) ($t['variant_id'] ?? '') === (string) $defaultVariantId) {
                                $initialGroup = $groupName;
                                $initialDimension = $dimName;
                                break 3;
                            }
                        }
                    }
                }
                $initialGroup = $initialGroup ?? ($sizeGroups[0] ?? null);
            @endphp

            <div class="size-selection-group">
                <h3>Size Group</h3>
                <div class="size-group-options">
                    @foreach ($sizeGroups as $group)
                        <button class="size-group-btn {{ $group === $initialGroup ? 'active' : '' }}"
                            data-group="{{ $group }}">{{ ucfirst($group) }}</button>
                    @endforeach
                    <button class="size-group-btn" id="customSizeBtn" data-group="custom">Custom</button>
                </div>
                <!-- Custom size input fields, hidden by default -->
                <div id="customSizeInputs"
                    style="display:none; margin-top:16px; padding:14px 10px; background:#f8f8f8; border-radius:8px; border:1px solid #e0e0e0; max-width:340px;">
                    <div style="display:flex; gap:16px; align-items:center; justify-content:space-between;">
                        <div style="flex:1;">
                            <label for="customLength" style="font-weight:500; font-size:14px; color:#333;">Height
                                (inches)</label>
                            <input type="number" min="1" id="customLength" name="custom_length"
                                class="custom-size-input"
                                style="width:100%; padding:7px 10px; border:1px solid #ccc; border-radius:5px; margin-top:4px; font-size:15px;"
                                placeholder="e.g. 75" />
                        </div>
                        <div style="flex:1;">
                            <label for="customBreadth" style="font-weight:500; font-size:14px; color:#333;">Width
                                (inches)</label>
                            <input type="number" min="1" id="customBreadth" name="custom_breadth"
                                class="custom-size-input"
                                style="width:100%; padding:7px 10px; border:1px solid #ccc; border-radius:5px; margin-top:4px; font-size:15px;"
                                placeholder="e.g. 60" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="size-selection-group">
                <h3>Dimensions</h3>
                <div class="dimension-options" id="dimensionOptions">
                    @php
                        $dimensions = $initialGroup ? $dimensionsByGroup[$initialGroup] ?? [] : [];
                        $variantIdsByDimension = [];
                        $activeDimension = $initialDimension;
                        foreach ($dimensions as $dimensionName => $thicknesses) {
                            $firstThickness = reset($thicknesses);
                            $variantIdsByDimension[$dimensionName] = $firstThickness['variant_id'] ?? null;
                            if (!$activeDimension) {
                                $activeDimension = $dimensionName;
                            }
                        }
                    @endphp
                    @foreach ($dimensions as $dimensionName => $thicknesses)
                        <button type="button"
                            class="dimension-btn {{ $dimensionName === $activeDimension ? 'active' : '' }}"
                            data-variant-id="{{ $variantIdsByDimension[$dimensionName] ?? '' }}"
                            data-dimension="{{ $dimensionName }}">{{ $dimensionName }}</button>
                    @endforeach
                </div>
            </div>

            <div class="size-selection-group">
                <h3>Thickness</h3>
                <div class="dimension-options" id="thicknessOptions">
                    @foreach ($thicknessVariants as $thickness)
                        @php
                            $isActiveThickness =
                                (string) $thickness->id === (string) $defaultThicknessId ||
                                ($defaultThicknessId === '' && $loop->first);
                        @endphp
                        <button type="button" class="dimension-btn {{ $isActiveThickness ? 'active' : '' }}"
                            data-thickness-id="{{ $thickness->id }}">{{ $thickness->thick }}</button>
                    @endforeach
                </div>
            </div>

            <button class="confirm-variant-btn">Confirm Selection</button>
            <input type="hidden" name="custom_length" id="hiddenCustomLength" />
            <input type="hidden" name="custom_breadth" id="hiddenCustomBreadth" />
        </div>
    </div>

@endsection
@push('styles')
    <style>
        /* =========================================== */
        /* CSS VARIABLES & GLOBAL RESET */
        /* =========================================== */

        :root {
            /* Updated Color Variables */
            --text-dark: #333;
            --text-light: #fff;
            --alert-red: #ff0000;
            --sleepsure-blue: #1b4e9b;
            --sleepsure-green: #429e39;
            --light-blue-bg: #e5f0ff;
            --light-green-bg: #f0fff0;

            /* Spacing Variables */
            --spacing-xs: 5px;
            --spacing-sm: 10px;
            --spacing-md: 15px;
            --spacing-lg: 20px;
            --spacing-xl: 30px;
            --spacing-xxl: 40px;

            /* Border Radius */
            --border-radius-sm: 4px;
            --border-radius-md: 8px;
            --border-radius-lg: 12px;
            --border-radius-xl: 15px;

            /* Shadows */
            --shadow-light: 0 2px 5px rgba(0, 0, 0, 0.05);
            --shadow-medium: 0 4px 10px rgba(0, 0, 0, 0.1);
            --shadow-heavy: 0 6px 15px rgba(0, 0, 0, 0.1);
        }

        /* Global Reset & Base Styles */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: "Inter", sans-serif;
        }

        a {
            text-decoration: none !important;
            color: var(--text-dark);
        }

        /* =========================================== */
        /* PRODUCT DETAIL PAGE STYLES */
        /* =========================================== */

        /* Variant modal buttons */
        .size-group-options,
        .dimension-options {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .size-group-btn,
        .dimension-btn {
            border: 1px solid #cdd6e0;
            background: #fff;
            color: #1a2b4c;
            padding: 8px 14px;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.15s ease;
            min-width: 64px;
            text-transform: capitalize;
        }

        .size-group-btn.active,
        .dimension-btn.active {
            background: #1b4e9b;
            color: #fff;
            border-color: #1b4e9b;
            box-shadow: 0 2px 6px rgba(27, 78, 155, 0.25);
        }

        .size-group-btn:hover,
        .dimension-btn:hover {
            border-color: #1b4e9b;
            color: #1b4e9b;
        }

        .product-page-container {
            margin: 0 auto;
            padding: var(--spacing-lg);
            background: white;
            border-radius: var(--border-radius-lg);
            box-shadow: var(--shadow-light);
        }

        .section-title {
            font-size: 1.5em;
            font-weight: 600;
            margin-bottom: var(--spacing-md);
            color: var(--sleepsure-blue);
        }

        hr {
            border: none;
            border-top: 1px solid #e2e8f0;
            margin: var(--spacing-xl) 0;
        }

        /* Product View Section */
        .product-view-section {
            display: flex;
            gap: var(--spacing-xl);
            padding-top: var(--spacing-lg);
        }

        .product-gallery {
            width: 60%;
            display: flex;
            gap: var(--spacing-md);
        }

        /* Thumbnails on Left Side */
        .thumbnails {
            display: flex;
            flex-direction: column;
            gap: var(--spacing-sm);
            padding: 20px;
            background-color: #e5f0ff;
        }

        .thumbnails img {
            width: 100%;
            height: 120px;
            width: 120px;
            border: 5px solid #fff;
            border-radius: var(--border-radius-lg);
            cursor: pointer;
            object-fit: cover;
            transition: all 0.3s ease;
        }

        .thumbnails img:hover {
            border-color: var(--sleepsure-blue);
            transform: scale(1.05);
        }

        .thumbnails img.active {
            border-color: var(--sleepsure-blue);
            border-width: 2px;
        }

        .main-image-container {
            flex: 1;
            border-radius: var(--border-radius-md);
            overflow: hidden;
            position: relative;
        }

        .main-image-container img {
            width: 100%;
            height: 700px;
            object-fit: cover;
        }

        .heart-icon {
            position: absolute;
            top: 12px;
            right: 12px;
            font-size: 22px;
            color: #cbd5e1;
            background: rgba(255, 255, 255, 0.92);
            border-radius: 50%;
            width: 38px;
            height: 38px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 6px 14px rgba(0, 0, 0, 0.12);
            transition: transform 0.2s ease, color 0.2s ease, box-shadow 0.2s ease;
        }

        .heart-icon:hover {
            transform: translateY(-1px) scale(1.02);
            box-shadow: 0 10px 22px rgba(0, 0, 0, 0.14);
        }

        .heart-icon.active {
            color: #e11d48;
        }

        .heart-icon.is-busy {
            opacity: 0.6;
            pointer-events: none;
        }

        /* Product Details */
        .product-details {
            width: 40%;
        }

        .product-name {
            font-size: 1.3em;
            font-weight: 600;
            color: var(--sleepsure-blue);
            margin-bottom: var(--spacing-xs);
        }

        .product-variant-info {
            color: #64748b;
            margin-bottom: var(--spacing-md);
        }

        .rating-and-cart-info {
            display: flex;
            gap: var(--spacing-md);
            margin-bottom: var(--spacing-lg);
        }

        .rating-stars {
            border: 1px solid rgb(230 231 232);
            color: black;
            padding: var(--spacing-xs) var(--spacing-sm);
            border-radius: var(--border-radius-sm);
            font-weight: 600;
        }

        .cart-info {
            color: black;
            font-weight: 500;
            border: 1px solid rgb(230 231 232);
            padding: 0px 10px;
            border-radius: var(--border-radius-sm);
            display: flex;
            align-items: center;
        }

        .price-section {
            margin-bottom: var(--spacing-lg);
        }

        .sale-badge {
            background: var(--alert-red);
            color: white;
            padding: var(--spacing-xs);
            border-radius: var(--border-radius-sm);
            font-size: 0.8em;
            font-weight: 600;
            margin-right: var(--spacing-sm);
        }

        .sale-ends {
            color: var(--alert-red);
            font-size: 0.8em;
            font-weight: 600;
        }

        .price-figures {
            display: flex;
            align-items: center;
            gap: var(--spacing-md);
            margin-top: var(--spacing-sm);
        }

        .current-price {
            font-size: 1.8em;
            font-weight: 700;
        }

        .old-price {
            text-decoration: line-through;
            color: #94a3b8;
        }

        .discount-percent {
            background: var(--sleepsure-green);
            color: white;
            padding: var(--spacing-xs);
            border-radius: var(--border-radius-sm);
            font-weight: 600;
        }

        .tax-info {
            color: #64748b;
            font-size: 0.8em;
            margin-top: var(--spacing-xs);
        }

        /* Delivery and Size Sections */
        .delivery-and-size {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: var(--spacing-md);
            margin-bottom: var(--spacing-lg);
        }

        .check-delivery,
        .choose-size-container {
            display: flex;
            flex-direction: column;
        }

        .check-delivery label,
        .choose-size-container label {
            font-weight: 600;
            color: #475569;
            margin-bottom: var(--spacing-xs);
            font-size: 0.9em;
        }

        .pincode-input {
            display: flex;
            border: 1px solid #e2e8f0;
            border-radius: var(--border-radius-md);
            overflow: hidden;
        }

        .pincode-input input {
            border: none;
            padding: var(--spacing-md);
            flex: 1;
            outline: none;
            font-size: 12px;
        }

        .pincode-input button {
            background: var(--sleepsure-blue);
            color: white;
            border: none;
            padding: var(--spacing-md) var(--spacing-lg);
            cursor: pointer;
            font-weight: 600;
            font-size: 12px;
        }

        .size-dropdown {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: var(--spacing-md);
            border: 1px solid var(--sleepsure-blue);
            background: var(--light-blue-bg);
            border-radius: var(--border-radius-md);
            cursor: pointer;
            font-weight: 600;
            color: var(--sleepsure-blue);
            font-size: 12px;
        }

        .size-dropdown .standard-options {
            font-size: 0.8em;
            color: #64748b;
        }

        /* Add to Cart Button */
        .add-to-cart-btn {
            width: 100%;
            padding: var(--spacing-md);
            background: var(--sleepsure-blue);
            color: white;
            border: none;
            border-radius: var(--border-radius-md);
            font-weight: 600;
            cursor: pointer;
            margin-bottom: var(--spacing-lg);
            transition: background 0.3s;
        }

        .add-to-cart-btn:hover {
            background: #153a73;
        }

        .buy-now-btn {
            width: 100%;
            padding: var(--spacing-md);
            background: var(--sleepsure-green);
            color: white;
            border: none;
            border-radius: var(--border-radius-md);
            font-weight: 600;
            cursor: pointer;
            margin-bottom: var(--spacing-lg);
            transition: background 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: var(--spacing-xs);
        }

        .buy-now-btn:hover {
            background: #029b42;
        }

        .cta-disabled {
            opacity: 0.6;
            cursor: not-allowed;
            pointer-events: none;
        }

        .action-message {
            margin-top: 8px;
            font-weight: 600;
            font-size: 0.95rem;
            color: #1b4e9b;
            min-height: 20px;
        }

        .action-message.error {
            color: #c0392b;
        }

        .action-message.success {
            color: #2d9d3a;
        }

        .qty-group {
            background: #f1f3f5;
            border-radius: 6px;
            overflow: hidden;
        }

        .qty-group button {
            background: #f5f5f5;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .qty-group button:hover {
            background: #e5e5e5;
        }

        .add-to-cart-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: var(--spacing-xs);
        }

        #deliveryResult {
            margin-top: var(--spacing-xs);
            font-size: 0.9em;
            color: var(--sleepsure-green);
        }

        /* Bank Card Style Offers */
        .save-extra-section h2 {
            font-size: 1.1em;
            font-weight: 600;
            margin-bottom: var(--spacing-md);
            color: var(--sleepsure-blue);
        }

        .offers-container {
            overflow-x: auto;
            padding-bottom: var(--spacing-sm);
            scrollbar-width: none;
        }

        .offers-container::-webkit-scrollbar {
            display: none;
        }

        .offers-track {
            display: flex;
            gap: var(--spacing-md);
            width: max-content;
        }

        .offer-card2 {
            min-width: 280px;
            padding: var(--spacing-sm);
            border-radius: 16px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            position: relative;
            overflow: hidden;
        }

        .offer-card2:nth-child(2) {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }

        .offer-card2:nth-child(3) {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }

        .offer-card2::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .offer-card2::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -30%;
            width: 150px;
            height: 150px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .offer-content {
            position: relative;
            z-index: 2;
        }

        .bank-logo {
            font-size: 1.2em;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: var(--spacing-sm);
        }

        .offer-detail {
            margin: var(--spacing-sm) 0;
        }

        .lowest-price {
            opacity: 0.9;
            font-size: 0.9em;
        }

        .price-value {
            font-size: 1.4em;
            font-weight: 700;
            margin: var(--spacing-xs) 0;
        }

        .offer-type {
            opacity: 0.9;
            font-size: 0.9em;
            margin-bottom: var(--spacing-md);
            display: flex;
            align-items: center;
            gap: var(--spacing-xs);
        }

        .view-offer-btn {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.3);
            padding: var(--spacing-sm) var(--spacing-md);
            border-radius: 20px;
            cursor: pointer;
            font-weight: 600;
            backdrop-filter: blur(10px);
            transition: all 0.3s;
        }

        .view-offer-btn:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        /* Features Section */
        .product-detail-last-section {
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

        /* =========================================== */
        /* WHY CHOOSE BOND TUFF SECTION */
        /* =========================================== */

        .whychoose {
            background-color: #f5f5f5;
            padding: 10px 0;
        }

        .whychooseheading {
            padding: 10px 0;
            border-bottom: 1px solid var(--sleepsure-blue);
            text-align: center;
        }

        .whychooseheading h2 {
            font-size: 2.2rem;
            color: var(--sleepsure-blue);
            margin-bottom: 20px;
            position: relative;
            display: inline-block;
        }

        .whychooseheading h2::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 3px;
            background: var(--sleepsure-blue);
            border-radius: 2px;
        }

        .whychoosefeature {
            padding: 20px 0;
            border-bottom: 1px solid var(--sleepsure-blue);
        }

        .whychoosefeature .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }

        /* Feature Category Styles */
        .feature-category {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            margin-bottom: 30px;
            height: 100%;
        }

        .category-title {
            font-size: 1.6rem;
            color: var(--sleepsure-blue);
            margin-bottom: 15px;
            font-weight: 600;
        }

        .category-description {
            font-size: 1rem;
            color: #666;
            line-height: 1.6;
        }

        /* Feature Item Styles */
        .feature-item {
            display: flex;
            align-items: flex-start;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
            transition: all 0.3s ease;
            height: 100%;
        }

        .feature-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            background: #f8fafc;
        }

        /* Feature Icon Design */
        .feature-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--sleepsure-blue), var(--sleepsure-green));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 20px;
            flex-shrink: 0;
            transition: all 0.3s ease;
        }

        .feature-item:hover .feature-icon {
            transform: scale(1.1);
            background: linear-gradient(135deg, var(--sleepsure-green), var(--sleepsure-blue));
        }

        .feature-icon i {
            font-size: 1.5rem;
            color: white;
        }

        /* Feature Text Design */
        .feature-text {
            flex: 1;
        }

        .feature-text h4 {
            font-size: 1.2rem;
            color: var(--sleepsure-blue);
            margin-bottom: 8px;
            font-weight: 600;
            line-height: 1.3;
        }

        .feature-text p {
            font-size: 0.95rem;
            color: #666;
            line-height: 1.5;
            margin: 0;
        }

        /* Small Text for Features */
        .whychoosefeature .small {
            font-size: 18px;
            color: var(--sleepsure-blue);
            font-weight: 500;
            margin-bottom: 10px;
            display: block;
        }

        /* Specifications Section */
        .spec-para {
            font-size: 18px;
            line-height: 1.6;
            color: #555;
        }

        .spec-para .step-num {
            width: 35px;
            height: 35px;
            background: var(--sleepsure-blue);
            color: white;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1rem;
            margin-right: 10px;
            vertical-align: middle;
        }

        /* Policy Tabs */
        .policy-tabs-container {
            display: flex;
            flex-wrap: wrap;
            font-family: sans-serif;
            color: var(--text-dark);
            border-radius: var(--border-radius-lg);
            overflow: hidden;
            margin: var(--spacing-xl) 0;
        }

        .policy-tabs-container input[type="radio"] {
            display: none;
        }

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

        .policy-tabs-container input:checked+label {
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

        .tab-content li:last-child {
            border-bottom: none;
        }

        /* FAQ Section */
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

        /* Accordion */
        .accordion-button:not(.collapsed) {
            background-color: #e6e7f8 !important;
        }

        .accordion-item {
            border: none;
            border-top: 1px solid #dcdcdc;
            background-color: transparent;
            padding: 5px 0;
        }

        .accordion-item:first-of-type {
            border-top: 1px solid #dcdcdc;
        }

        .accordion-item:last-of-type {
            border-bottom: 1px solid #dcdcdc;
        }

        .accordion-button {
            background-color: transparent;
            color: #333;
            font-weight: 400;
            font-size: 1.1rem;
            padding: 1rem 0;
            box-shadow: none !important;
        }

        .accordion-button:not(.collapsed) {
            color: #333;
            background-color: transparent;
            border-bottom: 1px solid #dcdcdc;
        }

        .accordion-body {
            padding: 1rem 0 1.5rem 0;
            color: #555;
            font-size: 0.95rem;
            line-height: 1.6;
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(5px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* =========================================== */
        /* RESPONSIVE DESIGN */
        /* =========================================== */

        @media (max-width: 768px) {
            .product-page-container {
                padding: var(--spacing-md);
                margin-top: var(--spacing-sm);
            }

            .product-view-section {
                flex-direction: column;
                gap: var(--spacing-lg);
                padding-top: 0;
            }

            .product-gallery,
            .product-details {
                width: 100%;
            }

            .thumbnails {
                flex-direction: row;
                width: 100%;
                order: 2;
                margin-top: var(--spacing-md);
            }

            .thumbnails img {
                width: 60px;
                height: 60px;
            }

            .product-gallery {
                flex-direction: column;
            }

            .main-image-container img {
                height: 350px;
            }

            .delivery-and-size {
                grid-template-columns: 1fr;
                gap: var(--spacing-lg);
            }

            .product-name {
                font-size: 1.3em;
            }

            .price-figures {
                flex-wrap: wrap;
            }

            .current-price {
                font-size: 1.5em;
            }

            .offer-card2 {
                min-width: 250px;
            }

            .reviews-slider-pointer-ul li {
                flex: 0 0 50%;
                margin-bottom: 10px;
            }

            /* Why Choose Section Mobile */
            .whychoosefeature {
                padding: 10px 0;
            }

            .whychooseheading h2 {
                font-size: 1.8rem;
            }

            .feature-item {
                padding: 20px;
                flex-direction: column;
                text-align: center;
            }

            .feature-icon {
                width: 50px;
                height: 50px;
                margin-right: 0;
                margin-bottom: 15px;
                align-self: center;
            }

            .feature-icon i {
                font-size: 1.2rem;
            }

            .feature-text h4 {
                font-size: 1.1rem;
            }

            .feature-text p {
                font-size: 0.9rem;
            }

            .feature-category {
                padding: 20px;
            }

            .category-title {
                font-size: 1.4rem;
            }

            .policy-tabs-container label {
                flex: 0 0 100%;
                border-bottom: 1px solid #ddd;
            }
        }

        @media (max-width: 480px) {
            .product-page-container {
                padding: var(--spacing-sm);
            }

            .product-name {
                font-size: 1.2em;
            }

            .rating-and-cart-info {
                flex-direction: column;
                gap: var(--spacing-sm);
            }

            .main-image-container img {
                height: 300px;
            }

            .thumbnails img {
                width: 50px;
                height: 50px;
            }

            .offer-card2 {
                min-width: 250px;
            }

            .pincode-input {
                flex-direction: column;
            }

            .pincode-input button {
                border-radius: 0 0 var(--border-radius-md) var(--border-radius-md);
            }

            /* Why Choose Section Mobile Small */
            .whychooseheading h2 {
                font-size: 1.6rem;
            }

            .whychoosefeature .small {
                font-size: 16px;
            }

            .spec-para {
                font-size: 16px;
            }

            .feature-item {
                padding: 15px;
            }

            .feature-icon {
                width: 45px;
                height: 45px;
            }

            .feature-icon i {
                font-size: 1.1rem;
            }

            .feature-text h4 {
                font-size: 1rem;
            }

            .feature-text p {
                font-size: 0.85rem;
            }
        }

        /* Show content based on checked radio */
        #tab-delivery:checked~.delivery-content,
        #tab-terms:checked~.terms-content,
        #tab-return:checked~.return-content,
        #tab-warranty:checked~.warranty-content,
        #tab-support:checked~.support-content {
            display: block;
        }
    </style>
@endpush

@push('scripts')
    <script>
        const dimensionGroups = @json($dimensionsByGroup);
        const dimensionContainer = document.getElementById('dimensionOptions');
        const thicknessContainer = document.getElementById('thicknessOptions');
        const productId = '{{ $product->product_id }}';
        const addToCartBtn = document.querySelector('.add-to-cart-btn');
        const buyNowPrimaryBtn = document.getElementById('buyNowBtn');
        const buyNowFlag = document.getElementById('buyNowFlag');
        const actionMessage = document.getElementById('actionMessage');
        const heartIcon = document.querySelector('.heart-icon');
        const wishlistAddUrl = "{{ route('wishlist.add') }}";
        const wishlistRemoveUrl = "{{ route('wishlist.remove') }}";
        const loginUrl = "{{ route('login') }}";

        // Size Guide click handler
        const learnMeasureBanner = document.querySelector('.learn-measure-banner');
        if (learnMeasureBanner) {
            learnMeasureBanner.addEventListener('click', function() {
                alert('Size Guide:\n\n• Single: Ideal for one person, kids rooms\n• Double: Comfortable for single sleepers who want extra space\n• Queen: Perfect for couples\n• King: Maximum space for families');
            });
        }

        if (heartIcon) {
            let isWishlisted = heartIcon.dataset.wishlisted === '1';
            const isAuthenticated = heartIcon.dataset.auth === '1';

            function setHeartState(active) {
                heartIcon.classList.toggle('active', active);
                heartIcon.setAttribute('aria-pressed', active ? 'true' : 'false');
                heartIcon.setAttribute('aria-label', active ? 'Remove from wishlist' : 'Add to wishlist');
            }

            setHeartState(isWishlisted);

            function toggleWishlist() {
                if (!isAuthenticated) {
                    window.location.href = loginUrl;
                    return;
                }

                heartIcon.classList.add('is-busy');
                const url = isWishlisted ? wishlistRemoveUrl : wishlistAddUrl;
                fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            product_id: productId
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (!data || data.success !== true) {
                            throw new Error('Wishlist update failed');
                        }
                        isWishlisted = !isWishlisted;
                        setHeartState(isWishlisted);
                        showActionMessage(isWishlisted ? 'Added to wishlist.' : 'Removed from wishlist.', 'success');
                    })
                    .catch(() => {
                        showActionMessage('Could not update wishlist right now.', 'error');
                    })
                    .finally(() => {
                        heartIcon.classList.remove('is-busy');
                    });
            }

            heartIcon.addEventListener('click', toggleWishlist);
            heartIcon.addEventListener('keypress', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    toggleWishlist();
                }
            });
        }

        function showActionMessage(message, type = 'info') {
            if (!actionMessage) return;
            actionMessage.textContent = message;
            actionMessage.classList.remove('error', 'success');
            if (type === 'error') actionMessage.classList.add('error');
            if (type === 'success') actionMessage.classList.add('success');
        }

        function hasValidSelection() {
            const variantId = document.getElementById('variant_id')?.value || '';
            const thicknessId = document.getElementById('thickness_id')?.value || '';
            const customLength = document.getElementById('hiddenCustomLength')?.value || '';
            const customBreadth = document.getElementById('hiddenCustomBreadth')?.value || '';
            const hasCustomSize = !!(customLength && customBreadth);
            const hasVariant = !!variantId;
            const hasThickness = !!thicknessId;
            return hasThickness && (hasVariant || hasCustomSize);
        }

        function toggleCtas(enabled) {
            [addToCartBtn, buyNowPrimaryBtn].forEach(btn => {
                if (!btn) return;
                if (enabled) {
                    btn.classList.remove('cta-disabled');
                    btn.removeAttribute('disabled');
                    btn.setAttribute('aria-disabled', 'false');
                } else {
                    btn.classList.add('cta-disabled');
                    btn.setAttribute('disabled', 'disabled');
                    btn.setAttribute('aria-disabled', 'true');
                }
            });
        }

        function updateActionButtonsState() {
            toggleCtas(hasValidSelection());
        }

        function triggerCustomPriceUpdate() {
            const sizeBtn = document.querySelector('.size-group-btn.active');
            const isCustom = sizeBtn && (sizeBtn.dataset.group || '').toLowerCase() === 'custom';
            if (!isCustom) return;

            const customLength = document.getElementById('customLength')?.value;
            const customBreadth = document.getElementById('customBreadth')?.value;

            updateActionButtonsState();

            let thicknessBtn = null;
            if (thicknessContainer) {
                thicknessBtn = Array.from(thicknessContainer.querySelectorAll('.dimension-btn')).find(btn => btn.classList
                    .contains('active'));
            }

            if (!customLength || !customBreadth || !thicknessBtn) return;

            const thicknessId = thicknessBtn.dataset.thicknessId;
            const productId = '{{ $product->product_id }}';

            // Set hidden fields for custom size
            document.getElementById('hiddenCustomLength').value = customLength;
            document.getElementById('hiddenCustomBreadth').value = customBreadth;

            updateProductPrice('', thicknessId, productId);
        }

        ['input', 'change'].forEach(evt => {
            document.getElementById('customLength')?.addEventListener(evt, triggerCustomPriceUpdate);
            document.getElementById('customBreadth')?.addEventListener(evt, triggerCustomPriceUpdate);
        });

        thicknessContainer?.querySelectorAll('.dimension-btn')
            .forEach(btn => {
                btn.addEventListener('click', triggerCustomPriceUpdate);
            });

        document.addEventListener('DOMContentLoaded', function() {
            const tabButtons = document.querySelectorAll('.tab-button');
            const tabContents = document.querySelectorAll('.tab-content');

            // Quantity controls
            const qtyInput = document.getElementById('quantityInput');
            const qtyMinus = document.getElementById('qtyMinus');
            const qtyPlus = document.getElementById('qtyPlus');
            const hiddenQuantity = document.getElementById('hiddenQuantity');

            if (qtyInput && qtyMinus && qtyPlus && hiddenQuantity) {
                qtyMinus.addEventListener('click', function() {
                    let val = parseInt(qtyInput.value, 10) || 1;
                    if (val > 1) {
                        qtyInput.value = val - 1;
                        hiddenQuantity.value = qtyInput.value;
                    }
                });

                qtyPlus.addEventListener('click', function() {
                    let val = parseInt(qtyInput.value, 10) || 1;
                    qtyInput.value = val + 1;
                    hiddenQuantity.value = qtyInput.value;
                });

                qtyInput.addEventListener('input', function() {
                    hiddenQuantity.value = qtyInput.value;
                });
            }

            // Buy Now functionality
            const buyNowBtn = document.getElementById('buyNowBtn');
            const addToCartForm = document.getElementById('addToCartForm');
            if (buyNowBtn && addToCartForm) {
                buyNowBtn.addEventListener('click', function() {
                    if (!hasValidSelection()) {
                        showActionMessage('Please select size and thickness before buying.', 'error');
                        updateActionButtonsState();
                        return;
                    }
                    // Sync form fields before submission
                    syncFormFields();
                    if (buyNowFlag) {
                        buyNowFlag.value = '1';
                    }
                    showActionMessage('Redirecting to checkout...', 'success');
                    addToCartForm.submit();
                });
            }

            if (addToCartBtn) {
                addToCartBtn.addEventListener('click', function() {
                    if (buyNowFlag) {
                        buyNowFlag.value = '0';
                    }
                });
            }

            // Form synchronization function
            function syncFormFields() {
                if (hiddenQuantity && qtyInput) {
                    hiddenQuantity.value = qtyInput.value;
                }
                // Sync variant and thickness IDs
                const variantId = document.getElementById('variant_id');
                const thicknessId = document.getElementById('thickness_id');
                const formVariantId = document.getElementById('formVariantId');
                const formThicknessId = document.getElementById('formThicknessId');
                const formProductPrice = document.getElementById('formProductPrice');
                const hiddenProductPrice = document.getElementById('hiddenProductPrice');
                const hiddenCustomLength = document.getElementById('hiddenCustomLength');
                const hiddenCustomBreadth = document.getElementById('hiddenCustomBreadth');

                const isCustomSize = !!(hiddenCustomLength?.value && hiddenCustomBreadth?.value);

                // If not custom, refresh hidden fields from the currently active buttons
                if (!isCustomSize) {
                    const activeDimension = dimensionContainer?.querySelector('.dimension-btn.active');
                    const activeThickness = thicknessContainer?.querySelector('.dimension-btn.active');
                    if (activeDimension && variantId) {
                        variantId.value = activeDimension.dataset.variantId || '';
                    }
                    if (activeThickness && thicknessId) {
                        thicknessId.value = activeThickness.dataset.thicknessId || '';
                    }
                }

                if (variantId && formVariantId) {
                    formVariantId.value = variantId.value;
                }
                if (thicknessId && formThicknessId) {
                    formThicknessId.value = thicknessId.value;
                }
                if (hiddenProductPrice && formProductPrice) {
                    formProductPrice.value = hiddenProductPrice.value;
                }
            }

            // Ensure form fields are synced before form submit
            if (addToCartForm) {
                addToCartForm.addEventListener('submit', function(e) {
                    if (!hasValidSelection()) {
                        e.preventDefault();
                        showActionMessage('Please select size and thickness before adding to cart.',
                            'error');
                        updateActionButtonsState();
                        return;
                    }
                    syncFormFields();
                    showActionMessage('Product added to cart!', 'success');
                });
            }

            const checkBtn = document.getElementById('checkDeliveryBtn');
            const pincodeInput = document.getElementById('deliveryPincode');
            const deliveryResult = document.getElementById('deliveryResult');
            if (checkBtn && pincodeInput && deliveryResult) {
                checkBtn.addEventListener('click', function() {
                    const pincode = pincodeInput.value.trim();
                    if (!/^[0-9]{6}$/.test(pincode)) {
                        deliveryResult.textContent = 'Please enter a valid 6-digit pincode.';
                        deliveryResult.style.color = 'red';
                        return;
                    }
                    deliveryResult.textContent = 'Checking...';
                    deliveryResult.style.color = '#333';
                    fetch("{{ route('product.checkDelivery') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]')
                                    .getAttribute('content'),
                            },
                            body: JSON.stringify({
                                pincode
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            deliveryResult.textContent = data.message;
                            deliveryResult.style.color = data.success ? 'green' : 'red';
                        })
                        .catch(() => {
                            deliveryResult.textContent = 'Error checking delivery.';
                            deliveryResult.style.color = 'red';
                        });
                });
            }

            tabButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const targetTab = this.getAttribute('data-tab');

                    tabButtons.forEach(btn => btn.classList.remove('active'));
                    tabContents.forEach(content => content.classList.remove('active'));

                    this.classList.add('active');
                    document.getElementById(targetTab).classList.add('active');
                });
            });

            const openVariantModal = document.getElementById('openVariantModal');
            const variantModal = document.getElementById('variantModal');
            const closeVariantModal = document.getElementById('closeVariantModal');

            if (openVariantModal && variantModal) {
                openVariantModal.addEventListener('click', function() {
                    variantModal.classList.add('active');
                });
            }

            if (closeVariantModal && variantModal) {
                closeVariantModal.addEventListener('click', function() {
                    variantModal.classList.remove('active');
                });

                variantModal.addEventListener('click', function(e) {
                    if (e.target === variantModal) {
                        variantModal.classList.remove('active');
                    }
                });
            }

            const sizeGroupBtns = document.querySelectorAll('.size-group-btn');
            const customBtn = document.getElementById('customSizeBtn');
            const customInputs = document.getElementById('customSizeInputs');
            const dimensionOptions = document.getElementById('dimensionOptions');
            const getDimensionBtns = () => Array.from(dimensionContainer ? dimensionContainer.querySelectorAll(
                '.dimension-btn') : []);
            const getThicknessBtns = () => Array.from(thicknessContainer ? thicknessContainer.querySelectorAll(
                '.dimension-btn') : []);

            function findGroupByVariant(variantId) {
                if (!variantId) return null;
                const target = String(variantId);
                for (const [groupName, dims] of Object.entries(dimensionGroups || {})) {
                    for (const dimName of Object.keys(dims || {})) {
                        const thicknesses = dims[dimName] || {};
                        for (const t of Object.values(thicknesses)) {
                            if (String(t.variant_id) === target) return groupName;
                        }
                    }
                }
                return null;
            }

            function markThicknessActive(thicknessId) {
                const buttons = getThicknessBtns();
                buttons.forEach(b => b.classList.remove('active'));
                const match = buttons.find(b => b.dataset.thicknessId === String(thicknessId));
                const targetBtn = match || buttons[0];
                if (!targetBtn) return;
                targetBtn.classList.add('active');
                const thicknessInput = document.getElementById('thickness_id');
                const formThicknessInput = document.getElementById('formThicknessId');
                if (thicknessInput) {
                    thicknessInput.value = targetBtn.dataset.thicknessId || '';
                    if (formThicknessInput) {
                        formThicknessInput.value = thicknessInput.value;
                    }
                }
            }

            function renderDimensionsForGroup(groupName, preferredVariantId = '') {
                if (!dimensionContainer) return;
                const groupData = dimensionGroups[groupName] || {};
                const buttonsHtml = Object.keys(groupData).map(dimName => {
                    const thicknesses = groupData[dimName] || {};
                    const firstThickness = Object.values(thicknesses)[0] || {};
                    return `<button type="button" class="dimension-btn" data-variant-id="${firstThickness.variant_id || ''}" data-dimension="${dimName}">${dimName}</button>`;
                }).join('');
                dimensionContainer.innerHTML = buttonsHtml;
                const newBtns = getDimensionBtns();
                if (newBtns.length) {
                    let activeBtn = null;
                    if (preferredVariantId) {
                        activeBtn = newBtns.find(btn => btn.dataset.variantId === String(preferredVariantId));
                    }
                    if (!activeBtn) {
                        activeBtn = newBtns[0];
                    }
                    activeBtn.classList.add('active');
                    const variantInput = document.getElementById('variant_id');
                    const formVariantInput = document.getElementById('formVariantId');
                    if (variantInput) {
                        variantInput.value = activeBtn.dataset.variantId || '';
                        if (formVariantInput) formVariantInput.value = variantInput.value;
                    }
                }
                wireDimensionClicks();
            }

            function activateSizeGroup(groupName, preferredVariantId = '') {
                if (!groupName) return;
                sizeGroupBtns.forEach(b => b.classList.remove('active'));
                const normalized = String(groupName).toLowerCase();
                const btn = Array.from(sizeGroupBtns).find(b => (b.dataset.group || '').toLowerCase() ===
                    normalized) || (normalized === 'custom' ? customBtn : null);
                if (btn) {
                    btn.classList.add('active');
                }
                const isCustom = normalized === 'custom';
                if (isCustom) {
                    customInputs.style.display = 'block';
                    if (dimensionOptions) dimensionOptions.style.display = 'none';
                    const variantInput = document.getElementById('variant_id');
                    const formVariantInput = document.getElementById('formVariantId');
                    if (variantInput) {
                        variantInput.value = '';
                        if (formVariantInput) formVariantInput.value = '';
                    }
                    document.getElementById('hiddenCustomLength').value = '';
                    document.getElementById('hiddenCustomBreadth').value = '';
                } else {
                    customInputs.style.display = 'none';
                    if (dimensionOptions) dimensionOptions.style.display = '';
                    renderDimensionsForGroup(groupName, preferredVariantId);
                }
                updateActionButtonsState();
            }

            sizeGroupBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const groupName = this.dataset.group;
                    activateSizeGroup(groupName);
                    triggerRealtimePriceUpdate();
                });
            });

            function getSelectedVariantAndThickness() {
                const dimensionBtn = getDimensionBtns().find(b => b.classList.contains('active'));
                const thicknessBtn = getThicknessBtns().find(b => b.classList.contains('active'));
                const sizeGroupBtn = Array.from(sizeGroupBtns).find(b => b.classList.contains('active'));
                return {
                    variantId: dimensionBtn ? dimensionBtn.dataset.variantId : '',
                    thicknessId: thicknessBtn ? thicknessBtn.dataset.thicknessId : '',
                    sizeGroup: sizeGroupBtn ? sizeGroupBtn.textContent.trim() : ''
                };
            }

            function triggerRealtimePriceUpdate() {
                const ids = getSelectedVariantAndThickness();
                const sizeBtn = document.querySelector('.size-group-btn.active');
                const isCustom = sizeBtn && ((sizeBtn.dataset.group || '').toLowerCase() === 'custom');

                // Custom path: use height/width + thickness
                if (isCustom) {
                    triggerCustomPriceUpdate();
                    return;
                }

                // Standard path: variant + thickness
                if (ids.variantId && ids.thicknessId) {
                    updateProductPrice(ids.variantId, ids.thicknessId, '{{ $product->product_id }}');
                }
            }

            function wireDimensionClicks() {
                getDimensionBtns().forEach(btn => {
                    btn.addEventListener('click', function() {
                        this.parentElement.querySelectorAll('.dimension-btn').forEach(b => b
                            .classList.remove('active'));
                        this.classList.add('active');
                        const variantInput = document.getElementById('variant_id');
                        const formVariantInput = document.getElementById('formVariantId');
                        if (variantInput) {
                            variantInput.value = this.dataset.variantId || '';
                            if (formVariantInput) {
                                formVariantInput.value = variantInput.value;
                            }
                        }
                        updateActionButtonsState();
                        triggerRealtimePriceUpdate();
                    });
                });
            }

            function wireThicknessClicks() {
                getThicknessBtns().forEach(btn => {
                    btn.addEventListener('click', function() {
                        this.parentElement.querySelectorAll('.dimension-btn').forEach(b => b
                            .classList.remove('active'));
                        this.classList.add('active');
                        const thicknessInput = document.getElementById('thickness_id');
                        const formThicknessInput = document.getElementById('formThicknessId');
                        if (thicknessInput) {
                            thicknessInput.value = this.dataset.thicknessId || '';
                            if (formThicknessInput) {
                                formThicknessInput.value = thicknessInput.value;
                            }
                        }
                        updateActionButtonsState();
                        triggerRealtimePriceUpdate();
                    });
                });
            }

            wireDimensionClicks();
            wireThicknessClicks();


            const confirmVariantBtn = document.querySelector('.confirm-variant-btn');



            confirmVariantBtn.addEventListener('click', function() {
                const sizeBtn = document.querySelector('.size-group-btn.active');
                const isCustom = sizeBtn && ((sizeBtn.dataset.group || '').toLowerCase() === 'custom');
                if (isCustom) {
                    const customLength = document.getElementById('customLength').value;
                    const customBreadth = document.getElementById('customBreadth').value;
                    const thicknessBtn = Array.from(thicknessContainer ? thicknessContainer
                        .querySelectorAll('.dimension-btn') : []).find(b => b.classList.contains(
                        'active'));
                    if (!customLength || !customBreadth) {
                        alert('Please enter both length and breadth for custom size.');
                        return;
                    }
                    if (!thicknessBtn) {
                        alert('Please select thickness.');
                        return;
                    }
                    document.getElementById('variant_id').value = '';
                    document.getElementById('thickness_id').value = thicknessBtn.dataset.thicknessId || '';
                    document.getElementById('hiddenCustomLength').value = customLength;
                    document.getElementById('hiddenCustomBreadth').value = customBreadth;
                    document.getElementById('formVariantId').value = '';
                    document.getElementById('formThicknessId').value = thicknessBtn.dataset.thicknessId ||
                        '';
                    // Update both display locations
                    const customText = `Custom: ${customLength} x ${customBreadth}`;
                    const displayDropdown = document.getElementById('selectedSizeDisplayDropdown');
                    const displayTop = document.getElementById('selectedSizeDisplayTop');
                    if (displayDropdown) displayDropdown.textContent = customText;
                    if (displayTop) displayTop.textContent = customText;
                    updateActionButtonsState();
                    showActionMessage('Custom size selected. Please proceed to add to cart.', 'success');
                    variantModal.classList.remove('active');
                    return;
                }

                const dimensionBtns = dimensionContainer ? dimensionContainer.querySelectorAll(
                    '.dimension-btn') : [];
                const thicknessBtns = thicknessContainer ? thicknessContainer.querySelectorAll(
                    '.dimension-btn') : [];
                const dimensionBtn = Array.from(dimensionBtns).find(b => b.classList.contains('active'));
                const thicknessBtn = Array.from(thicknessBtns).find(b => b.classList.contains('active'));
                if (!sizeBtn || !dimensionBtn || !thicknessBtn) {
                    alert('Please select size and thickness');
                    return;
                }
                const selectedSize = sizeBtn.textContent.trim();
                const selectedDimension = dimensionBtn.textContent.trim();
                const selectedThickness = thicknessBtn.textContent.trim();

                const variantId = dimensionBtn ? dimensionBtn.dataset.variantId : '';
                const thicknessId = thicknessBtn.dataset.thicknessId;

                document.getElementById('variant_id').value = variantId;
                document.getElementById('thickness_id').value = thicknessId;
                document.getElementById('hiddenCustomLength').value = '';
                document.getElementById('hiddenCustomBreadth').value = '';
                document.getElementById('formVariantId').value = variantId;
                document.getElementById('formThicknessId').value = thicknessId;
                // Update both display locations
                const displayDropdown = document.getElementById('selectedSizeDisplayDropdown');
                const displayTop = document.getElementById('selectedSizeDisplayTop');
                const displayText = `${selectedSize} | ${selectedDimension} x ${selectedThickness}`;
                if (displayDropdown) displayDropdown.textContent = displayText;
                if (displayTop) displayTop.textContent = displayText;
                variantModal.classList.remove('active');

                const productId = '{{ $product->product_id }}';
                updateProductPrice(variantId, thicknessId, productId);
                updateActionButtonsState();
                showActionMessage('Size selected. You can proceed to add to cart.', 'success');
            });


            const thumbnails = document.querySelectorAll('.thumbnails img');
            const mainImage = document.getElementById('mainImage');

            thumbnails.forEach(thumb => {
                thumb.addEventListener('click', function() {
                    thumbnails.forEach(t => t.classList.remove('active'));
                    this.classList.add('active');

                    const newImage = this.getAttribute('data-image');
                    if (mainImage && newImage) {
                        mainImage.src = newImage;
                    }
                });
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const defaultVariantId = '{{ $product->default_variant_id ?? '' }}';
            const defaultThicknessId = '{{ $product->default_thickness_id ?? '' }}';

            const initialGroup = findGroupByVariant(defaultVariantId) || (sizeGroupBtns[0]?.dataset.group || '');
            if (initialGroup) {
                activateSizeGroup(initialGroup, defaultVariantId);
            }
            markThicknessActive(defaultThicknessId);

            updateActionButtonsState();
        });

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
                        const formattedPrice = data.price ?? '';
                        const numericPrice = (typeof data.price_value !== 'undefined') ? data.price_value :
                            formattedPrice;
                        // Update both main and modal price displays
                        document.getElementById('mainProductPrice').textContent = formattedPrice;
                        document.getElementById('hiddenProductPrice').value = numericPrice;
                        var modalPrice = document.getElementById('modalProductPrice');
                        if (modalPrice) modalPrice.textContent = formattedPrice;
                    } else {
                        document.getElementById('mainProductPrice').textContent = 'N/A';
                        document.getElementById('hiddenProductPrice').value = '';
                        var modalPrice = document.getElementById('modalProductPrice');
                        if (modalPrice) modalPrice.textContent = 'N/A';
                        alert(data.message);
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert('Error fetching price');
                });
        }

        // Add Bootstrap accordion functionality
        document.addEventListener('DOMContentLoaded', function() {
            const accordionItems = document.querySelectorAll('.accordion-item');

            accordionItems.forEach(item => {
                const header = item.querySelector('.accordion-header button');
                const collapse = item.querySelector('.accordion-collapse');

                if (header && collapse) {
                    header.addEventListener('click', function() {
                        const isExpanded = this.getAttribute('aria-expanded') === 'true';

                        // Close all other accordion items
                        accordionItems.forEach(otherItem => {
                            if (otherItem !== item) {
                                const otherHeader = otherItem.querySelector(
                                    '.accordion-header button');
                                const otherCollapse = otherItem.querySelector(
                                    '.accordion-collapse');

                                if (otherHeader && otherCollapse) {
                                    otherHeader.setAttribute('aria-expanded', 'false');
                                    otherHeader.classList.add('collapsed');
                                    otherCollapse.classList.remove('show');
                                }
                            }
                        });

                        // Toggle current item
                        this.setAttribute('aria-expanded', !isExpanded);
                        this.classList.toggle('collapsed');
                        collapse.classList.toggle('show');
                    });
                }
            });
        });
    </script>
@endpush
