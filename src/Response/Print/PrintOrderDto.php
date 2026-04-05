<?php

declare(strict_types=1);

namespace WishboxCdek\Response\Print;

final readonly class PrintOrderDto
{
    public function __construct(
        public ?string $orderUuid = null,
        public ?string $cdekNumber = null,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            orderUuid: isset($data['order_uuid']) ? (string) $data['order_uuid'] : null,
            cdekNumber: isset($data['cdek_number']) ? (string) $data['cdek_number'] : null,
        );
    }
}