<?php

declare(strict_types=1);

namespace Softgeng\Paystack\Data\Transaction;

use Softgeng\Paystack\Concerns\HydratesFromArray;
use Softgeng\Paystack\Contracts\DataObject;
use Softgeng\Paystack\Support\Arr;

final readonly class InitializeTransactionData implements DataObject
{
    use HydratesFromArray;

    /**
     * @param  array<int, string>|null  $channels
     * @param  array<string, mixed>|null  $metadata
     */
    public function __construct(
        public int $amount,
        public string $email,
        public ?string $reference = null,
        public ?string $currency = null,
        public ?string $callback_url = null,
        public ?array $channels = null,
        public ?string $plan = null,
        public ?int $invoice_limit = null,
        public ?array $metadata = null,
        public ?string $subaccount = null,
        public ?int $transaction_charge = null,
        public ?string $bearer = null,
        public ?string $split_code = null
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return Arr::dropNulls([
            'amount' => $this->amount,
            'email' => $this->email,
            'reference' => $this->reference,
            'currency' => $this->currency,
            'callback_url' => $this->callback_url,
            'channels' => $this->channels,
            'plan' => $this->plan,
            'invoice_limit' => $this->invoice_limit,
            'metadata' => $this->metadata,
            'subaccount' => $this->subaccount,
            'transaction_charge' => $this->transaction_charge,
            'bearer' => $this->bearer,
            'split_code' => $this->split_code,
        ]);
    }
}
