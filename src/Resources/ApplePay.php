<?php

declare(strict_types=1);

namespace Softgeng\Paystack\Resources;

use Softgeng\Paystack\Contracts\DataObject;
use Softgeng\Paystack\Data\PaystackResponse;

final readonly class ApplePay extends Resource
{
    /**
     * @param  array<string, mixed>|DataObject  $payload
     */
    public function registerDomain(
        array|DataObject $payload = []
    ): PaystackResponse {
        return $this->client->post('/apple-pay/domain', $payload);
    }

    /**
     * @param  array<string, mixed>|DataObject  $query
     */
    public function listDomains(array|DataObject $query = []): PaystackResponse
    {
        return $this->client->get('/apple-pay/domain', $query);
    }

    /**
     * @param  array<string, mixed>|DataObject  $query
     */
    public function unregisterDomain(
        array|DataObject $query = []
    ): PaystackResponse {
        return $this->client->delete('/apple-pay/domain', $query);
    }
}
