<?php

declare(strict_types=1);

namespace Softgeng\Paystack\Resources;

use Softgeng\Paystack\Contracts\DataObject;
use Softgeng\Paystack\Data\PaystackResponse;

final readonly class Miscellaneous extends Resource
{
    /**
     * @param  array<string, mixed>|DataObject  $query
     */
    public function listBanks(array|DataObject $query = []): PaystackResponse
    {
        return $this->client->get('/bank', $query);
    }

    /**
     * @param  array<string, mixed>|DataObject  $query
     */
    public function listCountries(
        array|DataObject $query = []
    ): PaystackResponse {
        return $this->client->get('/country', $query);
    }

    /**
     * @param  array<string, mixed>|DataObject  $query
     */
    public function listStates(array|DataObject $query = []): PaystackResponse
    {
        return $this->client->get('/address_verification/states', $query);
    }
}
