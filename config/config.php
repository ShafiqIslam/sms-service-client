<?php

return [
    /**
     * Base url of sms service
     */
    'base_url' => env('SMS_SERVICE_BASE_URL', 'http://host.docker.internal:5551'),

    /**
     * Secret api key of the deployed sms service
     */
    'api_key' => env('SMS_SERVICE_API_KEY', 'secret'),
];
