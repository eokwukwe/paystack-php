# Usage Guide

## Initialize a transaction

```php
$response = $paystack->transactions()->initialize([
    'amount' => 250000,
    'email' => 'customer@example.com',
    'reference' => 'ORDER_123',
]);
```

## Verify a transaction

```php
$response = $paystack->transactions()->verify('ORDER_123');
```

## Create a customer

```php
$response = $paystack->customers()->create([
    'email' => 'customer@example.com',
    'first_name' => 'Ada',
    'last_name' => 'Lovelace',
]);
```

## Create a transfer recipient

```php
$response = $paystack->transferRecipients()->create([
    'type' => 'nuban',
    'name' => 'Ada Lovelace',
    'account_number' => '0000000000',
    'bank_code' => '058',
    'currency' => 'NGN',
]);
```

## Initiate a transfer

```php
$response = $paystack->transfers()->initiate([
    'source' => 'balance',
    'amount' => 500000,
    'recipient' => 'RCP_xxx',
    'reason' => 'Vendor payout',
]);
```
