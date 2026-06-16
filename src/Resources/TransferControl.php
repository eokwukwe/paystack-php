<?php

declare(strict_types=1);

namespace Softgeng\Paystack\Resources;

use Softgeng\Paystack\Contracts\DataObject;
use Softgeng\Paystack\Data\PaystackResponse;

final readonly class TransferControl extends Resource
{
    /**
     * @param  array<string, mixed>|DataObject  $query
     */
    public function balance(array|DataObject $query = []): PaystackResponse
    {
        return $this->client->get('/balance', $query);
    }

    /**
     * @param  array<string, mixed>|DataObject  $query
     */
    public function ledger(array|DataObject $query = []): PaystackResponse
    {
        return $this->client->get('/balance/ledger', $query);
    }

    /**
     * @param  array<string, mixed>|DataObject  $payload
     */
    public function resendOtp(array|DataObject $payload = []): PaystackResponse
    {
        return $this->client->post('/transfer/resend_otp', $payload);
    }

    /**
     * @param  array<string, mixed>|DataObject  $payload
     */
    public function disableOtp(array|DataObject $payload = []): PaystackResponse
    {
        return $this->client->post('/transfer/disable_otp', $payload);
    }

    /**
     * @param  array<string, mixed>|DataObject  $payload
     */
    public function finalizeDisableOtp(
        array|DataObject $payload = []
    ): PaystackResponse {
        return $this->client->post('/transfer/disable_otp_finalize', $payload);
    }

    /**
     * @param  array<string, mixed>|DataObject  $payload
     */
    public function enableOtp(array|DataObject $payload = []): PaystackResponse
    {
        return $this->client->post('/transfer/enable_otp', $payload);
    }
}
