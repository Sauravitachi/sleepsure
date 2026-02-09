@extends('layouts.app')

@section('title', 'Premium Mattress & Sleep Solutions')

@section('content')

<div class="container">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">
               My Wishlist
            </h1>
         
        </div>

        <!-- Wishlist Items -->
        <div class="wishlist-items">
            @forelse($products as $product)
                <div class="wishlist-item" data-product-id="{{ $product->product_id }}">
                    <div class="item-image">
                        <img src="{{ $product->image_url ?? asset('assets/images/noimage.png') }}" alt="{{ $product->product_name }}">
                    </div>
                    <div class="item-details">
                        <div class="item-category">{{ $product->categoryDetails->category_name ?? '' }}</div>
                        <h3 class="item-title">{{ $product->product_name }}</h3>
                        <div class="item-price">
                            ₹{{ number_format($product->price, 2) }}
                            @if(!empty($product->old_price) && $product->old_price > $product->price)
                                <span class="old-price">₹{{ number_format($product->old_price, 2) }}</span>
                                <span class="sale-badge">Sale</span>
                            @endif
                        </div>
                    </div>
                    <div class="item-actions">
                        <button class="btn btn-success add-to-cart-btn">
                            <i class="fas fa-cart-plus"></i> Add to Cart
                        </button>
                        <button class="btn btn-danger remove-wishlist-btn">
                            <i class="fas fa-trash"></i> Remove
                        </button>
                    </div>
                </div>
            @empty
                <div class="empty-wishlist">
                    <i class="fas fa-heart-broken"></i>
                    <h3>Your wishlist is empty</h3>
                    <p>Browse products and add them to your wishlist!</p>
                </div>
            @endforelse
        </div>

    </div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Add to Cart
    document.querySelectorAll('.add-to-cart-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var productId = this.closest('.wishlist-item').getAttribute('data-product-id');
            fetch('{{ route("cart.add") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ product_id: productId })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert('Added to cart!');
                    if (window.updateCartCount) window.updateCartCount();
                } else {
                    alert(data.message || 'Could not add to cart.');
                }
            });
        });
    });
    // Remove from Wishlist
    document.querySelectorAll('.remove-wishlist-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var productId = this.closest('.wishlist-item').getAttribute('data-product-id');
            fetch('/wishlist/remove', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ product_id: productId })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    this.closest('.wishlist-item').remove();
                    if (!document.querySelector('.wishlist-item')) {
                        document.querySelector('.wishlist-items').innerHTML = `<div class='empty-wishlist'><i class='fas fa-heart-broken'></i><h3>Your wishlist is empty</h3><p>Browse products and add them to your wishlist!</p></div>`;
                    }
                } else {
                    alert(data.message || 'Could not remove from wishlist.');
                }
            }.bind(this));
        });
    });
});
</script>
@endpush