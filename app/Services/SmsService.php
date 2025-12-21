<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
use App\Models\SmsLog;

class SmsService
{
    /**
     * Template IDs for different SMS types
     */
    const TEMPLATE_ID_REGISTRATION = 'TEMPLATE_ID_REGISTRATION';
    const TEMPLATE_ID_LOGIN = 'TEMPLATE_ID_LOGIN';
    const TEMPLATE_ID_BOOKING = 'TEMPLATE_ID_BOOKING';
    const TEMPLATE_ID_ORDER = 'TEMPLATE_ID_ORDER';
    const TEMPLATE_ID_GENERAL = 'TEMPLATE_ID_GENERAL';

    /**
     * Send SMS message
     *
     * @param string $mobile Mobile number (without country code)
     * @param string $message Message content
     * @param string $templateId Template ID for the SMS
     * @param array $options Additional options (country_code, etc.)
     * @return array Response array with success status and message
     */
    public static function send($mobile, $message, $templateId = self::TEMPLATE_ID_GENERAL, $options = [])
    {
        try {
            // Get SMS configuration
            $config = Config::get('services.sms');
            
            // Validate configuration
            if (empty($config['api_url']) || empty($config['username']) || empty($config['password'])) {
                Log::error('SMS configuration missing', ['config' => $config]);
                return [
                    'success' => false,
                    'message' => 'SMS service not configured properly',
                    'error' => 'Configuration missing'
                ];
            }

            // Format mobile number
            $countryCode = $options['country_code'] ?? $config['country_code'] ?? '91';
            $formattedMobile = self::formatMobileNumber($mobile, $countryCode);

            // Prepare request data
            $requestData = [
                'username' => $config['username'],
                'password' => $config['password'],
                'senderid' => $config['sender_id'] ?? 'RUBISTA',
                'templateid' => $templateId,
                'mobile' => $formattedMobile,
                'message' => $message,
            ];

            // Add any additional parameters
            if (isset($options['additional_params'])) {
                $requestData = array_merge($requestData, $options['additional_params']);
            }

            // Send SMS via HTTP request
            $response = Http::timeout(30)
                ->asForm()
                ->post($config['api_url'], $requestData);

            $responseBody = $response->body();
            $responseData = $response->json() ?? ['raw' => $responseBody];
            $statusCode = $response->status();

            // Determine success based on response
            $isSuccess = self::isSuccessResponse($responseData, $statusCode);

            // Log SMS
            self::logSms($formattedMobile, $message, $templateId, $isSuccess, $responseData, $requestData);

            if ($isSuccess) {
                Log::info('SMS sent successfully', [
                    'mobile' => $formattedMobile,
                    'template_id' => $templateId
                ]);

                return [
                    'success' => true,
                    'message' => 'SMS sent successfully',
                    'response' => $responseData
                ];
            } else {
                Log::warning('SMS sending failed', [
                    'mobile' => $formattedMobile,
                    'template_id' => $templateId,
                    'response' => $responseData
                ]);

                return [
                    'success' => false,
                    'message' => 'Failed to send SMS',
                    'error' => $responseData,
                    'response' => $responseData
                ];
            }

        } catch (\Exception $e) {
            Log::error('SMS service exception', [
                'mobile' => $mobile ?? 'unknown',
                'template_id' => $templateId ?? 'unknown',
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // Log SMS failure
            if (isset($mobile)) {
                self::logSms(
                    self::formatMobileNumber($mobile, $options['country_code'] ?? '91'),
                    $message ?? '',
                    $templateId ?? self::TEMPLATE_ID_GENERAL,
                    false,
                    ['error' => $e->getMessage()],
                    []
                );
            }

            return [
                'success' => false,
                'message' => 'SMS service error: ' . $e->getMessage(),
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Format mobile number with country code
     *
     * @param string $mobile Mobile number
     * @param string $countryCode Country code (default: 91 for India)
     * @return string Formatted mobile number
     */
    private static function formatMobileNumber($mobile, $countryCode = '91')
    {
        // Remove any non-numeric characters
        $mobile = preg_replace('/[^0-9]/', '', $mobile);

        // Remove leading country code if already present
        if (strpos($mobile, $countryCode) === 0) {
            $mobile = substr($mobile, strlen($countryCode));
        }

        // Add country code
        return $countryCode . $mobile;
    }

    /**
     * Check if SMS response indicates success
     *
     * @param array|string $response Response from SMS gateway
     * @param int $statusCode HTTP status code
     * @return bool
     */
    private static function isSuccessResponse($response, $statusCode)
    {
        // HTTP status should be 200
        if ($statusCode !== 200) {
            return false;
        }

        // Check common success indicators in response
        if (is_array($response)) {
            // Some providers return 'status' => 'success'
            if (isset($response['status']) && strtolower($response['status']) === 'success') {
                return true;
            }
            // Some providers return 'error' => null or empty
            if (isset($response['error']) && empty($response['error'])) {
                return true;
            }
            // Some providers return 'message_id' on success
            if (isset($response['message_id']) && !empty($response['message_id'])) {
                return true;
            }
        }

        // If response contains 'success' or 'sent' keywords
        $responseString = is_array($response) ? json_encode($response) : (string)$response;
        if (stripos($responseString, 'success') !== false || 
            stripos($responseString, 'sent') !== false ||
            stripos($responseString, 'accepted') !== false) {
            return true;
        }

        // Default: assume success if HTTP 200 (can be customized based on provider)
        return true;
    }

    /**
     * Log SMS to database
     *
     * @param string $mobile Mobile number
     * @param string $message Message content
     * @param string $templateId Template ID
     * @param bool $success Success status
     * @param array $response Response from gateway
     * @param array $request Request data sent
     * @return void
     */
    private static function logSms($mobile, $message, $templateId, $success, $response, $request)
    {
        try {
            // Check if SmsLog model exists
            if (class_exists(SmsLog::class)) {
                SmsLog::create([
                    'mobile' => $mobile,
                    'message' => $message,
                    'template_id' => $templateId,
                    'status' => $success ? 'sent' : 'failed',
                    'response' => is_array($response) ? json_encode($response) : $response,
                    'request_data' => json_encode($request),
                    'sent_at' => now(),
                ]);
            }
        } catch (\Exception $e) {
            // Log error but don't fail SMS sending
            Log::warning('Failed to log SMS to database', [
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Send OTP for registration
     *
     * @param string $mobile Mobile number
     * @param int $otp OTP code
     * @return array
     */
    public static function sendRegistrationOtp($mobile, $otp)
    {
        $message = "Thank you for registering with Rubista.\nYour registration OTP is $otp.\nDo not share this OTP with anyone.";

        return self::send($mobile, $message, self::TEMPLATE_ID_REGISTRATION);
    }

    /**
     * Send OTP for login
     *
     * @param string $mobile Mobile number
     * @param int $otp OTP code
     * @return array
     */
    public static function sendLoginOtp($mobile, $otp)
    {
        $message = "Thank you for choosing Rubista.\nYour login OTP is $otp.\nThis OTP is valid for 5 minutes.";

        return self::send($mobile, $message, self::TEMPLATE_ID_LOGIN);
    }

    /**
     * Send booking confirmation
     *
     * @param string $mobile Mobile number
     * @param string $bookingId Booking ID
     * @return array
     */
    public static function sendBookingConfirmation($mobile, $bookingId)
    {
        $message = "Thank you for booking with Rubista.\nYour booking has been confirmed.\nBooking ID: $bookingId.\nWe look forward to serving you.";

        return self::send($mobile, $message, self::TEMPLATE_ID_BOOKING);
    }

    /**
     * Send order confirmation
     *
     * @param string $mobile Mobile number
     * @param string $orderNumber Order number
     * @param float $totalAmount Total order amount
     * @return array
     */
    public static function sendOrderConfirmation($mobile, $orderNumber, $totalAmount = null)
    {
        $message = "Thank you for your order with Rubista.\nYour order has been confirmed.\nOrder Number: $orderNumber.";
        
        if ($totalAmount !== null) {
            $message .= "\nTotal Amount: ₹" . number_format($totalAmount, 2);
        }
        
        $message .= "\nWe will process your order shortly.";

        return self::send($mobile, $message, self::TEMPLATE_ID_ORDER);
    }
}
