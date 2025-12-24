<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use App\Services\Fast2SmsService;

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
            'phone' => ['required', 'regex:/^[0-9]{10}$/'],
            'type'  => ['required', 'in:login,register']
        ]);

        $phone = $request->phone;
        $type  = $request->type;

        $cacheKey = "otp_{$phone}";
        $cooldownKey = "otp_cooldown_{$phone}";

        // 🚫 Prevent OTP spam (60 sec cooldown)
        if (Cache::has($cooldownKey)) {
            return response()->json([
                'success' => false,
                'message' => 'Please wait before requesting another OTP.'
            ], 429);
        }

        // 🔢 Generate OTP
        $otp = random_int(100000, 999999);

        // ⏱ Expiry time
        $expiryMinutes = $type === 'login' ? 5 : 10;

        // 🔐 Store HASHED OTP
        Cache::put($cacheKey, [
            'otp'        => Hash::make($otp),
            'type'       => $type,
            'expires_at' => now()->addMinutes($expiryMinutes),
        ], now()->addMinutes($expiryMinutes));

        // ⏳ Set cooldown
        Cache::put($cooldownKey, true, now()->addSeconds(60));

        // 📩 Send SMS - Try main SMS service first
        $smsResult = $type === 'register'
            ? SmsService::sendRegistrationOtp($phone, $otp)
            : SmsService::sendLoginOtp($phone, $otp);

        $smsSuccess = $smsResult['success'] ?? false;
        $smsMessage = $smsResult['message'] ?? 'Unknown error';
        $smsError = $smsResult['error'] ?? null;

        // 🔄 Fallback to Fast2SMS if main SMS service fails
        if (!$smsSuccess && !empty(config('services.fast2sms.key'))) {
            Log::info('Main SMS service failed, trying Fast2SMS fallback', [
                'phone' => $phone,
                'error' => $smsError
            ]);
            
            $fast2smsResult = Fast2SmsService::sendOtp($phone, $otp);
            $fast2smsSuccess = $fast2smsResult['success'] ?? false;
            
            if ($fast2smsSuccess) {
                $smsSuccess = true;
                $smsMessage = 'OTP sent successfully via Fast2SMS';
                $smsError = null;
                Log::info('Fast2SMS fallback succeeded', ['phone' => $phone]);
            } else {
                $smsMessage = $fast2smsResult['message'] ?? $smsMessage;
                $smsError = $fast2smsResult['error'] ?? $smsError;
                Log::warning('Fast2SMS fallback also failed', [
                    'phone' => $phone,
                    'error' => $fast2smsResult['error'] ?? 'Unknown error'
                ]);
            }
        }

        // ⚠️ Debug only (NEVER in production)
        // Show OTP in debug mode if SMS failed OR if debug is enabled
        $showOtp = config('app.debug');

        // Log SMS failure details
        if (!$smsSuccess) {
            Log::warning('OTP SMS sending failed', [
                'phone' => $phone,
                'type' => $type,
                'error' => $smsError,
                'message' => $smsMessage,
                'otp' => $otp
            ]);
        }

        return response()->json([
            'success' => $smsSuccess,
            'message' => $smsSuccess
                ? 'OTP sent successfully to your mobile'
                : ($smsMessage ?: 'OTP generated but SMS failed. Please check your SMS configuration.'),
            'phone'   => $phone,
            'otp'     => $showOtp ? $otp : null,
            'debug'   => $showOtp,
            'sms_error' => $smsSuccess ? null : $smsError
        ], $smsSuccess ? 200 : 500);
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
        
        $cacheKey = "otp_{$phone}";
        
        // Get stored OTP from cache
        $storedOtp = Cache::get($cacheKey);
        
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
            Cache::forget($cacheKey);
            if ($request->ajax() || $request->wantsJson() || $request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'OTP has expired. Please request a new OTP.'
                ], 422);
            }
            return back()->withErrors(['otp' => 'OTP has expired. Please request a new OTP.'])->withInput();
        }

        // Verify OTP (compare hashed OTP)
        if (!Hash::check($otp, $storedOtp['otp']) || $storedOtp['type'] !== $type) {
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
            Cache::forget($cacheKey);
            
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
            Cache::forget($cacheKey);
            
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