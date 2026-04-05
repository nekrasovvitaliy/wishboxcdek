<?php

declare(strict_types=1);

namespace WishboxCdek\Request\Calculator;

use WishboxCdek\Enum\AdditionalOrderType;
use WishboxCdek\Enum\Language;
use WishboxCdek\Enum\OrderType;
use WishboxCdek\Request\RequestData;

final readonly class CalculateTariffWithServicesRequest extends RequestData
{
    /**
     * @param list<AdditionalOrderType> $additionalOrderTypes
     * @param list<PackageDto> $packages
     * @param list<AdditionalServiceDto> $services
     */
    public function __construct(
        public LocationDto $fromLocation,
        public LocationDto $toLocation,
        public array $services,
        public array $packages,
        public ?OrderType $type = null,
        public array $additionalOrderTypes = [],
        public ?string $currency = null,
        public ?string $date = null,
        public ?Language $lang = null,
    ) {
    }

    public function toArray(): array
    {
        return $this->normalizeArray([
            'date' => $this->date,
            'type' => $this->type?->value,
            'currency' => $this->currency,
            'lang' => $this->lang?->value,
            'from_location' => $this->fromLocation,
            'to_location' => $this->toLocation,
            'services' => $this->services,
            'packages' => $this->packages,
            'additional_order_types' => array_map(
                static fn (AdditionalOrderType $type): int => $type->value,
                $this->additionalOrderTypes,
            ),
        ]);
    }
}
