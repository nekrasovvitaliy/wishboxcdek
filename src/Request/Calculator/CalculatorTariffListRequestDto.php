<?php

declare(strict_types=1);

namespace WishboxCdek\Request\Calculator;

use WishboxCdek\Enum\AdditionalOrderType;
use WishboxCdek\Enum\Language;
use WishboxCdek\Enum\OrderType;
use WishboxCdek\Request\RequestData;

final readonly class CalculatorTariffListRequestDto extends RequestData
{
    /**
     * @param list<AdditionalOrderType> $additionalOrderTypes
     * @param list<CalcPackageRequestDto> $packages
     */
    public function __construct(
        public CalculatorLocationDto $fromLocation,
        public CalculatorLocationDto $toLocation,
        public array $packages,
        public ?OrderType $type = null,
        public array $additionalOrderTypes = [],
        public ?int $currency = null,
        public ?string $date = null,
        public ?Language $lang = null,
        public ?string $shipmentPoint = null,
        public ?string $deliveryPoint = null,
    ) {
    }

    public function toArray(): array
    {
        return $this->normalizeArray([
            'date' => $this->date,
            'type' => $this->type?->value,
            'additional_order_types' => array_map(
                static fn (AdditionalOrderType $type): int => $type->value,
                $this->additionalOrderTypes,
            ),
            'currency' => $this->currency,
            'lang' => $this->lang?->value,
            'shipment_point' => $this->shipmentPoint,
            'delivery_point' => $this->deliveryPoint,
            'from_location' => $this->fromLocation,
            'to_location' => $this->toLocation,
            'packages' => $this->packages,
        ]);
    }
}
