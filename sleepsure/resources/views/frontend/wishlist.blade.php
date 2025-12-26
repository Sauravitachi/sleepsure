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
            <!-- Item 1 -->
            <div class="wishlist-item">
                <div class="item-image">
                    <img src="https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80" alt="Premium Mattress">
                </div>
                <div class="item-details">
                    <div class="item-category">Mattress</div>
                    <h3 class="item-title">SleepSure Premium Memory Foam Mattress</h3>
                    <div class="item-price">
                        $899.99 <span class="old-price">$1,099.99</span>
                        <span class="sale-badge">Sale</span>
                    </div>
                </div>
                <div class="item-actions">
                    <button class="btn btn-success">
                        <i class="fas fa-cart-plus"></i> Add to Cart
                    </button>
                    <button class="btn btn-danger">
                        <i class="fas fa-trash"></i> Remove
                    </button>
                </div>
            </div>

            <!-- Item 2 -->
            <div class="wishlist-item">
                <div class="item-image">
                    <img src="https://images.unsplash.com/photo-1586105251261-72a756497a11?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80" alt="Pillows">
                </div>
                <div class="item-details">
                    <div class="item-category">Pillows</div>
                    <h3 class="item-title">Ergonomic Sleep Pillows (Set of 2)</h3>
                    <div class="item-price">$79.99</div>
                </div>
                <div class="item-actions">
                    <button class="btn btn-success">
                        <i class="fas fa-cart-plus"></i> Add to Cart
                    </button>
                    <button class="btn btn-danger">
                        <i class="fas fa-trash"></i> Remove
                    </button>
                </div>
            </div>

            <!-- Item 3 -->
            <div class="wishlist-item">
                <div class="item-image">
                    <img src="https://images.unsplash.com/photo-1555041469-a586c61ea9bc?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80" alt="Bed Frame">
                </div>
                <div class="item-details">
                    <div class="item-category">Bed Frame</div>
                    <h3 class="item-title">Modern Platform Bed Frame - Queen Size</h3>
                    <div class="item-price">$449.99</div>
                </div>
                <div class="item-actions">
                    <button class="btn btn-success">
                        <i class="fas fa-cart-plus"></i> Add to Cart
                    </button>
                    <button class="btn btn-danger">
                        <i class="fas fa-trash"></i> Remove
                    </button>
                </div>
            </div>

            <!-- Item 4 -->
            <div class="wishlist-item">
                <div class="item-image">
                    <img src="https://images.unsplash.com/photo-1586023492125-27b2c045efd7?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80" alt="Comforter">
                </div>
                <div class="item-details">
                    <div class="item-category">Bedding</div>
                    <h3 class="item-title">All-Season Down Alternative Comforter</h3>
                    <div class="item-price">$129.99</div>
                </div>
                <div class="item-actions">
                    <button class="btn btn-success">
                        <i class="fas fa-cart-plus"></i> Add to Cart
                    </button>
                    <button class="btn btn-danger">
                        <i class="fas fa-trash"></i> Remove
                    </button>
                </div>
            </div>

           
        </div>

    </div>

@endsection