# Paystack PHP SDK

A PHP 8.2+ SDK for the current Paystack API Reference, with optional Laravel integration.

This package intentionally tracks the current Paystack API docs only. Legacy aliases and helper APIs that are not present in the current API Reference are not exposed.

Paystack's API Reference remains the source of truth for endpoint fields and business rules. This SDK provides a PHP-friendly wrapper around those resources while keeping request and response payloads close to Paystack's JSON shape.

## Features

- Standalone PHP SDK powered by Laravel's standalone HTTP client.
- Optional Laravel service provider, config publishing, and facade support.
- Resource wrappers for the current Paystack API groups.
- Array payload and query support for every request.
- Typed data objects for common write operations.
- `fromArray()` and `toArray()` support on data objects.
- Consistent `PaystackResponse` wrapper for all API responses.
- Focused exception hierarchy for API, auth, rate limit, network, and validation failures.
- Pest test suite with 100% coverage.

## Requirements

- PHP `^8.2`
- `illuminate/http` `^10.0|^11.0|^12.0|^13.0`
- `illuminate/support` `^10.0|^11.0|^12.0|^13.0`

Laravel 13 is supported through Illuminate `^13.0`. Laravel 13 itself requires PHP 8.3+, so Composer will only resolve the Laravel 13 dependency set on PHP versions supported by Laravel 13.

## Installation

```bash
composer require softgeng/paystack-php
```

## Quick Start

```php
use Softgeng\Paystack\Paystack;

$paystack = Paystack::make('sk_test_xxx');

$response = $paystack->transactions()->initialize([
    'amount' => 500000,
    'email' => 'customer@example.com',
    'reference' => 'ORDER_123',
    'callback_url' => 'https://example.com/paystack/callback',
    'metadata' => [
        'order_id' => 123,
    ],
]);

$authorizationUrl = $response->data('authorization_url');
```

Paystack amounts should be sent as integers in the smallest supported currency subunit. For NGN, send Kobo.

## Configuration

For standalone PHP, create a client with your secret key. The secret key is used for almost every Paystack endpoint and should only be used from trusted server-side code.

```php
use Softgeng\Paystack\Config;
use Softgeng\Paystack\Paystack;

$paystack = new Paystack(new Config(
    secret_key: 'sk_test_xxx',
    public_key: 'pk_test_xxx',
    timeout: 30,
    retry_times: 2,
));
```

The shortcut form is enough for most integrations:

```php
$paystack = Paystack::make('sk_test_xxx', 'pk_test_xxx');
```

Most endpoints use the secret key. Capitec Pay requery uses the public key, so pass both keys if you need that resource.

Available configuration options:

| Option | Default | Description |
| --- | --- | --- |
| `secret_key` | Required | Paystack secret key used as the bearer token for API requests. |
| `public_key` | `null` | Paystack public key. Required for Capitec Pay requery. |
| `base_url` | `https://api.paystack.co` | Paystack API base URL. |
| `timeout` | `30` | HTTP timeout in seconds. |
| `retry_times` | `2` | Number of HTTP retry attempts. |
| `retry_sleep_ms` | `300` | Delay between retry attempts, in milliseconds. |
| `throw_on_paystack_status_false` | `false` | Throw `ApiException` when Paystack returns HTTP success with `"status": false`. |

## Laravel

The service provider is auto-discovered by Laravel.

Publish the config file:

```bash
php artisan vendor:publish --tag=paystack-config
```

Set your environment variables:

```env
PAYSTACK_SECRET_KEY=sk_test_xxx
PAYSTACK_PUBLIC_KEY=pk_test_xxx
PAYSTACK_BASE_URL=https://api.paystack.co
PAYSTACK_TIMEOUT=30
PAYSTACK_RETRY_TIMES=2
PAYSTACK_RETRY_SLEEP_MS=300
PAYSTACK_THROW_ON_STATUS_FALSE=false
```

Inject the SDK:

```php
use Softgeng\Paystack\Paystack;

final class CheckoutController
{
    public function verify(Paystack $paystack, string $reference)
    {
        return $paystack->transactions()->verify($reference)->toArray();
    }
}
```

Or use the facade:

```php
use Softgeng\Paystack\Laravel\PaystackFacade as Paystack;

$response = Paystack::transactions()->verify('ORDER_123');
```

## Responses

Every resource method returns `Softgeng\Paystack\Data\PaystackResponse`.

```php
$response = $paystack->transactions()->verify('ORDER_123');

$response->status;      // true or false
$response->message;     // Paystack message
$response->data();      // full data payload
$response->data('id');  // single key from data
$response->meta;        // response metadata, when present
$response->httpStatus;  // HTTP status code

$array = $response->toArray();
```

`data()` returns the complete Paystack `data` object or array. `data('key')` reads a top-level key from that payload and accepts a default as the second argument:

