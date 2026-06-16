<?php

declare(strict_types=1);

namespace Softgeng\Paystack\Resources;

use Softgeng\Paystack\Contracts\DataObject;
use Softgeng\Paystack\Data\PaystackResponse;

final readonly class Products extends Resource
{
    /**
     * @param  array<string, mixed>|DataObject  $payload
     */
    public function create(array|DataObject $payload = []): PaystackResponse
    {
        return $this->client->post('/product', $payload);
    }

    /**
     * @param  array<string, mixed>|DataObject  $query
     */
    public function list(array|DataObject $query = []): PaystackResponse
    {
        return $this->client->get('/product', $query);
    }

    /**
     * @param  array<string, mixed>|DataObject  $query
     */
    public function fetch(
        string|int $id,
        array|DataObject $query = []
    ): PaystackResponse {
        return $this->client->get("/product/{$id}", $query);
    }

    /**
     * @param  array<string, mixed>|DataObject  $payload
     */
    public function update(
        string|int $id,
        array|DataObject $payload = []
    ): PaystackResponse {
        return $this->client->put("/product/{$id}", $payload);
    }
}
