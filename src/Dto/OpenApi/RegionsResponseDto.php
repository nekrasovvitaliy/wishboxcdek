<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: RegionsResponseDto
 *
 * Транспорт ответа на запрос на поиск регионов
 */
final readonly class RegionsResponseDto
{
    public ?string $countryCode;

    public ?string $country;

    public ?string $region;

    public ?int $regionCode;

    public ?string $fiasRegionGuid;

    public ?string $kladrRegionCode;

    public function __construct(
        ?string $countryCode = null,
        ?string $country = null,
        ?string $region = null,
        ?int $regionCode = null,
        ?string $fiasRegionGuid = null,
        ?string $kladrRegionCode = null,
    ) {
        $this->countryCode = $countryCode;
        $this->country = $country;
        $this->region = $region;
        $this->regionCode = $regionCode;
        $this->fiasRegionGuid = $fiasRegionGuid;
        $this->kladrRegionCode = $kladrRegionCode;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            countryCode: isset($data['country_code']) ? (string) $data['country_code'] : null,
            country: isset($data['country']) ? (string) $data['country'] : null,
            region: isset($data['region']) ? (string) $data['region'] : null,
            regionCode: isset($data['region_code']) ? (int) $data['region_code'] : null,
            fiasRegionGuid: isset($data['fias_region_guid']) ? (string) $data['fias_region_guid'] : null,
            kladrRegionCode: isset($data['kladr_region_code']) ? (string) $data['kladr_region_code'] : null,
        );
    }
}
