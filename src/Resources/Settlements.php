<?php

declare(strict_types=1);

namespace Softgeng\Paystack\Resources;

use Softgeng\Paystack\Contracts\DataObject;
use Softgeng\Paystack\Data\PaystackResponse;

final readonly class Settlements extends Resource
{
    /**
     * @param  array<string, mixed>|DataObject  $query
     */
    public function list(array|DataObject $query = []): PaystackResponse
    {
        return $this->client->get('/settlement', $query);
    }

    /**
     * @param  array<string, mixed>|DataObject  $query
     */
    public function transactions(
        string|int $id,
        array|DataObject $query = []
    ): PaystackResponse {
        return $this->client->get("/settlement/{$id}/transactions", $query);
    }
}
