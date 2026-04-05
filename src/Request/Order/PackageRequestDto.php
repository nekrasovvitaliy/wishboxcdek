<?php

declare(strict_types=1);

namespace WishboxCdek\Request\Order;

use WishboxCdek\Request\RequestData;

final readonly class PackageRequestDto extends RequestData
{
    /**
     * @param list<ItemRequestDto> $items
     */
    public function __construct(
        public int $weight,
        public ?string $number = null,
        public ?int $length = null,
        public ?int $width = null,
        public ?int $height = null,
        public ?string $comment = null,
        public array $items = [],
        public ?string $packageId = null,
    ) {
    }

    public function toArray(): array
    {
        return $this->normalizeArray([
            'number' => $this->number,
            'weight' => $this->weight,
            'length' => $this->length,
            'width' => $this->width,
            'height' => $this->height,
            'comment' => $this->comment,
            'items' => $this->items === [] ? null : $this->items,
            'package_id' => $this->packageId,
        ]);
    }
}

