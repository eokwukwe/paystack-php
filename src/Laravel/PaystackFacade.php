<?php

declare(strict_types=1);

namespace Softgeng\Paystack\Laravel;

use Illuminate\Support\Facades\Facade;

final class PaystackFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'paystack';
    }
}
