<?php

declare(strict_types=1);

namespace Softgeng\Paystack\Resources;

use Softgeng\Paystack\Contracts\DataObject;
use Softgeng\Paystack\Data\PaystackResponse;

final readonly class BulkCharges extends Resource
{
    /**
     * @param  array<string, mixed>|DataObject  $payload
     */
    public function initiate(array|DataObject $payload = []): PaystackResponse
    {
        return $this->client->post('/bulkcharge', $payload);
    }

    /**
     * @param  array<string, mixed>|DataObject  $query
     */
    public function listBatches(array|DataObject $query = []): PaystackResponse
    {
        return $this->client->get('/bulkcharge', $query);
    }

    /**
     * @param  array<string, mixed>|DataObject  $query
     */
    public function fetchBatch(
        string|int $code_or_id,
        array|DataObject $query = []
    ): PaystackResponse {
        return $this->client->get("/bulkcharge/{$code_or_id}", $query);
    }

    /**
     * @param  array<string, mixed>|DataObject  $query
     */
    public function fetchChargesInBatch(
        string|int $code_or_id,
        array|DataObject $query = []
    ): PaystackResponse {
        return $this->client->get("/bulkcharge/{$code_or_id}/charges", $query);
    }

    /**
     * @param  array<string, mixed>|DataObject  $query
     */
    public function pause(
        string|int $code,
        array|DataObject $query = []
    ): PaystackResponse {
        return $this->client->get("/bulkcharge/pause/{$code}", $query);
    }

    /**
     * @param  array<string, mixed>|DataObject  $query
     */
    public function resume(
        string|int $code,
        array|DataObject $query = []
    ): PaystackResponse {
        return $this->client->get("/bulkcharge/resume/{$code}", $query);
    }
}
