@extends('layouts.app')

@section('title', 'Premium Mattress & Sleep Solutions')

@section('content')

<!-- Breadcrumb -->
    <section class="breadcrumb">
        <div class="container breadcrumb-container">
            <a href="#">Home</a>
            <span>/</span>
            <a href="#">Cart</a>
            <span>/</span>
            <span>Checkout</span>
        </div>
    </section>

    <!-- Checkout Section -->
    <section class="checkout-section">
        <div class="container-fluid">
            <h1 class="checkout-title">
                <i class="fas fa-shopping-bag"></i> Checkout
            </h1>

            <div class="checkout-container">
                <div class="checkout-form">
                    <!-- Shipping Information -->
                    <div class="form-section">
                        <h2 class="section-title">
                            <i class="fas fa-truck"></i> Shipping Information
                        </h2>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="firstName">First Name</label>
                                <input type="text" id="firstName" placeholder="Enter your first name">
                            </div>
                            <div class="form-group">
                                <label for="lastName">Last Name</label>
                                <input type="text" id="lastName" placeholder="Enter your last name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" id="email" placeholder="Enter your email">
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="tel" id="phone" placeholder="Enter your phone number">
                        </div>
                        <div class="form-group">
                            <label for="address">Street Address</label>
                            <input type="text" id="address" placeholder="Enter your street address">
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="city">City</label>
                                <input type="text" id="city" placeholder="Enter your city">
                            </div>
                            <div class="form-group">
                                <label for="state">State</label>
                                <select id="state">
                                    <option value="">Select State</option>
                                    <option value="CA">California</option>
                                    <option value="TX">Texas</option>
                                    <option value="NY">New York</option>
                                    <option value="FL">Florida</option>
                                    <option value="IL">Illinois</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="zipCode">ZIP Code</label>
                                <input type="text" id="zipCode" placeholder="Enter ZIP code">
                            </div>
                            <div class="form-group">
                                <label for="country">Country</label>
                                <select id="country">
                                    <option value="US">United States</option>
                                    <option value="CA">Canada</option>
                                    <option value="UK">United Kingdom</option>
                                </select>
                            </div>
                        </div>
                        <div class="checkbox-group">
                            <input type="checkbox" id="saveAddress">
                            <label for="saveAddress">Save this address for future orders</label>
                        </div>
                    </div>

                    <!-- Shipping Method -->
                    <div class="form-section">
                        <h2 class="section-title">
                            <i class="fas fa-shipping-fast"></i> Shipping Method
                        </h2>
                        <div class="form-group">
                            <div class="checkbox-group">
                                <input type="radio" id="standardShipping" name="shipping" checked>
                                <label for="standardShipping">Standard Shipping (5-7 business days) - FREE</label>
                            </div>
                            <div class="checkbox-group">
                                <input type="radio" id="expressShipping" name="shipping">
                                <label for="expressShipping">Express Shipping (2-3 business days) - ₹1,249</label>
                            </div>
                            <div class="checkbox-group">
                                <input type="radio" id="overnightShipping" name="shipping">
                                <label for="overnightShipping">Overnight Shipping (1 business day) - ₹1,249</label>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="form-section">
                        <h2 class="section-title">
                            <i class="fas fa-credit-card"></i> Payment Method
                        </h2>
                        <div class="payment-methods">
                            <div class="payment-method active" data-method="card">
                                <div class="payment-icon">
                                    <i class="far fa-credit-card"></i>
                                </div>
                                <div>Credit Card</div>
                            </div>
                            <div class="payment-method" data-method="paypal">
                                <div class="payment-icon">
                                    <i class="fab fa-paypal"></i>
                                </div>
                                <div>PayPal</div>
                            </div>
                            <div class="payment-method" data-method="apple">
                                <div class="payment-icon">
                                    <i class="fab fa-apple-pay"></i>
                                </div>
                                <div>Apple Pay</div>
                            </div>
                        </div>

                        <!-- Card Details -->
                        <div class="card-details active" id="cardDetails">
                            <div class="form-group">
                                <label for="cardNumber">Card Number</label>
                                <input type="text" id="cardNumber" placeholder="1234 5678 9012 3456">
                            </div>
                            <div class="card-row">
                                <div class="form-group">
                                    <label for="expiryDate">Expiry Date</label>
                                    <input type="text" id="expiryDate" placeholder="MM/YY">
                                </div>
                                <div class="form-group">
                                    <label for="cvv">CVV</label>
                                    <input type="text" id="cvv" placeholder="123">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="cardName">Name on Card</label>
                                <input type="text" id="cardName" placeholder="Enter name as shown on card">
                            </div>
                            <div class="checkbox-group">
                                <input type="checkbox" id="saveCard">
                                <label for="saveCard">Save this card for future purchases</label>
                            </div>
                        </div>
                    </div>

                    <!-- Billing Address -->
                    <div class="form-section">
                        <h2 class="section-title">
                            <i class="fas fa-file-invoice-dollar"></i> Billing Address
                        </h2>
                        <div class="checkbox-group">
                            <input type="checkbox" id="sameAsShipping" checked>
                            <label for="sameAsShipping">Same as shipping address</label>
                        </div>
                        <div id="billingAddress" style="display: none;">
                            <!-- Billing address fields would go here -->
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="order-summary">
                    <h2 class="summary-title">Order Summary</h2>
                    <div class="order-items">
                        <div class="order-item">
                            <div class="order-item-image">
                                <img src="assets/images/4.jpg" alt="SleepSure Premium Mattress">
                            </div>
                            <div class="order-item-details">
                                <h3 class="order-item-name">SleepSure Premium Hybrid Mattress</h3>
                                <p class="order-item-size">Size: Queen</p>
                                <p class="order-item-price">₹5,249</p>
                            </div>
                        </div>
                        <div class="order-item">
                            <div class="order-item-image">
                                <img src="assets/images/13.jpg" alt="SleepSure Memory Foam Pillow">
                            </div>
                            <div class="order-item-details">
                                <h3 class="order-item-name">SleepSure Memory Foam Pillow</h3>
                                <p class="order-item-size">Size: Standard</p>
                                <p class="order-item-price">₹5,249 × 2</p>
                            </div>
                        </div>
                        <div class="order-item">
                            <div class="order-item-image">
                                <img src="assets/images/Comfy Mattress .jpg" alt="SleepSure Cooling Mattress Protector">
                            </div>
                            <div class="order-item-details">
                                <h3 class="order-item-name">SleepSure Cooling Mattress Protector</h3>
                                <p class="order-item-size">Size: Queen</p>
                                <p class="order-item-price">₹5,249</p>
                            </div>
                        </div>
                    </div>
                    <div class="summary-row">
                        <span>Subtotal (3 items)</span>
                        <span>₹21,249</span>
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
                        <span class="amount">₹21,749</span>
                    </div>
                    <button class="place-order-btn" id="placeOrderBtn">
                        <i class="fas fa-lock"></i> Place Your Order
                    </button>
                    <div class="secure-checkout">
                        <i class="fas fa-shield-alt"></i> Secure checkout - 256-bit SSL encryption
                    </div>
                </div>
            </div>
        </div>
    </section>
    
@endsection