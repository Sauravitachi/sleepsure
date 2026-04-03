@extends('layouts.app')

@section('title', 'Premium Mattress & Sleep Solutions')

@section('content')

  <main class="main-content" style="display: block;">
        <section class="hero-section">

            <div id="carouselExampleIndicators" class="carousel slide">
                
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="assets/images/banner2.png" class="d-block w-100" alt="...">
                    </div>
                  
                </div>
               
            </div>
        </section>

         <!-- bank offer -->
        <div class="offers-section">


            <div class="filter-buttons">
                @foreach($rewards as $index => $reward)
                    <button class="{{ $index === 0 ? 'active' : '' }}" data-type="{{ strtolower($reward->title) }}">{{ $reward->title }}</button>
                @endforeach
            </div>

            <div class="offers-cards">
                @foreach($rewardTypes as $rewardType)
                    <div class="offer-card" data-type="{{ strtolower($rewardType->reward->title) }}">
                        @if($rewardType->logo)
                            <img src="{{ asset($rewardType->logo) }}" alt="{{ $rewardType->title }}">
                        @else
                            <div class="offer-card-placeholder">{{ $rewardType->title }}</div>
                        @endif
                        <p>{{ $rewardType->message }}</p>
                    </div>
                @endforeach
            </div>
        </div>


        <div class="coupon-section">
        <div class="coupon-header">
            <h2 class="coupon-title">Special Discount Coupons</h2>
            <p class="coupon-subtitle">Copy your favorite coupon code and apply at checkout</p>
        </div>

        <div class="coupon-container">
            <!-- Active Coupon -->
            @if(isset($coupons) && $coupons->isNotEmpty())
            @php
                $activeCoupon = $coupons->sortByDesc('discount_percentage')->first();
            @endphp
            <div class="active-coupon">
                <div class="coupon-label">YOUR ACTIVE COUPON</div>
                <div class="coupon-code">{{ $activeCoupon->coupon_discount_code }}</div>
                <div class="coupon-discount">{{ $activeCoupon->coupon_msg }}</div>
                <button class="copy-btn" onclick="copyCoupon('{{ $activeCoupon->coupon_discount_code }}')">
                    <i class="fas fa-copy"></i> Copy Code
                </button>
            </div>
            @endif

            <!-- Coupon Grid -->
            <div class="coupon-grid">
                @if(isset($coupons) && $coupons->isNotEmpty())
                    @foreach($coupons as $coupon)
                    <div class="coupon-card {{ $coupon->is_popular == '1' ? 'popular' : '' }}">
                        <h3 class="coupon-card-title">{{ $coupon->coupon_name }}</h3>
                        <div class="coupon-card-code">{{ $coupon->coupon_discount_code }}</div>
                        <p class="coupon-card-desc">{{ $coupon->coupon_msg }}</p>
                        <button class="coupon-card-btn" onclick="copyCoupon('{{ $coupon->coupon_discount_code }}')">
                            Copy Code
                        </button>
                    </div>
                    @endforeach
                @endif
            </div>

            <!-- Terms & Conditions -->
            <div class="terms-section">
                <h4 class="terms-title">Terms & Conditions</h4>
                <ul class="terms-list">
                    <li><i class="fas fa-check"></i> One coupon code per order</li>
                    <li><i class="fas fa-check"></i> Cannot be combined with other offers</li>
                    <li><i class="fas fa-check"></i> Valid until December 31, 2024</li>
                    <li><i class="fas fa-check"></i> Minimum purchase of $499 required</li>
                    <li><i class="fas fa-check"></i> Not applicable on clearance items</li>
                </ul>
            </div>
        </div>
    </div>

     </main>
@endsection