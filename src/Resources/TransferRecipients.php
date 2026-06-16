<?php

declare(strict_types=1);

namespace Softgeng\Paystack\Resources;

use Softgeng\Paystack\Contracts\DataObject;
use Softgeng\Paystack\Data\PaystackResponse;

final readonly class TransferRecipients extends Resource
{
    /**
     * @param  array<string, mixed>|DataObject  $payload
     */
    public function create(array|DataObject $payload = []): PaystackResponse
    {
        return $this->client->post('/transferrecipient', $payload);
    }

    /**
     * @param  array<string, mixed>|DataObject  $payload
     */
    public function bulkCreate(array|DataObject $payload = []): PaystackResponse
    {
        return $this->client->post('/transferrecipient/bulk', $payload);
    }

    /**
     * @param  array<string, mixed>|DataObject  $query
     */
    public function list(array|DataObject $query = []): PaystackResponse
    {
        return $this->client->get('/transferrecipient', $query);
    }

    /**
     * @param  array<string, mixed>|DataObject  $query
     */
    public function fetch(
        string|int $code_or_id,
        array|DataObject $query = []
    ): PaystackResponse {
        return $this->client->get("/transferrecipient/{$code_or_id}", $query);
    }

    /**
     * @param  array<string, mixed>|DataObject  $payload
     */
    public function update(
        string|int $code_or_id,
        array|DataObject $payload = []
    ): PaystackResponse {
        return $this->client->put("/transferrecipient/{$code_or_id}", $payload);
    }

    /**
     * @param  array<string, mixed>|DataObject  $query
     */
    public function delete(
        string|int $code_or_id,
        array|DataObject $query = []
    ): PaystackResponse {
        return $this->client->delete(
            "/transferrecipient/{$code_or_id}",
            $query
        );
    }
}
