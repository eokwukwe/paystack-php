<?php

declare(strict_types=1);

namespace Softgeng\Paystack\Enums;

enum RecipientType: string
{
    case NUBAN = 'nuban';
    case MOBILE_MONEY = 'mobile_money';
    case BASA = 'basa';
}
