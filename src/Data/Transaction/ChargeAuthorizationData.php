<?php

declare(strict_types=1);

namespace Softgeng\Paystack\Data\Transaction;

use Softgeng\Paystack\Concerns\HydratesFromArray;
use Softgeng\Paystack\Contracts\DataObject;
use Softgeng\Paystack\Support\Arr;

final readonly class ChargeAuthorizationData implements DataObject
{
    use HydratesFromArray;

    /**
     * @param  array<string, mixed>|null  $metadata
     */
    public function __construct(
        public string $authorization_code,
        public string $email,
        public int $amount,
        public ?string $reference = null,
        public ?string $currency = null,
        public ?array $metadata = null,
        public ?string $subaccount = null,
        public ?int $transaction_charge = null,
        public ?string $bearer = null,
        public ?string $queue = null
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return Arr::dropNulls([
            'authorization_code' => $this->authorization_code,
            'email' => $this->email,
            'amount' => $this->amount,
            'reference' => $this->reference,
            'currency' => $this->currency,
            'metadata' => $this->metadata,
            'subaccount' => $this->subaccount,
            'transaction_charge' => $this->transaction_charge,
            'bearer' => $this->bearer,
            'queue' => $this->queue,
        ]);
    }
}
