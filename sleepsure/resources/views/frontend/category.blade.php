@extends('layouts.app')

@section('title', 'Premium Mattress & Sleep Solutions')

@section('content')

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

                <div class="filter-group">
                    <h3>Categories</h3>
                    <div class="filter-options">
                        <div class="filter-option">
                            <input type="checkbox" id="category-1" checked>
                            <label for="category-1">Mattress</label>
                        </div>
                        <div class="filter-option">
                            <input type="checkbox" id="category-2" checked>
                            <label for="category-2">Pillow</label>
                        </div>
                        <div class="filter-option">
                            <input type="checkbox" id="category-3" checked>
                            <label for="category-3">Comforter</label>
                        </div>
                        <div class="filter-option">
                            <input type="checkbox" id="category-4">
                            <label for="category-4">Protector</label>
                        </div>

                    </div>
                </div>

                <div class="filter-group">
                    <h3>Price Range</h3>
                    <div class="slidecontainer">
                        <input type="range" min="1" max="100" value="50" class="slider" id="myRange">
                    </div>
                </div>

                <div class="filter-group">
                    <h3>Size</h3>
                    <div class="filter-options">
                        <div class="filter-option">
                            <input type="checkbox" id="size-1" checked>
                            <label for="size-1">Twin</label>
                        </div>
                        <div class="filter-option">
                            <input type="checkbox" id="size-2" checked>
                            <label for="size-2">Full</label>
                        </div>
                        <div class="filter-option">
                            <input type="checkbox" id="size-3" checked>
                            <label for="size-3">Queen</label>
                        </div>
                        <div class="filter-option">
                            <input type="checkbox" id="size-4">
                            <label for="size-4">King</label>
                        </div>
                        <div class="filter-option">
                            <input type="checkbox" id="size-5">
                            <label for="size-5">California King</label>
                        </div>
                    </div>
                </div>

                <div class="filter-group">
                    <h3>Firmness</h3>
                    <div class="filter-options">
                        <div class="filter-option">
                            <input type="checkbox" id="firmness-1" checked>
                            <label for="firmness-1">Soft</label>
                        </div>
                        <div class="filter-option">
                            <input type="checkbox" id="firmness-2" checked>
                            <label for="firmness-2">Medium</label>
                        </div>
                        <div class="filter-option">
                            <input type="checkbox" id="firmness-3">
                            <label for="firmness-3">Firm</label>
                        </div>
                    </div>
                </div>

                <button class="apply-filters">Apply Filters</button>
            </aside>

            <!-- Products Section -->
            <section class="products-section">
                <div class="filter-tab"
                    style="display: flex;justify-content: flex-end;align-items: center;box-shadow: var(--shadow-light);">
                    <div class="sort-bar">
                        <!-- <div class="results-count">Sort by :</div> -->
                        <div class="sort-options">
                            <label for="sort" style="font-size: 12px; ">Sort by:</label>
                            <select id="sort">
                                <option>Featured</option>
                                <option>Price: Low to High</option>
                                <option>Price: High to Low</option>
                                <option>Customer Rating</option>
                                <option>Newest</option>
                                <option>Newest</option>
                            </select>
                        </div>

                    </div>
                    <div class="filter-toggle mobile-only" id="filterToggle">
                        <span class="material-icons">filter_list</span>

                    </div>
                </div>

                <div class="products-grid">
                    <!-- Product 1 -->
                    <div class="wrapper">
                        <div class="container">
                            <div class="top"
                                style="background-image:url('https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80')">
                                <div class="rating-badge">4.5 <i class="fa-solid fa-star"></i></div>
                                <button class="wishlist-icon"><span>♡</span></button>
                            </div>
                            <div class="bottom">
                                <div class="left">
                                    <div class="details">
                                        <h1>Ortho Memory</h1>
                                        <p>(72X60X6 Inch)</p>
                                        <p>(1829X1524X153 mm)</p>
                                        <div class="price-group">
                                            <span class="price">₹5,249</span>
                                            <span class="discount">58% off</span>
                                        </div>
                                    </div>
                                    <div class="buy"><i class="fa-solid fa-cart-shopping"></i></div>
                                </div>
                                <div class="right">
                                    <div class="done"><i class="fa-solid fa-check"></i></div>
                                    <div class="details">
                                        <h1>Added to cart</h1>
                                        <p>Ortho Memory</p>
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
                                        <td>Mattress</td>
                                        <td>Orthopedic</td>
                                    </tr>
                                    <tr>
                                        <th>Size</th>
                                        <th>Thickness</th>
                                    </tr>
                                    <tr>
                                        <td>72x60 Inch</td>
                                        <td>6 Inch</td>
                                    </tr>
                                    <tr>
                                        <th>Warranty</th>
                                        <th>Material</th>
                                    </tr>
                                    <tr>
                                        <td>5 Years</td>
                                        <td>Memory Foam</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Product 2 -->
                    <div class="wrapper">
                        <div class="container">
                            <div class="top"
                                style="background-image:url('https://images.unsplash.com/photo-1541123356219-284ebe5adb8c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80')">
                                <div class="rating-badge">4.7 <i class="fa-solid fa-star"></i></div>
                                <button class="wishlist-icon"><span>♡</span></button>
                            </div>
                            <div class="bottom">
                                <div class="left">
                                    <div class="details">
                                        <h1>Hybrid Comfort</h1>
                                        <p>(78X60X8 Inch)</p>
                                        <p>(1981X1524X203 mm)</p>
                                        <div class="price-group">
                                            <span class="price">₹8,499</span>
                                            <span class="discount">42% off</span>
                                        </div>
                                    </div>
                                    <div class="buy"><i class="fa-solid fa-cart-shopping"></i></div>
                                </div>
                                <div class="right">
                                    <div class="done"><i class="fa-solid fa-check"></i></div>
                                    <div class="details">
                                        <h1>Added to cart</h1>
                                        <p>Hybrid Comfort</p>
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
                                        <td>Mattress</td>
                                        <td>Hybrid</td>
                                    </tr>
                                    <tr>
                                        <th>Size</th>
                                        <th>Thickness</th>
                                    </tr>
                                    <tr>
                                        <td>78x60 Inch</td>
                                        <td>8 Inch</td>
                                    </tr>
                                    <tr>
                                        <th>Warranty</th>
                                        <th>Material</th>
                                    </tr>
                                    <tr>
                                        <td>10 Years</td>
                                        <td>Memory Foam + Springs</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Product 3 -->
                    <div class="wrapper">
                        <div class="container">
                            <div class="top"
                                style="background-image:url('https://images.unsplash.com/photo-1616627547581-4c000edfa5dc?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80')">
                                <div class="rating-badge">4.3 <i class="fa-solid fa-star"></i></div>
                                <button class="wishlist-icon"><span>♡</span></button>
                            </div>
                            <div class="bottom">
                                <div class="left">
                                    <div class="details">
                                        <h1>Latex Bliss</h1>
                                        <p>(72X60X7 Inch)</p>
                                        <p>(1829X1524X178 mm)</p>
                                        <div class="price-group">
                                            <span class="price">₹12,999</span>
                                            <span class="discount">35% off</span>
                                        </div>
                                    </div>
                                    <div class="buy"><i class="fa-solid fa-cart-shopping"></i></div>
                                </div>
                                <div class="right">
                                    <div class="done"><i class="fa-solid fa-check"></i></div>
                                    <div class="details">
                                        <h1>Added to cart</h1>
                                        <p>Latex Bliss</p>
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
                                        <td>Mattress</td>
                                        <td>Latex</td>
                                    </tr>
                                    <tr>
                                        <th>Size</th>
                                        <th>Thickness</th>
                                    </tr>
                                    <tr>
                                        <td>72x60 Inch</td>
                                        <td>7 Inch</td>
                                    </tr>
                                    <tr>
                                        <th>Warranty</th>
                                        <th>Material</th>
                                    </tr>
                                    <tr>
                                        <td>15 Years</td>
                                        <td>Natural Latex</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Product 4 -->
                    <div class="wrapper">
                        <div class="container">
                            <div class="top"
                                style="background-image:url('https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80')">
                                <div class="rating-badge">4.8 <i class="fa-solid fa-star"></i></div>
                                <button class="wishlist-icon"><span>♡</span></button>
                            </div>
                            <div class="bottom">
                                <div class="left">
                                    <div class="details">
                                        <h1>Cool Gel Pro</h1>
                                        <p>(78X60X10 Inch)</p>
                                        <p>(1981X1524X254 mm)</p>
                                        <div class="price-group">
                                            <span class="price">₹15,499</span>
                                            <span class="discount">30% off</span>
                                        </div>
                                    </div>
                                    <div class="buy"><i class="fa-solid fa-cart-shopping"></i></div>
                                </div>
                                <div class="right">
                                    <div class="done"><i class="fa-solid fa-check"></i></div>
                                    <div class="details">
                                        <h1>Added to cart</h1>
                                        <p>Cool Gel Pro</p>
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
                                        <td>Mattress</td>
                                        <td>Memory Foam</td>
                                    </tr>
                                    <tr>
                                        <th>Size</th>
                                        <th>Thickness</th>
                                    </tr>
                                    <tr>
                                        <td>78x60 Inch</td>
                                        <td>10 Inch</td>
                                    </tr>
                                    <tr>
                                        <th>Warranty</th>
                                        <th>Material</th>
                                    </tr>
                                    <tr>
                                        <td>12 Years</td>
                                        <td>Gel Memory Foam</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Product 5 -->
                    <div class="wrapper">
                        <div class="container">
                            <div class="top"
                                style="background-image:url('https://images.unsplash.com/photo-1616627547581-4c000edfa5dc?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80')">
                                <div class="rating-badge">4.6 <i class="fa-solid fa-star"></i></div>
                                <button class="wishlist-icon"><span>♡</span></button>
                            </div>
                            <div class="bottom">
                                <div class="left">
                                    <div class="details">
                                        <h1>Spring Deluxe</h1>
                                        <p>(72X60X8 Inch)</p>
                                        <p>(1829X1524X203 mm)</p>
                                        <div class="price-group">
                                            <span class="price">₹6,799</span>
                                            <span class="discount">45% off</span>
                                        </div>
                                    </div>
                                    <div class="buy"><i class="fa-solid fa-cart-shopping"></i></div>
                                </div>
                                <div class="right">
                                    <div class="done"><i class="fa-solid fa-check"></i></div>
                                    <div class="details">
                                        <h1>Added to cart</h1>
                                        <p>Spring Deluxe</p>
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
                                        <td>Mattress</td>
                                        <td>Innerspring</td>
                                    </tr>
                                    <tr>
                                        <th>Size</th>
                                        <th>Thickness</th>
                                    </tr>
                                    <tr>
                                        <td>72x60 Inch</td>
                                        <td>8 Inch</td>
                                    </tr>
                                    <tr>
                                        <th>Warranty</th>
                                        <th>Material</th>
                                    </tr>
                                    <tr>
                                        <td>8 Years</td>
                                        <td>Pocket Springs</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Product 6 -->
                    <div class="wrapper">
                        <div class="container">
                            <div class="top"
                                style="background-image:url('https://images.unsplash.com/photo-1541123356219-284ebe5adb8c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80')">
                                <div class="rating-badge">4.9 <i class="fa-solid fa-star"></i></div>
                                <button class="wishlist-icon"><span>♡</span></button>
                            </div>
                            <div class="bottom">
                                <div class="left">
                                    <div class="details">
                                        <h1>Adjustable Base</h1>
                                        <p>(78X60X12 Inch)</p>
                                        <p>(1981X1524X305 mm)</p>
                                        <div class="price-group">
                                            <span class="price">₹22,999</span>
                                            <span class="discount">25% off</span>
                                        </div>
                                    </div>
                                    <div class="buy"><i class="fa-solid fa-cart-shopping"></i></div>
                                </div>
                                <div class="right">
                                    <div class="done"><i class="fa-solid fa-check"></i></div>
                                    <div class="details">
                                        <h1>Added to cart</h1>
                                        <p>Adjustable Base</p>
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
                                        <td>Mattress</td>
                                        <td>Adjustable</td>
                                    </tr>
                                    <tr>
                                        <th>Size</th>
                                        <th>Thickness</th>
                                    </tr>
                                    <tr>
                                        <td>78x60 Inch</td>
                                        <td>12 Inch</td>
                                    </tr>
                                    <tr>
                                        <th>Warranty</th>
                                        <th>Material</th>
                                    </tr>
                                    <tr>
                                        <td>15 Years</td>
                                        <td>Multi-layer Foam</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pagination -->
                <div class="pagination">
                    <a href="#" class="active">1</a>
                    <a href="#">2</a>
                    <a href="#">3</a>
                    <a href="#">4</a>
                    <a href="#">Next →</a>
                </div>
            </section>
        </div>
    </div>

    <script>
        // Filter Sidebar Toggle for Mobile
        document.addEventListener('DOMContentLoaded', function () {
            const filterToggle = document.getElementById('filterToggle');
            const filterSidebar = document.getElementById('filterSidebar');
            const closeFilter = document.getElementById('closeFilter');
            const filterOverlay = document.createElement('div');

            // Create overlay
            filterOverlay.className = 'filter-overlay';
            document.body.appendChild(filterOverlay);

            // Open filter sidebar
            if (filterToggle) {
                filterToggle.addEventListener('click', function () {
                    filterSidebar.classList.add('active');
                    filterOverlay.classList.add('active');
                    document.body.style.overflow = 'hidden';
                });
            }

            // Close filter sidebar
            if (closeFilter) {
                closeFilter.addEventListener('click', function () {
                    filterSidebar.classList.remove('active');
                    filterOverlay.classList.remove('active');
                    document.body.style.overflow = 'auto';
                });
            }

            // Close when clicking overlay
            filterOverlay.addEventListener('click', function () {
                filterSidebar.classList.remove('active');
                filterOverlay.classList.remove('active');
                document.body.style.overflow = 'auto';
            });

            // Close with Escape key
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape' && filterSidebar.classList.contains('active')) {
                    filterSidebar.classList.remove('active');
                    filterOverlay.classList.remove('active');
                    document.body.style.overflow = 'auto';
                }
            });
        });
    </script>
    
@endsection