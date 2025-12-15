<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
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
        
        // Generate 6-digit OTP
        $otp = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        
        // Store OTP in session with expiry (10 minutes)
        Session::put('otp_' . $phone, [
            'code' => $otp,
            'expires_at' => now()->addMinutes(10),
            'type' => $request->type
        ]);

        // In production, send OTP via SMS service
        // For now, we'll return it in response for testing
        // You can remove this in production
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'OTP sent successfully!',
                'otp' => $otp, // Remove this in production
                'phone' => $phone
            ]);
        }

        return back()->with('otp_sent', true)->with('phone', $phone)->with('otp', $otp); // Remove 'otp' in production
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