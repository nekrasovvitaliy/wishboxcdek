<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: IntakePackageDto
 *
 * Информация об упаковке
 */
final readonly class IntakePackageDto
{
    public ?string $packageId;

    public mixed $weight;

    public mixed $length;

    public mixed $width;

    public mixed $height;

    public function __construct(
        ?string $packageId = null,
        mixed $weight = null,
        mixed $length = null,
        mixed $width = null,
        mixed $height = null,
    ) {
        $this->packageId = $packageId;
        $this->weight = $weight;
        $this->length = $length;
        $this->width = $width;
        $this->height = $height;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            packageId: isset($data['package_id']) ? (string) $data['package_id'] : null,
            weight: $data['weight'] ?? null,
            length: $data['length'] ?? null,
            width: $data['width'] ?? null,
            height: $data['height'] ?? null,
        );
    }
}
