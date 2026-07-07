<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: EstimatedDeliveryIntervalsRequestDto
 *
 * Запрос на получение доступных интервалов доставки до создания заказа
 */
final readonly class EstimatedDeliveryIntervalsRequestDto
{
    public ?string $dateTime;

    public mixed $fromLocation;

    public mixed $shipmentPoint;

    public mixed $toLocation;

    public mixed $tariffCode;

    /**
     * @var array<int|string, mixed>
     */
    public array $additionalOrderTypes;

    public function __construct(
        ?string $dateTime = null,
        mixed $fromLocation = null,
        mixed $shipmentPoint = null,
        mixed $toLocation = null,
        mixed $tariffCode = null,
        array $additionalOrderTypes = [],
    ) {
        $this->dateTime = $dateTime;
        $this->fromLocation = $fromLocation;
        $this->shipmentPoint = $shipmentPoint;
        $this->toLocation = $toLocation;
        $this->tariffCode = $tariffCode;
        $this->additionalOrderTypes = $additionalOrderTypes;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            dateTime: isset($data['date_time']) ? (string) $data['date_time'] : null,
            fromLocation: $data['from_location'] ?? null,
            shipmentPoint: $data['shipment_point'] ?? null,
            toLocation: $data['to_location'] ?? null,
            tariffCode: $data['tariff_code'] ?? null,
            additionalOrderTypes: isset($data['additional_order_types']) && is_array($data['additional_order_types']) ? $data['additional_order_types'] : [],
        );
    }
}
