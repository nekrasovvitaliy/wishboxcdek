<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: PhotoReadyOrderDto
 *
 * Готовый к скачиванию заказ
 */
final readonly class PhotoReadyOrderDto
{
    public ?string $orderUuid;

    public mixed $cdekNumber;

    public mixed $link;

    public mixed $status;

    public ?string $createDate;

    public function __construct(
        ?string $orderUuid = null,
        mixed $cdekNumber = null,
        mixed $link = null,
        mixed $status = null,
        ?string $createDate = null,
    ) {
        $this->orderUuid = $orderUuid;
        $this->cdekNumber = $cdekNumber;
        $this->link = $link;
        $this->status = $status;
        $this->createDate = $createDate;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            orderUuid: isset($data['order_uuid']) ? (string) $data['order_uuid'] : null,
            cdekNumber: $data['cdek_number'] ?? null,
            link: $data['link'] ?? null,
            status: $data['status'] ?? null,
            createDate: isset($data['create_date']) ? (string) $data['create_date'] : null,
        );
    }
}
