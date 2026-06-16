<?php

declare(strict_types=1);

namespace Softgeng\Paystack\Exceptions;

class ApiException extends PaystackException
{
    /**
     * @param  array<string, mixed>  $response
     */
    public function __construct(
        string $message,
        public readonly int $statusCode = 0,
        public readonly array $response = []
    ) {
        parent::__construct($message, $statusCode);
    }
}
