<?php

declare(strict_types=1);

namespace Softgeng\Paystack\Resources;

use Softgeng\Paystack\Contracts\DataObject;
use Softgeng\Paystack\Data\PaystackResponse;

final readonly class Disputes extends Resource
{
    /**
     * @param  array<string, mixed>|DataObject  $query
     */
    public function list(array|DataObject $query = []): PaystackResponse
    {
        return $this->client->get('/dispute', $query);
    }

    /**
     * @param  array<string, mixed>|DataObject  $query
     */
    public function fetch(
        string|int $id,
        array|DataObject $query = []
    ): PaystackResponse {
        return $this->client->get("/dispute/{$id}", $query);
    }

    /**
     * @param  array<string, mixed>|DataObject  $query
     */
    public function listForTransaction(
        string|int $id,
        array|DataObject $query = []
    ): PaystackResponse {
        return $this->client->get("/dispute/transaction/{$id}", $query);
    }

    /**
     * @param  array<string, mixed>|DataObject  $payload
     */
    public function update(
        string|int $id,
        array|DataObject $payload = []
    ): PaystackResponse {
        return $this->client->put("/dispute/{$id}", $payload);
    }

    /**
     * @param  array<string, mixed>|DataObject  $payload
     */
    public function addEvidence(
        string|int $id,
        array|DataObject $payload = []
    ): PaystackResponse {
        return $this->client->post("/dispute/{$id}/evidence", $payload);
    }

    /**
     * @param  array<string, mixed>|DataObject  $query
     */
    public function getUploadUrl(
        string|int $id,
        array|DataObject $query = []
    ): PaystackResponse {
        return $this->client->get("/dispute/{$id}/upload_url", $query);
    }

    /**
     * @param  array<string, mixed>|DataObject  $payload
     */
    public function resolve(
        string|int $id,
        array|DataObject $payload = []
    ): PaystackResponse {
        return $this->client->put("/dispute/{$id}/resolve", $payload);
    }

    /**
     * @param  array<string, mixed>|DataObject  $query
     */
    public function export(array|DataObject $query = []): PaystackResponse
    {
        return $this->client->get('/dispute/export', $query);
    }
}
