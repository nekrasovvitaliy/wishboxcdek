<?php

declare(strict_types=1);

namespace WishboxCdek\Request\International;

use WishboxCdek\Request\RequestData;

final readonly class RestrictionPackageRequestDto extends RequestData
{
    /**
     * @param list<RestrictionPackageItemRequestDto> $items
     */
    public function __construct(
        public ?int $weight = null,
        public ?int $length = null,
        public ?int $width = null,
        public ?int $height = null,
        public array $items = [],
        public ?string $packageId = null,
    ) {
    }

    public function toArray(): array
    {
        return $this->normalizeArray([
            'weight' => $this->weight,
            'length' => $this->length,
            'width' => $this->width,
            'height' => $this->height,
            'items' => $this->items,
            'package_id' => $this->packageId,
        ]);
    }
}
