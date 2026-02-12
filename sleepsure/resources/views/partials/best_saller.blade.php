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
                                    <p>({{ $product['size'] }})</p>
                                    <p>({{ $product['size_cm'] }})</p>
                                    <div class="price-group">
                                                <span class="price">{{ $product['price'] ?? 0 }}</span>
                                                @if($product['discount_percent'] > 0)
                                                <span class="discount">{{ $product['discount_percent'] }}% off</span>
                                                @endif
                                            </div>
                                        </div>
                                        @if(!empty($product['variant_id']) && !empty($product['thickness_id']))
                                        <form class="add-to-cart-form" action="{{ route('cart.add') }}" method="POST" style="height:100%;display:flex;align-items:center;">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product['product_id'] }}">
                                            <input type="hidden" name="variant_id" value="{{ $product['variant_id'] }}">
                                            <input type="hidden" name="thickness_id" value="{{ $product['thickness_id'] }}">
                                            <input type="hidden" name="quantity" value="1">
                                            <input type="hidden" name="price" value="{{ $product['price_value'] ?? 0 }}">
                                            <button type="submit" class="buy" aria-label="Add to cart" style="border:0;">
                                                <i class="fa-solid fa-cart-shopping"></i>
                                            </button>
                                        </form>
                                        @else
                                        <a class="buy" href="{{ route('product.details', ['id' => $product['product_id']]) }}" aria-label="View details to select options">
                                            <i class="fa-solid fa-cart-shopping"></i>
                                        </a>
                                        @endif
                                    </div>
                            <div class="right">
                                <div class="done"><i class="fa-solid fa-check"></i></div>
                                <div class="details">
                                    <h1>Added to cart</h1>
                                    <p>{{ $product['product_name'] ?? 'N/A' }}</p>
                                </div>
                                <div class="remove"><i class="fa-solid fa-xmark"></i></div>
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