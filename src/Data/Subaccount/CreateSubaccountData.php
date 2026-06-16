<?php

declare(strict_types=1);

namespace Softgeng\Paystack\Data\Subaccount;

use Softgeng\Paystack\Concerns\HydratesFromArray;
use Softgeng\Paystack\Contracts\DataObject;
use Softgeng\Paystack\Support\Arr;

final readonly class CreateSubaccountData implements DataObject
{
    use HydratesFromArray;

    /**
     * @param  array<string, mixed>|null  $metadata
     */
    public function __construct(
        public string $business_name,
        public string $settlement_bank,
        public string $account_number,
        public float $percentage_charge,
        public ?string $description = null,
        public ?string $primary_contact_email = null,
        public ?string $primary_contact_name = null,
        public ?string $primary_contact_phone = null,
        public ?array $metadata = null
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return Arr::dropNulls([
            'business_name' => $this->business_name,
            'settlement_bank' => $this->settlement_bank,
            'account_number' => $this->account_number,
            'percentage_charge' => $this->percentage_charge,
            'description' => $this->description,
            'primary_contact_email' => $this->primary_contact_email,
            'primary_contact_name' => $this->primary_contact_name,
            'primary_contact_phone' => $this->primary_contact_phone,
            'metadata' => $this->metadata,
        ]);
    }
}
