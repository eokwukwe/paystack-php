<?php

declare(strict_types=1);

namespace Softgeng\Paystack\Resources;

use Softgeng\Paystack\Contracts\DataObject;
use Softgeng\Paystack\Data\PaystackResponse;

final readonly class PaymentRequests extends Resource
{
    /**
     * @param  array<string, mixed>|DataObject  $payload
     */
    public function create(array|DataObject $payload = []): PaystackResponse
    {
        return $this->client->post('/paymentrequest', $payload);
    }

    /**
     * @param  array<string, mixed>|DataObject  $query
     */
    public function list(array|DataObject $query = []): PaystackResponse
    {
        return $this->client->get('/paymentrequest', $query);
    }

    /**
     * @param  array<string, mixed>|DataObject  $query
     */
    public function fetch(
        string|int $id_or_code,
        array|DataObject $query = []
    ): PaystackResponse {
        return $this->client->get("/paymentrequest/{$id_or_code}", $query);
    }

    /**
     * @param  array<string, mixed>|DataObject  $query
     */
    public function verify(
        string|int $code,
        array|DataObject $query = []
    ): PaystackResponse {
        return $this->client->get("/paymentrequest/verify/{$code}", $query);
    }

    /**
     * @param  array<string, mixed>|DataObject  $payload
     */
    public function sendNotification(
        string|int $code,
        array|DataObject $payload = []
    ): PaystackResponse {
        return $this->client->post("/paymentrequest/notify/{$code}", $payload);
    }

    /**
     * @param  array<string, mixed>|DataObject  $query
     */
    public function total(array|DataObject $query = []): PaystackResponse
    {
        return $this->client->get('/paymentrequest/totals', $query);
    }

    /**
     * @param  array<string, mixed>|DataObject  $payload
     */
    public function finalize(
        string|int $code,
        array|DataObject $payload = []
    ): PaystackResponse {
        return $this->client->post("/paymentrequest/finalize/{$code}", $payload);
    }

    /**
     * @param  array<string, mixed>|DataObject  $payload
     */
    public function update(
        string|int $id_or_code,
        array|DataObject $payload = []
    ): PaystackResponse {
        return $this->client->put("/paymentrequest/{$id_or_code}", $payload);
    }

    /**
     * @param  array<string, mixed>|DataObject  $payload
     */
    public function archive(
        string|int $code,
        array|DataObject $payload = []
    ): PaystackResponse {
        return $this->client->post("/paymentrequest/archive/{$code}", $payload);
    }
}
