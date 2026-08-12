
<?php

return [
    /*
    |--------------------------------------------------------------------------
    | IPROG API Configuration
    |--------------------------------------------------------------------------
    */

    'api_token' => env('IPROG_API_TOKEN'),

    // OTP Endpoint
    'api_url'   => env('IPROG_API_URL', 'https://www.iprogsms.com/api/v1/otp/send_otp'),

    // Non-OTP SMS Endpoint
    'sms_api_url' => env('IPROG_SMS_API_URL', 'https://www.iprogsms.com/api/v1/sms_messages'),
];
