@extends('frontend.layouts.app')

@section('title', 'Register - Rubista')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card mt-5 shadow-sm">
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <i class="fas fa-user-plus fa-3x text-primary mb-3"></i>
                        <h3>Join Rubista</h3>
                        <p class="text-muted">Create your account today</p>
                    </div>
                    
                    <!-- Tabs for Registration Methods -->
                    <ul class="nav nav-tabs mb-4" id="registerTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="password-register-tab" data-bs-toggle="tab" data-bs-target="#password-register" type="button" role="tab">
                                <i class="fas fa-key me-2"></i>Password
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="otp-register-tab" data-bs-toggle="tab" data-bs-target="#otp-register" type="button" role="tab">
                                <i class="fas fa-mobile-alt me-2"></i>OTP Signup
                            </button>
                        </li>
                    </ul>
                    
                    <div class="tab-content" id="registerTabsContent">
                        <!-- Password Registration Tab -->
                        <div class="tab-pane fade" id="password-register" role="tabpanel">
                            <form method="POST" action="{{ route('frontend.register') }}" id="password-register-form">
                                @csrf
                                
                                <div class="mb-3">
                                    <label for="name" class="form-label">Full Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
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
                                
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control" 
                                           id="password_confirmation" name="password_confirmation" required>
                                </div>
                                
                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" id="terms" required>
                                    <label class="form-check-label" for="terms">
                                        I agree to the <a href="#" class="text-decoration-none">Terms of Service</a>
                                    </label>
                                </div>
                                
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-user-plus me-2"></i>Create Account
                                </button>
                            </form>
                        </div>
                        
                        <!-- OTP Registration Tab -->
                        <div class="tab-pane fade show active" id="otp-register" role="tabpanel">
                            <form id="otp-register-form">
                                @csrf
                                <input type="hidden" name="type" value="register">
                                
                                <div class="mb-3">
                                    <label for="register-name" class="form-label">Full Name</label>
                                    <input type="text" class="form-control" 
                                           id="register-name" name="name" 
                                           placeholder="Enter your full name" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="register-phone" class="form-label">Phone Number</label>
                                    <div class="input-group">
                                        <span class="input-group-text">+91</span>
                                        <input type="tel" class="form-control" 
                                               id="register-phone" name="phone" 
                                               placeholder="Enter 10-digit mobile number" 
                                               pattern="[0-9]{10}" maxlength="10" required>
                                    </div>
                                    <small class="text-muted">We'll send you an OTP to verify your number</small>
                                </div>
                                
                                <div id="register-otp-send-section">
                                    <button type="button" class="btn btn-primary w-100" id="register-send-otp-btn">
                                        <i class="fas fa-paper-plane me-2"></i>Send OTP
                                    </button>
                                </div>
                                
                                <div id="register-otp-verify-section" style="display: none;">
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle me-2"></i>
                                        OTP sent to <strong id="register-otp-phone-display"></strong>
                                        <br>
                                        <small id="register-otp-display" class="text-danger fw-bold"></small>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="register-otp-code" class="form-label">Enter OTP</label>
                                        <input type="text" class="form-control text-center" 
                                               id="register-otp-code" name="otp" 
                                               placeholder="000000" 
                                               pattern="[0-9]{6}" maxlength="6" 
                                               style="font-size: 1.5rem; letter-spacing: 0.5rem;">
                                        <small class="text-muted">Enter the 6-digit OTP sent to your phone</small>
                                    </div>
                                    
                                    <button type="submit" class="btn btn-success w-100 mb-2">
                                        <i class="fas fa-check me-2"></i>Verify & Sign Up
                                    </button>
                                    
                                    <button type="button" class="btn btn-link w-100" id="register-resend-otp-btn">
                                        <i class="fas fa-redo me-2"></i>Resend OTP
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <div class="text-center mt-3">
                        <p class="mb-0">Already have an account? 
                            <a href="{{ route('frontend.login') }}" class="text-decoration-none">Sign in</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const otpForm = document.getElementById('otp-register-form');
    const sendOtpBtn = document.getElementById('register-send-otp-btn');
    const resendOtpBtn = document.getElementById('register-resend-otp-btn');
    const otpSendSection = document.getElementById('register-otp-send-section');
    const otpVerifySection = document.getElementById('register-otp-verify-section');
    const otpPhoneInput = document.getElementById('register-phone');
    const otpPhoneDisplay = document.getElementById('register-otp-phone-display');
    const otpCodeInput = document.getElementById('register-otp-code');
    const otpDisplay = document.getElementById('register-otp-display');
    const nameInput = document.getElementById('register-name');
    
    let otpSent = false;
    
    // Send OTP
    sendOtpBtn.addEventListener('click', function() {
        const phone = otpPhoneInput.value.trim();
        const name = nameInput.value.trim();
        
        if (!name) {
            alert('Please enter your name');
            nameInput.focus();
            return;
        }
        
        if (!phone || phone.length !== 10) {
            alert('Please enter a valid 10-digit phone number');
            otpPhoneInput.focus();
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
                type: 'register'
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
        const name = nameInput.value.trim();
        
        if (!name) {
            alert('Please enter your name');
            nameInput.focus();
            return;
        }
        
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
                type: 'register',
                name: name
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = data.redirect || '{{ route("frontend.home") }}';
            } else {
                alert(data.message || 'Invalid OTP. Please try again.');
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-check me-2"></i>Verify & Sign Up';
                otpCodeInput.value = '';
                otpCodeInput.focus();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error verifying OTP. Please try again.');
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-check me-2"></i>Verify & Sign Up';
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