```php
$authorizationUrl = $response->data('authorization_url');
$gatewayResponse = $response->data('gateway_response', 'No gateway response');
```

## Request Payloads

Every resource method accepts plain arrays:

```php
$response = $paystack->customers()->create([
    'email' => 'customer@example.com',
    'first_name' => 'Ada',
    'last_name' => 'Lovelace',
]);
```

For list, export, and search endpoints, pass query parameters as arrays:

```php
$response = $paystack->transactions()->list([
    'perPage' => 50,
    'page' => 1,
    'from' => '2026-01-01',
    'to' => '2026-01-31',
]);
```

Path values such as references, codes, IDs, slugs, and customer identifiers are passed as method arguments:

```php
$transaction = $paystack->transactions()->fetch(123456789);
$customer = $paystack->customers()->fetch('CUS_xxx');
$page = $paystack->paymentPages()->fetch('checkout-page');
```

Common write operations also have typed data objects:

```php
use Softgeng\Paystack\Data\Transaction\InitializeTransactionData;

$data = new InitializeTransactionData(
    amount: 500000,
    email: 'customer@example.com',
    reference: 'ORDER_123',
);

$response = $paystack->transactions()->initialize($data);
```

Data objects support hydration and serialization:

```php
$data = InitializeTransactionData::fromArray([
    'amount' => 500000,
    'email' => 'customer@example.com',
    'reference' => 'ORDER_123',
]);

$payload = $data->toArray();
```

`fromArray()` maps constructor keys and ignores unrelated fields. `toArray()` removes `null` values before sending the payload.

Data objects are intentionally lightweight convenience classes. They are useful for common create and initialize flows, but arrays remain fully supported for every endpoint and for newly added Paystack fields.

## Available Data Objects

- `Softgeng\Paystack\Data\Charge\CreateChargeData`
- `Softgeng\Paystack\Data\Customer\CreateCustomerData`
- `Softgeng\Paystack\Data\DedicatedVirtualAccount\CreateDedicatedVirtualAccountData`
- `Softgeng\Paystack\Data\PaymentRequest\CreatePaymentRequestData`
- `Softgeng\Paystack\Data\Plan\CreatePlanData`
- `Softgeng\Paystack\Data\Refund\CreateRefundData`
- `Softgeng\Paystack\Data\Split\CreateSplitData`
- `Softgeng\Paystack\Data\Subaccount\CreateSubaccountData`
- `Softgeng\Paystack\Data\Subscription\CreateSubscriptionData`
- `Softgeng\Paystack\Data\Transaction\ChargeAuthorizationData`
- `Softgeng\Paystack\Data\Transaction\InitializeTransactionData`
- `Softgeng\Paystack\Data\Transfer\InitiateTransferData`
- `Softgeng\Paystack\Data\TransferRecipient\CreateTransferRecipientData`
- `Softgeng\Paystack\Data\Verification\ResolveAccountNumberData`

Typed data objects are convenience helpers. If Paystack adds a new field to an existing endpoint, pass an array until a matching data object property is added.

## Resource Methods

All methods return `PaystackResponse`. Payload and query arguments may be arrays or data objects.

