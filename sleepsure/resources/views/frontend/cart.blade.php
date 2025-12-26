@extends('layouts.app')

@section('title', 'Premium Mattress & Sleep Solutions')

@section('content')

 <!-- Breadcrumb -->
    <section class="breadcrumb">
        <div class="container breadcrumb-container">
            <a href="#">Home</a>
            <span>/</span>
            <a href="#">Mattresses</a>
            <span>/</span>
            <span>Your Cart</span>
        </div>
    </section>

    <!-- Cart Section -->
    <section class="cart-section">
        <div class="container">
            <h1 class="cart-title">
                <i class="fas fa-shopping-cart"></i> Your Shopping Cart
            </h1>

            <div class="cart-container">
                <div class="cart-items">
                    <div class="cart-item">
                        <div class="item-image">
                            <img src="assets/images/4.jpg"
                                alt="SleepSure Premium Mattress">
                        </div>
                        <div class="item-details">
                            <h3 class="item-name">SleepSure Premium Hybrid Mattress</h3>
                            <p class="item-size">Size: Queen</p>
                            <p class="item-price">₹5,249</p>
                            <div class="item-actions">
                                <div class="quantity-selector">
                                    <button class="quantity-btn">-</button>
                                    <input type="text" class="quantity-input" value="1">
                                    <button class="quantity-btn">+</button>
                                </div>
                                <button class="remove-btn">
                                    <i class="fas fa-trash"></i> Remove
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="cart-item">
                        <div class="item-image">
                            <img src="assets/images/13.jpg"
                                alt="SleepSure Memory Foam Pillow">
                        </div>
                        <div class="item-details">
                            <h3 class="item-name">SleepSure Memory Foam Pillow</h3>
                            <p class="item-size">Size: Standard</p>
                            <p class="item-price">₹5,249</p>
                            <div class="item-actions">
                                <div class="quantity-selector">
                                    <button class="quantity-btn">-</button>
                                    <input type="text" class="quantity-input" value="2">
                                    <button class="quantity-btn">+</button>
                                </div>
                                <button class="remove-btn">
                                    <i class="fas fa-trash"></i> Remove
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="cart-item">
                        <div class="item-image">
                            <img src="assets/images/Comfy Mattress .jpg"
                                alt="SleepSure Cooling Mattress Protector">
                        </div>
                        <div class="item-details">
                            <h3 class="item-name">SleepSure Cooling Mattress Protector</h3>
                            <p class="item-size">Size: Queen</p>
                            <p class="item-price">₹5,249</p>
                            <div class="item-actions">
                                <div class="quantity-selector">
                                    <button class="quantity-btn">-</button>
                                    <input type="text" class="quantity-input" value="1">
                                    <button class="quantity-btn">+</button>
                                </div>
                                <button class="remove-btn">
                                    <i class="fas fa-trash"></i> Remove
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="cart-summary">
                    <h2 class="summary-title">Order Summary</h2>
                    <div class="summary-row">
                        <span>Subtotal (3 items)</span>
                        <span>₹15,647</span>
                    </div>
                    <div class="summary-row">
                        <span>Shipping</span>
                        <span>FREE</span>
                    </div>
                    <div class="summary-row">
                        <span>Tax</span>
                        <span>₹500</span>
                    </div>
                    <div class="summary-row summary-total">
                        <span>Total</span>
                        <span class="amount">₹16,247</span>
                    </div>
                   
                    <a href="checkout.html" class="checkout-btn">
                        <i class="fas fa-lock"></i>Proceed to checkout
                    </a>
                    <a href="index.html" class="continue-shopping">
                        <i class="fas fa-arrow-left"></i> Continue Shopping
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Recently Viewed Section -->
    <section class="recently-viewed">
        <div class="container">
            <h2 class="section-title">You Might Also Like</h2>
            <div class="featured-products">
                <div class="section-header">
                    <h2>Featured Products</h2>
                    <a href="#" class="view-all">View All</a>
                </div>
                <div class="slider-container">



                    <!-- CARD 1 -->
                    <div class="wrapper">
                        <div class="container">
                            <div class="top" style="background-image:url('assets/images/4.jpg')">
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
                                    <div class="done"><i class="material-icons">done</i></div>
                                    <div class="details">
                                        <h1>Added to cart</h1>
                                        <p>Ortho Memory</p>
                                    </div>
                                    <div class="remove"><i class="material-icons">clear</i></div>
                                </div>
                            </div>
                        </div>
                        <div class="inside">
                            <div class="icon"><i class="material-icons">info_outline</i></div>
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

                    <!-- CARD 2 -->
                    <div class="wrapper">
                        <div class="container">
                            <div class="top" style="background-image:url('assets/images/13.jpg')">
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
                                    <div class="done"><i class="material-icons">done</i></div>
                                    <div class="details">
                                        <h1>Added to cart</h1>
                                        <p>Ortho Memory</p>
                                    </div>
                                    <div class="remove"><i class="material-icons">clear</i></div>
                                </div>
                            </div>
                        </div>
                        <div class="inside">
                            <div class="icon"><i class="material-icons">info_outline</i></div>
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

                    <!-- CARD 3 -->
                    <div class="wrapper">
                        <div class="container">
                            <div class="top" style="background-image:url('assets/images/Thrill\ Mattress\ .jpg')">
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
                                    <div class="done"><i class="material-icons">done</i></div>
                                    <div class="details">
                                        <h1>Added to cart</h1>
                                        <p>Ortho Memory</p>
                                    </div>
                                    <div class="remove"><i class="material-icons">clear</i></div>
                                </div>
                            </div>
                        </div>
                        <div class="inside">
                            <div class="icon"><i class="material-icons">info_outline</i></div>
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

                    <!-- CARD 4 -->
                    <div class="wrapper">
                        <div class="container">
                            <div class="top" style="background-image:url('assets/images/Pride\ Mattress\ .jpg')">
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
                                    <div class="done"><i class="material-icons">done</i></div>
                                    <div class="details">
                                        <h1>Added to cart</h1>
                                        <p>Ortho Memory</p>
                                    </div>
                                    <div class="remove"><i class="material-icons">clear</i></div>
                                </div>
                            </div>
                        </div>
                        <div class="inside">
                            <div class="icon"><i class="material-icons">info_outline</i></div>
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

                    <!-- CARD 5 -->
                    <div class="wrapper">
                        <div class="container">
                            <div class="top" style="background-image:url('assets/images/Prestige\ Mattress\ .jpg')">
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
                                    <div class="done"><i class="material-icons">done</i></div>
                                    <div class="details">
                                        <h1>Added to cart</h1>
                                        <p>Ortho Memory</p>
                                    </div>
                                    <div class="remove"><i class="material-icons">clear</i></div>
                                </div>
                            </div>
                        </div>
                        <div class="inside">
                            <div class="icon"><i class="material-icons">info_outline</i></div>
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

                </div>
            </div>
        </div>
    </section>

@endsection