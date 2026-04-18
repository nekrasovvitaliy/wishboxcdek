<?php

declare(strict_types=1);

namespace WishboxCdek\Enum;

enum OrderPrint: string
{
    case WAYBILL = 'WAYBILL';
    case BARCODE = 'BARCODE';
}
