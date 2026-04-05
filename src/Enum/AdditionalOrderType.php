<?php

declare(strict_types=1);

namespace WishboxCdek\Enum;

enum AdditionalOrderType: int
{
    /** Сборный груз (LTL). */
    case LTL = 2;

    /** Forward. */
    case FORWARD = 4;

    /** Фулфилмент. Приход. */
    case FULFILLMENT_INBOUND = 6;

    /** Фулфилмент. Отгрузка. */
    case FULFILLMENT_OUTBOUND = 7;

    /** Forward.Express. */
    case FORWARD_EXPRESS = 9;

    /** Доставка шин по тарифу «Экономичный экспресс». */
    case ECONOMY_EXPRESS_TYRES = 10;

    /** Доставка в рамках одного офиса «Один офис». */
    case SAME_OFFICE = 11;

    /** CDEK.Shopping. */
    case CDEK_SHOPPING = 14;

    /** ТО для последней мили. */
    case LAST_MILE_TECHNICAL_PROCESS = 15;
}