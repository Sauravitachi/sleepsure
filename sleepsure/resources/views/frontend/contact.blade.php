@extends('layouts.app')

@section('title', 'Premium Mattress & Sleep Solutions')

@section('content')
<div class="contact-container">
        <div class="contact-header">
            <h1 class="page-title">Get In Touch</h1>
            <p class="page-subtitle">We're here to help you find the perfect sleep solution. Reach out to our team for any questions or support.</p>
        </div>

        <div class="contact-grid">
            <!-- Contact Form -->
            <div class="contact-form-section">
                <h2 class="form-title">Send us a Message</h2>
                
                @if(session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul style="margin: 0; padding-left: 20px;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <form id="contactForm" method="POST" action="{{ route('contact.submit') }}">
                    @csrf
                    <div class="form-group">
                        <label class="form-label" for="full_name">Full Name</label>
                        <input type="text" class="form-control" id="full_name" name="full_name" 
                               placeholder="Enter your full name" value="{{ old('full_name') }}" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="email">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" 
                               placeholder="Enter your email" value="{{ old('email') }}" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="phone">Phone Number</label>
                        <input type="tel" class="form-control" id="phone" name="phone" 
                               placeholder="Enter your phone number" value="{{ old('phone') }}">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="subject">Subject</label>
                        <select class="form-control" id="subject" name="subject" required>
                            <option value="">Select a subject</option>
                            <option value="product-info" {{ old('subject') == 'product-info' ? 'selected' : '' }}>Product Information</option>
                            <option value="order-support" {{ old('subject') == 'order-support' ? 'selected' : '' }}>Order Support</option>
                            <option value="warranty-claim" {{ old('subject') == 'warranty-claim' ? 'selected' : '' }}>Warranty Claim</option>
                            <option value="complaint" {{ old('subject') == 'complaint' ? 'selected' : '' }}>Complaint</option>
                            <option value="general" {{ old('subject') == 'general' ? 'selected' : '' }}>General Inquiry</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="message">Message</label>
                        <textarea class="form-control" id="message" name="message" 
                                  placeholder="Tell us how we can help you..." required>{{ old('message') }}</textarea>
                    </div>
                    
                    <button type="submit" class="submit-btn">
                        <i class="fas fa-paper-plane"></i> Send Message
                    </button>
                </form>
            </div>

            <!-- Contact Information -->
            <div class="contact-info-section">
                @foreach($supportCall as $item)
                    <div class="info-card">
                        <div class="card-header">
                            <div class="card-icon">
                                <i class="fas 
                                    @if($item->alias == 'customer_support') fa-headset
                                    @elseif($item->alias == 'sales_team') fa-shopping-cart
                                    @elseif($item->alias == 'visit_our_showroom') fa-store
                                    @else fa-info-circle
                                    @endif
                                "></i>
                            </div>
                            <div>
                                <h3 class="card-title">{{ $item->title }}</h3>
                                <p>
                                    @if($item->alias == 'customer_support')
                                        Get help with your order or product
                                    @elseif($item->alias == 'sales_team')
                                        Questions about products or pricing
                                    @elseif($item->alias == 'visit_our_showroom')
                                        Experience our mattresses in person
                                    @endif
                                </p>
                            </div>
                        </div>

                        <ul class="contact-details">
                            @if($item->phone)
                                <li><i class="fas fa-phone"></i> {{ $item->phone }}</li>
                            @endif

                            @if($item->email)
                                <li><i class="fas fa-envelope"></i> {{ $item->email }}</li>
                            @endif

                            @if($item->address1)
                                <li><i class="fas fa-map-marker-alt"></i> {{ $item->address1 }}</li>
                            @endif

                            @if($item->address2)
                                <li><i class="fas fa-city"></i> {{ $item->address2 }}</li>
                            @endif
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Map Section -->
        <div class="map-section">
            <div class="map-header">
                <h3 class="map-title">Our Location</h3>
            </div>
            <div class="map-placeholder">
                <i class="fas fa-map-marked-alt map-icon"></i>
                <h3>SleepSure Showroom</h3>
                <p>123 Sleep Street, Restful City, RC 12345</p>
                <p style="margin-top: var(--spacing-sm); font-size: 0.9rem; opacity: 0.8;">
                    <i class="fas fa-directions"></i> Get Directions
                </p>
            </div>
        </div>

       
    </div>

@endsection