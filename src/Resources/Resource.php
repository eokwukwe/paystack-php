<?php

declare(strict_types=1);

namespace Softgeng\Paystack\Resources;

use Softgeng\Paystack\PaystackClient;

abstract readonly class Resource
{
    public function __construct(protected PaystackClient $client) {}
}
