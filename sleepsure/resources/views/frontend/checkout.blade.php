@extends('layouts.app')

@section('title', 'Premium Mattress & Sleep Solutions')

@push('styles')
<style>
.payment-methods {
    display: flex;
    gap: 15px;
    margin-top: 10px;
}

.payment-option {
    flex: 1;
}

.payment-option input[type="radio"] {
    display: none;
}

.payment-label {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 12px 15px;
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
    background: white;
}

.payment-label:hover {
    border-color: #007bff;
    background-color: #f8f9fa;
}

.payment-option input[type="radio"]:checked + .payment-label {
    border-color: #007bff;
    background-color: #e3f2fd;
    color: #0056b3;
}

.payment-label i {
    font-size: 18px;
}

@media (max-width: 768px) {
    .payment-methods {
        flex-direction: column;
    }
}
</style>
@endpush

@section('content')

@php
    $subtotal = 0;
    $totalQuantity = 0;
    foreach ($cartItems as $item) {
        $subtotal += $item->price * $item->quantity;
        $totalQuantity += $item->quantity;
    }
    $taxRate = 0.03;
    $tax = $subtotal * $taxRate;
    $grandTotal = $subtotal + $tax;
@endphp

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
                <!-- Checkout Order Placement Form -->
                <form method="POST" action="{{ route('checkout.store') }}" class="form-section">
                    @csrf
                    <h2 class="section-title">
                        <i class="fas fa-truck"></i> Shipping Information
                    </h2>
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="form-row">
                        <div class="form-group">
                            <label for="first_name">First Name</label>
                            <input type="text" id="first_name" name="first_name" class="form-control" value="{{ old('first_name') }}">
                        </div>
                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <input type="text" id="last_name" name="last_name" class="form-control" value="{{ old('last_name') }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="customer_email">Email Address</label>
                        <input type="email" id="customer_email" name="customer_email" class="form-control" value="{{ old('customer_email') }}">
                    </div>
                    <div class="form-group">
                        <label for="customer_mobile">Phone Number</label>
                        <input type="tel" id="customer_mobile" name="customer_mobile" class="form-control" value="{{ old('customer_mobile') }}">
                    </div>
                    <div class="form-group">
                        <label for="customer_address_line_1">Street Address</label>
                        <input type="text" id="customer_address_line_1" name="customer_address_line_1" class="form-control" value="{{ old('customer_address_line_1') }}">
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="ship_city">City</label>
                            <input type="text" id="ship_city" name="ship_city" class="form-control" value="{{ old('ship_city') }}">
                        </div>
                        <div class="form-group">
                            <label for="ship_state">State</label>
                            <input type="text" id="ship_state" name="ship_state" class="form-control" value="{{ old('ship_state') }}">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="ship_zip">ZIP Code</label>
                            <input type="text" id="ship_zip" name="ship_zip" class="form-control" value="{{ old('ship_zip') }}">
                        </div>
                        <div class="form-group">
                            <label for="country">Country</label>
                            <input type="text" id="country" name="country" class="form-control" value="{{ old('country') }}">
                        </div>
                    </div>
                    
                    <!-- Payment Method Selection -->
                    <div class="form-group">
                        <label class="form-label">Payment Method</label>
                        <div class="payment-methods">
                            <div class="payment-option">
                                <input type="radio" id="cod" name="payment_method" value="COD" checked>
                                <label for="cod" class="payment-label">
                                    <i class="fas fa-money-bill"></i>
                                    Cash on Delivery
                                </label>
                            </div>
                            <div class="payment-option">
                                <input type="radio" id="razorpay" name="payment_method" value="razorpay">
                                <label for="razorpay" class="payment-label">
                                    <i class="fas fa-credit-card"></i>
                                    Pay Online (Razorpay)
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Hidden fields -->
                    <input type="hidden" name="delivery_method" value="1">
                    <input type="hidden" name="total_amount" value="{{ $grandTotal }}">
                    
                    <!-- Add cart items as hidden fields -->
                    @foreach($cartItems as $item)
                        <input type="hidden" name="cart[{{ $loop->index }}][product_id]" value="{{ $item->product_id }}">
                        <input type="hidden" name="cart[{{ $loop->index }}][variant]" value="{{ $item->variant_id }}">
                        <input type="hidden" name="cart[{{ $loop->index }}][qty]" value="{{ $item->quantity }}">
                        <input type="hidden" name="cart[{{ $loop->index }}][actual_price]" value="{{ $item->price }}">
                        <input type="hidden" name="cart[{{ $loop->index }}][supplier_price]" value="{{ $item->supplier_price ?? 0 }}">
                        <input type="hidden" name="cart[{{ $loop->index }}][discount]" value="{{ $item->discount ?? 0 }}">
                        <input type="hidden" name="cart[{{ $loop->index }}][variant_color]" value="">
                        <input type="hidden" name="cart[{{ $loop->index }}][store_id]" value="1">
                    @endforeach
                    <div class="checkbox-group">
                        <input type="checkbox" id="saveAddress" name="saveAddress">
                        <label for="saveAddress">Save this address for future orders</label>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="place-order-btn" id="placeOrderBtn">
                            <i class="fas fa-lock"></i> Place Your Order
                        </button>
                    </div>
                </form>
            </div>

            <!-- Order Summary (unchanged) -->
            <div class="order-summary">
                <h2 class="summary-title">Order Summary</h2>
                <div class="order-items">
                    @forelse($cartItems as $item)
                        @php
                            $itemTotal = $item->price * $item->quantity;
                            $img = isset($item->product) && isset($item->product->image_url) ? $item->product->image_url : 'assets/images/default.jpg';
                            $pname = isset($item->product) && isset($item->product->product_name) ? $item->product->product_name : 'Product';
                            $size = $item->variant->variant_cat ?? 'N/A';
                        @endphp
                        <div class="order-item">
                            <div class="order-item-image">
                                <img src="{{ asset($img) }}" alt="{{ $pname }}">
                            </div>
                            <div class="order-item-details">
                                <h3 class="order-item-name">{{ $pname }}</h3>
                                <p class="order-item-size">Size: {{ $size }}</p>
                                <p class="order-item-price">₹{{ number_format($item->price, 2) }} × {{ $item->quantity }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="order-item">
                            <div class="order-item-details">
                                <h3>Your cart is empty.</h3>
                            </div>
                        </div>
                    @endforelse
                </div>
                <div class="summary-row">
                    <span>Subtotal ({{ $totalQuantity }} items)</span>
                    <span>₹{{ number_format($subtotal, 2) }}</span>
                </div>
                <div class="summary-row">
                    <span>Shipping</span>
                    <span>FREE</span>
                </div>
                <div class="summary-row">
                    <span>Tax</span>
                    <span>₹{{ number_format($tax, 2) }}</span>
                </div>
                <div class="summary-row summary-total">
                    <span>Total</span>
                    <span class="amount">₹{{ number_format($grandTotal, 2) }}</span>
                </div>

                <div class="secure-checkout">
                    <i class="fas fa-shield-alt"></i> Secure checkout - 256-bit SSL encryption
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form.form-section');
    const placeOrderBtn = document.getElementById('placeOrderBtn');

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        placeOrderBtn.disabled = true;
        placeOrderBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';

        const formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            body: formData,
            credentials: 'same-origin',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                if (data.payment_method === 'razorpay' && data.needs_payment) {
                    initiateRazorpayPayment(data);
                } else {
                    alert('Order placed successfully! Order ID: ' + data.order_id);
                    window.location.href = '/';
                }
            } else {
                alert('Error placing order: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(err => {
            console.error('Error:', err);
            alert('An error occurred while placing the order. Please try again.');
        })
        .finally(() => {
            placeOrderBtn.disabled = false;
            placeOrderBtn.innerHTML = '<i class="fas fa-lock"></i> Place Your Order';
        });
    });

    // Helper: parse JSON only when server returns JSON
    function safeJson(res) {
        const ct = res.headers.get('content-type') || '';
        if (ct.includes('application/json')) return res.json();
        return res.text().then(t => { throw new Error('Non-JSON response: ' + t.slice(0, 200)); });
    }

    function initiateRazorpayPayment(orderData) {
        fetch('{{ url("payment/create-order") }}', {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                order_id: orderData.order_id,
                amount: orderData.total_amount, // rupees; backend converts to paise
                customer_email: orderData.customer_email,
                customer_mobile: orderData.customer_mobile
            })
        })
        .then(safeJson)
        .then(data => {
            if (!data.success) {
                alert('Failed to initiate payment: ' + (data.message || 'Unknown'));
                return;
            }
            const options = {
                key: data.config.key,
                amount: data.amount,
                currency: data.currency || 'INR',
                name: data.config.name,
                description: data.config.description,
                image: data.config.image,
                order_id: data.razorpay_order_id,
                theme: data.config.theme,
                handler: function (resp) { verifyPayment(resp, orderData.order_id); },
                prefill: {
                    email: orderData.customer_email || '',
                    contact: orderData.customer_mobile || ''
                },
                modal: { ondismiss: function () { paymentFailed(orderData.order_id, { reason: 'Payment cancelled by user' }); } }
            };
            const rzp = new Razorpay(options);
            rzp.open();
        })
        .catch(err => {
            console.error('Payment initiation error:', err);
            alert('Failed to initiate payment. Please try again.');
        });
    }

    function verifyPayment(response, orderId) {
        fetch('{{ url("payment/verify") }}', {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                razorpay_order_id: response.razorpay_order_id,
                razorpay_payment_id: response.razorpay_payment_id,
                razorpay_signature: response.razorpay_signature,
                order_id: orderId
            })
        })
        .then(safeJson)
        .then(data => {
            if (data.success) {
                alert('Payment successful! Order ID: ' + orderId);
                window.location.href = '/';
            } else {
                alert('Payment verification failed: ' + (data.message || 'Unknown'));
            }
        })
        .catch(err => {
            console.error('Payment verification error:', err);
            alert('Payment verification failed. Please contact support.');
        });
    }

    function paymentFailed(orderId, error) {
        fetch('{{ url("payment/failed") }}', {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ order_id: orderId, error })
        })
        .then(() => alert('Payment failed. You can retry payment later.'))
        .catch(err => console.error('Failed to record payment failure:', err));
    }
});
</script>
@endpush




