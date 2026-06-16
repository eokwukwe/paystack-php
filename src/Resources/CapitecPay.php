<?php

declare(strict_types=1);

namespace Softgeng\Paystack\Resources;

use Softgeng\Paystack\Contracts\DataObject;
use Softgeng\Paystack\Data\PaystackResponse;

final readonly class CapitecPay extends Resource
{
    /**
     * @param  array<string, mixed>|DataObject  $query
     */
    public function requery(
        string|int $reference,
        array|DataObject $query = []
    ): PaystackResponse {
        return $this->client->getWithPublicKey(
            "/capitec-pay/requery/{$reference}",
            $query
        );
    }
}
