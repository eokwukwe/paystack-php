<?php

declare(strict_types=1);

use Softgeng\Paystack\Config;
use Softgeng\Paystack\Exceptions\ApiException;
use Softgeng\Paystack\Support\Arr;

it('requires a non-empty secret key', function (): void {
    expect(fn (): Config => new Config(secret_key: '   '))
        ->toThrow(InvalidArgumentException::class, 'Paystack secret key is required.');
});

it('converts booleans to strings and leaves other values alone', function (): void {
    expect(Arr::boolToString(true))->toBe('true')
        ->and(Arr::boolToString(false))->toBe('false')
        ->and(Arr::boolToString('true'))->toBe('true');
});

it('stores api exception response context', function (): void {
    $exception = new ApiException('Failed', 400, ['status' => false]);

    expect($exception->getMessage())->toBe('Failed')
        ->and($exception->statusCode)->toBe(400)
        ->and($exception->response)->toBe(['status' => false]);
});
