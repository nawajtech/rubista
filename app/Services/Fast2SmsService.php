<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Fast2SmsService
{
    /**
     * Send OTP via Fast2SMS
     *
     * @param string $mobile Mobile number (10 digits, without country code)
     * @param string $otp OTP code
     * @return array Response array with success status and message
     */
    public static function sendOtp($mobile, $otp)
    {
        try {
            $apiKey = config('services.fast2sms.key');
            
            if (empty($apiKey)) {
                return [
                    'success' => false,
                    'message' => 'Fast2SMS API key not configured. Please set FAST2SMS_API_KEY in .env file',
                    'error' => 'API key missing'
                ];
            }

            // Format mobile number (Fast2SMS expects 10-digit Indian numbers or with country code)
            $formattedMobile = preg_replace('/[^0-9]/', '', $mobile);
            
            // If 10 digits, add country code 91
            if (strlen($formattedMobile) === 10) {
                $formattedMobile = '91' . $formattedMobile;
            }

            $response = Http::timeout(30)
                ->withHeaders([
                    'authorization' => $apiKey,
                    'Content-Type'  => 'application/json',
                    'Accept'        => 'application/json',
                ])->post('https://www.fast2sms.com/dev/bulkV2', [
                    "route"            => "otp",
                    "variables_values" => (string) $otp,
                    "numbers"          => $formattedMobile,
                ]);

            $responseData = $response->json();
            $statusCode = $response->status();

            // Fast2SMS returns success in 'return' field
            $isSuccess = $statusCode === 200 && isset($responseData['return']) && $responseData['return'] === true;

            if ($isSuccess) {
                Log::info('Fast2SMS OTP sent successfully', [
                    'mobile' => $formattedMobile,
                    'response' => $responseData
                ]);

                return [
                    'success' => true,
                    'message' => 'OTP sent successfully',
                    'response' => $responseData
                ];
            } else {
                $errorMessage = $responseData['message'] ?? 'Failed to send OTP';
                
                Log::warning('Fast2SMS OTP sending failed', [
                    'mobile' => $formattedMobile,
                    'response' => $responseData,
                    'status_code' => $statusCode
                ]);

                return [
                    'success' => false,
                    'message' => $errorMessage,
                    'error' => $responseData,
                    'response' => $responseData,
                    'status_code' => $statusCode
                ];
            }
        } catch (\Exception $e) {
            Log::error('Fast2SMS service exception', [
                'mobile' => $mobile ?? 'unknown',
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => 'SMS service error: ' . $e->getMessage(),
                'error' => $e->getMessage()
            ];
        }
    }
}
