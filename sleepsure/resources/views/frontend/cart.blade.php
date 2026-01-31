@extends('layouts.app')

@section('title', 'Premium Mattress & Sleep Solutions')

@section('content')
<style>
    .slider-wrapper {
    position: relative;
    width: 100%;
}

.slider-container {
    display: flex;
    gap: 20px;
    overflow-x: auto;
    scroll-behavior: smooth;
    padding: 10px 40px;
    cursor: grab;
    -webkit-overflow-scrolling: touch;
}

/* Hide scrollbar */
.slider-container::-webkit-scrollbar {
    display: none;
}
.slider-container {
    -ms-overflow-style: none;
    scrollbar-width: none;
}

/* Product card width */
.slider-container .wrapper {
    flex: 0 0 280px;
    min-width: 240px;
}

.slider-container .testimonial-card,
.slider-container .award-item {
    min-width: 220px;
    max-width: 320px;
    flex: 0 0 80vw;
}

/* ===== ARROWS ===== */
.slider-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    z-index: 10;
    background: #0b3b8c;
    color: #fff;
    border: none;
    width: 42px;
    height: 42px;
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
}

.slider-btn.left {
    left: 0;
}

.slider-btn.right {
    right: 0;
}

.slider-btn:hover {
    background: #092f6e;
}

