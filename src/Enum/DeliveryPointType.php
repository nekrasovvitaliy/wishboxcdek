<?php

declare(strict_types=1);

namespace WishboxCdek\Enum;

enum DeliveryPointType: string
{
    case POSTAMAT = 'POSTAMAT';
    case PVZ = 'PVZ';
    case ALL = 'ALL';
}
