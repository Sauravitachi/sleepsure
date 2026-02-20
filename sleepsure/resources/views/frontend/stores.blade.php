@extends('layouts.app')

@section('title', 'Premium Mattress & Sleep Solutions')

@section('content')

 <main class="main-content">

        <section class="stores-section">
            <div class="stores-container">
                <!-- Left Side: Stores Cards -->
               <div class="stores-box">
                <h2 class="stores-heading">Explore Our Stores</h2>

                <div class="stores-grid">
                    @foreach($store_sets as $store)
                        <div class="store-card">
                            <div class="store-icon">
                                <i class="fa-solid fa-store"></i>
                            </div>
                            <h3>{{ $store->store_name }}</h3>
                        </div>
                    @endforeach
                </div>

                <a href="#" class="view-stores-link">View {{ $store_sets->count() }}+ Stores</a>
            </div>

                <!-- Right Side: Image -->
                <div class="image-box">
                    <img src="https://adyourdream.com/images/portfolio/relaxon%20banner.webp" alt="Stores Showcase">
                </div>
            </div>
        </section>
    </main>

@endsection