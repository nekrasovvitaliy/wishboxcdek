<?php

declare(strict_types=1);

namespace WishboxCdek\Request\Delivery;

use WishboxCdek\Enum\AdditionalOrderType;
use WishboxCdek\Request\RequestData;

final readonly class GetEstimatedDeliveryIntervalsRequest extends RequestData
{
    /**
     * @param list<AdditionalOrderType> $additionalOrderTypes
     */
    public function __construct(
        public string $dateTime,
        public EstimatedDeliveryLocationDto $toLocation,
        public int $tariffCode,
        public ?EstimatedDeliveryLocationDto $fromLocation = null,
        public ?string $shipmentPoint = null,
        public array $additionalOrderTypes = [],
    ) {
    }

    public function toArray(): array
    {
        return $this->normalizeArray([
            'date_time' => $this->dateTime,
            'from_location' => $this->fromLocation,
            'shipment_point' => $this->shipmentPoint,
            'to_location' => $this->toLocation,
            'tariff_code' => $this->tariffCode,
            'additional_order_types' => array_map(
                static fn (AdditionalOrderType $type): int => $type->value,
                $this->additionalOrderTypes,
            ),
        ]);
    }
}