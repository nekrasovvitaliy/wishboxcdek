<?php

declare(strict_types=1);

namespace WishboxCdek\Request\Prealert;

use WishboxCdek\Request\RequestData;

final readonly class RegisterPrealertRequest extends RequestData
{
    /**
     * @param list<PrealertOrderDto> $orders
     */
    public function __construct(
        public string $plannedDate,
        public string $shipmentPoint,
        public array $orders,
    ) {
    }

    public function toArray(): array
    {
        return $this->normalizeArray([
            'planned_date' => $this->plannedDate,
            'shipment_point' => $this->shipmentPoint,
            'orders' => $this->orders,
        ]);
    }
}