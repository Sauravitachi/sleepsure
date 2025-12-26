@extends('layouts.auth')

@section('title', 'Sign Up - SleepSure')

@section('content')
    <div class="page-wrapper">
        <div class="content-container">
            <div class="grid-row">
                <div class="grid-half">
                    <div class="account-panel">
                        <div class="brand-section">
                            <div class="brand-logo" style="margin: 60px auto;">
                                <a href="{{ route('home') }}">
                                    <img src="{{ $logo_url }}" alt="SleepSure" class="home-icon">
                                </a>
                            </div>
                            <div class="welcome-content">
                                <h1>Join SleepSure Family</h1>
                                <p>Create your account to unlock exclusive sleep solutions, personalized
                                    recommendations, and member-only benefits for your perfect night's rest.</p>
                            </div>
                            <div class="benefits-list">
                                <div class="benefit-item">
                                    <div class="benefit-icon">
                                        <i class="fas fa-check"></i>
                                    </div>
                                    <span>Premium member discounts</span>
                                </div>
                                <div class="benefit-item">
                                    <div class="benefit-icon">
                                        <i class="fas fa-check"></i>
                                    </div>
                                    <span>Free shipping & easy returns</span>
                                </div>
                                <div class="benefit-item">
                                    <div class="benefit-icon">
                                        <i class="fas fa-check"></i>
                                    </div>
                                    <span>100-night sleep trial</span>
                                </div>
                                <div class="benefit-item">
                                    <div class="benefit-icon">
                                        <i class="fas fa-check"></i>
                                    </div>
                                    <span>Expert sleep guidance</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid-half">
                    <div class="account-panel">
                        <div class="form-section">
                            <div class="form-header">
                                <h2 class="form-heading">Create Your Account</h2>
                                <p class="form-description">Start your journey to better sleep today</p>
                            </div>

                            <form id="accountForm" method="POST" action="{{ route('signup.submit') }}">
                                @csrf
                                
                                @if(session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
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
                                
                                <div class="input-row">
                                    <div class="input-half">
                                        <div class="field-group">
                                            <label for="userFirstName" class="field-label">First Name</label>
                                            <input type="text" class="field-input" id="userFirstName" name="first_name"
                                                placeholder="Enter first name" value="{{ old('first_name') }}" required>
                                        </div>
                                    </div>
                                    <div class="input-half">
                                        <div class="field-group">
                                            <label for="userLastName" class="field-label">Last Name</label>
                                            <input type="text" class="field-input" id="userLastName" name="last_name"
                                                placeholder="Enter last name" value="{{ old('last_name') }}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="field-group">
                                    <label for="userEmail" class="field-label">Email Address</label>
                                    <input type="email" class="field-input" id="userEmail" name="customer_email"
                                        placeholder="Enter your email (optional)" value="{{ old('customer_email') }}">
                                </div>

                                <div class="field-group">
                                    <label for="userPhone" class="field-label">Mobile Number</label>
                                    <input type="tel" class="field-input" id="userPhone" name="phone"
                                        placeholder="Enter your 10-digit mobile number" value="{{ old('phone') }}" maxlength="10" required>
                                </div>
                                
                                <div class="checkbox-container">
                                    <div class="checkbox-item">
                                        <input type="checkbox" class="checkbox-input" id="acceptTerms" required>
                                        <label for="acceptTerms" class="checkbox-text">
                                            I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy
                                                Policy</a>
                                        </label>
                                    </div>

                                    <div class="checkbox-item">
                                        <input type="checkbox" class="checkbox-input" id="receiveUpdates">
                                        <label for="receiveUpdates" class="checkbox-text">
                                            Send me sleep tips, exclusive offers, and product updates
                                        </label>
                                    </div>
                                </div>

                                <button type="submit" class="submit-button" id="createAccountBtn">
                                    Create Account
                                </button>
                            </form>

                            <div class="separator">
                                <span class="separator-text">Or continue with</span>
                            </div>

                            <div class="social-buttons">
                                <button type="button" class="social-button">
                                    <i class="fab fa-google"></i> Google
                                </button>
                                <button type="button" class="social-button">
                                    <i class="fab fa-facebook-f"></i> Facebook
                                </button>
                            </div>

                            <div class="auth-link">
                                Already have an account? <a href="{{ route('login') }}">Sign in here</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const phoneInput = document.getElementById('userPhone');
        // Only allow numbers in phone
        phoneInput.addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    });
</script>
@endpush