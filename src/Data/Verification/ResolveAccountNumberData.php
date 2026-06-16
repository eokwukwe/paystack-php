<?php

declare(strict_types=1);

namespace Softgeng\Paystack\Data\Verification;

use Softgeng\Paystack\Concerns\HydratesFromArray;
use Softgeng\Paystack\Contracts\DataObject;
use Softgeng\Paystack\Support\Arr;

final readonly class ResolveAccountNumberData implements DataObject
{
    use HydratesFromArray;

    public function __construct(
        public string $account_number,
        public string $bank_code
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return Arr::dropNulls([
            'account_number' => $this->account_number,
            'bank_code' => $this->bank_code,
        ]);
    }
}