/* Mobile tweaks */
@media (max-width: 768px) {
    .slider-container {
        padding: 10px 0;
        gap: 12px;
    }
    .slider-btn {
        display: none; /* swipe only */
    }
    .slider-container .wrapper,
    .slider-container .testimonial-card,
    .slider-container .award-item {
        min-width: 80vw;
        max-width: 90vw;
    }
    /* Optional: add a scroll hint gradient */
    .slider-wrapper::after {
        content: '';
        position: absolute;
        right: 0;
        top: 0;
        width: 40px;
        height: 100%;
        pointer-events: none;
        background: linear-gradient(to left, #fff 60%, transparent 100%);
        z-index: 2;
        display: block;
    }
}

</style>
 <!-- Breadcrumb -->
    <section class="breadcrumb">
        <div class="container breadcrumb-container">
            <a href="{{ url('/') }}">Home</a>
            <span>/</span>
            @php
                $categoryName = 'Mattresses';
                if (isset($cartItems) && count($cartItems) > 0 && isset($cartItems[0]->product->category_name)) {
                    $categoryName = $cartItems[0]->product->category_name;
                }
            @endphp
            <a href="#">{{ $categoryName }}</a>
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
                    @php
                        $subtotal = 0;
                        $totalQuantity = 0;
                    @endphp
                    @forelse($cartItems as $item)
                        @php
                            $itemTotal = $item->price * $item->quantity;
                            $subtotal += $itemTotal;
                            $totalQuantity += $item->quantity;
                        @endphp
                        <div class="cart-item">
                            <div class="item-image">
                                @php
                                    $img = isset($item->product) && isset($item->product->image_url) ? $item->product->image_url : 'assets/images/default.jpg';
                                    $pname = isset($item->product) && isset($item->product->product_name) ? $item->product->product_name : 'Product';
                                    @endphp
                                <img src="{{ asset($img) }}" alt="{{ $pname }}">
                            </div>
                            <div class="item-details">
                                <h3 class="item-name">{{ $pname }}</h3>
                                <p class="item-size">
                                    Size:
                                    @if($item->custom_length && $item->custom_breadth)
                                        Custom: {{ $item->custom_length }} x {{ $item->custom_breadth }}@if($item->thickness) x {{ $item->thickness->thick }}@endif
                                    @elseif($item->variant && $item->variant->variant_cat)
                                        {{ $item->variant->variant_cat }}@if($item->thickness) x {{ $item->thickness->thick }}@endif
                                    @else
                                        N/A@if($item->thickness) x {{ $item->thickness->thick }}
                                    @endif
                                </p>
                                
                                <p class="item-price">₹{{ number_format($item->price, 2) }}</p>
                                <div class="item-actions">
                                    <form action="{{ route('cart.quantityUpdate', $item->id) }}" method="POST" class="quantity-form" style="display:inline-flex;align-items:center;" onsubmit="return false;">
                                        @csrf
                                        <div class="quantity-selector">
                                            <button type="button" class="quantity-btn minus" @if($item->quantity <= 1) disabled @endif>-</button>
                                            <input type="number" class="quantity-input" name="quantity" value="{{ $item->quantity }}" min="1" step="1" style="width:60px; text-align:center;" @if($item->quantity <= 1) min="1" @endif>
                                            <button type="button" class="quantity-btn plus">+</button>
                                        </div>
                                    </form>
                                    <form action="{{ route('cart.remove', $item->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="remove-btn">
                                            <i class="fas fa-trash"></i> Remove
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="cart-item">
                            <div class="item-details">
                                <h3>Your cart is empty.</h3>
                            </div>
                        </div>
                    @endforelse
                </div>

                <div class="cart-summary">
                    <h2 class="summary-title">Order Summary</h2>
                    <div class="summary-row">
                        <span>Subtotal ({{ $totalQuantity }} items)</span>
                        <span>₹{{ number_format($subtotal, 2) }}</span>
                    </div>
                    <div class="summary-row">
                        <span>Shipping</span>
                        <span>FREE</span>
                    </div>
                    @php $tax = $subtotal * 0.03; @endphp
                    <div class="summary-row">
                        <span>Tax</span>
                        <span>₹{{ number_format($tax, 2) }}</span>
                    </div>
                    <div class="summary-row summary-total">
                        <span>Total</span>
                        <span class="amount">₹{{ number_format($subtotal + $tax, 2) }}</span>
                    </div>
                   
                    <a href="{{ route('checkout') }}" class="checkout-btn">
                        <i class="fas fa-lock"></i>Proceed to checkout
                    </a>
                    <a href="{{ url('/') }}" class="continue-shopping">
                        <i class="fas fa-arrow-left"></i> Continue Shopping
                    </a>
                </div>
            </div>
        </div>
    </section>

    
     <div class="container">
            <h2 class="section-title">You Might Also Like</h2>
    <div>
        @include('partials.featured_product',['featured_products' => $featured_products])



@endsection

<script>

document.addEventListener('click', function (e) {
    // PLUS BUTTON
    if (e.target.classList.contains('plus')) {
        console.debug('Plus button clicked');
        const item = e.target.closest('.cart-item');
        const input = item.querySelector('.quantity-input');
        input.value = parseInt(input.value) + 1;
        updateQuantity(item, input.value);
    }

    // MINUS BUTTON
    if (e.target.classList.contains('minus')) {
        console.debug('Minus button clicked');
        const item = e.target.closest('.cart-item');
        const input = item.querySelector('.quantity-input');
        let val = parseInt(input.value) - 1;
        if (val < 1) val = 1;
        input.value = val;
        updateQuantity(item, val);
    }
});

// INPUT CHANGE
document.addEventListener('change', function (e) {
    if (e.target.classList.contains('quantity-input')) {
        console.debug('Quantity input changed');
        let val = parseInt(e.target.value);
        if (isNaN(val) || val < 1) {
            e.target.value = 1;
            val = 1;
        }
        const item = e.target.closest('.cart-item');
        updateQuantity(item, val);
    }
});

function updateQuantity(item, quantity) {
    const form = item.querySelector('.quantity-form');
    const url = form.action;
    const token = form.querySelector('input[name="_token"]').value;
    const formData = new FormData();
    formData.append('_method', 'PUT');
    formData.append('quantity', quantity);
    console.debug('Sending quantity update:', { url, quantity });

    fetch(url, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': token,
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(res => {
        console.debug('Received response', res);
        return res.json();
    })
    .then(data => {
        console.debug('Response data', data);
        if (data.success) {
            location.reload(); // OR update subtotal via JS
        } else {
            alert('Failed to update quantity');
        }
    })
    .catch((err) => {
        console.error('Quantity update error', err);
        alert('Something went wrong');
    });
}

</script>
