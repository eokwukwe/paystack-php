<?php

declare(strict_types=1);

use Softgeng\Paystack\Concerns\HydratesFromArray;
use Softgeng\Paystack\Data\Charge\CreateChargeData;
use Softgeng\Paystack\Data\Customer\CreateCustomerData;
use Softgeng\Paystack\Data\DedicatedVirtualAccount\CreateDedicatedVirtualAccountData;
use Softgeng\Paystack\Data\PaymentRequest\CreatePaymentRequestData;
use Softgeng\Paystack\Data\PaystackResponse;
use Softgeng\Paystack\Data\Plan\CreatePlanData;
use Softgeng\Paystack\Data\Refund\CreateRefundData;
use Softgeng\Paystack\Data\Split\CreateSplitData;
use Softgeng\Paystack\Data\Subaccount\CreateSubaccountData;
use Softgeng\Paystack\Data\Subscription\CreateSubscriptionData;
use Softgeng\Paystack\Data\Transaction\ChargeAuthorizationData;
use Softgeng\Paystack\Data\Transaction\InitializeTransactionData;
use Softgeng\Paystack\Data\Transfer\InitiateTransferData;
use Softgeng\Paystack\Data\TransferRecipient\CreateTransferRecipientData;
use Softgeng\Paystack\Data\Verification\ResolveAccountNumberData;

it('drops null values', function (): void {
    $data = new InitializeTransactionData(amount: 1000, email: 'a@example.com');

    expect($data->toArray())->toBe([
        'amount' => 1000,
        'email' => 'a@example.com',
    ]);
});

it('creates data from array', function (): void {
    $data = InitializeTransactionData::fromArray([
        'amount' => 1000,
        'email' => 'a@example.com',
        'reference' => 'ref_123',
        'ignored' => true,
    ]);

    expect($data->toArray())->toBe([
        'amount' => 1000,
        'email' => 'a@example.com',
        'reference' => 'ref_123',
    ]);
});

it('creates response data from array', function (): void {
    $response = PaystackResponse::fromArray([
        'status' => true,
        'message' => 'Transaction initialized',
        'data' => ['reference' => 'ref_123'],
        'meta' => ['page' => 1],
    ], 201);

    expect($response->status)->toBeTrue()
        ->and($response->http_status)->toBe(201)
        ->and($response->data())->toBe(['reference' => 'ref_123'])
        ->and($response->data('reference'))->toBe('ref_123')
        ->and($response->toArray())->toBe([
            'status' => true,
            'message' => 'Transaction initialized',
            'data' => ['reference' => 'ref_123'],
            'meta' => ['page' => 1],
        ]);
});

it('round trips all request data objects', function (string $class, array $payload): void {
    expect($class::fromArray($payload + ['ignored' => true])->toArray())->toBe($payload);
})->with([
    'charge' => [CreateChargeData::class, [
        'email' => 'customer@example.com',
        'amount' => 1000,
        'bank' => ['code' => '057'],
        'card' => ['number' => '4084084084084081'],
        'authorization_code' => 'AUTH_123',
        'pin' => '1234',
        'metadata' => ['order_id' => 1],
        'reference' => 'ref_123',
        'ussd' => '*123#',
        'mobile_money' => 'mobile',
    ]],
    'customer' => [CreateCustomerData::class, [
        'email' => 'customer@example.com',
        'first_name' => 'Ada',
        'last_name' => 'Lovelace',
        'phone' => '08000000000',
        'metadata' => ['tier' => 'gold'],
    ]],
    'dedicated virtual account' => [CreateDedicatedVirtualAccountData::class, [
        'customer' => 'CUS_123',
        'preferred_bank' => 'wema-bank',
        'subaccount' => 'ACCT_123',
        'split_code' => 'SPL_123',
        'first_name' => 'Ada',
        'last_name' => 'Lovelace',
        'phone' => '08000000000',
    ]],
    'payment request' => [CreatePaymentRequestData::class, [
        'customer' => 'CUS_123',
        'amount' => 1000,
        'due_date' => '2026-06-15',
        'description' => 'Invoice',
        'line_items' => '[{"name":"Item"}]',
        'tax' => '[{"name":"VAT"}]',
        'currency' => 'NGN',
        'send_notification' => true,
        'draft' => 'false',
        'has_invoice' => true,
        'invoice_number' => 'INV-001',
    ]],
    'plan' => [CreatePlanData::class, [
        'name' => 'Monthly',
        'amount' => 1000,
        'interval' => 'monthly',
        'description' => 'Monthly plan',
        'currency' => 'NGN',
        'invoice_limit' => '12',
        'send_invoices' => true,
        'send_sms' => false,
    ]],
    'refund' => [CreateRefundData::class, [
        'transaction' => '12345',
        'amount' => 500,
        'currency' => 'NGN',
        'customer_note' => 'Customer note',
        'merchant_note' => 'Merchant note',
    ]],
    'split' => [CreateSplitData::class, [
        'name' => 'Marketplace',
        'type' => 'percentage',
        'currency' => 'NGN',
        'subaccounts' => [['subaccount' => 'ACCT_123', 'share' => 50]],
        'bearer_type' => 'subaccount',
        'bearer_subaccount' => 'ACCT_123',
    ]],
    'subaccount' => [CreateSubaccountData::class, [
        'business_name' => 'Softgeng',
        'settlement_bank' => '057',
        'account_number' => '0000000000',
        'percentage_charge' => 10.5,
        'description' => 'Vendor',
        'primary_contact_email' => 'vendor@example.com',
        'primary_contact_name' => 'Vendor',
        'primary_contact_phone' => '08000000000',
        'metadata' => ['vendor_id' => 1],
    ]],
    'subscription' => [CreateSubscriptionData::class, [
        'customer' => 'CUS_123',
        'plan' => 'PLN_123',
        'authorization' => 'AUTH_123',
        'start_date' => '2026-06-15',
    ]],
    'charge authorization' => [ChargeAuthorizationData::class, [
        'authorization_code' => 'AUTH_123',
        'email' => 'customer@example.com',
        'amount' => 1000,
        'reference' => 'ref_123',
        'currency' => 'NGN',
        'metadata' => ['order_id' => 1],
        'subaccount' => 'ACCT_123',
        'transaction_charge' => 100,
        'bearer' => 'account',
        'queue' => 'true',
    ]],
    'transfer' => [InitiateTransferData::class, [
        'source' => 'balance',
        'amount' => 1000,
        'recipient' => 'RCP_123',
        'reason' => 'Payout',
        'currency' => 'NGN',
        'reference' => 'ref_123',
    ]],
    'transfer recipient' => [CreateTransferRecipientData::class, [
        'type' => 'nuban',
        'name' => 'Ada Lovelace',
        'account_number' => '0000000000',
        'bank_code' => '057',
        'currency' => 'NGN',
        'description' => 'Recipient',
        'metadata' => ['recipient_id' => 1],
    ]],
    'resolve account number' => [ResolveAccountNumberData::class, [
        'account_number' => '0000000000',
        'bank_code' => '057',
    ]],
]);

it('hydrates classes without constructors from arrays', function (): void {
    $class = new class
    {
        use HydratesFromArray;
    };

    expect($class::fromArray(['ignored' => true]))->toBeInstanceOf($class::class);
});
