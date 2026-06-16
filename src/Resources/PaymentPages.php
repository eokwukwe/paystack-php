<?php

declare(strict_types=1);

namespace Softgeng\Paystack\Resources;

use Softgeng\Paystack\Contracts\DataObject;
use Softgeng\Paystack\Data\PaystackResponse;

final readonly class PaymentPages extends Resource
{
    /**
     * @param  array<string, mixed>|DataObject  $payload
     */
    public function create(array|DataObject $payload = []): PaystackResponse
    {
        return $this->client->post('/page', $payload);
    }

    /**
     * @param  array<string, mixed>|DataObject  $query
     */
    public function list(array|DataObject $query = []): PaystackResponse
    {
        return $this->client->get('/page', $query);
    }

    /**
     * @param  array<string, mixed>|DataObject  $query
     */
    public function fetch(
        string|int $id_or_slug,
        array|DataObject $query = []
    ): PaystackResponse {
        return $this->client->get("/page/{$id_or_slug}", $query);
    }

    /**
     * @param  array<string, mixed>|DataObject  $payload
     */
    public function update(
        string|int $id_or_slug,
        array|DataObject $payload = []
    ): PaystackResponse {
        return $this->client->put("/page/{$id_or_slug}", $payload);
    }

    /**
     * @param  array<string, mixed>|DataObject  $query
     */
    public function checkSlugAvailability(
        string|int $slug,
        array|DataObject $query = []
    ): PaystackResponse {
        return $this->client->get("/page/check_slug_availability/{$slug}", $query);
    }

    /**
     * @param  array<string, mixed>|DataObject  $payload
     */
    public function addProducts(
        string|int $id,
        array|DataObject $payload = []
    ): PaystackResponse {
        return $this->client->post("/page/{$id}/product", $payload);
    }
}
