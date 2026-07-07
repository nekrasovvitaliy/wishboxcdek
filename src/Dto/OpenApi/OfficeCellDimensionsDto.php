<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: OfficeCellDimensionsDto
 *
 * Размеры ячеек
 */
final readonly class OfficeCellDimensionsDto
{
    public mixed $width;

    public mixed $height;

    public mixed $depth;

    public function __construct(
        mixed $width = null,
        mixed $height = null,
        mixed $depth = null,
    ) {
        $this->width = $width;
        $this->height = $height;
        $this->depth = $depth;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            width: $data['width'] ?? null,
            height: $data['height'] ?? null,
            depth: $data['depth'] ?? null,
        );
    }
}
