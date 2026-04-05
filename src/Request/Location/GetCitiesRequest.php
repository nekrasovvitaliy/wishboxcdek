<?php

declare(strict_types=1);

namespace WishboxCdek\Request\Location;

use WishboxCdek\Request\RequestData;

final readonly class GetCitiesRequest extends RequestData
{
    public function __construct(
        public ?string $countryCodes = null,
        public ?int $regionCode = null,
        public ?string $postalCode = null,
        public ?string $city = null,
        public ?int $page = null,
        public ?int $size = null
    ) {
    }

    public function toArray(): array
    {
        return $this->filterNulls([
            'country_codes' => $this->countryCodes,
            'region_code' => $this->regionCode,
            'postal_code' => $this->postalCode,
            'city' => $this->city,
            'page' => $this->page,
            'size' => $this->size,
        ]);
    }
}
