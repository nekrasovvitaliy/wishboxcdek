<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: BarcodeRequestDto
 *
 * Запрос на формирование ШК места к заказу
 */
final readonly class BarcodeRequestDto
{
    /**
     * @var array<int|string, mixed> of PrintOrderDto
     */
    public array $orders;

    public mixed $copyCount;

    public mixed $format;

    public mixed $lang;

    public function __construct(
        array $orders = [],
        mixed $copyCount = null,
        mixed $format = null,
        mixed $lang = null,
    ) {
        $this->orders = $orders;
        $this->copyCount = $copyCount;
        $this->format = $format;
        $this->lang = $lang;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            orders: isset($data['orders']) && is_array($data['orders']) ? $data['orders'] : [],
            copyCount: $data['copy_count'] ?? null,
            format: $data['format'] ?? null,
            lang: $data['lang'] ?? null,
        );
    }
}
