<?php

declare(strict_types=1);

namespace WishboxCdek\Request\Location;

use WishboxCdek\Request\RequestData;

final readonly class SuggestCitiesRequest extends RequestData
{
    public function __construct(
        public string $name,
        public ?string $countryCode = null
    ) {
    }

    public function toArray(): array
    {
        return $this->filterNulls([
            'name' => $this->name,
            'country_code' => $this->countryCode,
        ]);
    }
}
