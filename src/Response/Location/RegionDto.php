<?php

declare(strict_types=1);

namespace WishboxCdek\Response\Location;

use WishboxCdek\Exception\CdekException;

final readonly class RegionDto
{
    public function __construct(
        public string $countryCode,
        public string $country,
        public string $region,
        public ?int $regionCode = null,
        public ?string $fiasRegionGuid = null,
        public ?string $kladrRegionCode = null,
    ) {
    }

    public static function fromArray(array $data): self
    {
        $countryCode = self::requireNonEmptyString($data, 'country_code');
        $country = self::requireNonEmptyString($data, 'country');
        $region = self::requireNonEmptyString($data, 'region');

        return new self(
            countryCode: $countryCode,
            country: $country,
            region: $region,
            regionCode: isset($data['region_code']) ? (int) $data['region_code'] : null,
            fiasRegionGuid: isset($data['fias_region_guid']) ? (string) $data['fias_region_guid'] : null,
            kladrRegionCode: isset($data['kladr_region_code']) ? (string) $data['kladr_region_code'] : null,
        );
    }

    private static function requireNonEmptyString(array $data, string $key): string
    {
        if (!isset($data[$key])) {
            throw new CdekException(sprintf('CDEK region response does not contain %s.', $key));
        }

        $value = trim((string) $data[$key]);

        if ($value === '') {
            throw new CdekException(sprintf('CDEK region response contains an empty %s.', $key));
        }

        return $value;
    }
}
