<?php

declare(strict_types=1);

namespace Softgeng\Paystack\Resources;

use Softgeng\Paystack\Contracts\DataObject;
use Softgeng\Paystack\Data\PaystackResponse;

final readonly class DirectDebits extends Resource
{
    /**
     * @param  array<string, mixed>|DataObject  $payload
     */
    public function triggerActivationCharge(
        array|DataObject $payload = []
    ): PaystackResponse {
        return $this->client->put('/directdebit/activation-charge', $payload);
    }

    /**
     * @param  array<string, mixed>|DataObject  $query
     */
    public function mandateAuthorizations(
        array|DataObject $query = []
    ): PaystackResponse {
        return $this->client->get(
            '/directdebit/mandate-authorizations',
            $query
        );
    }
}
