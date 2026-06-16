<?php

declare(strict_types=1);

namespace Softgeng\Paystack\Resources;

use Softgeng\Paystack\Contracts\DataObject;
use Softgeng\Paystack\Data\PaystackResponse;

final readonly class Charges extends Resource
{
    /**
     * @param  array<string, mixed>|DataObject  $payload
     */
    public function create(array|DataObject $payload = []): PaystackResponse
    {
        return $this->client->post('/charge', $payload);
    }

    /**
     * @param  array<string, mixed>|DataObject  $payload
     */
    public function submitPin(array|DataObject $payload = []): PaystackResponse
    {
        return $this->client->post('/charge/submit_pin', $payload);
    }

    /**
     * @param  array<string, mixed>|DataObject  $payload
     */
    public function submitOtp(array|DataObject $payload = []): PaystackResponse
    {
        return $this->client->post('/charge/submit_otp', $payload);
    }

    /**
     * @param  array<string, mixed>|DataObject  $payload
     */
    public function submitPhone(
        array|DataObject $payload = []
    ): PaystackResponse {
        return $this->client->post('/charge/submit_phone', $payload);
    }

    /**
     * @param  array<string, mixed>|DataObject  $payload
     */
    public function submitBirthday(
        array|DataObject $payload = []
    ): PaystackResponse {
        return $this->client->post('/charge/submit_birthday', $payload);
    }

    /**
     * @param  array<string, mixed>|DataObject  $payload
     */
    public function submitAddress(
        array|DataObject $payload = []
    ): PaystackResponse {
        return $this->client->post('/charge/submit_address', $payload);
    }

    /**
     * @param  array<string, mixed>|DataObject  $query
     */
    public function checkPending(
        string|int $reference,
        array|DataObject $query = []
    ): PaystackResponse {
        return $this->client->get("/charge/{$reference}", $query);
    }
}
