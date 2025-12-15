@extends('frontend.layouts.app')

@section('title', 'Login - Rubista')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card mt-5 shadow-sm">
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <i class="fas fa-lock fa-3x text-primary mb-3"></i>
                        <h3>Welcome Back</h3>
                        <p class="text-muted">Sign in to your account</p>
                    </div>
                    
                    <!-- Tabs for Login Methods -->
                    <ul class="nav nav-tabs mb-4" id="loginTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="password-tab" data-bs-toggle="tab" data-bs-target="#password-login" type="button" role="tab">
                                <i class="fas fa-key me-2"></i>Password
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="otp-tab" data-bs-toggle="tab" data-bs-target="#otp-login" type="button" role="tab">
                                <i class="fas fa-mobile-alt me-2"></i>OTP Login
                            </button>
                        </li>
                    </ul>
                    
                    <div class="tab-content" id="loginTabsContent">
                        <!-- Password Login Tab -->
                        <div class="tab-pane fade" id="password-login" role="tabpanel">
                            <form method="POST" action="{{ route('frontend.login') }}" id="password-login-form">
                                @csrf
                                
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           id="email" name="email" value="{{ old('email') }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                           id="password" name="password" required>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                    <label class="form-check-label" for="remember">
                                        Remember me
                                    </label>
                                </div>
                                
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-sign-in-alt me-2"></i>Sign In
                                </button>
                            </form>
                        </div>
                        
                        <!-- OTP Login Tab -->
                        <div class="tab-pane fade show active" id="otp-login" role="tabpanel">
                            <form id="otp-login-form">
                                @csrf
                                <input type="hidden" name="type" value="login">
                                
                                <div class="mb-3">
                                    <label for="otp-phone" class="form-label">Phone Number</label>
                                    <div class="input-group">
                                        <span class="input-group-text">+91</span>
                                        <input type="tel" class="form-control" 
                                               id="otp-phone" name="phone" 
                                               placeholder="Enter 10-digit mobile number" 
                                               pattern="[0-9]{10}" maxlength="10" required>
                                    </div>
                                    <small class="text-muted">Enter your registered phone number</small>
                                </div>
                                
                                <div id="otp-send-section">
                                    <button type="button" class="btn btn-primary w-100" id="send-otp-btn">
                                        <i class="fas fa-paper-plane me-2"></i>Send OTP
                                    </button>
                                </div>
                                
                                <div id="otp-verify-section" style="display: none;">
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle me-2"></i>
                                        OTP sent to <strong id="otp-phone-display"></strong>
                                        <br>
                                        <small id="otp-display" class="text-danger fw-bold"></small>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="otp-code" class="form-label">Enter OTP</label>
                                        <input type="text" class="form-control text-center" 
                                               id="otp-code" name="otp" 
                                               placeholder="000000" 
                                               pattern="[0-9]{6}" maxlength="6" 
                                               style="font-size: 1.5rem; letter-spacing: 0.5rem;">
                                        <small class="text-muted">Enter the 6-digit OTP sent to your phone</small>
                                    </div>
                                    
                                    <button type="submit" class="btn btn-success w-100 mb-2">
                                        <i class="fas fa-check me-2"></i>Verify & Login
                                    </button>
                                    
                                    <button type="button" class="btn btn-link w-100" id="resend-otp-btn">
                                        <i class="fas fa-redo me-2"></i>Resend OTP
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <div class="text-center mt-3">
                        <p class="mb-0">Don't have an account? 
                            <a href="{{ route('frontend.register') }}" class="text-decoration-none">Sign up</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const otpForm = document.getElementById('otp-login-form');
    const sendOtpBtn = document.getElementById('send-otp-btn');
    const resendOtpBtn = document.getElementById('resend-otp-btn');
    const otpSendSection = document.getElementById('otp-send-section');
    const otpVerifySection = document.getElementById('otp-verify-section');
    const otpPhoneInput = document.getElementById('otp-phone');
    const otpPhoneDisplay = document.getElementById('otp-phone-display');
    const otpCodeInput = document.getElementById('otp-code');
    const otpDisplay = document.getElementById('otp-display');
    
    let otpSent = false;
    
    // Send OTP
    sendOtpBtn.addEventListener('click', function() {
        const phone = otpPhoneInput.value.trim();
        
        if (!phone || phone.length !== 10) {
            alert('Please enter a valid 10-digit phone number');
            return;
        }
        
        sendOtpBtn.disabled = true;
        sendOtpBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Sending...';
        
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        fetch('{{ route("frontend.otp.send") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                phone: phone,
                type: 'login'
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                otpSent = true;
                otpSendSection.style.display = 'none';
                otpVerifySection.style.display = 'block';
                otpPhoneDisplay.textContent = '+91 ' + phone;
                otpDisplay.textContent = 'OTP: ' + data.otp; // Remove in production
                otpCodeInput.focus();
                
                // Start countdown for resend
                let countdown = 60;
                resendOtpBtn.disabled = true;
                const countdownInterval = setInterval(() => {
                    countdown--;
                    resendOtpBtn.innerHTML = `<i class="fas fa-redo me-2"></i>Resend OTP (${countdown}s)`;
                    if (countdown <= 0) {
                        clearInterval(countdownInterval);
                        resendOtpBtn.disabled = false;
                        resendOtpBtn.innerHTML = '<i class="fas fa-redo me-2"></i>Resend OTP';
                    }
                }, 1000);
            } else {
                alert(data.message || 'Failed to send OTP');
                sendOtpBtn.disabled = false;
                sendOtpBtn.innerHTML = '<i class="fas fa-paper-plane me-2"></i>Send OTP';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error sending OTP. Please try again.');
            sendOtpBtn.disabled = false;
            sendOtpBtn.innerHTML = '<i class="fas fa-paper-plane me-2"></i>Send OTP';
        });
    });
    
    // Resend OTP
    resendOtpBtn.addEventListener('click', function() {
        sendOtpBtn.click();
    });
    
    // Verify OTP
    otpForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        if (!otpSent) {
            alert('Please send OTP first');
            return;
        }
        
        const phone = otpPhoneInput.value.trim();
        const otp = otpCodeInput.value.trim();
        
        if (otp.length !== 6) {
            alert('Please enter a valid 6-digit OTP');
            return;
        }
        
        const submitBtn = otpForm.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Verifying...';
        
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        fetch('{{ route("frontend.otp.verify") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                phone: phone,
                otp: otp,
                type: 'login'
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = data.redirect || '{{ route("frontend.home") }}';
            } else {
                alert(data.message || 'Invalid OTP. Please try again.');
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-check me-2"></i>Verify & Login';
                otpCodeInput.value = '';
                otpCodeInput.focus();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error verifying OTP. Please try again.');
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-check me-2"></i>Verify & Login';
        });
    });
    
    // Auto-format phone input
    otpPhoneInput.addEventListener('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    
    // Auto-format OTP input
    otpCodeInput.addEventListener('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
});
</script>
@endsection
