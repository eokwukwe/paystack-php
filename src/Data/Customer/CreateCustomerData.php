<?php

declare(strict_types=1);

namespace Softgeng\Paystack\Data\Customer;

use Softgeng\Paystack\Concerns\HydratesFromArray;
use Softgeng\Paystack\Contracts\DataObject;
use Softgeng\Paystack\Support\Arr;

final readonly class CreateCustomerData implements DataObject
{
    use HydratesFromArray;

    /**
     * @param  array<string, mixed>|null  $metadata
     */
    public function __construct(
        public string $email,
        public ?string $first_name = null,
        public ?string $last_name = null,
        public ?string $phone = null,
        public ?array $metadata = null
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return Arr::dropNulls([
            'email' => $this->email,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'phone' => $this->phone,
            'metadata' => $this->metadata,
        ]);
    }
}
