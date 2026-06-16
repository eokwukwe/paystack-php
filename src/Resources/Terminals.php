<?php

declare(strict_types=1);

namespace Softgeng\Paystack\Resources;

use Softgeng\Paystack\Contracts\DataObject;
use Softgeng\Paystack\Data\PaystackResponse;

final readonly class Terminals extends Resource
{
    /**
     * @param  array<string, mixed>|DataObject  $payload
     */
    public function sendEvent(
        string|int $terminal_id,
        array|DataObject $payload = []
    ): PaystackResponse {
        return $this->client->post("/terminal/{$terminal_id}/event", $payload);
    }

    /**
     * @param  array<string, mixed>|DataObject  $query
     */
    public function fetchEventStatus(
        string|int $terminal_id,
        string|int $event_id,
        array|DataObject $query = []
    ): PaystackResponse {
        return $this->client->get(
            "/terminal/{$terminal_id}/event/{$event_id}",
            $query
        );
    }

    /**
     * @param  array<string, mixed>|DataObject  $query
     */
    public function fetchTerminalStatus(
        string|int $terminal_id,
        array|DataObject $query = []
    ): PaystackResponse {
        return $this->client->get("/terminal/{$terminal_id}/presence", $query);
    }

    /**
     * @param  array<string, mixed>|DataObject  $query
     */
    public function list(array|DataObject $query = []): PaystackResponse
    {
        return $this->client->get('/terminal', $query);
    }

    /**
     * @param  array<string, mixed>|DataObject  $query
     */
    public function fetch(
        string|int $terminal_id,
        array|DataObject $query = []
    ): PaystackResponse {
        return $this->client->get("/terminal/{$terminal_id}", $query);
    }

    /**
     * @param  array<string, mixed>|DataObject  $payload
     */
    public function update(
        string|int $terminal_id,
        array|DataObject $payload = []
    ): PaystackResponse {
        return $this->client->put("/terminal/{$terminal_id}", $payload);
    }

    /**
     * @param  array<string, mixed>|DataObject  $payload
     */
    public function commission(
        string|int $terminal_id,
        array|DataObject $payload = []
    ): PaystackResponse {
        return $this->client->post(
            "/terminal/{$terminal_id}/commission",
            $payload
        );
    }

    /**
     * @param  array<string, mixed>|DataObject  $payload
     */
    public function decommission(
        string|int $terminal_id,
        array|DataObject $payload = []
    ): PaystackResponse {
        return $this->client->post(
            "/terminal/{$terminal_id}/decommission",
            $payload
        );
    }
}
