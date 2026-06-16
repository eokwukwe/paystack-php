<?php

declare(strict_types=1);

namespace Softgeng\Paystack\Data\PaymentRequest;

use Softgeng\Paystack\Concerns\HydratesFromArray;
use Softgeng\Paystack\Contracts\DataObject;
use Softgeng\Paystack\Support\Arr;

final readonly class CreatePaymentRequestData implements DataObject
{
    use HydratesFromArray;

    public function __construct(
        public string $customer,
        public int $amount,
        public ?string $due_date = null,
        public ?string $description = null,
        public ?string $line_items = null,
        public ?string $tax = null,
        public ?string $currency = null,
        public ?bool $send_notification = null,
        public ?string $draft = null,
        public ?bool $has_invoice = null,
        public ?string $invoice_number = null
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return Arr::dropNulls([
            'customer' => $this->customer,
            'amount' => $this->amount,
            'due_date' => $this->due_date,
            'description' => $this->description,
            'line_items' => $this->line_items,
            'tax' => $this->tax,
            'currency' => $this->currency,
            'send_notification' => $this->send_notification,
            'draft' => $this->draft,
            'has_invoice' => $this->has_invoice,
            'invoice_number' => $this->invoice_number,
        ]);
    }
}
