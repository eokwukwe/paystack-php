<?php

declare(strict_types=1);

namespace Softgeng\Paystack\Data\Subscription;

use Softgeng\Paystack\Concerns\HydratesFromArray;
use Softgeng\Paystack\Contracts\DataObject;
use Softgeng\Paystack\Support\Arr;

final readonly class CreateSubscriptionData implements DataObject
{
    use HydratesFromArray;

    public function __construct(
        public string $customer,
        public string $plan,
        public ?string $authorization = null,
        public ?string $start_date = null
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return Arr::dropNulls([
            'customer' => $this->customer,
            'plan' => $this->plan,
            'authorization' => $this->authorization,
            'start_date' => $this->start_date,
        ]);
    }
}
