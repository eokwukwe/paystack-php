<?php

declare(strict_types=1);

namespace Softgeng\Paystack\Resources;

use Softgeng\Paystack\Contracts\DataObject;
use Softgeng\Paystack\Data\PaystackResponse;

final readonly class DedicatedVirtualAccounts extends Resource
{
    /**
     * @param  array<string, mixed>|DataObject  $payload
     */
    public function create(array|DataObject $payload = []): PaystackResponse
    {
        return $this->client->post('/dedicated_account', $payload);
    }

    /**
     * @param  array<string, mixed>|DataObject  $payload
     */
    public function assign(array|DataObject $payload = []): PaystackResponse
    {
        return $this->client->post('/dedicated_account/assign', $payload);
    }

    /**
     * @param  array<string, mixed>|DataObject  $query
     */
    public function list(array|DataObject $query = []): PaystackResponse
    {
        return $this->client->get('/dedicated_account', $query);
    }

    /**
     * @param  array<string, mixed>|DataObject  $query
     */
    public function fetch(
        string|int $id,
        array|DataObject $query = []
    ): PaystackResponse {
        return $this->client->get("/dedicated_account/{$id}", $query);
    }

    /**
     * @param  array<string, mixed>|DataObject  $query
     */
    public function deactivate(
        string|int $id,
        array|DataObject $query = []
    ): PaystackResponse {
        return $this->client->delete("/dedicated_account/{$id}", $query);
    }

    /**
     * @param  array<string, mixed>|DataObject  $payload
     */
    public function split(array|DataObject $payload = []): PaystackResponse
    {
        return $this->client->post('/dedicated_account/split', $payload);
    }

    /**
     * @param  array<string, mixed>|DataObject  $query
     */
    public function removeSplit(array|DataObject $query = []): PaystackResponse
    {
        return $this->client->delete('/dedicated_account/split', $query);
    }

    /**
     * @param  array<string, mixed>|DataObject  $query
     */
    public function providers(array|DataObject $query = []): PaystackResponse
    {
        return $this->client->get(
            '/dedicated_account/available_providers',
            $query
        );
    }

    /**
     * @param  array<string, mixed>|DataObject  $query
     */
    public function requery(array|DataObject $query = []): PaystackResponse
    {
        return $this->client->get('/dedicated_account/requery', $query);
    }
}
