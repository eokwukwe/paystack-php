<?php

declare(strict_types=1);

namespace Softgeng\Paystack\Resources;

use Softgeng\Paystack\Contracts\DataObject;
use Softgeng\Paystack\Data\PaystackResponse;

final readonly class Splits extends Resource
{
    /**
     * @param  array<string, mixed>|DataObject  $payload
     */
    public function create(array|DataObject $payload = []): PaystackResponse
    {
        return $this->client->post('/split', $payload);
    }

    /**
     * @param  array<string, mixed>|DataObject  $query
     */
    public function list(array|DataObject $query = []): PaystackResponse
    {
        return $this->client->get('/split', $query);
    }

    /**
     * @param  array<string, mixed>|DataObject  $query
     */
    public function fetch(
        string|int $id_or_code,
        array|DataObject $query = []
    ): PaystackResponse {
        return $this->client->get("/split/{$id_or_code}", $query);
    }

    /**
     * @param  array<string, mixed>|DataObject  $payload
     */
    public function update(
        string|int $id_or_code,
        array|DataObject $payload = []
    ): PaystackResponse {
        return $this->client->put("/split/{$id_or_code}", $payload);
    }

    /**
     * @param  array<string, mixed>|DataObject  $payload
     */
    public function addSubaccount(
        string|int $id_or_code,
        array|DataObject $payload = []
    ): PaystackResponse {
        return $this->client->post("/split/{$id_or_code}/subaccount/add", $payload);
    }

    /**
     * @param  array<string, mixed>|DataObject  $payload
     */
    public function removeSubaccount(
        string|int $id_or_code,
        array|DataObject $payload = []
    ): PaystackResponse {
        return $this->client->post("/split/{$id_or_code}/subaccount/remove", $payload);
    }
}
