<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: GetPrealertResponseDtoPrealertDto
 *
 * Информация о преалерте
 */
final readonly class GetPrealertResponseDtoPrealertDto
{
    public ?string $uuid;

    public mixed $prealertNumber;

    public ?string $plannedDate;

    public mixed $shipmentPoint;

    public ?string $closedDate;

    public mixed $factShipmentPoint;

    /**
     * @var array<int|string, mixed> of GetPrealertResponseDtoOrderDto
     */
    public array $orders;

    public function __construct(
        ?string $uuid = null,
        mixed $prealertNumber = null,
        ?string $plannedDate = null,
        mixed $shipmentPoint = null,
        ?string $closedDate = null,
        mixed $factShipmentPoint = null,
        array $orders = [],
    ) {
        $this->uuid = $uuid;
        $this->prealertNumber = $prealertNumber;
        $this->plannedDate = $plannedDate;
        $this->shipmentPoint = $shipmentPoint;
        $this->closedDate = $closedDate;
        $this->factShipmentPoint = $factShipmentPoint;
        $this->orders = $orders;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            uuid: isset($data['uuid']) ? (string) $data['uuid'] : null,
            prealertNumber: $data['prealert_number'] ?? null,
            plannedDate: isset($data['planned_date']) ? (string) $data['planned_date'] : null,
            shipmentPoint: $data['shipment_point'] ?? null,
            closedDate: isset($data['closed_date']) ? (string) $data['closed_date'] : null,
            factShipmentPoint: $data['fact_shipment_point'] ?? null,
            orders: isset($data['orders']) && is_array($data['orders']) ? $data['orders'] : [],
        );
    }
}
