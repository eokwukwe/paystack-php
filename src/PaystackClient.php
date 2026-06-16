<?php

declare(strict_types=1);

namespace Softgeng\Paystack;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Factory;
use Illuminate\Http\Client\PendingRequest;
use Softgeng\Paystack\Contracts\DataObject;
use Softgeng\Paystack\Data\PaystackResponse;
use Softgeng\Paystack\Exceptions\ApiException;
use Softgeng\Paystack\Exceptions\AuthenticationException;
use Softgeng\Paystack\Exceptions\NetworkException;
use Softgeng\Paystack\Exceptions\RateLimitException;
use Softgeng\Paystack\Exceptions\ValidationException;

final readonly class PaystackClient
{
    public function __construct(
        private Config $config,
        private Factory $http = new Factory(),
    ) {}

    /**
     * @param  array<string, mixed>|DataObject  $query
     */
    public function get(
        string $path,
        array|DataObject $query = []
    ): PaystackResponse {
        return $this->request('GET', $path, $query);
    }

    /**
     * @param  array<string, mixed>|DataObject  $query
     */
    public function getWithPublicKey(
        string $path,
        array|DataObject $query = []
    ): PaystackResponse {
        if (
            $this->config->public_key === null ||
            trim($this->config->public_key) === ''
        ) {
            throw new ValidationException('Paystack public key is required for this endpoint.');
        }

        return $this->request('GET', $path, $query, $this->config->public_key);
    }

    /**
     * @param  array<string, mixed>|DataObject  $payload
     */
    public function post(
        string $path,
        array|DataObject $payload = []
    ): PaystackResponse {
        return $this->request('POST', $path, $payload);
    }

    /**
     * @param  array<string, mixed>|DataObject  $payload
     */
    public function put(
        string $path,
        array|DataObject $payload = []
    ): PaystackResponse {
        return $this->request('PUT', $path, $payload);
    }

    /**
     * @param  array<string, mixed>|DataObject  $payload
     */
    public function delete(
        string $path,
        array|DataObject $payload = []
    ): PaystackResponse {
        return $this->request('DELETE', $path, $payload);
    }

    /**
     * @param  array<string, mixed>|DataObject  $data
     */
    private function request(
        string $method,
        string $path,
        array|DataObject $data = [],
        ?string $bearerToken = null
    ): PaystackResponse {
        $data = $data instanceof DataObject ? $data->toArray() : $data;

        try {
            $response = $this->http($bearerToken)->send(
                $method,
                ltrim($path, '/'),
                [$method === 'GET' ? 'query' : 'json' => $data]
            );
        } catch (ConnectionException $e) {
            throw new NetworkException($e->getMessage(), $e->getCode(), previous: $e);
        }

        $payload = $response->json();
        $payload = is_array($payload) ? $payload : ['status' => false, 'message' => $response->body()];

        if ($response->status() === 401 || $response->status() === 403) {
            throw new AuthenticationException(
                $payload['message'] ?? 'Paystack authentication failed.',
                $response->status()
            );
        }

        if ($response->status() === 429) {
            throw new RateLimitException(
                $payload['message'] ?? 'Paystack rate limit exceeded.',
                429
            );
        }

        if ($response->failed()) {
            throw new ApiException(
                $payload['message'] ?? 'Paystack API request failed.',
                $response->status(),
                $payload
            );
        }

        if (
            $this->config->throw_on_paystack_status_false &&
            (($payload['status'] ?? true) === false)
        ) {
            throw new ApiException(
                $payload['message'] ?? 'Paystack request was not successful.',
                $response->status(),
                $payload
            );
        }

        return PaystackResponse::fromArray($payload, $response->status());
    }

    private function http(?string $bearerToken = null): PendingRequest
    {
        return $this->http
            ->baseUrl(rtrim($this->config->base_url, '/'))
            ->timeout($this->config->timeout)
            ->retry(
                $this->config->retry_times,
                $this->config->retry_sleep_ms,
                throw: false
            )
            ->acceptJson()
            ->asJson()
            ->withToken($bearerToken ?? $this->config->secret_key);
    }
}
