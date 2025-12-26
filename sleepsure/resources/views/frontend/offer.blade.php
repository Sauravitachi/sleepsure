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
            <div class="active-coupon">
                <div class="coupon-label">YOUR ACTIVE COUPON</div>
                <div class="coupon-code">SLEEP40</div>
                <div class="coupon-discount">Get 40% OFF on all premium mattresses</div>
                <button class="copy-btn" onclick="copyCoupon('SLEEP40')">
                    <i class="fas fa-copy"></i> Copy Code
                </button>
            </div>

            <!-- Coupon Grid -->
            <div class="coupon-grid">
                <!-- Coupon 1 -->
                <div class="coupon-card popular">
                    <h3 class="coupon-card-title">First Order Special</h3>
                    <div class="coupon-card-code">WELCOME25</div>
                    <p class="coupon-card-desc">25% off on your first mattress purchase</p>
                    <button class="coupon-card-btn" onclick="copyCoupon('WELCOME25')">
                        Copy Code
                    </button>
                </div>

                <!-- Coupon 2 -->
                <div class="coupon-card">
                    <h3 class="coupon-card-title">Luxury Upgrade</h3>
                    <div class="coupon-card-code">LUXURY30</div>
                    <p class="coupon-card-desc">30% off on SleepSure Luxury collection</p>
                    <button class="coupon-card-btn" onclick="copyCoupon('LUXURY30')">
                        Copy Code
                    </button>
                </div>

                <!-- Coupon 3 -->
                <div class="coupon-card">
                    <h3 class="coupon-card-title">Bundle Deal</h3>
                    <div class="coupon-card-code">BUNDLE35</div>
                    <p class="coupon-card-desc">35% off when you buy mattress + bedding</p>
                    <button class="coupon-card-btn" onclick="copyCoupon('BUNDLE35')">
                        Copy Code
                    </button>
                </div>
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