<?php

declare(strict_types=1);

namespace WishboxCdek\Request\Calculator;

use WishboxCdek\Request\RequestData;

final readonly class LocationDto extends RequestData
{
    public function __construct(
        public ?int $code = null,
        public ?string $fiasGuid = null,
        public ?string $postalCode = null,
        public string|float|null $longitude = null,
        public string|float|null $latitude = null,
        public ?string $countryCode = null,
        public ?string $region = null,
        public ?int $regionCode = null,
        public ?string $subRegion = null,
        public ?string $city = null,
        public ?string $address = null,
        public ?string $contragentType = null,
    ) {
    }

    public function toArray(): array
    {
        return $this->filterNulls([
            'code' => $this->code,
            'fias_guid' => $this->fiasGuid,
            'postal_code' => $this->postalCode,
            'longitude' => $this->longitude,
            'latitude' => $this->latitude,
            'country_code' => $this->countryCode,
            'region' => $this->region,
            'region_code' => $this->regionCode,
            'sub_region' => $this->subRegion,
            'city' => $this->city,
            'address' => $this->address,
            'contragent_type' => $this->contragentType,
        ]);
    }
}
