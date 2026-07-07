<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: IntakeLocationDto
 *
 * Населённый пункт. Необходимо заполнять, если не передан номер заказа. Иначе значение берется из заказа
 */
final readonly class IntakeLocationDto
{
    public mixed $code;

    public ?string $cityUuid;

    public mixed $city;

    public ?string $fiasGuid;

    public mixed $kladrCode;

    public mixed $countryCode;

    public mixed $country;

    public mixed $region;

    public mixed $regionCode;

    public ?string $fiasRegionGuid;

    public mixed $kladrRegionCode;

    public mixed $subRegion;

    public mixed $longitude;

    public mixed $latitude;

    public mixed $address;

    public mixed $postalCode;

    public function __construct(
        mixed $code = null,
        ?string $cityUuid = null,
        mixed $city = null,
        ?string $fiasGuid = null,
        mixed $kladrCode = null,
        mixed $countryCode = null,
        mixed $country = null,
        mixed $region = null,
        mixed $regionCode = null,
        ?string $fiasRegionGuid = null,
        mixed $kladrRegionCode = null,
        mixed $subRegion = null,
        mixed $longitude = null,
        mixed $latitude = null,
        mixed $address = null,
        mixed $postalCode = null,
    ) {
        $this->code = $code;
        $this->cityUuid = $cityUuid;
        $this->city = $city;
        $this->fiasGuid = $fiasGuid;
        $this->kladrCode = $kladrCode;
        $this->countryCode = $countryCode;
        $this->country = $country;
        $this->region = $region;
        $this->regionCode = $regionCode;
        $this->fiasRegionGuid = $fiasRegionGuid;
        $this->kladrRegionCode = $kladrRegionCode;
        $this->subRegion = $subRegion;
        $this->longitude = $longitude;
        $this->latitude = $latitude;
        $this->address = $address;
        $this->postalCode = $postalCode;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            code: $data['code'] ?? null,
            cityUuid: isset($data['city_uuid']) ? (string) $data['city_uuid'] : null,
            city: $data['city'] ?? null,
            fiasGuid: isset($data['fias_guid']) ? (string) $data['fias_guid'] : null,
            kladrCode: $data['kladr_code'] ?? null,
            countryCode: $data['country_code'] ?? null,
            country: $data['country'] ?? null,
            region: $data['region'] ?? null,
            regionCode: $data['region_code'] ?? null,
            fiasRegionGuid: isset($data['fias_region_guid']) ? (string) $data['fias_region_guid'] : null,
            kladrRegionCode: $data['kladr_region_code'] ?? null,
            subRegion: $data['sub_region'] ?? null,
            longitude: $data['longitude'] ?? null,
            latitude: $data['latitude'] ?? null,
            address: $data['address'] ?? null,
            postalCode: $data['postal_code'] ?? null,
        );
    }
}
