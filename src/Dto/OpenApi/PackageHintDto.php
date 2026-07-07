<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: PackageHintDto
 *
 * Описание ограничений по упаковке
 */
final readonly class PackageHintDto
{
    public mixed $packageId;

    public mixed $status;

    public mixed $description;

    /**
     * @var array<int|string, mixed> of ItemHintDto
     */
    public array $items;

    public function __construct(
        mixed $packageId = null,
        mixed $status = null,
        mixed $description = null,
        array $items = [],
    ) {
        $this->packageId = $packageId;
        $this->status = $status;
        $this->description = $description;
        $this->items = $items;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            packageId: $data['package_id'] ?? null,
            status: $data['status'] ?? null,
            description: $data['description'] ?? null,
            items: isset($data['items']) && is_array($data['items']) ? $data['items'] : [],
        );
    }
}
