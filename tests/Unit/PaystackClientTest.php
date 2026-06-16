<?php

declare(strict_types=1);

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Factory;
use Illuminate\Http\Client\Request;
use Softgeng\Paystack\Config;
use Softgeng\Paystack\Data\Transaction\InitializeTransactionData;
use Softgeng\Paystack\Exceptions\ApiException;
use Softgeng\Paystack\Exceptions\AuthenticationException;
use Softgeng\Paystack\Exceptions\NetworkException;
use Softgeng\Paystack\Exceptions\RateLimitException;
use Softgeng\Paystack\Exceptions\ValidationException;
use Softgeng\Paystack\PaystackClient;

it('sends data objects as request payloads', function (): void {
    $http = new Factory();
    $http->fake(fn () => $http->response(['status' => true, 'message' => 'ok'], 200));

    $client = new PaystackClient(new Config(secret_key: 'sk_test_secret'), $http);

    $response = $client->post('/transaction/initialize', new InitializeTransactionData(
        amount: 1000,
        email: 'a@example.com',
    ));

    expect($response->status)->toBeTrue();

    $http->assertSent(fn (Request $request): bool => $request->data() === [
        'amount' => 1000,
        'email' => 'a@example.com',
    ]);
});

it('uses public key for public-key endpoints', function (): void {
    $http = new Factory();
    $http->fake(fn () => $http->response(['status' => true, 'message' => 'ok'], 200));

    $client = new PaystackClient(new Config(
        secret_key: 'sk_test_secret',
        public_key: 'pk_test_public',
    ), $http);

    $client->getWithPublicKey('/capitec-pay/requery/ref_123', ['currency' => 'ZAR']);

    $http->assertSent(fn (Request $request): bool => $request->hasHeader('Authorization', 'Bearer pk_test_public'));
});

it('requires public key for public-key endpoints', function (): void {
    $client = new PaystackClient(new Config(secret_key: 'sk_test_secret'), new Factory());

    expect(fn (): Softgeng\Paystack\Data\PaystackResponse => $client->getWithPublicKey('/capitec-pay/requery/ref_123'))
        ->toThrow(ValidationException::class, 'Paystack public key is required for this endpoint.');
});

it('throws authentication exceptions for auth failures', function (int $status): void {
    $http = new Factory();
    $http->fake(fn () => $http->response(['status' => false, 'message' => 'Invalid key'], $status));

    $client = new PaystackClient(new Config(secret_key: 'sk_test_secret'), $http);

    expect(fn (): Softgeng\Paystack\Data\PaystackResponse => $client->get('/customer'))
        ->toThrow(AuthenticationException::class, 'Invalid key');
})->with([401, 403]);

it('throws rate limit exceptions', function (): void {
    $http = new Factory();
    $http->fake(fn () => $http->response(['status' => false, 'message' => 'Too many requests'], 429));

    $client = new PaystackClient(new Config(secret_key: 'sk_test_secret'), $http);

    expect(fn (): Softgeng\Paystack\Data\PaystackResponse => $client->get('/customer'))
        ->toThrow(RateLimitException::class, 'Too many requests');
});

it('throws api exceptions for failed responses', function (): void {
    $http = new Factory();
    $http->fake(fn () => $http->response(['status' => false, 'message' => 'Bad request', 'errors' => []], 400));

    $client = new PaystackClient(new Config(secret_key: 'sk_test_secret'), $http);

    try {
        $client->post('/charge', ['amount' => 1000]);
    } catch (ApiException $exception) {
        expect($exception->statusCode)->toBe(400)
            ->and($exception->response)->toBe(['status' => false, 'message' => 'Bad request', 'errors' => []]);

        return;
    }

    fail('Expected ApiException was not thrown.');
});

it('throws api exceptions when configured to reject Paystack status false responses', function (): void {
    $http = new Factory();
    $http->fake(fn () => $http->response(['status' => false, 'message' => 'Not successful'], 200));

    $client = new PaystackClient(new Config(
        secret_key: 'sk_test_secret',
        throw_on_paystack_status_false: true,
    ), $http);

    expect(fn (): Softgeng\Paystack\Data\PaystackResponse => $client->get('/customer'))
        ->toThrow(ApiException::class, 'Not successful');
});

it('wraps non-json responses', function (): void {
    $http = new Factory();
    $http->fake(fn () => $http->response('plain response', 200));

    $client = new PaystackClient(new Config(secret_key: 'sk_test_secret'), $http);

    $response = $client->get('/customer');

    expect($response->status)->toBeFalse()
        ->and($response->message)->toBe('plain response');
});

it('throws network exceptions for connection failures', function (): void {
    $http = new Factory();
    $http->fake(fn () => throw new ConnectionException('Connection failed'));

    $client = new PaystackClient(new Config(secret_key: 'sk_test_secret'), $http);

    expect(fn (): Softgeng\Paystack\Data\PaystackResponse => $client->get('/customer'))
        ->toThrow(NetworkException::class, 'Connection failed');
});
