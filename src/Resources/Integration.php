<?php

declare(strict_types=1);

namespace Softgeng\Paystack\Resources;

use Softgeng\Paystack\Contracts\DataObject;
use Softgeng\Paystack\Data\PaystackResponse;

final readonly class Integration extends Resource
{
    /**
     * @param  array<string, mixed>|DataObject  $query
     */
    public function fetchPaymentSessionTimeout(
        array|DataObject $query = []
    ): PaystackResponse {
        return $this->client->get('/integration/payment_session_timeout', $query);
    }

    /**
     * @param  array<string, mixed>|DataObject  $payload
     */
    public function updatePaymentSessionTimeout(
        array|DataObject $payload = []
    ): PaystackResponse {
        return $this->client->put('/integration/payment_session_timeout', $payload);
    }
}
