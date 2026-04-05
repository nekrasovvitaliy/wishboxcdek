<?php

declare(strict_types=1);

namespace WishboxCdek\Request\Intake;

use WishboxCdek\Request\RequestData;

final readonly class IntakeAvailableDaysLocationDto extends RequestData
{
    public function __construct(
        public ?int $code = null,
        public ?string $city = null,
        public ?string $fiasGuid = null,
        public ?string $countryCode = null,
        public ?string $region = null,
        public ?int $regionCode = null,
        public ?string $subRegion = null,
        public ?float $longitude = null,
        public ?float $latitude = null,
        public ?string $postalCode = null,
        public ?string $address = null,
    ) {
    }

    public function toArray(): array
    {
        return $this->normalizeArray([
            'code' => $this->code,
            'city' => $this->city,
            'fias_guid' => $this->fiasGuid,
            'country_code' => $this->countryCode,
            'region' => $this->region,
            'region_code' => $this->regionCode,
            'sub_region' => $this->subRegion,
            'longitude' => $this->longitude,
            'latitude' => $this->latitude,
            'postal_code' => $this->postalCode,
            'address' => $this->address,
        ]);
    }
}
