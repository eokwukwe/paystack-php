<?php

declare(strict_types=1);

namespace Softgeng\Paystack\Data\Transfer;

use Softgeng\Paystack\Concerns\HydratesFromArray;
use Softgeng\Paystack\Contracts\DataObject;
use Softgeng\Paystack\Support\Arr;

final readonly class InitiateTransferData implements DataObject
{
    use HydratesFromArray;

    public function __construct(
        public string $source,
        public int $amount,
        public string $recipient,
        public ?string $reason = null,
        public ?string $currency = null,
        public ?string $reference = null
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return Arr::dropNulls([
            'source' => $this->source,
            'amount' => $this->amount,
            'recipient' => $this->recipient,
            'reason' => $this->reason,
            'currency' => $this->currency,
            'reference' => $this->reference,
        ]);
    }
}
