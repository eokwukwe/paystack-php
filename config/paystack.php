<?php

declare(strict_types=1);

return [
    'secret_key' => env('PAYSTACK_SECRET_KEY'),
    'public_key' => env('PAYSTACK_PUBLIC_KEY'),
    'base_url' => env('PAYSTACK_BASE_URL', 'https://api.paystack.co'),
    'timeout' => (int) env('PAYSTACK_TIMEOUT', 30),
    'retry_times' => (int) env('PAYSTACK_RETRY_TIMES', 2),
    'retry_sleep_ms' => (int) env('PAYSTACK_RETRY_SLEEP_MS', 300),
    'throw_on_paystack_status_false' => (bool) env('PAYSTACK_THROW_ON_STATUS_FALSE', false),
];
