<?php

declare(strict_types=1);

namespace Softgeng\Paystack\Data\DedicatedVirtualAccount;

use Softgeng\Paystack\Concerns\HydratesFromArray;
use Softgeng\Paystack\Contracts\DataObject;
use Softgeng\Paystack\Support\Arr;

final readonly class CreateDedicatedVirtualAccountData implements DataObject
{
    use HydratesFromArray;

    public function __construct(
        public string $customer,
        public ?string $preferred_bank = null,
        public ?string $subaccount = null,
        public ?string $split_code = null,
        public ?string $first_name = null,
        public ?string $last_name = null,
        public ?string $phone = null
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return Arr::dropNulls([
            'customer' => $this->customer,
            'preferred_bank' => $this->preferred_bank,
            'subaccount' => $this->subaccount,
            'split_code' => $this->split_code,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'phone' => $this->phone,
        ]);
    }
}
