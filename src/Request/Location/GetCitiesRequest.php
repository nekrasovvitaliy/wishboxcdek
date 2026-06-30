<?php

declare(strict_types=1);

namespace WishboxCdek\Request\Location;

use WishboxCdek\Enum\Language;
use WishboxCdek\Request\RequestData;

final readonly class GetCitiesRequest extends RequestData
{
    public function __construct(
        public ?string $countryCodes = null,
        public ?int $regionCode = null,
        public ?string $kladrRegionCode = null,
        public ?string $fiasRegionGuid = null,
        public ?string $kladrCode = null,
        public ?string $fiasGuid = null,
        public ?string $postalCode = null,
        public ?string $city = null,
        public ?int $page = null,
        public ?int $size = null,
        public ?Language $lang = null
    ) {
    }

    public function toArray(): array
    {
        return $this->filterNulls([
            'country_codes' => $this->normalizeCountryCodes($this->countryCodes),
            'region_code' => $this->regionCode,
            'kladr_region_code' => $this->kladrRegionCode,
            'fias_region_guid' => $this->fiasRegionGuid,
            'kladr_code' => $this->kladrCode,
            'fias_guid' => $this->fiasGuid,
            'postal_code' => $this->postalCode,
            'city' => $this->city,
            'page' => $this->page,
            'size' => $this->size,
            'lang' => $this->lang?->value,
        ]);
    }
}
