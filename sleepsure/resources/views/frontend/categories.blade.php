@extends('layouts.app')

@section('title', 'All Categories - Premium Mattress & Sleep Solutions')

@section('content')

<style>
    /* Filter Toggle Button - Mobile */
    .filter-toggle {
        display: none;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1rem;
        color: white;
        border: none;
        cursor: pointer;
        font-size: 1rem;
        font-weight: 500;
        border-radius: 4px;
    }

    .filter-header {
        display: none;
        justify-content: space-between;
        align-items: center;
        padding: 1rem;
        border-bottom: 1px solid #e0e0e0;
    }

    .close-filter {
        background: none;
        border: none;
        cursor: pointer;
        color: #666;
    }

    /* Mobile Styles */
    @media (max-width: 992px) {
        .filter-toggle {
            display: flex;
        }

        .filter-sidebar {
            position: fixed;
            left: -100%;
            top: 0;
            height: 100vh;
            z-index: 1001;
            transition: left 0.3s ease;
            overflow-y: auto;
            background: white;
        }

        .filter-sidebar.active {
            left: 0;
        }

        .filter-header {
            display: flex;
        }

        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            display: none;
        }

        .sidebar-overlay.active {
            display: block;
        }
    }

    /* Center empty state message */
    .products-grid {
        min-height: 400px;
    }

    .empty-state {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        min-height: 400px;
        grid-column: 1 / -1;
    }

    .empty-state p {
        font-size: 18px;
        color: #666;
        text-align: center;
    }
</style>

<!-- Main Content -->
<div class="container-fluid">
    <div class="sidebar-container" style="display: flex;">
        <!-- Filter Sidebar -->
        <aside class="filter-sidebar" id="filterSidebar">
            <div class="filter-header">
                <h2>Filter Products</h2>
                <button class="close-filter" id="closeFilter">
                    <span class="material-icons">close</span>
                </button>
            </div>

            <form id="filterForm" method="GET" action="{{ route('categories.index') }}">
                <div class="filter-group">
                    <h3>Categories</h3>
                    <div class="filter-options">
                        @foreach($categories->take(5) as $category)
                        <div class="filter-option">
                            <input type="checkbox" 
                                   name="categories[]" 
                                   id="category-{{ $category->category_id }}" 
                                   value="{{ $category->category_id }}"
                                   {{ in_array($category->category_id, (array)request('categories', [])) ? 'checked' : '' }}>
                            <label for="category-{{ $category->category_id }}">{{ $category->category_name }}</label>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="filter-group">
                    <h3>Price Range</h3>
                    <div class="slidecontainer">
                        <input type="range" 
                               name="price_max" 
                               min="1000" 
                               max="100000" 
                               value="{{ request('price_max', 100000) }}" 
                               class="slider" 
                               id="myRange">
                        <p>Max: ₹<span id="priceValue">{{ request('price_max', 100000) }}</span></p>
                    </div>
                </div>

                <div class="filter-group">
                    <h3>Size</h3>
                    <div class="filter-options">
                        @php
                        $sizes = ['Single', 'Twin', 'Full', 'Queen', 'King', 'California King'];
                        @endphp
                        @foreach($sizes as $size)
                        <div class="filter-option">
                            <input type="checkbox" 
                                   name="sizes[]" 
                                   id="size-{{ $loop->index }}" 
                                   value="{{ $size }}"
                                   {{ in_array($size, (array)request('sizes', [])) ? 'checked' : '' }}>
                            <label for="size-{{ $loop->index }}">{{ $size }}</label>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="filter-group">
                    <h3>Firmness</h3>
                    <div class="filter-options">
                        @php
                        $firmness = ['Soft', 'Medium', 'Firm'];
                        @endphp
                        @foreach($firmness as $firm)
                        <div class="filter-option">
                            <input type="checkbox" 
                                   name="firmness[]" 
                                   id="firmness-{{ $loop->index }}" 
                                   value="{{ $firm }}"
                                   {{ in_array($firm, (array)request('firmness', [])) ? 'checked' : '' }}>
                            <label for="firmness-{{ $loop->index }}">{{ $firm }}</label>
                        </div>
                        @endforeach
                    </div>
                </div>

                <button type="submit" class="apply-filters">Apply Filters</button>
                <!-- Hidden sort input to preserve sort parameter -->
                <input type="hidden" name="sort" id="sortInput" value="{{ request('sort', 'featured') }}">
            </form>
        </aside>

        <!-- Products Section -->
        <section class="products-section">
            <div class="filter-tab"
                style="display: flex;justify-content: flex-end;align-items: center;box-shadow: var(--shadow-light);">
                <div class="sort-bar">
                    <div class="sort-options">
                        <label for="sort" style="font-size: 12px;">Sort by:</label>
                        <select id="sort" name="sort" onchange="this.form.submit()">
                            <option value="featured" {{ request('sort') == 'featured' ? 'selected' : '' }}>Featured</option>
                            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                            <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Customer Rating</option>
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                        </select>
                    </div>
                </div>
                <div class="filter-toggle mobile-only" id="filterToggle">
                    <span class="material-icons">filter_list</span>
                </div>
            </div>

            <div class="products-grid">
                @forelse($products as $product)
                <!-- Product {{ $loop->iteration }} -->
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
                                        <span class="price">₹{{ number_format($product['variant_price'] ?? 0) }}</span>
                                        @if($product['discount_percent'] > 0)
                                        <span class="discount">{{ $product['discount_percent'] }}% off</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="buy"><i class="fa-solid fa-cart-shopping"></i></div>
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
                <div class="empty-state">
                    <p>No products found matching your criteria.</p>
                </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($paginatedProducts->hasPages())
            <div class="pagination">
                {{-- Previous Page Link --}}
                @if ($paginatedProducts->onFirstPage())
                    <span class="disabled">← Previous</span>
                @else
                    <a href="{{ $paginatedProducts->previousPageUrl() }}">← Previous</a>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($paginatedProducts->getUrlRange(1, $paginatedProducts->lastPage()) as $page => $url)
                    @if ($page == $paginatedProducts->currentPage())
                        <a href="#" class="active">{{ $page }}</a>
                    @else
                        <a href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($paginatedProducts->hasMorePages())
                    <a href="{{ $paginatedProducts->nextPageUrl() }}">Next →</a>
                @else
                    <span class="disabled">Next →</span>
                @endif
            </div>
            @endif
        </section>
    </div>
