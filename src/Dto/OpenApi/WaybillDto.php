<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: WaybillDto
 *
 * Информация о квитанции к заказу
 */
final readonly class WaybillDto
{
    public ?string $uuid;

    /**
     * @var array<int|string, mixed> of PrintOrderDto
     */
    public array $orders;

    public mixed $copyCount;

    public mixed $type;

    public mixed $url;

    /**
     * @var array<int|string, mixed> of PrintStatusDto
     */
    public array $statuses;

    public function __construct(
        ?string $uuid = null,
        array $orders = [],
        mixed $copyCount = null,
        mixed $type = null,
        mixed $url = null,
        array $statuses = [],
    ) {
        $this->uuid = $uuid;
        $this->orders = $orders;
        $this->copyCount = $copyCount;
        $this->type = $type;
        $this->url = $url;
        $this->statuses = $statuses;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            uuid: isset($data['uuid']) ? (string) $data['uuid'] : null,
            orders: isset($data['orders']) && is_array($data['orders']) ? $data['orders'] : [],
            copyCount: $data['copy_count'] ?? null,
            type: $data['type'] ?? null,
            url: $data['url'] ?? null,
            statuses: isset($data['statuses']) && is_array($data['statuses']) ? $data['statuses'] : [],
        );
    }
}
