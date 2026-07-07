<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: OfficeLocationDto
 *
 * Информация об офисе
 */
final readonly class OfficeLocationDto
{
    public mixed $countryCode;

    public mixed $regionCode;

    public mixed $region;

    public mixed $cityCode;

    public mixed $city;

    public ?string $fiasGuid;

    public mixed $postalCode;

    public mixed $longitude;

    public mixed $latitude;

    public mixed $address;

    public mixed $addressFull;

    public ?string $cityUuid;

    public function __construct(
        mixed $countryCode = null,
        mixed $regionCode = null,
        mixed $region = null,
        mixed $cityCode = null,
        mixed $city = null,
        ?string $fiasGuid = null,
        mixed $postalCode = null,
        mixed $longitude = null,
        mixed $latitude = null,
        mixed $address = null,
        mixed $addressFull = null,
        ?string $cityUuid = null,
    ) {
        $this->countryCode = $countryCode;
        $this->regionCode = $regionCode;
        $this->region = $region;
        $this->cityCode = $cityCode;
        $this->city = $city;
        $this->fiasGuid = $fiasGuid;
        $this->postalCode = $postalCode;
        $this->longitude = $longitude;
        $this->latitude = $latitude;
        $this->address = $address;
        $this->addressFull = $addressFull;
        $this->cityUuid = $cityUuid;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            countryCode: $data['country_code'] ?? null,
            regionCode: $data['region_code'] ?? null,
            region: $data['region'] ?? null,
            cityCode: $data['city_code'] ?? null,
            city: $data['city'] ?? null,
            fiasGuid: isset($data['fias_guid']) ? (string) $data['fias_guid'] : null,
            postalCode: $data['postal_code'] ?? null,
            longitude: $data['longitude'] ?? null,
            latitude: $data['latitude'] ?? null,
            address: $data['address'] ?? null,
            addressFull: $data['address_full'] ?? null,
            cityUuid: isset($data['city_uuid']) ? (string) $data['city_uuid'] : null,
        );
    }
}
