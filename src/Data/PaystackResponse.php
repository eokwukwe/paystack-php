<?php

declare(strict_types=1);

namespace Softgeng\Paystack\Data;

final readonly class PaystackResponse
{
    /**
     * @param  array<string, mixed>  $raw
     * @param  array<string, mixed>  $meta
     */
    public function __construct(
        public bool $status,
        public string $message,
        public mixed $data = null,
        public array $meta = [],
        public array $raw = [],
        public int $http_status = 200,
    ) {}

    /**
     * @param  array<string, mixed>  $payload
     */
    public static function fromArray(array $payload, int $httpStatus = 200): self
    {
        return new self(
            status: (bool) ($payload['status'] ?? false),
            message: (string) ($payload['message'] ?? ''),
            data: $payload['data'] ?? null,
            meta: is_array($payload['meta'] ?? null) ? $payload['meta'] : [],
            raw: $payload,
            http_status: $httpStatus,
        );
    }

    public function data(?string $key = null, mixed $default = null): mixed
    {
        if ($key === null) {
            return $this->data;
        }

        return is_array($this->data) ? ($this->data[$key] ?? $default) : $default;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return $this->raw;
    }
}
