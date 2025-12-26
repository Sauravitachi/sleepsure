@extends('layouts.auth')

@section('title', 'Login - SleepSure')

@section('content')

    <!-- Auth Section -->
    <section class="auth-section">
        <div class="auth-container">
            <div class="auth-image">
                <div class="auth-image-content">
                    <h2>Better Sleep Awaits</h2>
                    <p>Experience the comfort of SleepSure with quick and secure OTP login. No passwords to remember!</p>
                </div>
            </div>
            <div class="auth-forms" id="auth-forms">
                <!-- Phone Form -->
                <div class="form-container" id="phone-form">
                    <h2 class="form-title">Welcome Back</h2>
                    <p class="form-subtitle">Enter your mobile number to continue</p>
                    
                    <form id="phoneForm" method="POST" action="{{ route('login.submit') }}">
                        @csrf
                        <div class="form-group">
                            <label for="phone-number">Mobile Number</label>
                            <div class="phone-input-container">
                                <div class="country-code">
                                    <i class="fas fa-flag"></i> +91
                                </div>
                                <input type="tel" id="phone-number" name="phone" class="phone-input" placeholder="Enter your 10-digit mobile number" maxlength="10" required>
                            </div>
                            @error('phone')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <button type="submit" class="auth-btn text-center" id="send-otp-btn">
                            Send OTP
                        </button>
                    </form>
                    
                    <div class="divider">
                        <span>Or continue with</span>
                    </div>
                    
                    <div class="social-login">
                        <button class="social-btn google">
                            <i class="fab fa-google"></i> Google
                        </button>
                        <button class="social-btn facebook">
                            <i class="fab fa-facebook-f"></i> Facebook
                        </button>
                    </div>
                    
                    <div class="auth-switch">
                        New to SleepSure? <a href="{{ route('signup') }}" id="switch-to-signup">Create Account</a>
                    </div>
                </div>
                
           
            </div>
        </div>
    </section>

@endsection
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('phoneForm');
    const phoneInput = document.getElementById('phone-number');

    phoneInput.addEventListener('input', () => {
        phoneInput.value = phoneInput.value.replace(/\D/g, '');
    });

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const phone = phoneInput.value;

        if (phone.length !== 10) {
            alert('Please enter a valid 10-digit mobile number');
            return;
        }

        const formData = new FormData();
        formData.append('mobile', phone);
        formData.append('type', 'otp');

        const csrfToken = document.querySelector('input[name=_token]').value;

        fetch('/send-otp', {
            method: 'POST',
            body: formData,
            headers: { 'X-CSRF-TOKEN': csrfToken }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                if (data.otp) {
                    alert('Your OTP is: ' + data.otp); // Show OTP in alert
                }
                window.location.href = '/verify-otp';
            } else {
                alert(data.message || 'Failed to send OTP');
            }
        })
        .catch(err => {
            alert('OTP service error');
            console.error(err);
        });
    });
});
</script>
@endpush
