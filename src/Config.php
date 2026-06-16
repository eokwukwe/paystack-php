<?php

declare(strict_types=1);

namespace Softgeng\Paystack;

use InvalidArgumentException;

final readonly class Config
{
    public function __construct(
        public string $secret_key,
        public ?string $public_key = null,
        public string $base_url = 'https://api.paystack.co',
        public int $timeout = 30,
        public int $retry_times = 2,
        public int $retry_sleep_ms = 300,
        public bool $throw_on_paystack_status_false = false,
    ) {
        if (trim($this->secret_key) === '') {
            throw new InvalidArgumentException(
                'Paystack secret key is required.'
            );
        }
    }
}
