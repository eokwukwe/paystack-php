<?php

declare(strict_types=1);

namespace Softgeng\Paystack\Resources;

use Softgeng\Paystack\Contracts\DataObject;
use Softgeng\Paystack\Data\PaystackResponse;

final readonly class Verification extends Resource
{
    /**
     * @param  array<string, mixed>|DataObject  $query
     */
    public function resolveAccountNumber(
        array|DataObject $query = []
    ): PaystackResponse {
        return $this->client->get('/bank/resolve', $query);
    }

    /**
     * @param  array<string, mixed>|DataObject  $payload
     */
    public function validateAccount(
        array|DataObject $payload = []
    ): PaystackResponse {
        return $this->client->post('/bank/validate', $payload);
    }

    /**
     * @param  array<string, mixed>|DataObject  $query
     */
    public function resolveCardBin(
        string|int $bin,
        array|DataObject $query = []
    ): PaystackResponse {
        return $this->client->get("/decision/bin/{$bin}", $query);
    }
}
