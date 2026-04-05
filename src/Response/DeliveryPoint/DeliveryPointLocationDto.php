<?php

declare(strict_types=1);

namespace WishboxCdek\Response\DeliveryPoint;

final readonly class DeliveryPointLocationDto
{
    public function __construct(
        public ?string $countryCode = null,
        public ?int $regionCode = null,
        public ?string $region = null,
        public ?int $cityCode = null,
        public ?string $city = null,
        public ?string $fiasGuid = null,
        public ?string $postalCode = null,
        public ?float $longitude = null,
        public ?float $latitude = null,
        public ?string $address = null,
        public ?string $addressFull = null,
        public ?string $cityUuid = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            countryCode: isset($data['country_code']) ? (string) $data['country_code'] : null,
            regionCode: isset($data['region_code']) ? (int) $data['region_code'] : null,
            region: isset($data['region']) ? (string) $data['region'] : null,
            cityCode: isset($data['city_code']) ? (int) $data['city_code'] : null,
            city: isset($data['city']) ? (string) $data['city'] : null,
            fiasGuid: isset($data['fias_guid']) ? (string) $data['fias_guid'] : null,
            postalCode: isset($data['postal_code']) ? (string) $data['postal_code'] : null,
            longitude: isset($data['longitude']) ? (float) $data['longitude'] : null,
            latitude: isset($data['latitude']) ? (float) $data['latitude'] : null,
            address: isset($data['address']) ? (string) $data['address'] : null,
            addressFull: isset($data['address_full']) ? (string) $data['address_full'] : null,
            cityUuid: isset($data['city_uuid']) ? (string) $data['city_uuid'] : null,
        );
    }
}