| Accessor | Methods |
| --- | --- |
| `transactions()` | `initialize`, `verify`, `list`, `fetch`, `chargeAuthorization`, `viewTimeline`, `transactionTotals`, `export`, `partialDebit` |
| `splits()` | `create`, `list`, `fetch`, `update`, `addSubaccount`, `removeSubaccount` |
| `terminals()` | `sendEvent`, `fetchEventStatus`, `fetchTerminalStatus`, `list`, `fetch`, `update`, `commission`, `decommission` |
| `virtualTerminals()` | `create`, `list`, `fetch`, `update`, `deactivate`, `assignDestination`, `unassignDestination`, `addSplitCode`, `removeSplitCode` |
| `customers()` | `create`, `list`, `fetch`, `update`, `validate`, `setRiskAction`, `initializeAuthorization`, `verifyAuthorization`, `initializeDirectDebit`, `directDebitActivationCharge`, `mandateAuthorizations`, `deactivateAuthorization` |
| `directDebits()` | `triggerActivationCharge`, `mandateAuthorizations` |
| `dedicatedVirtualAccounts()` | `create`, `assign`, `list`, `fetch`, `requery`, `deactivate`, `split`, `removeSplit`, `providers` |
| `preauthorizations()` | `initialize`, `capture`, `reserve`, `verify`, `release`, `list` |
| `applePay()` | `registerDomain`, `listDomains`, `unregisterDomain` |
| `capitecPay()` | `requery` |
| `subaccounts()` | `create`, `list`, `fetch`, `update` |
| `plans()` | `create`, `list`, `fetch`, `update` |
| `subscriptions()` | `create`, `list`, `fetch`, `enable`, `disable`, `manageLink`, `sendManageLink` |
| `products()` | `create`, `list`, `fetch`, `update` |
| `storefronts()` | `create`, `list`, `fetch`, `update`, `delete`, `verifySlug`, `orders`, `addProducts`, `products`, `publish`, `duplicate` |
| `orders()` | `create`, `list`, `fetch`, `productOrders`, `validate` |
| `paymentPages()` | `create`, `list`, `fetch`, `update`, `checkSlugAvailability`, `addProducts` |
| `paymentRequests()` | `create`, `list`, `fetch`, `verify`, `sendNotification`, `total`, `finalize`, `update`, `archive` |
| `settlements()` | `list`, `transactions` |
| `transferRecipients()` | `create`, `bulkCreate`, `list`, `fetch`, `update`, `delete` |
| `transfers()` | `initiate`, `finalize`, `bulk`, `list`, `fetch`, `verify` |
| `transferControl()` | `balance`, `ledger`, `resendOtp`, `disableOtp`, `finalizeDisableOtp`, `enableOtp` |
| `bulkCharges()` | `initiate`, `listBatches`, `fetchBatch`, `fetchChargesInBatch`, `pause`, `resume` |
| `integration()` | `fetchPaymentSessionTimeout`, `updatePaymentSessionTimeout` |
| `charges()` | `create`, `submitPin`, `submitOtp`, `submitPhone`, `submitBirthday`, `submitAddress`, `checkPending` |
| `disputes()` | `list`, `fetch`, `listForTransaction`, `update`, `addEvidence`, `getUploadUrl`, `resolve`, `export` |
| `refunds()` | `create`, `retry`, `list`, `fetch` |
| `verification()` | `resolveAccountNumber`, `validateAccount`, `resolveCardBin` |
| `miscellaneous()` | `listBanks`, `listCountries`, `listStates` |

## Common Examples

### Verify a transaction

```php
$response = $paystack->transactions()->verify('ORDER_123');

if ($response->status) {
    $amount = $response->data('amount');
}
```

### Create a customer

```php
$response = $paystack->customers()->create([
    'email' => 'customer@example.com',
    'first_name' => 'Ada',
    'last_name' => 'Lovelace',
]);
```

### Resolve an account number

```php
use Softgeng\Paystack\Data\Verification\ResolveAccountNumberData;

$response = $paystack->verification()->resolveAccountNumber(
    new ResolveAccountNumberData(
        account_number: '0000000000',
        bank_code: '058',
    )
);
```

### Create a transfer recipient

```php
use Softgeng\Paystack\Data\TransferRecipient\CreateTransferRecipientData;

$response = $paystack->transferRecipients()->create(
    new CreateTransferRecipientData(
        type: 'nuban',
        name: 'Ada Lovelace',
        account_number: '0000000000',
        bank_code: '058',
        currency: 'NGN',
    )
);
```

### Initiate a transfer

```php
use Softgeng\Paystack\Data\Transfer\InitiateTransferData;
use Softgeng\Paystack\Enums\TransferSource;

$response = $paystack->transfers()->initiate(
    new InitiateTransferData(
        source: TransferSource::BALANCE->value,
        amount: 500000,
        recipient: 'RCP_xxx',
        reason: 'Vendor payout',
    )
);
```

### Requery a Capitec Pay transaction

```php
$paystack = Paystack::make('sk_test_xxx', 'pk_test_xxx');

$response = $paystack->capitecPay()->requery('transaction-reference');
```

## Exceptions

The SDK throws package-specific exceptions under `Softgeng\Paystack\Exceptions`.

```php
use Softgeng\Paystack\Exceptions\ApiException;
use Softgeng\Paystack\Exceptions\AuthenticationException;
use Softgeng\Paystack\Exceptions\NetworkException;
use Softgeng\Paystack\Exceptions\RateLimitException;

try {
    $response = $paystack->transactions()->verify('ORDER_123');
} catch (AuthenticationException $exception) {
    // Invalid or unauthorized API key.
} catch (RateLimitException $exception) {
    // Paystack rate limit response.
} catch (NetworkException $exception) {
    // Transport or connection failure.
} catch (ApiException $exception) {
    // Non-successful Paystack API response.
}
```

If `throw_on_paystack_status_false` is enabled in config, the client also throws an `ApiException` when Paystack returns HTTP success with `"status": false`.

## Testing

This package uses Pest v3 to stay compatible with PHP 8.2+.

```bash
composer test
composer test:coverage
```

If you use Laravel Herd locally:

```bash
herd composer test:coverage
```

The current suite is maintained at 100% coverage.

## Paystack API Scope

This SDK mirrors the current [Paystack API Reference](https://paystack.com/docs/api/).

It does not expose helper APIs or aliases that are outside the current API Reference. For webhook processing, validate Paystack webhook signatures in your application layer according to Paystack's integration guidance.

## License

The MIT License. See `LICENSE.md`.
