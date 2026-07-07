<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: PhotoOrderDto
 *
 * Заказ, по которому нужно получить фото
 */
final readonly class PhotoOrderDto
{
    public ?string $orderUuid;

    public mixed $cdekNumber;

    public function __construct(
        ?string $orderUuid = null,
        mixed $cdekNumber = null,
    ) {
        $this->orderUuid = $orderUuid;
        $this->cdekNumber = $cdekNumber;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            orderUuid: isset($data['order_uuid']) ? (string) $data['order_uuid'] : null,
            cdekNumber: $data['cdek_number'] ?? null,
        );
    }
}
