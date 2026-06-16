<?php

declare(strict_types=1);

namespace Softgeng\Paystack\Enums;

enum PlanInterval: string
{
    case DAILY = 'daily';
    case WEEKLY = 'weekly';
    case MONTHLY = 'monthly';
    case QUARTERLY = 'quarterly';
    case BIANNUALLY = 'biannually';
    case ANNUALLY = 'annually';
}
