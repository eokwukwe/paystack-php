<?php

declare(strict_types=1);

namespace Softgeng\Paystack\Data\Split;

use Softgeng\Paystack\Concerns\HydratesFromArray;
use Softgeng\Paystack\Contracts\DataObject;
use Softgeng\Paystack\Support\Arr;

final readonly class CreateSplitData implements DataObject
{
    use HydratesFromArray;

    /**
     * @param  array<int, array<string, mixed>>  $subaccounts
     */
    public function __construct(
        public string $name,
        public string $type,
        public string $currency,
        public array $subaccounts,
        public ?string $bearer_type = null,
        public ?string $bearer_subaccount = null
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return Arr::dropNulls([
            'name' => $this->name,
            'type' => $this->type,
            'currency' => $this->currency,
            'subaccounts' => $this->subaccounts,
            'bearer_type' => $this->bearer_type,
            'bearer_subaccount' => $this->bearer_subaccount,
        ]);
    }
}