</div>

<script>
    // Filter Sidebar Toggle for Mobile
    document.addEventListener('DOMContentLoaded', function () {
        const filterToggle = document.getElementById('filterToggle');
        const filterSidebar = document.getElementById('filterSidebar');
        const closeFilter = document.getElementById('closeFilter');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        // Open filter sidebar
        if (filterToggle) {
            filterToggle.addEventListener('click', function () {
                filterSidebar.classList.add('active');
                if (sidebarOverlay) {
                    sidebarOverlay.classList.add('active');
                }
            });
        }

        // Close filter sidebar
        if (closeFilter) {
            closeFilter.addEventListener('click', function () {
                filterSidebar.classList.remove('active');
                if (sidebarOverlay) {
                    sidebarOverlay.classList.remove('active');
                }
            });
        }

        // Close on overlay click
        if (sidebarOverlay) {
            sidebarOverlay.addEventListener('click', function () {
                filterSidebar.classList.remove('active');
                sidebarOverlay.classList.remove('active');
            });
        }

        // Price range slider
        const priceSlider = document.getElementById('myRange');
        const priceValue = document.getElementById('priceValue');
        
        if (priceSlider && priceValue) {
            priceSlider.addEventListener('input', function() {
                priceValue.textContent = this.value;
            });
        }

        // Auto-submit sort form
        const sortSelect = document.getElementById('sort');
        if (sortSelect) {
            sortSelect.addEventListener('change', function() {
                // Get current URL params
                const url = new URL(window.location.href);
                url.searchParams.set('sort', this.value);
                window.location.href = url.toString();
            });
        }
    });
</script>

@endsection
