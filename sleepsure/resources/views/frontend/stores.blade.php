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
                        <!-- Card 1 -->
                        <div class="store-card">
                            <div class="store-icon">
                                <i class="fa-solid fa-landmark"></i>
                            </div>
                            <h3>Delhi</h3>
                        </div>

                        <!-- Card 2 -->
                        <div class="store-card">
                            <div class="store-icon">
                                <i class="fa-solid fa-archway"></i>
                            </div>
                            <h3>Mumbai</h3>
                        </div>

                        <!-- Card 3 -->
                        <div class="store-card">
                            <div class="store-icon">
                                <i class="fa-solid fa-city"></i>
                            </div>
                            <h3>Bangalore</h3>
                        </div>

                        <!-- Card 4 -->
                        <div class="store-card">
                            <div class="store-icon">
                                <i class="fa-solid fa-bridge"></i>
                            </div>
                            <h3>Kolkata</h3>
                        </div>

                        <!-- Card 5 -->
                        <div class="store-card">
                            <div class="store-icon">
                                <i class="fa-solid fa-mosque"></i>
                            </div>
                            <h3>Hyderabad</h3>
                        </div>

                        <!-- Card 6 -->
                        <div class="store-card">
                            <div class="store-icon">
                                <i class="fa-solid fa-torii-gate"></i>
                            </div>
                            <h3>Jaipur</h3>
                        </div>
                    </div>

                    <a href="#" class="view-stores-link">View 50+ Stores</a>
                </div>

                <!-- Right Side: Image -->
                <div class="image-box">
                    <img src="https://adyourdream.com/images/portfolio/relaxon%20banner.webp" alt="Stores Showcase">
                </div>
            </div>
        </section>
    </main>

@endsection