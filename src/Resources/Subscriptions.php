<?php

declare(strict_types=1);

namespace Softgeng\Paystack\Resources;

use Softgeng\Paystack\Contracts\DataObject;
use Softgeng\Paystack\Data\PaystackResponse;

final readonly class Subscriptions extends Resource
{
    /**
     * @param  array<string, mixed>|DataObject  $payload
     */
    public function create(array|DataObject $payload = []): PaystackResponse
    {
        return $this->client->post('/subscription', $payload);
    }

    /**
     * @param  array<string, mixed>|DataObject  $query
     */
    public function list(array|DataObject $query = []): PaystackResponse
    {
        return $this->client->get('/subscription', $query);
    }

    /**
     * @param  array<string, mixed>|DataObject  $query
     */
    public function fetch(
        string|int $code_or_id,
        array|DataObject $query = []
    ): PaystackResponse {
        return $this->client->get("/subscription/{$code_or_id}", $query);
    }

    /**
     * @param  array<string, mixed>|DataObject  $payload
     */
    public function enable(array|DataObject $payload = []): PaystackResponse
    {
        return $this->client->post('/subscription/enable', $payload);
    }

    /**
     * @param  array<string, mixed>|DataObject  $payload
     */
    public function disable(array|DataObject $payload = []): PaystackResponse
    {
        return $this->client->post('/subscription/disable', $payload);
    }

    /**
     * @param  array<string, mixed>|DataObject  $query
     */
    public function manageLink(
        string|int $code,
        array|DataObject $query = []
    ): PaystackResponse {
        return $this->client->get("/subscription/{$code}/manage/link", $query);
    }

    /**
     * @param  array<string, mixed>|DataObject  $payload
     */
    public function sendManageLink(
        string|int $code,
        array|DataObject $payload = []
    ): PaystackResponse {
        return $this->client->post("/subscription/{$code}/manage/email", $payload);
    }
}
