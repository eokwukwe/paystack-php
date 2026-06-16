<?php

declare(strict_types=1);

namespace Softgeng\Paystack\Resources;

use Softgeng\Paystack\Contracts\DataObject;
use Softgeng\Paystack\Data\PaystackResponse;

final readonly class Customers extends Resource
{
    /**
     * @param  array<string, mixed>|DataObject  $payload
     */
    public function create(array|DataObject $payload = []): PaystackResponse
    {
        return $this->client->post('/customer', $payload);
    }

    /**
     * @param  array<string, mixed>|DataObject  $query
     */
    public function list(array|DataObject $query = []): PaystackResponse
    {
        return $this->client->get('/customer', $query);
    }

    /**
     * @param  array<string, mixed>|DataObject  $query
     */
    public function fetch(
        string|int $email_or_code,
        array|DataObject $query = []
    ): PaystackResponse {
        return $this->client->get("/customer/{$email_or_code}", $query);
    }

    /**
     * @param  array<string, mixed>|DataObject  $payload
     */
    public function update(
        string|int $code,
        array|DataObject $payload = []
    ): PaystackResponse {
        return $this->client->put("/customer/{$code}", $payload);
    }

    /**
     * @param  array<string, mixed>|DataObject  $payload
     */
    public function validate(
        string|int $code,
        array|DataObject $payload = []
    ): PaystackResponse {
        return $this->client->post(
            "/customer/{$code}/identification",
            $payload
        );
    }

    /**
     * @param  array<string, mixed>|DataObject  $payload
     */
    public function setRiskAction(
        array|DataObject $payload = []
    ): PaystackResponse {
        return $this->client->post('/customer/set_risk_action', $payload);
    }

    /**
     * @param  array<string, mixed>|DataObject  $payload
     */
    public function initializeAuthorization(
        array|DataObject $payload = []
    ): PaystackResponse {
        return $this->client->post(
            '/customer/authorization/initialize',
            $payload
        );
    }

    /**
     * @param  array<string, mixed>|DataObject  $query
     */
    public function verifyAuthorization(
        string|int $reference,
        array|DataObject $query = []
    ): PaystackResponse {
        return $this->client->get(
            "/customer/authorization/verify/{$reference}",
            $query
        );
    }

    /**
     * @param  array<string, mixed>|DataObject  $payload
     */
    public function initializeDirectDebit(
        string|int $id,
        array|DataObject $payload = []
    ): PaystackResponse {
        return $this->client->post(
            "/customer/{$id}/initialize-direct-debit",
            $payload
        );
    }

    /**
     * @param  array<string, mixed>|DataObject  $payload
     */
    public function directDebitActivationCharge(
        string|int $id,
        array|DataObject $payload = []
    ): PaystackResponse {
        return $this->client->put(
            "/customer/{$id}/directdebit-activation-charge",
            $payload
        );
    }

    /**
     * @param  array<string, mixed>|DataObject  $query
     */
    public function mandateAuthorizations(
        string|int $id,
        array|DataObject $query = []
    ): PaystackResponse {
        return $this->client->get(
            "/customer/{$id}/directdebit-mandate-authorizations",
            $query
        );
    }

    /**
     * @param  array<string, mixed>|DataObject  $payload
     */
    public function deactivateAuthorization(
        array|DataObject $payload = []
    ): PaystackResponse {
        return $this->client->post(
            '/customer/authorization/deactivate',
            $payload
        );
    }
}
