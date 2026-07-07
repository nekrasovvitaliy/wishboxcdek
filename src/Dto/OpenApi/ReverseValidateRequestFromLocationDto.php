<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: ReverseValidateRequestFromLocationDto
 *
 * Адрес отправления. Не может использоваться одновременно с shipment_point. Обязателен, если тариф с режимом "от двери".
 */
final readonly class ReverseValidateRequestFromLocationDto
{
    public mixed $code;

    public ?string $fiasGuid;

    public mixed $postalCode;

    public mixed $longitude;

    public mixed $latitude;

    public mixed $countryCode;

    public mixed $region;

    public mixed $regionCode;

    public mixed $subRegion;

    public mixed $city;

    public mixed $address;

    public function __construct(
        mixed $code = null,
        ?string $fiasGuid = null,
        mixed $postalCode = null,
        mixed $longitude = null,
        mixed $latitude = null,
        mixed $countryCode = null,
        mixed $region = null,
        mixed $regionCode = null,
        mixed $subRegion = null,
        mixed $city = null,
        mixed $address = null,
    ) {
        $this->code = $code;
        $this->fiasGuid = $fiasGuid;
        $this->postalCode = $postalCode;
        $this->longitude = $longitude;
        $this->latitude = $latitude;
        $this->countryCode = $countryCode;
        $this->region = $region;
        $this->regionCode = $regionCode;
        $this->subRegion = $subRegion;
        $this->city = $city;
        $this->address = $address;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            code: $data['code'] ?? null,
            fiasGuid: isset($data['fias_guid']) ? (string) $data['fias_guid'] : null,
            postalCode: $data['postal_code'] ?? null,
            longitude: $data['longitude'] ?? null,
            latitude: $data['latitude'] ?? null,
            countryCode: $data['country_code'] ?? null,
            region: $data['region'] ?? null,
            regionCode: $data['region_code'] ?? null,
            subRegion: $data['sub_region'] ?? null,
            city: $data['city'] ?? null,
            address: $data['address'] ?? null,
        );
    }
}
