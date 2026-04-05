<?php

declare(strict_types=1);

namespace WishboxCdek\Response\International;

final readonly class RestrictionPackageDto
{
    /**
     * @param list<RestrictionItemDto> $items
     */
    public function __construct(
        public ?string $packageId = null,
        public ?RestrictionStatusDto $status = null,
        public array $items = [],
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            packageId: isset($data['package_id']) ? (string) $data['package_id'] : null,
            status: isset($data['status']) && is_array($data['status'])
                ? RestrictionStatusDto::fromArray($data['status'])
                : null,
            items: array_map(
                static fn (array $item): RestrictionItemDto => RestrictionItemDto::fromArray($item),
                array_values(array_filter(
                    $data['items'] ?? [],
                    static fn (mixed $item): bool => is_array($item),
                )),
            ),
        );
    }
}
