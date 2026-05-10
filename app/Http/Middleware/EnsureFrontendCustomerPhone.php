<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureFrontendCustomerPhone
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::check()) {
            return $next($request);
        }

        $user = Auth::user();

        if ($user->is_admin) {
            return $next($request);
        }

        if ($user->accountHasUsablePhone()) {
            return $next($request);
        }

        if ($this->isExempt($request)) {
            return $next($request);
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Please add your mobile number to continue.',
                'redirect' => route('frontend.phone.required'),
            ], 403);
        }

        return redirect()->route('frontend.phone.required');
    }

    private function isExempt(Request $request): bool
    {
        if ($request->routeIs([
            'frontend.phone.required',
            'frontend.phone.store',
            'frontend.logout',
            'frontend.login',
            'frontend.register',
            'frontend.otp.send',
            'frontend.otp.verify',
        ])) {
            return true;
        }

        if ($request->is('auth/google') || $request->is('auth/google/callback')) {
            return true;
        }

        return false;
    }
}
