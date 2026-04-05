<?php

declare(strict_types=1);

namespace WishboxCdek\Response\DeliveryPoint;

final readonly class DeliveryPointDimensionDto
{
    public function __construct(
        public ?int $width = null,
        public ?int $height = null,
        public ?int $depth = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            width: isset($data['width']) ? (int) $data['width'] : null,
            height: isset($data['height']) ? (int) $data['height'] : null,
            depth: isset($data['depth']) ? (int) $data['depth'] : null,
        );
    }
}
