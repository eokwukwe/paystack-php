<?php

declare(strict_types=1);

namespace Softgeng\Paystack\Data\Plan;

use Softgeng\Paystack\Concerns\HydratesFromArray;
use Softgeng\Paystack\Contracts\DataObject;
use Softgeng\Paystack\Support\Arr;

final readonly class CreatePlanData implements DataObject
{
    use HydratesFromArray;

    public function __construct(
        public string $name,
        public int $amount,
        public string $interval,
        public ?string $description = null,
        public ?string $currency = null,
        public ?string $invoice_limit = null,
        public ?bool $send_invoices = null,
        public ?bool $send_sms = null
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return Arr::dropNulls([
            'name' => $this->name,
            'amount' => $this->amount,
            'interval' => $this->interval,
            'description' => $this->description,
            'currency' => $this->currency,
            'invoice_limit' => $this->invoice_limit,
            'send_invoices' => $this->send_invoices,
            'send_sms' => $this->send_sms,
        ]);
    }
}
