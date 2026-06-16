<?php

declare(strict_types=1);

namespace Softgeng\Paystack\Resources;

use Softgeng\Paystack\Contracts\DataObject;
use Softgeng\Paystack\Data\PaystackResponse;

final readonly class Refunds extends Resource
{
    /**
     * @param  array<string, mixed>|DataObject  $payload
     */
    public function create(array|DataObject $payload = []): PaystackResponse
    {
        return $this->client->post('/refund', $payload);
    }

    /**
     * @param  array<string, mixed>|DataObject  $query
     */
    public function list(array|DataObject $query = []): PaystackResponse
    {
        return $this->client->get('/refund', $query);
    }

    /**
     * @param  array<string, mixed>|DataObject  $query
     */
    public function fetch(
        string|int $reference,
        array|DataObject $query = []
    ): PaystackResponse {
        return $this->client->get("/refund/{$reference}", $query);
    }

    /**
     * @param  array<string, mixed>|DataObject  $payload
     */
    public function retry(
        string|int $reference,
        array|DataObject $payload = []
    ): PaystackResponse {
        return $this->client->post("/refund/{$reference}/retry", $payload);
    }
}
