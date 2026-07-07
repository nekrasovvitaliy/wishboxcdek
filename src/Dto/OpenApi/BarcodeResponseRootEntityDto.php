<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: BarcodeResponseRootEntityDto
 *
 * Информация о ШК места к заказу
 */
final readonly class BarcodeResponseRootEntityDto
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
