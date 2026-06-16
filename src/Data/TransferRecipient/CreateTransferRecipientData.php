<?php

declare(strict_types=1);

namespace Softgeng\Paystack\Data\TransferRecipient;

use Softgeng\Paystack\Concerns\HydratesFromArray;
use Softgeng\Paystack\Contracts\DataObject;
use Softgeng\Paystack\Support\Arr;

final readonly class CreateTransferRecipientData implements DataObject
{
    use HydratesFromArray;

    /**
     * @param  array<string, mixed>|null  $metadata
     */
    public function __construct(
        public string $type,
        public string $name,
        public string $account_number,
        public string $bank_code,
        public string $currency,
        public ?string $description = null,
        public ?array $metadata = null
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return Arr::dropNulls([
            'type' => $this->type,
            'name' => $this->name,
            'account_number' => $this->account_number,
            'bank_code' => $this->bank_code,
            'currency' => $this->currency,
            'description' => $this->description,
            'metadata' => $this->metadata,
        ]);
    }
}
