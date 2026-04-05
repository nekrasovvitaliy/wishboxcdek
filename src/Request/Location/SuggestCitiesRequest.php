<?php

declare(strict_types=1);

namespace WishboxCdek\Request\Location;

use WishboxCdek\Request\RequestData;

final readonly class SuggestCitiesRequest extends RequestData
{
    public function __construct(
        public string $city,
        public ?string $countryCodes = null,
        public ?int $size = null
    ) {
    }

    public function toArray(): array
    {
        return $this->filterNulls([
            'city' => $this->city,
            'country_codes' => $this->countryCodes,
            'size' => $this->size,
        ]);
    }
}
