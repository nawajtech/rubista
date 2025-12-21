# SMS Gateway Configuration Guide

This application uses an SMS service to send OTP codes and notifications. Follow this guide to configure your SMS gateway.

## Environment Variables

Add the following variables to your `.env` file:

```env
# SMS Gateway Configuration
SMS_API_URL=https://your-sms-provider-api-url.com/api/send
SMS_USER=your_sms_username
SMS_PASS=your_sms_password
SMS_SENDER=RUBISTA
SMS_COUNTRY_CODE=91
SMS_ENABLED=true
```

## Configuration Details

### Required Variables

- **SMS_API_URL**: The API endpoint URL of your SMS provider
- **SMS_USER**: Your SMS provider username/API key
- **SMS_PASS**: Your SMS provider password/API secret
- **SMS_SENDER**: Sender ID (usually your brand name, max 6 characters)
- **SMS_COUNTRY_CODE**: Default country code (default: 91 for India)
- **SMS_ENABLED**: Enable/disable SMS service (true/false)

## SMS Template IDs

The following template IDs are used in the application:

- `TEMPLATE_ID_REGISTRATION` - For registration OTP
- `TEMPLATE_ID_LOGIN` - For login OTP
- `TEMPLATE_ID_BOOKING` - For booking confirmations
- `TEMPLATE_ID_ORDER` - For order confirmations
- `TEMPLATE_ID_GENERAL` - For general messages

**Note**: Some SMS providers require template IDs to be registered with them. Make sure to register your templates with your SMS provider and use the actual template IDs provided by them.

## Usage Examples

### Registration OTP

```php
use App\Services\SmsService;

$otp = rand(1000, 9999);
$result = SmsService::sendRegistrationOtp($mobile, $otp);
```

### Login OTP

```php
use App\Services\SmsService;

$otp = rand(1000, 9999);
$result = SmsService::sendLoginOtp($mobile, $otp);
```

### Booking Confirmation

```php
use App\Services\SmsService;

$result = SmsService::sendBookingConfirmation($mobile, $bookingId);
```

### Order Confirmation

```php
use App\Services\SmsService;

$result = SmsService::sendOrderConfirmation($mobile, $orderNumber, $totalAmount);
```

### Custom Message

```php
use App\Services\SmsService;

$result = SmsService::send(
    $mobile,
    "Your custom message here",
    SmsService::TEMPLATE_ID_GENERAL
);
```

## SMS Provider Requirements

Your SMS provider API should accept POST requests with the following parameters:

- `username` - Your API username
- `password` - Your API password
- `senderid` - Sender ID
- `templateid` - Template ID
- `mobile` - Mobile number (with country code)
- `message` - Message content

## Response Format

The SMS service expects the provider to return:
- HTTP 200 status code for successful requests
- Response indicating success (can be JSON or text)

The service will automatically detect success based on:
- HTTP status code 200
- Response containing "success", "sent", or "accepted" keywords
- JSON response with `status: "success"` or `error: null`

## SMS Logging

All SMS messages are logged to the `sms_logs` table with the following information:
- Mobile number
- Message content
- Template ID
- Status (sent/failed/pending)
- Response from gateway
- Request data
- Timestamp

You can view SMS logs in the database or create an admin interface to view them.

## Testing

For testing purposes, when `APP_DEBUG=true` in your `.env` file, OTP codes will be included in the response. **Remove this in production!**

## Troubleshooting

1. **SMS not sending**: Check your SMS provider credentials and API URL
2. **Invalid template ID**: Ensure template IDs are registered with your SMS provider
3. **Mobile number format**: The service automatically formats numbers with country code
4. **Check logs**: Review Laravel logs (`storage/logs/laravel.log`) for detailed error messages
5. **Database logs**: Check `sms_logs` table for SMS sending history and errors

## Popular SMS Providers

Some popular SMS providers that work with this setup:

- **MSG91** (India)
- **Twilio** (International)
- **TextLocal** (India)
- **Fast2SMS** (India)
- **SMS Gateway API** (Various)

Each provider may have slightly different API requirements. You may need to customize the `SmsService` class to match your specific provider's API format.
