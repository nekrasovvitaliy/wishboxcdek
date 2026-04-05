<?php

declare(strict_types=1);

namespace WishboxCdek\Response\Prealert;

final readonly class PrealertEntityDto
{
    /**
     * @param list<PrealertOrderDto> $orders
     */
    public function __construct(
        public ?string $uuid = null,
        public ?string $prealertNumber = null,
        public ?string $plannedDate = null,
        public ?string $shipmentPoint = null,
        public ?string $closedDate = null,
        public ?string $factShipmentPoint = null,
        public array $orders = [],
    ) {
    }

    public static function fromArray(array $data): self
    {
        $orders = [];
        foreach (($data['orders'] ?? []) as $order) {
            if (is_array($order)) {
                $orders[] = PrealertOrderDto::fromArray($order);
            }
        }

        return new self(
            uuid: isset($data['uuid']) ? (string) $data['uuid'] : null,
            prealertNumber: isset($data['prealert_number']) ? (string) $data['prealert_number'] : null,
            plannedDate: isset($data['planned_date']) ? (string) $data['planned_date'] : null,
            shipmentPoint: isset($data['shipment_point']) ? (string) $data['shipment_point'] : null,
            closedDate: isset($data['closed_date']) ? (string) $data['closed_date'] : null,
            factShipmentPoint: isset($data['fact_shipment_point']) ? (string) $data['fact_shipment_point'] : null,
            orders: $orders,
        );
    }
}