<?php

declare(strict_types=1);

namespace WishboxCdek\Enum;

enum TariffMode: string
{
    case WAREHOUSE_WAREHOUSE = 'warehouse-warehouse';
    case WAREHOUSE_DOOR = 'warehouse-door';
    case DOOR_WAREHOUSE = 'door-warehouse';
    case DOOR_DOOR = 'door-door';

    public function requiresDeliveryPoint(): bool
    {
        return $this === self::WAREHOUSE_WAREHOUSE || $this === self::DOOR_WAREHOUSE;
    }

    public function requiresToLocationAddress(): bool
    {
        return $this === self::WAREHOUSE_DOOR || $this === self::DOOR_DOOR;
    }
}
