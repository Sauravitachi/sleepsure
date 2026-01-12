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
                                                                               <span class="price">{{ $product['price'] ?? 0 }}</span>

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