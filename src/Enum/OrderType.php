<?php

declare(strict_types=1);

namespace WishboxCdek\Enum;

enum OrderType: int
{
    case INTERNET_SHOP = 1;
    case DELIVERY = 2;
}
