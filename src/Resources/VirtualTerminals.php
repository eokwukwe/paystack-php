<?php

declare(strict_types=1);

namespace Softgeng\Paystack\Resources;

use Softgeng\Paystack\Contracts\DataObject;
use Softgeng\Paystack\Data\PaystackResponse;

final readonly class VirtualTerminals extends Resource
{
    /**
     * @param  array<string, mixed>|DataObject  $payload
     */
    public function create(array|DataObject $payload = []): PaystackResponse
    {
        return $this->client->post('/virtual_terminal', $payload);
    }

    /**
     * @param  array<string, mixed>|DataObject  $query
     */
    public function list(array|DataObject $query = []): PaystackResponse
    {
        return $this->client->get('/virtual_terminal', $query);
    }

    /**
     * @param  array<string, mixed>|DataObject  $query
     */
    public function fetch(
        string|int $code,
        array|DataObject $query = []
    ): PaystackResponse {
        return $this->client->get("/virtual_terminal/{$code}", $query);
    }

    /**
     * @param  array<string, mixed>|DataObject  $payload
     */
    public function update(
        string|int $code,
        array|DataObject $payload = []
    ): PaystackResponse {
        return $this->client->put("/virtual_terminal/{$code}", $payload);
    }

    /**
     * @param  array<string, mixed>|DataObject  $payload
     */
    public function deactivate(
        string|int $code,
        array|DataObject $payload = []
    ): PaystackResponse {
        return $this->client->put(
            "/virtual_terminal/{$code}/deactivate",
            $payload
        );
    }

    /**
     * @param  array<string, mixed>|DataObject  $payload
     */
    public function assignDestination(
        string|int $code,
        array|DataObject $payload = []
    ): PaystackResponse {
        return $this->client->post(
            "/virtual_terminal/{$code}/destination/assign",
            $payload
        );
    }

    /**
     * @param  array<string, mixed>|DataObject  $payload
     */
    public function unassignDestination(
        string|int $code,
        array|DataObject $payload = []
    ): PaystackResponse {
        return $this->client->post(
            "/virtual_terminal/{$code}/destination/unassign",
            $payload
        );
    }

    /**
     * @param  array<string, mixed>|DataObject  $payload
     */
    public function addSplitCode(
        string|int $code,
        array|DataObject $payload = []
    ): PaystackResponse {
        return $this->client->put(
            "/virtual_terminal/{$code}/split_code",
            $payload
        );
    }

    /**
     * @param  array<string, mixed>|DataObject  $payload
     */
    public function removeSplitCode(
        string|int $code,
        array|DataObject $payload = []
    ): PaystackResponse {
        return $this->client->delete(
            "/virtual_terminal/{$code}/split_code",
            $payload
        );
    }
}
