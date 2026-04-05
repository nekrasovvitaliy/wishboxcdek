<?php

declare(strict_types=1);

namespace WishboxCdek\Response\Location;

final readonly class RegionDto
{
    public function __construct(
        public string $countryCode,
        public string $country,
        public string $region,
        public int $regionCode,
        public ?string $fiasRegionGuid = null,
        public ?string $kladrRegionCode = null,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            countryCode: (string) ($data['country_code'] ?? ''),
            country: (string) ($data['country'] ?? ''),
            region: (string) ($data['region'] ?? ''),
            regionCode: (int) ($data['region_code'] ?? 0),
            fiasRegionGuid: isset($data['fias_region_guid']) ? (string) $data['fias_region_guid'] : null,
            kladrRegionCode: isset($data['kladr_region_code']) ? (string) $data['kladr_region_code'] : null,
        );
    }
}

