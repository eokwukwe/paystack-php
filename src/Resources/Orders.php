<?php

declare(strict_types=1);

namespace Softgeng\Paystack\Resources;

use Softgeng\Paystack\Contracts\DataObject;
use Softgeng\Paystack\Data\PaystackResponse;

final readonly class Orders extends Resource
{
    /**
     * @param  array<string, mixed>|DataObject  $payload
     */
    public function create(array|DataObject $payload = []): PaystackResponse
    {
        return $this->client->post('/order', $payload);
    }

    /**
     * @param  array<string, mixed>|DataObject  $query
     */
    public function list(array|DataObject $query = []): PaystackResponse
    {
        return $this->client->get('/order', $query);
    }

    /**
     * @param  array<string, mixed>|DataObject  $query
     */
    public function fetch(
        string|int $id,
        array|DataObject $query = []
    ): PaystackResponse {
        return $this->client->get("/order/{$id}", $query);
    }

    /**
     * @param  array<string, mixed>|DataObject  $query
     */
    public function productOrders(
        string|int $id,
        array|DataObject $query = []
    ): PaystackResponse {
        return $this->client->get("/order/product/{$id}", $query);
    }

    /**
     * @param  array<string, mixed>|DataObject  $query
     */
    public function validate(
        string|int $code,
        array|DataObject $query = []
    ): PaystackResponse {
        return $this->client->get("/order/{$code}/validate", $query);
    }
}
