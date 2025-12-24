<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],


    'sms' => [
        'api_url' => env('SMS_API_URL'),
        'username' => env('SMS_USER'),
        'password' => env('SMS_PASS'),
        'sender_id' => env('SMS_SENDER', 'RUBISTA'),
        'country_code' => env('SMS_COUNTRY_CODE', '91'),
        'enabled' => env('SMS_ENABLED', true),
        'template_ids' => [
            'registration' => env('SMS_TEMPLATE_ID_REGISTRATION', 'TEMPLATE_ID_REGISTRATION'),
            'login' => env('SMS_TEMPLATE_ID_LOGIN', 'TEMPLATE_ID_LOGIN'),
            'booking' => env('SMS_TEMPLATE_ID_BOOKING', 'TEMPLATE_ID_BOOKING'),
            'order' => env('SMS_TEMPLATE_ID_ORDER', 'TEMPLATE_ID_ORDER'),
            'general' => env('SMS_TEMPLATE_ID_GENERAL', 'TEMPLATE_ID_GENERAL'),
        ],
    ],

    'fast2sms' => [
        'key' => env('FAST2SMS_API_KEY'),
    ],


];
