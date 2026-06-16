<?php

declare(strict_types=1);

namespace Softgeng\Paystack\Data\Charge;

use Softgeng\Paystack\Concerns\HydratesFromArray;
use Softgeng\Paystack\Contracts\DataObject;
use Softgeng\Paystack\Support\Arr;

final readonly class CreateChargeData implements DataObject
{
    use HydratesFromArray;

    /**
     * @param  array<string, mixed>|null  $bank
     * @param  array<string, mixed>|null  $card
     * @param  array<string, mixed>|null  $metadata
     */
    public function __construct(
        public string $email,
        public int $amount,
        public ?array $bank = null,
        public ?array $card = null,
        public ?string $authorization_code = null,
        public ?string $pin = null,
        public ?array $metadata = null,
        public ?string $reference = null,
        public ?string $ussd = null,
        public ?string $mobile_money = null
    ) {}

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return Arr::dropNulls([
            'email' => $this->email,
            'amount' => $this->amount,
            'bank' => $this->bank,
            'card' => $this->card,
            'authorization_code' => $this->authorization_code,
            'pin' => $this->pin,
            'metadata' => $this->metadata,
            'reference' => $this->reference,
            'ussd' => $this->ussd,
            'mobile_money' => $this->mobile_money,
        ]);
    }
}
