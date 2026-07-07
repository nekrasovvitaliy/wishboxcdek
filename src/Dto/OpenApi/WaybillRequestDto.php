<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: WaybillRequestDto
 *
 * Запрос на формирование квитанции к заказу
 */
final readonly class WaybillRequestDto
{
    /**
     * @var array<int|string, mixed> of PrintOrderDto
     */
    public array $orders;

    public mixed $copyCount;

    public mixed $type;

    public function __construct(
        array $orders = [],
        mixed $copyCount = null,
        mixed $type = null,
    ) {
        $this->orders = $orders;
        $this->copyCount = $copyCount;
        $this->type = $type;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            orders: isset($data['orders']) && is_array($data['orders']) ? $data['orders'] : [],
            copyCount: $data['copy_count'] ?? null,
            type: $data['type'] ?? null,
        );
    }
}
