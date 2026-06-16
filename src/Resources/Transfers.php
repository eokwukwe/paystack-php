<?php

declare(strict_types=1);

namespace Softgeng\Paystack\Resources;

use Softgeng\Paystack\Contracts\DataObject;
use Softgeng\Paystack\Data\PaystackResponse;

final readonly class Transfers extends Resource
{
    /**
     * @param  array<string, mixed>|DataObject  $payload
     */
    public function initiate(array|DataObject $payload = []): PaystackResponse
    {
        return $this->client->post('/transfer', $payload);
    }

    /**
     * @param  array<string, mixed>|DataObject  $payload
     */
    public function finalize(array|DataObject $payload = []): PaystackResponse
    {
        return $this->client->post('/transfer/finalize_transfer', $payload);
    }

    /**
     * @param  array<string, mixed>|DataObject  $payload
     */
    public function bulk(array|DataObject $payload = []): PaystackResponse
    {
        return $this->client->post('/transfer/bulk', $payload);
    }

    /**
     * @param  array<string, mixed>|DataObject  $query
     */
    public function list(array|DataObject $query = []): PaystackResponse
    {
        return $this->client->get('/transfer', $query);
    }

    /**
     * @param  array<string, mixed>|DataObject  $query
     */
    public function fetch(
        string|int $code_or_id,
        array|DataObject $query = []
    ): PaystackResponse {
        return $this->client->get("/transfer/{$code_or_id}", $query);
    }

    /**
     * @param  array<string, mixed>|DataObject  $query
     */
    public function verify(
        string|int $reference,
        array|DataObject $query = []
    ): PaystackResponse {
        return $this->client->get("/transfer/verify/{$reference}", $query);
    }
}
