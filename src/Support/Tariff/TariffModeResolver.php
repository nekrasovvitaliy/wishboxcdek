<?php

declare(strict_types=1);

namespace WishboxCdek\Support\Tariff;

use WishboxCdek\Enum\TariffMode;

final class TariffModeResolver
{
    /**
     * @var array<int, TariffMode>
     */
    private const array TARIFF_MODES = [
        136 => TariffMode::WAREHOUSE_WAREHOUSE,
        137 => TariffMode::WAREHOUSE_DOOR,
        138 => TariffMode::DOOR_WAREHOUSE,
        139 => TariffMode::DOOR_DOOR,
        231 => TariffMode::DOOR_DOOR,
        232 => TariffMode::DOOR_WAREHOUSE,
        233 => TariffMode::WAREHOUSE_DOOR,
        234 => TariffMode::WAREHOUSE_WAREHOUSE,
    ];

    public function resolve(int $tariffCode): ?TariffMode
    {
        return self::TARIFF_MODES[$tariffCode] ?? null;
    }
}
