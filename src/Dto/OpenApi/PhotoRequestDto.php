<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: PhotoRequestDto
 *
 * Запрос на получение списка заказов с готовыми фото
 */
final readonly class PhotoRequestDto
{
    public ?string $periodBegin;

    public ?string $periodEnd;

    /**
     * @var array<int|string, mixed> of PhotoOrderDto
     */
    public array $orders;

    public function __construct(
        ?string $periodBegin = null,
        ?string $periodEnd = null,
        array $orders = [],
    ) {
        $this->periodBegin = $periodBegin;
        $this->periodEnd = $periodEnd;
        $this->orders = $orders;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            periodBegin: isset($data['period_begin']) ? (string) $data['period_begin'] : null,
            periodEnd: isset($data['period_end']) ? (string) $data['period_end'] : null,
            orders: isset($data['orders']) && is_array($data['orders']) ? $data['orders'] : [],
        );
    }
}
