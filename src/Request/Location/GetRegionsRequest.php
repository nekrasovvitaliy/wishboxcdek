<?php

declare(strict_types=1);

namespace WishboxCdek\Request\Location;

use WishboxCdek\Enum\Language;
use WishboxCdek\Request\RequestData;

final readonly class GetRegionsRequest extends RequestData
{
    public function __construct(
        public string|array|null $countryCodes = null,
        public ?int $page = null,
        public ?int $size = null,
        public ?Language $lang = null
    ) {
    }

    public function toArray(): array
    {
        return $this->filterNulls([
            'country_codes' => $this->normalizeCountryCodes($this->countryCodes),
            'page' => $this->page,
            'size' => $this->size,
            'lang' => $this->lang?->value,
        ]);
    }
}
