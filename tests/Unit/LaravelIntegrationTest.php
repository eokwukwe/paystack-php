<?php

declare(strict_types=1);

use Illuminate\Contracts\Foundation\CachesConfiguration;
use Illuminate\Support\ServiceProvider;
use Softgeng\Paystack\Laravel\PaystackFacade;
use Softgeng\Paystack\Laravel\PaystackServiceProvider;
use Softgeng\Paystack\Paystack;

it('registers the paystack singleton and alias', function (): void {
    $app = new class implements CachesConfiguration
    {
        public object $config;

        public array $bindings = [];

        public array $aliases = [];

        public function __construct()
        {
            $this->config = new class
            {
                public array $items = [
                    'paystack' => [
                        'secret_key' => 'sk_test_secret',
                        'public_key' => 'pk_test_public',
                        'base_url' => 'https://api.paystack.co',
                        'timeout' => 30,
                        'retry_times' => 2,
                        'retry_sleep_ms' => 300,
                        'throw_on_paystack_status_false' => false,
                    ],
                ];

                public function get(string $key, mixed $default = null): mixed
                {
                    return $this->items[$key] ?? $default;
                }

                public function set(string $key, mixed $value): void
                {
                    $this->items[$key] = $value;
                }
            };
        }

        public function make(string $abstract): mixed
        {
            if ($abstract === 'config') {
                return $this->config;
            }

            $abstract = $this->aliases[$abstract] ?? $abstract;

            if (isset($this->bindings[$abstract])) {
                $binding = $this->bindings[$abstract];

                return $binding instanceof Closure ? $binding() : $binding;
            }

            return null;
        }

        public function singleton(string $abstract, Closure $factory): void
        {
            $this->bindings[$abstract] = function () use ($factory, $abstract): mixed {
                if ($this->bindings[$abstract] instanceof Closure) {
                    $this->bindings[$abstract] = $factory();
                }

                return $this->bindings[$abstract];
            };
        }

        public function alias(string $abstract, string $alias): void
        {
            $this->aliases[$alias] = $abstract;
        }

        public function configurationIsCached(): bool
        {
            return true;
        }

        public function getCachedConfigPath(): string
        {
            return 'cached-config.php';
        }

        public function getCachedServicesPath(): string
        {
            return 'cached-services.php';
        }
    };

    (new PaystackServiceProvider($app))->register();

    expect($app->make(Paystack::class))->toBeInstanceOf(Paystack::class)
        ->and($app->make('paystack'))->toBe($app->make(Paystack::class));
});

it('merges the package config with existing values', function (): void {
    $app = new class implements CachesConfiguration
    {
        public object $config;

        public function __construct()
        {
            $this->config = new class
            {
                public array $items = [
                    'paystack' => [
                        'secret_key' => 'sk_test_secret',
                    ],
                ];

                public function get(string $key, mixed $default = null): mixed
                {
                    return $this->items[$key] ?? $default;
                }

                public function set(string $key, mixed $value): void
                {
                    $this->items[$key] = $value;
                }
            };
        }

        public function make(string $abstract): mixed
        {
            return $abstract === 'config' ? $this->config : null;
        }

        public function singleton(string $abstract, Closure $factory): void
        {
            //
        }

        public function alias(string $abstract, string $alias): void {}

        public function configurationIsCached(): bool
        {
            return true;
        }

        public function getCachedConfigPath(): string
        {
            return 'cached-config.php';
        }

        public function getCachedServicesPath(): string
        {
            return 'cached-services.php';
        }
    };

    (new PaystackServiceProvider($app))->register();

    expect($app->config->get('paystack'))->toBe(['secret_key' => 'sk_test_secret']);
});

it('publishes the package config file', function (): void {
    ServiceProvider::$publishes = [];
    ServiceProvider::$publishGroups = [];

    $provider = new PaystackServiceProvider(new class
    {
        public function make(string $abstract): mixed
        {
            return $abstract === 'path.config' ? 'config' : null;
        }
    });
    $provider->boot();

    $paths = ServiceProvider::pathsToPublish(PaystackServiceProvider::class, 'paystack-config');

    expect(array_key_first($paths))->toEndWith('config/paystack.php')
        ->and(array_values($paths)[0])->toBe('config'.DIRECTORY_SEPARATOR.'paystack.php');
});

it('falls back to a relative config path when the config path binding is unavailable', function (): void {
    ServiceProvider::$publishes = [];
    ServiceProvider::$publishGroups = [];

    $provider = new PaystackServiceProvider(new class
    {
        public function make(string $abstract): mixed
        {
            return null;
        }
    });
    $provider->boot();

    $paths = ServiceProvider::pathsToPublish(PaystackServiceProvider::class, 'paystack-config');

    expect(array_values($paths)[0])->toBe('config'.DIRECTORY_SEPARATOR.'paystack.php');
});

it('uses the paystack facade accessor', function (): void {
    $method = new ReflectionMethod(PaystackFacade::class, 'getFacadeAccessor');

    expect($method->invoke(null))->toBe('paystack');
});
