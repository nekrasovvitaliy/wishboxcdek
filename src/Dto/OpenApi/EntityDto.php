<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: EntityDto
 */
final readonly class EntityDto
{
    public ?string $uuid;

    public function __construct(
        ?string $uuid = null,
    ) {
        $this->uuid = $uuid;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            uuid: isset($data['uuid']) ? (string) $data['uuid'] : null,
        );
    }
}
