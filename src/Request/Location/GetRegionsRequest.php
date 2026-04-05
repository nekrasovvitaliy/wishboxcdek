<?php

declare(strict_types=1);

namespace WishboxCdek\Request\Location;

use WishboxCdek\Request\RequestData;

final readonly class GetRegionsRequest extends RequestData
{
    public function __construct(
        public ?string $countryCodes = null,
        public ?int $page = null,
        public ?int $size = null
    ) {
    }

    public function toArray(): array
    {
        return $this->filterNulls([
            'country_codes' => $this->countryCodes,
            'page' => $this->page,
            'size' => $this->size,
        ]);
    }
}
