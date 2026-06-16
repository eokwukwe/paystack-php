<?php

declare(strict_types=1);

namespace Softgeng\Paystack\Resources;

use Softgeng\Paystack\Contracts\DataObject;
use Softgeng\Paystack\Data\PaystackResponse;

final readonly class Transactions extends Resource
{
    /**
     * @param  array<string, mixed>|DataObject  $payload
     */
    public function initialize(array|DataObject $payload = []): PaystackResponse
    {
        return $this->client->post('/transaction/initialize', $payload);
    }

    /**
     * @param  array<string, mixed>|DataObject  $query
     */
    public function verify(
        string|int $reference,
        array|DataObject $query = []
    ): PaystackResponse {
        return $this->client->get("/transaction/verify/{$reference}", $query);
    }

    /**
     * @param  array<string, mixed>|DataObject  $query
     */
    public function list(array|DataObject $query = []): PaystackResponse
    {
        return $this->client->get('/transaction', $query);
    }

    /**
     * @param  array<string, mixed>|DataObject  $query
     */
    public function fetch(
        string|int $id,
        array|DataObject $query = []
    ): PaystackResponse {
        return $this->client->get("/transaction/{$id}", $query);
    }

    /**
     * @param  array<string, mixed>|DataObject  $payload
     */
    public function chargeAuthorization(
        array|DataObject $payload = []
    ): PaystackResponse {
        return $this->client->post('/transaction/charge_authorization', $payload);
    }

    /**
     * @param  array<string, mixed>|DataObject  $query
     */
    public function viewTimeline(
        string|int $id_or_reference,
        array|DataObject $query = []
    ): PaystackResponse {
        return $this->client->get("/transaction/timeline/{$id_or_reference}", $query);
    }

    /**
     * @param  array<string, mixed>|DataObject  $query
     */
    public function transactionTotals(
        array|DataObject $query = []
    ): PaystackResponse {
        return $this->client->get('/transaction/totals', $query);
    }

    /**
     * @param  array<string, mixed>|DataObject  $query
     */
    public function export(array|DataObject $query = []): PaystackResponse
    {
        return $this->client->get('/transaction/export', $query);
    }

    /**
     * @param  array<string, mixed>|DataObject  $payload
     */
    public function partialDebit(
        array|DataObject $payload = []
    ): PaystackResponse {
        return $this->client->post('/transaction/partial_debit', $payload);
    }
}
