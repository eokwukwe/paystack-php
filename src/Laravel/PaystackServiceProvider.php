<?php

declare(strict_types=1);

namespace Softgeng\Paystack\Laravel;

use Illuminate\Support\ServiceProvider;
use Softgeng\Paystack\Config;
use Softgeng\Paystack\Paystack;

final class PaystackServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../config/paystack.php',
            'paystack'
        );

        $this->app->singleton(Paystack::class, function (): Paystack {
            $config = $this->app->make('config')->get('paystack');

            return new Paystack(new Config(
                secret_key: (string) $config['secret_key'],
                public_key: $config['public_key'] ?? null,
                base_url: (string) $config['base_url'],
                timeout: (int) $config['timeout'],
                retry_times: (int) $config['retry_times'],
                retry_sleep_ms: (int) $config['retry_sleep_ms'],
                throw_on_paystack_status_false: (bool) $config['throw_on_paystack_status_false'],
            ));
        });

        $this->app->alias(Paystack::class, 'paystack');
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../../config/paystack.php' => $this->configPath('paystack.php'),
        ], 'paystack-config');
    }

    private function configPath(string $path): string
    {
        $configPath = $this->app->make('path.config');

        if (is_string($configPath)) {
            return $configPath.DIRECTORY_SEPARATOR.$path;
        }

        return 'config'.DIRECTORY_SEPARATOR.$path;
    }
}
