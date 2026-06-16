<?php

declare(strict_types=1);

namespace Softgeng\Paystack\Enums;

enum Bearer: string
{
    case ACCOUNT = 'account';
    case SUBACCOUNT = 'subaccount';
}
