<?php

declare(strict_types=1);

use Illuminate\Http\Client\Factory;
use Softgeng\Paystack\Config;
use Softgeng\Paystack\Paystack;
use Softgeng\Paystack\PaystackClient;
use Softgeng\Paystack\Resources\ApplePay;
use Softgeng\Paystack\Resources\BulkCharges;
use Softgeng\Paystack\Resources\CapitecPay;
use Softgeng\Paystack\Resources\Charges;
use Softgeng\Paystack\Resources\Customers;
use Softgeng\Paystack\Resources\DedicatedVirtualAccounts;
use Softgeng\Paystack\Resources\DirectDebits;
use Softgeng\Paystack\Resources\Disputes;
use Softgeng\Paystack\Resources\Integration;
use Softgeng\Paystack\Resources\Miscellaneous;
use Softgeng\Paystack\Resources\Orders;
use Softgeng\Paystack\Resources\PaymentPages;
use Softgeng\Paystack\Resources\PaymentRequests;
use Softgeng\Paystack\Resources\Plans;
use Softgeng\Paystack\Resources\Preauthorizations;
use Softgeng\Paystack\Resources\Products;
use Softgeng\Paystack\Resources\Refunds;
use Softgeng\Paystack\Resources\Settlements;
use Softgeng\Paystack\Resources\Splits;
use Softgeng\Paystack\Resources\Storefronts;
use Softgeng\Paystack\Resources\Subaccounts;
use Softgeng\Paystack\Resources\Subscriptions;
use Softgeng\Paystack\Resources\Terminals;
use Softgeng\Paystack\Resources\Transactions;
use Softgeng\Paystack\Resources\TransferControl;
use Softgeng\Paystack\Resources\TransferRecipients;
use Softgeng\Paystack\Resources\Transfers;
use Softgeng\Paystack\Resources\Verification;
use Softgeng\Paystack\Resources\VirtualTerminals;

it('creates an sdk instance from keys', function (): void {
    expect(Paystack::make('sk_test_secret', 'pk_test_public'))->toBeInstanceOf(Paystack::class);
});

it('returns cached resource accessors', function (string $method, string $class): void {
    $client = new PaystackClient(new Config(secret_key: 'sk_test_secret'), new Factory());
    $paystack = new Paystack(new Config(secret_key: 'sk_test_secret'), $client);

    expect($paystack->{$method}())->toBeInstanceOf($class)
        ->and($paystack->{$method}())->toBe($paystack->{$method}());
})->with([
    'transactions' => ['transactions', Transactions::class],
    'customers' => ['customers', Customers::class],
    'dedicated virtual accounts' => ['dedicatedVirtualAccounts', DedicatedVirtualAccounts::class],
    'plans' => ['plans', Plans::class],
    'subscriptions' => ['subscriptions', Subscriptions::class],
    'transfer recipients' => ['transferRecipients', TransferRecipients::class],
    'transfers' => ['transfers', Transfers::class],
    'transfer control' => ['transferControl', TransferControl::class],
    'charges' => ['charges', Charges::class],
    'bulk charges' => ['bulkCharges', BulkCharges::class],
    'payment requests' => ['paymentRequests', PaymentRequests::class],
    'payment pages' => ['paymentPages', PaymentPages::class],
    'products' => ['products', Products::class],
    'storefronts' => ['storefronts', Storefronts::class],
    'orders' => ['orders', Orders::class],
    'subaccounts' => ['subaccounts', Subaccounts::class],
    'splits' => ['splits', Splits::class],
    'refunds' => ['refunds', Refunds::class],
    'disputes' => ['disputes', Disputes::class],
    'settlements' => ['settlements', Settlements::class],
    'verification' => ['verification', Verification::class],
    'miscellaneous' => ['miscellaneous', Miscellaneous::class],
    'apple pay' => ['applePay', ApplePay::class],
    'integration' => ['integration', Integration::class],
    'terminals' => ['terminals', Terminals::class],
    'virtual terminals' => ['virtualTerminals', VirtualTerminals::class],
    'preauthorizations' => ['preauthorizations', Preauthorizations::class],
    'direct debits' => ['directDebits', DirectDebits::class],
    'capitec pay' => ['capitecPay', CapitecPay::class],
]);
