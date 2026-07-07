<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: BarcodeDto
 *
 * Информация о ШК месте к заказу
 */
final readonly class BarcodeDto
{
    public ?string $uuid;

    /**
     * @var array<int|string, mixed> of PrintOrderDto
     */
    public array $orders;

    public mixed $copyCount;

    public mixed $format;

    public mixed $url;

    public mixed $lang;

    /**
     * @var array<int|string, mixed> of PrintStatusDto
     */
    public array $statuses;

    public function __construct(
        ?string $uuid = null,
        array $orders = [],
        mixed $copyCount = null,
        mixed $format = null,
        mixed $url = null,
        mixed $lang = null,
        array $statuses = [],
    ) {
        $this->uuid = $uuid;
        $this->orders = $orders;
        $this->copyCount = $copyCount;
        $this->format = $format;
        $this->url = $url;
        $this->lang = $lang;
        $this->statuses = $statuses;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            uuid: isset($data['uuid']) ? (string) $data['uuid'] : null,
            orders: isset($data['orders']) && is_array($data['orders']) ? $data['orders'] : [],
            copyCount: $data['copy_count'] ?? null,
            format: $data['format'] ?? null,
            url: $data['url'] ?? null,
            lang: $data['lang'] ?? null,
            statuses: isset($data['statuses']) && is_array($data['statuses']) ? $data['statuses'] : [],
        );
    }
}
