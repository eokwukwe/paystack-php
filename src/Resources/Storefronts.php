<?php

declare(strict_types=1);

namespace Softgeng\Paystack\Resources;

use Softgeng\Paystack\Contracts\DataObject;
use Softgeng\Paystack\Data\PaystackResponse;

final readonly class Storefronts extends Resource
{
    /**
     * @param  array<string, mixed>|DataObject  $payload
     */
    public function create(array|DataObject $payload = []): PaystackResponse
    {
        return $this->client->post('/storefront', $payload);
    }

    /**
     * @param  array<string, mixed>|DataObject  $query
     */
    public function list(array|DataObject $query = []): PaystackResponse
    {
        return $this->client->get('/storefront', $query);
    }

    /**
     * @param  array<string, mixed>|DataObject  $query
     */
    public function fetch(
        string|int $id,
        array|DataObject $query = []
    ): PaystackResponse {
        return $this->client->get("/storefront/{$id}", $query);
    }

    /**
     * @param  array<string, mixed>|DataObject  $payload
     */
    public function update(
        string|int $id,
        array|DataObject $payload = []
    ): PaystackResponse {
        return $this->client->put("/storefront/{$id}", $payload);
    }

    /**
     * @param  array<string, mixed>|DataObject  $query
     */
    public function delete(
        string|int $id,
        array|DataObject $query = []
    ): PaystackResponse {
        return $this->client->delete("/storefront/{$id}", $query);
    }

    /**
     * @param  array<string, mixed>|DataObject  $query
     */
    public function verifySlug(
        string|int $slug,
        array|DataObject $query = []
    ): PaystackResponse {
        return $this->client->get("/storefront/verify/{$slug}", $query);
    }

    /**
     * @param  array<string, mixed>|DataObject  $query
     */
    public function orders(
        string|int $id,
        array|DataObject $query = []
    ): PaystackResponse {
        return $this->client->get("/storefront/{$id}/order", $query);
    }

    /**
     * @param  array<string, mixed>|DataObject  $payload
     */
    public function addProducts(
        string|int $id,
        array|DataObject $payload = []
    ): PaystackResponse {
        return $this->client->post("/storefront/{$id}/product", $payload);
    }

    /**
     * @param  array<string, mixed>|DataObject  $query
     */
    public function products(
        string|int $id,
        array|DataObject $query = []
    ): PaystackResponse {
        return $this->client->get("/storefront/{$id}/product", $query);
    }

    /**
     * @param  array<string, mixed>|DataObject  $payload
     */
    public function publish(
        string|int $id,
        array|DataObject $payload = []
    ): PaystackResponse {
        return $this->client->post("/storefront/{$id}/publish", $payload);
    }

    /**
     * @param  array<string, mixed>|DataObject  $payload
     */
    public function duplicate(
        string|int $id,
        array|DataObject $payload = []
    ): PaystackResponse {
        return $this->client->post("/storefront/{$id}/duplicate", $payload);
    }
}
