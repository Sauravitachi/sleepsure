@extends('layouts.app')

@section('title', 'Premium Mattress & Sleep Solutions')

@section('content')

<div class="product-page-container">
        <section class="product-view-section">
            <div class="product-gallery">
                <div class="thumbnails">
                    <img src="{{ $product->image_url }}" alt="{{ $product->product_name }}" class="active" data-image="{{ $product->image_url }}">
                </div>
                <div class="main-image-container">
                    <img src="{{ $product->image_url }}"
                        alt="{{ $product->product_name }}" id="mainImage">
                </div>
            </div>

            <div class="product-details">
                <h1 class="product-name">{{ $product->product_name ?? 'Product' }}</h1>
                <p class="product-variant-info">
                    <span id="selectedSizeDisplayTop">
                        {{ $product->variant_full_display.'  Warranty' }}
                    </span>
                </p>
                
                {{-- @if($product?->description)
                <div class="product-description">
                    <p>{{ $product?->description }}</p>
                </div>
                @endif --}}

                <div class="rating-and-cart-info">
                    <span class="rating-stars">{{ $product->review }} ★</span>
                    <span class="cart-info">{{ $product->total_reviewers }} reviews</span>
                </div>

                <div class="price-section">
                    @if($product->onsale)
                    <div>
                        <span class="sale-badge">SALE</span>
                    </div>
                    @endif
                    <div class="price-figures">
                        <span class="current-price" id="mainProductPrice">{{ $product->price ?? 0 }}</span>
                        @if($product->onsale && $product->onsale_price)
                            <span class="old-price" id="mainOldPrice">{{ $product->price }}</span>
                            <span class="discount-percent">
                                @if($product->original_price > 0)
                                    {{ round((($product->original_price - $product->discount_price) / $product->original_price) * 100) }}%
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
                                @if(!empty($product->default_variant) && $product->default_variant !== 'N/A')
                                    {{ $product->default_variant }}
                                @else
                                    Select Size & Thickness
                                @endif
                            </span>
                        </div>
                    </div>
                </div>

                <form action="{{ route('cart.add') }}" method="POST">
                    @csrf

                    <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                    <input type="hidden" name="variant_id" id="variant_id" value="{{ $product->default_variant_id ?? '' }}">
                    <input type="hidden" name="thickness_id" id="thickness_id" value="{{ $product->default_thickness_id ?? '' }}">
                    <input type="hidden" name="quantity" value="1">
                    <input type="hidden" name="price" id="hiddenProductPrice" value="{{ $product->price }}">

                    <button type="submit" class="add-to-cart-btn">
                        Add to Cart
                    </button>
                </form>


                <div class="save-extra-section">
                    <h2>Save with Offers</h2>
                    <div class="offers-container">
                        <div class="offers-track">
                            <div class="offer-card2">
                                <div class="offer-content">
                                    <div class="bank-logo">
                                        <i class="fas fa-credit-card"></i>
                                        HDFC Bank
                                    </div>
                                    <div class="offer-detail">
                                        <div class="lowest-price">Lowest price with</div>
                                        <div class="price-value">₹6,039</div>
                                    </div>
                                    <div class="offer-type">
                                        <i class="fas fa-percentage"></i>
                                        10% Instant Discount
                                    </div>
                                    <button class="view-offer-btn">Apply Now</button>
                                </div>
                            </div>
                            <div class="offer-card2">
                                <div class="offer-content">
                                    <div class="bank-logo">
                                        <i class="fas fa-mobile-alt"></i>
                                        UPI
                                    </div>
                                    <div class="offer-detail">
                                        <div class="lowest-price">UPI Special Price</div>
                                        <div class="price-value">₹6,424</div>
                                    </div>
                                    <div class="offer-type">
                                        <i class="fas fa-rupee-sign"></i>
                                        Extra ₹125 Cashback
                                    </div>
                                    <button class="view-offer-btn">Pay Now</button>
                                </div>
                            </div>
                            <div class="offer-card2">
                                <div class="offer-content">
                                    <div class="bank-logo">
                                        <i class="fas fa-chart-line"></i>
                                        EMI
                                    </div>
                                    <div class="offer-detail">
                                        <div class="lowest-price">Easy EMI Options</div>
                                        <div class="price-value">₹1,704/month</div>
                                    </div>
                                    <div class="offer-type">
                                        <i class="fas fa-calendar-alt"></i>
                                        3 months • No Cost EMI
                                    </div>
                                    <button class="view-offer-btn">View Plans</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <hr>

        <section class="product-detail-section">
            <h2 class="section-title">Product Details</h2>
            <div class="detail-tabs">
                @if($product->description)
                <button class="tab-button active" data-tab="description">Description</button>
                <button class="tab-button" data-tab="specifications">Specifications</button>
                @else
                <button class="tab-button active" data-tab="specifications">Specifications</button>
                @endif
                <button class="tab-button" data-tab="dimensions">Dimensions</button>
                <button class="tab-button" data-tab="policies">Policies</button>
            </div>

            @if($product->description)
            <div class="tab-content active" id="description">
                <div class="detail-grid">
                    <div class="detail-item" style="grid-column: 1 / -1;">
                        <div class="text-content">
                            <p>{!! nl2br(e($product->description)) !!}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <div class="tab-content @if(!$product->description) active @endif" id="specifications">
                <div class="detail-grid">
                    <div class="detail-item">
                        <div class="icon-box"><i class="fas fa-bed"></i></div>
                        <div class="text-content">
                            <h3>Mattress Feel</h3>
                            <p>Medium Firm - Perfect balance of comfort and orthopedic support. Recommended by sleep
                                experts for back pain relief.</p>
                        </div>
                    </div>
                    <div class="detail-item">
                        <div class="icon-box"><i class="fas fa-palette"></i></div>
                        <div class="text-content">
                            <h3>Cover Material</h3>
                            <p>AeroTex Knit Fabric (Space Grey) - Breathable, hypoallergenic, and removable with zipper
                                for easy washing.</p>
                        </div>
                    </div>
                    <div class="detail-item">
                        <div class="icon-box"><i class="fas fa-shield-alt"></i></div>
                        <div class="text-content">
                            <h3>Warranty</h3>
                            <p>{{ $product->warranty_text }} Comprehensive Warranty against manufacturing defects. Easy claim process with
                                dedicated support.</p>
                        </div>
                    </div>
                    <div class="detail-item">
                        <div class="icon-box"><i class="fas fa-layer-group"></i></div>
                        <div class="text-content">
                            <h3>Category & Type</h3>
                            <p>{{ $product->category ?? 'Mattress' }}@if($product->thickness) | Thickness: {{ $product->thickness }}@endif</p>
                        </div>
                    </div>
                    <div class="detail-item">
   
                        <div class="icon-box"><i class="fas fa-atom"></i></div>
                        <div class="text-content">
                            <h3>Material Technology</h3>
                            <p>@if($product->material){{ $product->material }} - @endif{{ $product->product_name }}. High quality construction that
                                won't sag over time.</p>
                        </div>
                    </div>
                    <div class="detail-item">
                        <div class="icon-box"><i class="fas fa-wind"></i></div>
                        <div class="text-content">
                            <h3>Breathability</h3>
                            <p>Advanced air circulation system with gel-infused memory foam to keep you cool throughout
                                the night.</p>
                        </div>
                    </div>
                    <div class="detail-item">
                        <div class="icon-box"><i class="fas fa-balance-scale"></i></div>
                        <div class="text-content">
                            <h3>Weight Distribution</h3>
                            <p>5-zone support system for optimal weight distribution and spinal alignment. Reduces
                                pressure points.</p>
                        </div>
                    </div>
                    
                    @if($product->specification)
                    <div class="detail-item" style="grid-column: 1 / -1;">
                        <div class="icon-box"><i class="fas fa-list"></i></div>
                        <div class="text-content">
                            <h3>Additional Specifications</h3>
                            <div>{!! $product->specification !!}</div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <div class="tab-content" id="dimensions">
                <div class="detail-grid">
                    @if($product->size)
                    <div class="detail-item">
                        <div class="icon-box"><i class="fas fa-ruler"></i></div>
                        <div class="text-content">
                            <h3>Size</h3>
                            <p>{{ $product->size }} - Available for your comfort needs.</p>
                        </div>
                    </div>
                    @endif
                    <div class="detail-item">
                        <div class="icon-box"><i class="fas fa-ruler-combined"></i></div>
                        <div class="text-content">
                            <h3>Available Sizes</h3>
                            <p>Multiple size options available. Choose the perfect fit for your bedroom.</p>
                        </div>
                    </div>
                    <div class="detail-item">
                        <div class="icon-box"><i class="fas fa-ruler-horizontal"></i></div>
                        <div class="text-content">
                            <h3>King Size</h3>
                            <p>78" x 72" x 6" (198cm x 183cm x 15cm) - Maximum sleeping space for ultimate comfort and
                                movement.</p>
                        </div>
                    </div>
                    <div class="detail-item">
                        <div class="icon-box"><i class="fas fa-weight"></i></div>
                        <div class="text-content">
                            <h3>Weight Capacity</h3>
                            <p>Single: 300 lbs | Queen: 500 lbs | King: 600 lbs. Designed for long-lasting durability
                                and support.</p>
                        </div>
                    </div>
                    <div class="detail-item">
                        <div class="icon-box"><i class="fas fa-box"></i></div>
                        <div class="text-content">
                            <h3>Packaged Size</h3>
                            <p>Roll-packed and compressed to 1/3 original size for easy transportation and setup.
                                Expands in 48 hours.</p>
                        </div>
                    </div>
                    <div class="detail-item">
                        <div class="icon-box"><i class="fas fa-couch"></i></div>
                        <div class="text-content">
                            <h3>Bed Frame Compatibility</h3>
                            <p>Compatible with all standard bed frames, platform beds, and adjustable bases. No box
                                spring required.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-content" id="policies">
                <div class="detail-grid">
                    <div class="detail-item">
                        <div class="icon-box"><i class="fas fa-truck"></i></div>
                        <div class="text-content">
                            <h3>Delivery Policy</h3>
                            <p>Free shipping across India. Delivery within 3-7 business days. White-glove delivery
                                service available in metro cities.</p>
                        </div>
                    </div>
                    <div class="detail-item">
                        <div class="icon-box"><i class="fas fa-undo"></i></div>
                        <div class="text-content">
                            <h3>Return Policy</h3>
                            <p>100-night risk-free trial. Full refund if not satisfied. Free pickup for returns. No
                                questions asked policy.</p>
                        </div>
                    </div>
                    <div class="detail-item">
                        <div class="icon-box"><i class="fas fa-tools"></i></div>
                        <div class="text-content">
                            <h3>Warranty Claim</h3>
                            <p>10-year warranty against manufacturing defects. Online claim process with 48-hour
                                response time.</p>
                        </div>
                    </div>
                    <div class="detail-item">
                        <div class="icon-box"><i class="fas fa-headset"></i></div>
                        <div class="text-content">
                            <h3>Customer Support</h3>
                            <p>24/7 customer support via phone, email, and chat. Dedicated sleep experts to assist with
                                any queries.</p>
                        </div>
                    </div>
                    <div class="detail-item">
                        <div class="icon-box"><i class="fas fa-credit-card"></i></div>
                        <div class="text-content">
                            <h3>Payment Options</h3>
                            <p>All major credit/debit cards, UPI, net banking, EMI options, and cash on delivery
                                available.</p>
                        </div>
                    </div>
                    <div class="detail-item">
                        <div class="icon-box"><i class="fas fa-leaf"></i></div>
                        <div class="text-content">
                            <h3>Sustainability</h3>
                            <p>Eco-friendly manufacturing process. CertiPUR-US certified foams. Recyclable packaging
                                materials.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <hr>

        <section class="reviews-section">
            <h2 class="section-title">Customer Reviews</h2>
            <div class="review-summary-panel">
                <div class="summary-left">
                    <div class="overall-rating">
                        @php
                            $avgReview = is_numeric($product->review) ? (float)$product->review : 0.0;
                        @endphp
                        {{ number_format($avgReview, 1) }}
                    </div>
                    <div class="star-row">
                        @for ($i = 1; $i <= 5; $i++)
                            <i class="fa fa-star{{ $i <= round($avgReview) ? '' : '-o' }}" style="color: #ffc107;"></i>
                        @endfor
                    </div>
                    <div class="rating-info">Based on {{ $product->total_reviewers }} reviews</div>
                </div>
                <div class="summary-right">
                    @php
                        $total = max(1, $product->total_reviewers);
                        $breakdown = [5=>0,4=>0,3=>0,2=>0,1=>0];
                        foreach($productModel->reviews as $r) { $breakdown[$r->rate] = ($breakdown[$r->rate] ?? 0) + 1; }
                    @endphp
                    @foreach([5,4,3,2,1] as $star)
                        <div class="rating-breakdown-row">
                            <span class="star-label">{{ $star }} <i class="fa fa-star" style="color:#ffc107;"></i></span>
                            <div class="progress-bar-bg">
                                <div class="progress-bar-fill" style="width:{{ ($breakdown[$star] ?? 0) / $total * 100 }}%"></div>
                            </div>
                            <span class="count">{{ $breakdown[$star] ?? 0 }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <h3 class="customer-media-title">Customer Photos</h3>
            <div class="customer-media-carousel">
                <!-- TODO: Dynamically load customer images from reviews with media -->
                <img src="assets/images/4.jpg" alt="Customer photo">
                <img src="assets/images/13.jpg" alt="Customer photo">
                <img src="assets/images/Comfy Mattress .jpg" alt="Customer photo">
            </div>

            <!-- Review Submission Form (to be enhanced in next step) -->
            @php
                $user = auth()->user();
                $alreadyReviewed = false;
                if ($user) {
                    $alreadyReviewed = $productModel->reviews->where('reviewer_id', $user->id)->count() > 0;
                }
            @endphp
            @if(!$user)
                <div class="review-form-container" style="margin: 30px 0;">
                    <div style="color: #d9534f; font-weight: 500;">Please <a href="{{ route('login') }}">sign in</a> to submit a review.</div>
                </div>
            @elseif($alreadyReviewed)
                <div class="review-form-container" style="margin: 30px 0;">
                    <div style="color: #28a745; font-weight: 500;">You have already submitted a review for this product. Thank you!</div>
                </div>
            @else
                <div class="review-form-container" style="margin: 30px 0;">
                    @include('frontend.partials.review_form', ['product' => $product])
                </div>
            @endif

            <!-- Display Product Reviews -->
            @include('frontend.partials.product_reviews', ['productModel' => $productModel])
        </section>
    </div>

    <!-- Variant Selection Modal -->
    <div class="modal-overlay" id="variantModal">
        <div class="modal-content">
            <button class="modal-close-btn" id="closeVariantModal">&times;</button>
            <h2 class="modal-title">Choose Your Size</h2>

                <div class="modal-product-header">
                    <img src="{{ $product->image_url }}"
                        alt="{{ $product->product_name }}" class="modal-thumbnail">
                    <div>
                        <div class="modal-product-name">{{ $product->product_name }}</div>
                        <div class="current-price" id="modalProductPrice">{{ $product->price ?? 0 }}</div>
                    </div>
                </div>

            <div class="learn-measure-banner">
                <i class="fas fa-ruler-combined"></i> Not sure about size? Learn how to measure
            </div>

            <div class="size-selection-group">
                <h3>Size Group</h3>
                <div class="size-group-options">
                    <button class="size-group-btn">Single</button>
                    <button class="size-group-btn">Double</button>
                    <button class="size-group-btn">Queen</button>
                    <button class="size-group-btn">King</button>
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

            <div class="size-selection-group">
                <h3>Dimensions</h3>
                <div class="dimension-options" id="dimensionOptions">
                 @foreach($dimensionVariants as $i => $dim)
    <button class="dimension-btn{{ $i === 0 ? ' active' : '' }}" data-variant-id="{{ $dim->variant_id }}">
        {{ $dim->variant_name }}
    </button>
@endforeach
                </div>
            </div>

            <div class="size-selection-group">
                <h3>Thickness</h3>
                <div class="dimension-options">
               @foreach($thicknessVariants as $i => $thick)
                    <button
                        class="dimension-btn {{ $i === 0 ? 'active' : '' }}"
                        data-thickness-id="{{ $thick->id }}"
                    >
                        {{ $thick->thick }}{{ $thick->map ? ' ' . $thick->map : '' }}
                    </button>
                    @endforeach

                </div>
            </div>

            <button class="confirm-variant-btn">Confirm Selection</button>
                    <input type="hidden" name="custom_length" id="hiddenCustomLength" />
                    <input type="hidden" name="custom_breadth" id="hiddenCustomBreadth" />
        </div>
    </div>

@endsection

@push('scripts')
<script>

    function triggerCustomPriceUpdate() {
        const customLength = document.getElementById('customLength')?.value;
        const customBreadth = document.getElementById('customBreadth')?.value;

        let thicknessBtn = null;
        const thicknessGroups = document.querySelectorAll('.dimension-options');
        if (thicknessGroups.length > 1) {
            thicknessBtn = Array.from(thicknessGroups[1].querySelectorAll('.dimension-btn')).find(btn => btn.classList.contains('active'));
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

document.querySelectorAll('.dimension-options:nth-of-type(2) .dimension-btn')
    .forEach(btn => {
        btn.addEventListener('click', triggerCustomPriceUpdate);
    });
    
    document.addEventListener('DOMContentLoaded', function() {
        const tabButtons = document.querySelectorAll('.tab-button');
        const tabContents = document.querySelectorAll('.tab-content');

        
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
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content'),
                    },
                    body: JSON.stringify({ pincode })
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
        sizeGroupBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                sizeGroupBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                if (this === customBtn) {
                    customInputs.style.display = 'block';
                    if (dimensionOptions) dimensionOptions.style.display = 'none';
                } else {
                    customInputs.style.display = 'none';
                    if (dimensionOptions) dimensionOptions.style.display = '';
                 
                    const dimensionBtnsArr = Array.from(dimensionBtns);
                    const thicknessBtnsArr = Array.from(thicknessBtns);
                    if (!dimensionBtnsArr.some(b => b.classList.contains('active')) && dimensionBtnsArr.length > 0) {
                        dimensionBtnsArr.forEach(b => b.classList.remove('active'));
                        dimensionBtnsArr[0].classList.add('active');
                    }
                    if (!thicknessBtnsArr.some(b => b.classList.contains('active')) && thicknessBtnsArr.length > 0) {
                        thicknessBtnsArr.forEach(b => b.classList.remove('active'));
                        thicknessBtnsArr[0].classList.add('active');
                    }
                    triggerRealtimePriceUpdate();
                }
            });
        });

        const dimensionBtns = document.querySelectorAll('.dimension-options')[0].querySelectorAll('.dimension-btn');
        const thicknessBtns = document.querySelectorAll('.dimension-options')[1].querySelectorAll('.dimension-btn');

        function getSelectedVariantAndThickness() {
            const dimensionBtn = Array.from(dimensionBtns).find(b => b.classList.contains('active'));
            const thicknessBtn = Array.from(thicknessBtns).find(b => b.classList.contains('active'));
            return {
                variantId: dimensionBtn ? dimensionBtn.dataset.variantId : '',
                thicknessId: thicknessBtn ? thicknessBtn.dataset.thicknessId : ''
            };
        }

        function triggerRealtimePriceUpdate() {
            const ids = getSelectedVariantAndThickness();
            if (ids.variantId && ids.thicknessId) {
                updateProductPrice(ids.variantId, ids.thicknessId, '{{ $product->product_id }}');
            }
        }

        dimensionBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                this.parentElement.querySelectorAll('.dimension-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                triggerRealtimePriceUpdate();
            });
        });
        thicknessBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                this.parentElement.querySelectorAll('.dimension-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                triggerRealtimePriceUpdate();
            });
        });


        const confirmVariantBtn = document.querySelector('.confirm-variant-btn');



        confirmVariantBtn.addEventListener('click', function () {
            const sizeBtn = document.querySelector('.size-group-btn.active');
            const isCustom = sizeBtn && sizeBtn.textContent.trim() === 'Custom';
            if (isCustom) {
                const customLength = document.getElementById('customLength').value;
                const customBreadth = document.getElementById('customBreadth').value;
                if (!customLength || !customBreadth) {
                    alert('Please enter both length and breadth for custom size.');
                    return;
                }
                document.getElementById('variant_id').value = '';
                document.getElementById('thickness_id').value = '';
                document.getElementById('hiddenCustomLength').value = customLength;
                document.getElementById('hiddenCustomBreadth').value = customBreadth;
                // Update both display locations
                const customText = `Custom: ${customLength} x ${customBreadth}`;
                const displayDropdown = document.getElementById('selectedSizeDisplayDropdown');
                const displayTop = document.getElementById('selectedSizeDisplayTop');
                if(displayDropdown) displayDropdown.textContent = customText;
                if(displayTop) displayTop.textContent = customText;
                variantModal.classList.remove('active');
                return;
            }
            
            const dimensionBtns = document.querySelectorAll('.dimension-options')[0].querySelectorAll('.dimension-btn');
            const thicknessBtns = document.querySelectorAll('.dimension-options')[1].querySelectorAll('.dimension-btn');
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
            // Update both display locations
            const displayDropdown = document.getElementById('selectedSizeDisplayDropdown');
            const displayTop = document.getElementById('selectedSizeDisplayTop');
            const displayText = `${selectedSize} | ${selectedDimension} x ${selectedThickness}`;
            if(displayDropdown) displayDropdown.textContent = displayText;
            if(displayTop) displayTop.textContent = displayText;
            variantModal.classList.remove('active');

            const productId = '{{ $product->product_id }}';
            updateProductPrice(variantId, thicknessId, productId);
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
        document.getElementById('variant_id').value = '{{ $product->default_variant_id ?? '' }}';
        document.getElementById('thickness_id').value = '{{ $product->default_thickness_id ?? '' }}';

        const defaultVariantId = '{{ $product->default_variant_id ?? '' }}';
        const defaultThicknessId = '{{ $product->default_thickness_id ?? '' }}';

        // const sizeGroupBtns = document.querySelectorAll('.size-group-btn');
        // sizeGroupBtns.forEach(btn => {
        //     if (btn.textContent.trim() === 'Single' && defaultVariantId === '72 x 36 ') {
        //         btn.classList.add('active');
        //     } else if (btn.textContent.trim() === 'Double' && defaultVariantId === '75 x 36 ') {
        //         btn.classList.add('active');
        //     } else if (btn.textContent.trim() === 'Queen' && defaultVariantId === '78 x 60 ') {
        //         btn.classList.add('active');
        //     } else if (btn.textContent.trim() === 'King' && defaultVariantId === '78 x 72 ') {
        //         btn.classList.add('active');
        //     } else if (btn.textContent.trim() === 'Custom') {
        //         btn.classList.add('active');
        //         if (customInputs) customInputs.style.display = 'block';
        //     }
        // });

        // Activate the corresponding dimension button
        const dimensionBtns = document.querySelectorAll('.dimension-options .dimension-btn');
        dimensionBtns.forEach(btn => {
            if (btn.textContent.trim() === defaultVariantId) {
                btn.classList.add('active');
            }
        });

        // Activate the corresponding thickness button
        const thicknessBtns = document.querySelectorAll('.dimension-options')[1].querySelectorAll('.dimension-btn');
        thicknessBtns.forEach(btn => {
            if (btn.textContent.trim() === defaultThicknessId) {
                btn.classList.add('active');
            }
        });
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
            // Update both main and modal price
            document.getElementById('mainProductPrice').textContent = data.price;
            document.getElementById('hiddenProductPrice').value = data.price;
            var modalPrice = document.getElementById('modalProductPrice');
            if (modalPrice) modalPrice.textContent = data.price;
        } else {
            document.getElementById('mainProductPrice').textContent = 'N/A';
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



</script>
@endpush