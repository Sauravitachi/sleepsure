@extends('layouts.app')

@section('title', 'Premium Mattress & Sleep Solutions')

@section('content')

<main class="main-content">
        <div class="about-container">
            <h2 class="page-title">About SleepSure</h2>
            <!-- About Us Section -->
            <section class="section">
                <div class="row">
                    <div class="col-md-6">
                        <div class="text-content">
                            <p>SleepSure was founded in 2010 with a simple mission: to create exceptional mattresses
                                that make quality sleep accessible to everyone. We believe that restorative sleep is
                                fundamental to health and happiness, and everyone deserves a mattress that supports
                                their well-being.

                                Our journey began in a small workshop, driven by the belief that premium sleep shouldn't
                                come with a luxury price tag. By eliminating unnecessary markups and focusing on
                                direct-to-consumer sales, we deliver exceptional value without compromising on quality.

                                Today, we continue to innovate while staying true to our founding principles. Each
                                SleepSure mattress combines traditional craftsmanship with cutting-edge sleep
                                technology, designed to provide the perfect balance of comfort and support for every
                                type of sleeper.</p>
                        </div>
                        <div class="card-column why-choose-us-content">
                    <h3>Why Choose Us?</h3>

                    <div class="feature-item-modern">
                        <i class="fa-solid fa-circle-check"></i>
                        <div>
                            <h4>100% Quality Assurance</h4>
                            <p>Only certified, non-toxic materials are used, ensuring a safe and healthy sleep
                                environment.</p>
                        </div>
                    </div>

                    <div class="feature-item-modern">
                        <i class="fa-solid fa-circle-check"></i>
                        <div>
                            <h4>10-Year Warranty</h4>
                            <p>Confidence in our durability, backed by a comprehensive decade-long guarantee.</p>
                        </div>
                    </div>

                    <div class="feature-item-modern">
                        <i class="fa-solid fa-circle-check"></i>
                        <div>
                            <h4>Free Delivery & Setup</h4>
                            <p>Enjoy hassle-free service with doorstep delivery and professional setup.</p>
                        </div>
                    </div>
                </div>
                    </div>
                    <div class="col-md-6">
                        <div class="image-content">
                            <div class="image-placeholder">
                                <img src="https://kurlon.com/cdn/shop/files/34A9753-Enhanced-NR.jpg?v=1752566689" alt=""
                                    width="100%">
                            </div>
                        </div>
                    </div>


                </div>


            </section>
        </div>

        <section class="layer">
            <div class="mattress-features-container">

                <header class="features-header">
                    <div class="feature-point" data-number="1">
                        <span class="green-dot"></span>
                        <h2>Cover</h2>
                        <p>The cover's blend of fabrics and fibers adjusts to your body temperature and pulls moisture
                            away.
                        </p>
                    </div>
                    <div class="feature-point" data-number="2">
                        <span class="green-dot"></span>
                        <h2>Layers</h2>
                        <p>This mattress is designed to fit your body and eliminate unwanted temperature changes
                            enabling
                            you to sleep comfortably.</p>
                    </div>
                    <div class="feature-point" data-number="3">
                        <span class="green-dot"></span>
                        <h2>Foam Layers</h2>
                        <p>The mattress is equipped with layers of softness to mold to your body so you can wake up
                            feeling
                            refreshed without that achy feeling. There is an added layer of exceptional-quality foam for
                            constant support while sleeping.</p>
                    </div>
                </header>

                <div class="mattress-diagram-section-image">
                    <img src="assets/images/layer.png" alt="Mattress Layers Diagram" class="mattress-image">
                </div>

                <div class="features-footer">
                    <div class="feature-point" data-number="4">
                        <span class="green-dot"></span>
                        <h2>Additional support layer</h2>
                        <p>Unlike most mattresses where deep dips in the foam eventually occur, this mattress has
                            built-in
                            springs to prevent causing motion upon movement. It stays the same, including support for
                            the
                            bed edges and comfortable temperature adjustments.</p>
                    </div>
                    <div class="feature-point" data-number="5">
                        <span class="green-dot"></span>
                        <h2>Foam base</h2>
                        <p>The high quality of the foam base improves its strength, contour ability, and support for all
                            body types. Softness/Hardness – Medium to medium-firm comfort</p>
                    </div>
                </div>

            </div>
        </section>


        <section class="money-back-guarantee-section">
            <div class="content-container">
                <p class="tagline">ZERO RISK | ZERO OBLIGATION</p>
                <h1>Love Sleepsure or Your Money Back</h1>
                <p class="subtitle">If Your Child Doesn't Love Their Sleepsure Bed After 100 Nights, Return It For Free.
                </p>

                <div class="feature-grid new-feature-grid">

                    <div class="feature-item">
                        <div class="icon-wrapper icon-wrapper-1">
                            <img src="assets/images/icon/i1.png" alt="100-Night Home Trial Icon">
                        </div>
                        <h3>100-Night Home Trial</h3>
                        <p>Try the Sleepsure at home for 100 nights and if you're not satisfied, return it for free.</p>

                    </div>

                    <div class="feature-item">
                        <div class="icon-wrapper icon-wrapper-2">
                            <img src="assets/images/icon/i2.png" alt="Delivery & Setup Icon">
                        </div>
                        <h3>Delivery & Setup</h3>
                        <p>We deliver and install your Sleepsure bed at no extra charge.</p>

                    </div>

                    <div class="feature-item">
                        <div class="icon-wrapper icon-wrapper-3">
                            <img src="assets/images/icon/i3.png" alt="Free Shipping Icon">
                        </div>
                        <h3>Free Shipping</h3>
                        <p>Shipping is free - even if you decide to return your Sleepsure bed during the 100-night
                            trial.
                        </p>

                    </div>

                    <div class="feature-item">
                        <div class="icon-wrapper icon-wrapper-4">
                            <img src="assets/images/icon/i4.png" alt="Financing Available Icon">
                        </div>
                        <h3>Financing Available</h3>
                        <p>Make monthly payments with 0% interest when you pay with a credit card.</p>

                    </div>

                </div>
            </div>
        </section>
    </main>
@endsection