@extends('layouts.auth')

@section('title', 'OTP Verification - SleepSure')

@section('content')
<section class="otp-main">
    <div class="otp-container">

        <!-- HEADER -->
        <div class="otp-header">
            <a href="{{ route('login') }}" class="back-btn">
                <i class="fas fa-arrow-left"></i>
            </a>

            <div class="logo">
                <img src="{{ asset('assets/images/logo.png') }}" alt="SleepSure" width="125">
            </div>
        </div>

        <!-- CONTENT -->
        <div class="otp-content">

            <h1 class="otp-title">Verify OTP</h1>
            <p class="otp-subtitle">Enter the 6-digit code sent to your mobile number</p>

            <!-- MOBILE DISPLAY (NOT INPUT) -->
            <div class="phone-number">
                +91 ••••• {{ substr(session('otp_phone'), -4) }}
            </div>

            <!-- ALERTS -->
            <div class="success-message" id="successMessage" style="display:none;">
                <i class="fas fa-check-circle"></i> OTP verified successfully!
            </div>

            <div class="error-message" id="errorMessage" style="display:none;">
                <i class="fas fa-exclamation-circle"></i> Invalid OTP. Please try again.
            </div>

            <!-- OTP FORM -->
            <form id="otpForm">
                @csrf


                <div class="otp-inputs">
                    @for ($i = 0; $i < 6; $i++)
                        <input type="text" class="otp-input" maxlength="1" inputmode="numeric">
                    @endfor
                </div>

                <input type="hidden" id="otp" name="otp">
                <input type="hidden" id="mobile" name="mobile" value="{{ session('otp_phone') }}">

                <!-- TIMER -->
                <div class="timer-section">
                    <div class="timer">
                        Code expires in <span class="countdown" id="countdown">02:00</span>
                    </div>
                </div>

                <!-- RESEND -->
                <div class="resend-otp">
                    <a href="#" class="resend-link disabled" id="resendOtp">
                        <i class="fas fa-redo"></i> Resend OTP
                    </a>
                </div>

                <!-- VERIFY BUTTON -->
                <button type="submit" class="verify-btn">
                    <i class="fas fa-shield-alt"></i> Verify & Continue
                </button>
            </form>

            <div class="help-text">
                Didn't receive the code? Check SMS or wait for resend timer.
            </div>

            <div class="contact-support">
                <a href="#" class="support-link">
                    <i class="fas fa-headset"></i> Need help? Contact Support
                </a>
            </div>

        </div>
    </div>
</section>
@endsection
@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", () => {

    const inputs = document.querySelectorAll(".otp-input");
    const otpHidden = document.getElementById("otp");
    const form = document.getElementById("otpForm");
    const errorBox = document.getElementById("errorMessage");
    const successBox = document.getElementById("successMessage");

    // ✅ SAFE CSRF (from @csrf)
    const csrfToken = document.querySelector('input[name="_token"]').value;

    /* OTP INPUT */
    inputs[0].focus();

    inputs.forEach((input, i) => {
        input.addEventListener("input", () => {
            input.value = input.value.replace(/\D/g, '');
            if (input.value && i < inputs.length - 1) {
                inputs[i + 1].focus();
            }
            otpHidden.value = [...inputs].map(el => el.value).join('');
        });

        input.addEventListener("keydown", e => {
            if (e.key === "Backspace" && !input.value && i > 0) {
                inputs[i - 1].focus();
            }
        });
    });

    /* VERIFY OTP */
    form.addEventListener("submit", e => {
        e.preventDefault();

        errorBox.style.display = "none";
        successBox.style.display = "none";

        if (otpHidden.value.length !== 6) {
            errorBox.innerText = "Please enter 6-digit OTP";
            errorBox.style.display = "block";
            return;
        }

        fetch("/verify-otp-proxy", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken
            },
            // ✅ SEND ONLY OTP (mobile comes from session)
            body: JSON.stringify({
                otp: otpHidden.value
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                successBox.style.display = "block";
                setTimeout(() => {
                    window.location.href = data.redirect || "/";
                }, 800);
            } else {
                errorBox.innerText = data.message || "Invalid OTP";
                errorBox.style.display = "block";
            }
        })
        .catch(() => {
            errorBox.innerText = "Verification failed";
            errorBox.style.display = "block";
        });
    });

    /* TIMER */
    let time = 120;
    const countdown = document.getElementById("countdown");
    const resend = document.getElementById("resendOtp");

    function startTimer() {
        const m = String(Math.floor(time / 60)).padStart(2, '0');
        const s = String(time % 60).padStart(2, '0');
        countdown.textContent = `${m}:${s}`;

        if (time-- > 0) setTimeout(startTimer, 1000);
        else resend.classList.remove("disabled");
    }
    startTimer();

    /* RESEND OTP */
    resend.addEventListener("click", e => {
        e.preventDefault();
        if (resend.classList.contains("disabled")) return;

        resend.classList.add("disabled");

        fetch("/resend-otp", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": csrfToken
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                time = 120;
                startTimer();
            } else {
                alert(data.message || "Failed to resend OTP");
                resend.classList.remove("disabled");
            }
        });
    });

});
</script>
@endpush
