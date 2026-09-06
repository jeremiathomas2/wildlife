<?php

namespace App\Services;

use App\Exceptions\PesaPalException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class PesaPalService
{
    const SANDBOX_BASE = 'https://cybqa.pesapal.com/pesapalv3/api';
    const LIVE_BASE = 'https://pay.pesapal.com/v3/api';

    const SUPPORTED_CURRENCIES = ['TZS', 'KES', 'UGX', 'RWF', 'BIF', 'USD', 'EUR', 'GBP', 'ZAR', 'NGN', 'GHS', 'CAD', 'AUD'];

    public function baseUrl(): string
    {
        return PaymentSettings::environment() === 'live'
            ? self::LIVE_BASE
            : self::SANDBOX_BASE;
    }

    public function headers(): array
    {
        return [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];
    }

    protected function attempt(string $endpoint, callable $fn): Response
    {
        try {
            return $fn();
        } catch (ConnectionException $e) {
            throw new PesaPalException(
                'Could not reach PesaPal (' . $this->baseUrl() . '/' . $endpoint . '). '
                . 'Please check your internet connection and try again. (' . $e->getMessage() . ')'
            );
        }
    }

    public function accessToken(): string
    {
        $environment = PaymentSettings::environment();

        return Cache::remember("pesapal_token_{$environment}", 3000, function () {
            $consumerKey = PaymentSettings::secret('pesapal_consumer_key');
            $consumerSecret = PaymentSettings::secret('pesapal_consumer_secret');

            if (!$consumerKey || !$consumerSecret) {
                throw PesaPalException::missingCredentials();
            }

            $response = $this->attempt('Auth/RequestToken', fn () => Http::withHeaders($this->headers())
                ->post($this->baseUrl() . '/Auth/RequestToken', [
                    'consumer_key' => $consumerKey,
                    'consumer_secret' => $consumerSecret,
                ]));

            $this->assertSuccessful($response, 'Auth/RequestToken');

            $token = data_get($response->json(), 'token');
            if (!$token) {
                throw new PesaPalException('PesaPal did not return an access token. Response: ' . $response->body());
            }

            return $token;
        });
    }

    public function registerIpnUrl(string $url, string $method = 'POST'): array
    {
        $response = $this->attempt('URLSetup/RegisterIPN', fn () => Http::withToken($this->accessToken())
            ->withHeaders($this->headers())
            ->post($this->baseUrl() . '/URLSetup/RegisterIPN', [
                'url' => $url,
                'ipn_notification_type' => $method,
            ]));

        $this->assertSuccessful($response, 'URLSetup/RegisterIPN');

        return $response->json() ?? [];
    }

    public function ipnList(): array
    {
        $response = $this->attempt('URLSetup/GetIpnList', fn () => Http::withToken($this->accessToken())
            ->withHeaders($this->headers())
            ->get($this->baseUrl() . '/URLSetup/GetIpnList'));

        $this->assertSuccessful($response, 'URLSetup/GetIpnList');

        return $response->json() ?? [];
    }

    public function submitOrder(array $payload): array
    {
        $response = $this->attempt('Transactions/SubmitOrderRequest', fn () => Http::withToken($this->accessToken())
            ->withHeaders($this->headers())
            ->post($this->baseUrl() . '/Transactions/SubmitOrderRequest', $payload));

        $this->assertSuccessful($response, 'Transactions/SubmitOrderRequest');

        return $response->json() ?? [];
    }

    public function transactionStatus(string $orderTrackingId, string $merchantReference): array
    {
        $response = $this->attempt('Transactions/GetTransactionStatus', fn () => Http::withToken($this->accessToken())
            ->withHeaders($this->headers())
            ->get($this->baseUrl() . '/Transactions/GetTransactionStatus', [
                'orderTrackingId' => $orderTrackingId,
                'orderMerchantReference' => $merchantReference,
            ]));

        $this->assertSuccessful($response, 'Transactions/GetTransactionStatus');

        return $response->json() ?? [];
    }

    protected function assertSuccessful(Response $response, string $endpoint): void
    {
        if ($response->successful()) {
            return;
        }

        $message = "PesaPal request failed for {$endpoint} with status {$response->status()}: " . $response->body();

        throw new PesaPalException($message);
    }
}