@extends('layouts.app')

@section('title', 'Premium Mattress & Sleep Solutions')

@section('content')

<div class="container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">Our Guarantees</h1>
            <p class="page-subtitle">At SleepSure, we stand behind our products with comprehensive guarantees designed to give you complete peace of mind and the best sleep experience possible.</p>
        </div>

        <!-- Hero Banner -->
        <div class="hero-banner">
            <h2>Sleep Confidently with Our Unbeatable Guarantees</h2>
            <p>We're so confident in the quality of our products that we back them with industry-leading guarantees and exceptional customer service.</p>
        </div>

        <!-- Guarantees Container -->
        <div class="guarantees-container">
            <!-- Guarantees Grid -->
            <div class="guarantees-grid">
                <!-- 100-Night Trial -->
                <div class="guarantee-card">
                    <div class="guarantee-icon">
                        <i class="fas fa-bed"></i>
                    </div>
                    <h3 class="guarantee-title">100-Night Sleep Trial</h3>
                    <p class="guarantee-description">Take 100 nights to ensure your mattress is the perfect fit for your sleep needs. If you're not completely satisfied, we'll arrange a hassle-free return and full refund.</p>
                    <div class="guarantee-details">
                        <h4>What's Included:</h4>
                        <ul>
                            <li>Full 100 nights to test your mattress</li>
                            <li>Free returns with no hidden fees</li>
                            <li>Full refund of purchase price</li>
                            <li>Free mattress pickup from your home</li>
                        </ul>
                    </div>
                </div>

                <!-- 10-Year Warranty -->
                <div class="guarantee-card">
                    <div class="guarantee-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3 class="guarantee-title">10-Year Limited Warranty</h3>
                    <p class="guarantee-description">Every SleepSure mattress is protected by our comprehensive 10-year warranty against manufacturing defects and premature wear.</p>
                    <div class="guarantee-details">
                        <h4>Coverage Includes:</h4>
                        <ul>
                            <li>Manufacturing defects in materials</li>
                            <li>Sagging greater than 1.5 inches</li>
                            <li>Physical flaws in the foam layers</li>
                            <li>Zipper and cover defects</li>
                        </ul>
                    </div>
                </div>

                <!-- Price Match -->
                <div class="guarantee-card">
                    <div class="guarantee-icon">
                        <i class="fas fa-tag"></i>
                    </div>
                    <h3 class="guarantee-title">Price Match Guarantee</h3>
                    <p class="guarantee-description">Found the same mattress for less? We'll match the price and give you an additional 5% discount on your purchase.</p>
                    <div class="guarantee-details">
                        <h4>Conditions:</h4>
                        <ul>
                            <li>Valid for 30 days after purchase</li>
                            <li>Must be the exact same model</li>
                            <li>Competitor must be authorized retailer</li>
                            <li>Includes all fees and shipping costs</li>
                        </ul>
                    </div>
                </div>

                <!-- Free Shipping -->
                <div class="guarantee-card">
                    <div class="guarantee-icon">
                        <i class="fas fa-shipping-fast"></i>
                    </div>
                    <h3 class="guarantee-title">Free Shipping & Returns</h3>
                    <p class="guarantee-description">We offer free standard shipping to all 50 states and free returns if you're not satisfied with your purchase during the trial period.</p>
                    <div class="guarantee-details">
                        <h4>Shipping Details:</h4>
                        <ul>
                            <li>Free shipping within 2-5 business days</li>
                            <li>White glove delivery available</li>
                            <li>No hidden fees or charges</li>
                            <li>Free returns during trial period</li>
                        </ul>
                    </div>
                </div>

                <!-- Quality Guarantee -->
                <div class="guarantee-card">
                    <div class="guarantee-icon">
                        <i class="fas fa-award"></i>
                    </div>
                    <h3 class="guarantee-title">Quality Guarantee</h3>
                    <p class="guarantee-description">We use only certified, high-quality materials that are independently tested for durability, performance, and safety.</p>
                    <div class="guarantee-details">
                        <h4>Certifications:</h4>
                        <ul>
                            <li>CertiPUR-US® certified foams</li>
                            <li>OEKO-TEX® Standard 100 certified</li>
                            <li>GREENGUARD Gold certified</li>
                            <li>Made in India</li>
                        </ul>
                    </div>
                </div>

                <!-- Support Guarantee -->
                <div class="guarantee-card">
                    <div class="guarantee-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h3 class="guarantee-title">24/7 Customer Support</h3>
                    <p class="guarantee-description">Our sleep experts are available 24/7 to answer your questions, help with setup, or assist with any concerns about your purchase.</p>
                    <div class="guarantee-details">
                        <h4>Support Channels:</h4>
                        <ul>
                            <li>24/7 phone and chat support</li>
                            <li>Email response within 2 hours</li>
                            <li>Dedicated sleep specialists</li>
                            <li>Extended support hours</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- How It Works -->
            <div class="how-it-works">
                <h2>How Our Guarantees Work</h2>
                <div class="steps">
                    <div class="step">
                        <div class="step-number">1</div>
                        <h3 class="step-title">Purchase</h3>
                        <p>Buy any SleepSure mattress online or in-store</p>
                    </div>
                    <div class="step">
                        <div class="step-number">2</div>
                        <h3 class="step-title">Receive</h3>
                        <p>Get free delivery and set up your new mattress</p>
                    </div>
                    <div class="step">
                        <div class="step-number">3</div>
                        <h3 class="step-title">Test</h3>
                        <p>Sleep on it for up to 100 nights risk-free</p>
                    </div>
                    <div class="step">
                        <div class="step-number">4</div>
                        <h3 class="step-title">Decide</h3>
                        <p>Keep it and enjoy, or return for a full refund</p>
                    </div>
                </div>
            </div>

            <!-- FAQ Section -->
            <div class="faq-section">
                <h2>Frequently Asked Questions</h2>
                
                <div class="faq-item">
                    <div class="faq-question">
                        What if I don't like my mattress during the trial period?
                        <span class="faq-toggle">+</span>
                    </div>
                    <div class="faq-answer">
                        <p>If you're not completely satisfied with your SleepSure mattress during the 100-night trial, simply contact our customer service team. We'll arrange a free pickup of your mattress and process a full refund to your original payment method. No questions asked.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        Are there any costs associated with returns?
                        <span class="faq-toggle">+</span>
                    </div>
                    <div class="faq-answer">
                        <p>No, returns during the trial period are completely free. We cover all pickup and processing costs. The only exception is if you selected white glove delivery, in which case the delivery fee is non-refundable but the mattress price is fully refundable.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        How do I make a warranty claim?
                        <span class="faq-toggle">+</span>
                    </div>
                    <div class="faq-answer">
                        <p>To make a warranty claim, contact our customer service team with your order information and details about the issue. We may request photos or arrange for an inspection. If your claim is approved, we'll repair or replace your mattress at no cost to you.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        Do you offer guarantees on all products?
                        <span class="faq-toggle">+</span>
                    </div>
                    <div class="faq-answer">
                        <p>The 100-night trial applies to mattresses only. Bed frames, pillows, and other accessories come with a 30-day return policy. All SleepSure products are covered by at least a 1-year warranty, with mattresses having our comprehensive 10-year warranty.</p>
                    </div>
                </div>
            </div>

            <!-- CTA Section -->
            <div class="cta-section">
                <h2>Ready to Experience Better Sleep?</h2>
                <p>Shop our collection of premium mattresses today, backed by our industry-leading guarantees and exceptional customer service.</p>
                <a href="category.html" class="btn btn-primary">
                    <i class="fas fa-shopping-cart"></i> Shop Mattresses
                </a>
            </div>
        </div>
    </div>

@endsection