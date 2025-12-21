<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Show the login form
     */
    public function showLoginForm()
    {
        return view('frontend.auth.login');
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            
            // Redirect regular users to homepage
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Show the registration form
     */
    public function showRegisterForm()
    {
        return view('frontend.auth.register');
    }

    /**
     * Handle registration request
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => false, // Regular users are not admin
        ]);

        Auth::login($user);

        return redirect()->route('frontend.home')->with('success', 'Registration successful! Welcome to Rubista!');
    }

    /**
     * Handle logout request
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('frontend.home');
    }

    /**
     * Send OTP for login/registration
     */
    public function sendOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|regex:/^[0-9]{10}$/',
            'type' => 'required|in:login,register'
        ]);

        $phone = $request->phone;
        $type = $request->type;
        
        // Generate 4-digit OTP (as per user's example)
        $otp = rand(1000, 9999);
        
        // Store OTP in session with expiry (5 minutes for login, 10 minutes for registration)
        $expiryMinutes = $type === 'login' ? 5 : 10;
        Session::put('otp_' . $phone, [
            'code' => $otp,
            'expires_at' => now()->addMinutes($expiryMinutes),
            'type' => $type
        ]);

        // Send OTP via SMS service
        $smsResult = null;
        if ($type === 'register') {
            $smsResult = SmsService::sendRegistrationOtp($phone, $otp);
        } else {
            $smsResult = SmsService::sendLoginOtp($phone, $otp);
        }

        // Check if SMS was sent successfully
        $smsSuccess = $smsResult['success'] ?? false;
        
        // For development/testing: if SMS fails, still allow OTP in response (remove in production)
        $showOtpInResponse = !$smsSuccess && config('app.debug', false);

        if ($request->ajax()) {
            $response = [
                'success' => true,
                'message' => $smsSuccess 
                    ? 'OTP sent successfully to your mobile number!' 
                    : 'OTP generated. ' . ($smsResult['message'] ?? 'SMS service unavailable.'),
                'phone' => $phone
            ];

            // Only include OTP in response if debugging or SMS failed (remove in production)
            if ($showOtpInResponse) {
                $response['otp'] = $otp;
                $response['debug'] = true;
            }

            return response()->json($response);
        }

        $redirect = back()->with('otp_sent', true)
            ->with('phone', $phone)
            ->with('sms_sent', $smsSuccess);

        // Only include OTP in session if debugging (remove in production)
        if ($showOtpInResponse) {
            $redirect = $redirect->with('otp', $otp);
        }

        return $redirect;
    }

    /**
     * Verify OTP and login/register
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|regex:/^[0-9]{10}$/',
            'otp' => 'required|string|size:6',
            'type' => 'required|in:login,register',
            'name' => 'required_if:type,register|string|max:255',
        ]);

        $phone = $request->phone;
        $otp = $request->otp;
        $type = $request->type;
        
        // Get stored OTP from session
        $storedOtp = Session::get('otp_' . $phone);
        
        if (!$storedOtp) {
            if ($request->ajax() || $request->wantsJson() || $request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'OTP not found. Please request a new OTP.'
                ], 422);
            }
            return back()->withErrors(['otp' => 'OTP not found. Please request a new OTP.'])->withInput();
        }

        // Check if OTP expired
        if (now()->greaterThan($storedOtp['expires_at'])) {
            Session::forget('otp_' . $phone);
            if ($request->ajax() || $request->wantsJson() || $request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'OTP has expired. Please request a new OTP.'
                ], 422);
            }
            return back()->withErrors(['otp' => 'OTP has expired. Please request a new OTP.'])->withInput();
        }

        // Verify OTP
        if ($storedOtp['code'] !== $otp || $storedOtp['type'] !== $type) {
            if ($request->ajax() || $request->wantsJson() || $request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid OTP. Please try again.'
                ], 422);
            }
            return back()->withErrors(['otp' => 'Invalid OTP. Please try again.'])->withInput();
        }

        // OTP verified, proceed with login/registration
        if ($type === 'login') {
            // Find user by phone
            $user = User::where('phone', $phone)->first();
            
            if (!$user) {
                if ($request->ajax() || $request->wantsJson() || $request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'No account found with this phone number. Please register first.'
                    ], 422);
                }
                return back()->withErrors(['phone' => 'No account found with this phone number. Please register first.'])->withInput();
            }

            // Login user
            Auth::login($user, true);
            Session::forget('otp_' . $phone);
            
            if ($request->ajax() || $request->wantsJson() || $request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Login successful!',
                    'redirect' => route('frontend.home')
                ]);
            }

            return redirect()->route('frontend.home')->with('success', 'Login successful!');
        } else {
            // Registration
            // Check if phone already exists
            if (User::where('phone', $phone)->exists()) {
                if ($request->ajax() || $request->wantsJson() || $request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Phone number already registered. Please login instead.'
                    ], 422);
                }
                return back()->withErrors(['phone' => 'Phone number already registered. Please login instead.'])->withInput();
            }

            // Create new user
            $user = User::create([
                'name' => $request->name,
                'phone' => $phone,
                'email' => $phone . '@rubista.com', // Temporary email
                'password' => Hash::make(Str::random(16)), // Random password since OTP login
                'is_admin' => false,
            ]);

            // Login user
            Auth::login($user, true);
            Session::forget('otp_' . $phone);
            
            if ($request->ajax() || $request->wantsJson() || $request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Registration successful!',
                    'redirect' => route('frontend.home')
                ]);
            }

            return redirect()->route('frontend.home')->with('success', 'Registration successful! Welcome to Rubista!');
        }
    }
} 