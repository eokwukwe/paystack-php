<?php

declare(strict_types=1);

namespace Softgeng\Paystack\Data\Refund;

use Softgeng\Paystack\Concerns\HydratesFromArray;
use Softgeng\Paystack\Contracts\DataObject;
use Softgeng\Paystack\Support\Arr;

final readonly class CreateRefundData implements DataObject
{
    use HydratesFromArray;

    public function __construct(
        public string $transaction,
        public ?int $amount = null,
        public ?string $currency = null,
        public ?string $customer_note = null,
        public ?string $merchant_note = null
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return Arr::dropNulls([
            'transaction' => $this->transaction,
            'amount' => $this->amount,
            'currency' => $this->currency,
            'customer_note' => $this->customer_note,
            'merchant_note' => $this->merchant_note,
        ]);
    }
}
