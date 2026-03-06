@extends('layouts.app')

@section('title', 'Premium Mattress & Sleep Solutions')

@section('content')

<div class="container wishlist-page">
    <div class="page-header">
        <div class="wishlist-title">
            <span class="pill">Saved</span>
            <h1 class="page-title">My Wishlist</h1>
        </div>
        <p class="page-subtitle">Curated picks styled like the home page cards.</p>
    </div>

    <div class="wishlist-grid">
        @forelse($products as $product)
            <div class="wishlist-card" data-product-id="{{ $product->product_id }}">
                <div class="card-visual">
                    <a href="{{ route('product.details', ['id' => $product->product_id]) }}" class="card-top" style="background-image:url('{{ $product->image_url ?? asset('assets/images/noimage.png') }}')">
                        <span class="rating-badge">Wishlisted</span>
                    </a>
                    <button class="ghost-btn remove-wishlist-btn" type="button" aria-label="Remove from wishlist">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="card-bottom">
                    <div class="card-info">
                        <div class="item-category">{{ $product->categoryDetails->category_name ?? '' }}</div>
                        <h3 class="item-title">{{ $product->product_name }}</h3>
                        <div class="item-price">
                            <span class="current">₹{{ number_format($product->price, 2) }}</span>
                            @if(!empty($product->old_price) && $product->old_price > $product->price)
                                <span class="old-price">₹{{ number_format($product->old_price, 2) }}</span>
                                <span class="sale-badge">{{ number_format((($product->old_price - $product->price)/$product->old_price)*100, 0) }}% off</span>
                            @endif
                        </div>
                    </div>
                    <div class="card-actions">
                        <button class="add-to-cart-btn" type="button" aria-label="Add to cart">
                            <i class="fas fa-cart-plus"></i>
                            <span>Add to Cart</span>
                        </button>
                        <a class="view-btn" href="{{ route('product.details', ['id' => $product->product_id]) }}">
                            View
                        </a>
                    </div>
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

@push('styles')
<style>
.wishlist-page {padding: 28px 0 40px;}
.page-header {display: flex; align-items: flex-start; justify-content: space-between; gap: 12px; margin-bottom: 18px;}
.wishlist-title {display: flex; align-items: center; gap: 10px;}
.pill {padding: 6px 12px; border-radius: 999px; background: #0b3b8c; color: #fff; font-weight: 600; font-size: 12px; letter-spacing: 0.4px; text-transform: uppercase;}
.page-title {margin: 0; font-size: 28px; font-weight: 800; color: #0b132a;}
.page-subtitle {margin: 4px 0 0; color: #64748b; font-size: 14px;}

.wishlist-grid {display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 18px;}
.wishlist-card {background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.08); display: flex; flex-direction: column; transition: transform 0.35s ease, box-shadow 0.35s ease;}
.wishlist-card:hover {transform: translateY(-4px); box-shadow: 0 16px 36px rgba(0,0,0,0.12);}

.card-visual {position: relative;}
.card-top {position: relative; display: block; height: 210px; background-size: cover; background-position: center;}
.rating-badge {position: absolute; top: 12px; left: 12px; background: #fff; color: #0b132a; padding: 6px 10px; border-radius: 6px; font-size: 12px; font-weight: 700; box-shadow: 0 6px 18px rgba(0,0,0,0.08);} 
.ghost-btn {position: absolute; top: 12px; right: 12px; width: 36px; height: 36px; border-radius: 50%; border: none; background: rgba(255,255,255,0.9); color: #0f172a; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 20px rgba(0,0,0,0.08); transition: background 0.2s ease, transform 0.2s ease;}
.ghost-btn:hover {background: #fee2e2; color: #b91c1c; transform: translateY(-2px);} 

.card-bottom {padding: 14px 14px 16px; display: flex; flex-direction: column; gap: 12px; flex: 1;}
.card-info {display: flex; flex-direction: column; gap: 6px;}
.item-category {font-size: 12px; color: #64748b; text-transform: uppercase; letter-spacing: 0.6px; font-weight: 600;}
.item-title {font-size: 18px; margin: 0; color: #0f172a; line-height: 1.3;}
.item-price {display: flex; align-items: center; gap: 8px;}
.item-price .current {font-size: 18px; font-weight: 800; color: #0b3b8c;}
.item-price .old-price {font-size: 14px; color: #94a3b8; text-decoration: line-through;}
.sale-badge {padding: 4px 8px; background: #fef2f2; color: #b91c1c; border-radius: 8px; font-size: 12px; font-weight: 700;}

.card-actions {display: flex; gap: 10px; align-items: center;}
.add-to-cart-btn {flex: 1; display: inline-flex; align-items: center; justify-content: center; gap: 8px; padding: 10px 12px; border-radius: 10px; border: none; background: linear-gradient(135deg, #0b3b8c, #1565c0); color: #fff; font-weight: 700; cursor: pointer; box-shadow: 0 10px 24px rgba(12,74,110,0.28); transition: transform 0.2s ease, box-shadow 0.2s ease;}
.add-to-cart-btn:hover {transform: translateY(-1px); box-shadow: 0 14px 30px rgba(12,74,110,0.32);} 
.add-to-cart-btn i {font-size: 16px;}
.view-btn {display: inline-flex; align-items: center; justify-content: center; padding: 10px 12px; border-radius: 10px; background: #f1f5f9; color: #0f172a; font-weight: 700; text-decoration: none; transition: background 0.2s ease, color 0.2s ease;}
.view-btn:hover {background: #e2e8f0; color: #0b3b8c;}

.empty-wishlist {text-align: center; padding: 48px; background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 16px; color: #475569;}
.empty-wishlist i {font-size: 40px; color: #e11d48; margin-bottom: 12px;}

@media (max-width: 768px) {
    .page-header {flex-direction: column; align-items: flex-start;}
    .wishlist-grid {grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 14px;}
    .card-top {height: 180px;}
}
</style>
@endpush

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
            fetch('{{ url("wishlist/remove") }}', {
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