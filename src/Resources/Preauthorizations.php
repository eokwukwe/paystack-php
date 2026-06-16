<?php

declare(strict_types=1);

namespace Softgeng\Paystack\Resources;

use Softgeng\Paystack\Contracts\DataObject;
use Softgeng\Paystack\Data\PaystackResponse;

final readonly class Preauthorizations extends Resource
{
    /**
     * @param  array<string, mixed>|DataObject  $payload
     */
    public function initialize(array|DataObject $payload = []): PaystackResponse
    {
        return $this->client->post('/preauthorization/initialize', $payload);
    }

    /**
     * @param  array<string, mixed>|DataObject  $payload
     */
    public function capture(array|DataObject $payload = []): PaystackResponse
    {
        return $this->client->post('/preauthorization/capture', $payload);
    }

    /**
     * @param  array<string, mixed>|DataObject  $payload
     */
    public function reserve(array|DataObject $payload = []): PaystackResponse
    {
        return $this->client->post(
            '/preauthorization/reserve_authorization',
            $payload
        );
    }

    /**
     * @param  array<string, mixed>|DataObject  $query
     */
    public function verify(
        string|int $reference,
        array|DataObject $query = []
    ): PaystackResponse {
        return $this->client->get(
            "/preauthorization/verify/{$reference}",
            $query
        );
    }

    /**
     * @param  array<string, mixed>|DataObject  $payload
     */
    public function release(array|DataObject $payload = []): PaystackResponse
    {
        return $this->client->post('/preauthorization/release', $payload);
    }

    /**
     * @param  array<string, mixed>|DataObject  $query
     */
    public function list(array|DataObject $query = []): PaystackResponse
    {
        return $this->client->get('/preauthorization', $query);
    }
}
