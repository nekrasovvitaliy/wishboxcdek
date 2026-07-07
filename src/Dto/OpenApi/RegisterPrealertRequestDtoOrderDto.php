<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: RegisterPrealertRequestDtoOrderDto
 *
 * Заказ, которые планируется передать в СДЭК
 */
final readonly class RegisterPrealertRequestDtoOrderDto
{
    public ?string $orderUuid;

    public mixed $cdekNumber;

    public mixed $imNumber;

    public function __construct(
        ?string $orderUuid = null,
        mixed $cdekNumber = null,
        mixed $imNumber = null,
    ) {
        $this->orderUuid = $orderUuid;
        $this->cdekNumber = $cdekNumber;
        $this->imNumber = $imNumber;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            orderUuid: isset($data['order_uuid']) ? (string) $data['order_uuid'] : null,
            cdekNumber: $data['cdek_number'] ?? null,
            imNumber: $data['im_number'] ?? null,
        );
    }
}
