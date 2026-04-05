<?php

declare(strict_types=1);

namespace WishboxCdek\Request\Calculator;

use WishboxCdek\Request\RequestData;

final readonly class PackageDto extends RequestData
{
    public function __construct(
        public int $weight,
        public ?int $length = null,
        public ?int $width = null,
        public ?int $height = null,
    ) {
    }

    public function toArray(): array
    {
        return $this->filterNulls([
            'weight' => $this->weight,
            'length' => $this->length,
            'width' => $this->width,
            'height' => $this->height,
        ]);
    }
}
