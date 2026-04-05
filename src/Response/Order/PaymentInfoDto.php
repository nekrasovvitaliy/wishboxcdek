<?php

declare(strict_types=1);

namespace WishboxCdek\Response\Order;

final readonly class PaymentInfoDto
{
    public function __construct(
        public ?string $type = null,
        public int|float|null $sum = null,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            type: isset($data['type']) ? (string) $data['type'] : null,
            sum: isset($data['sum']) ? (is_int($data['sum']) ? $data['sum'] : (float) $data['sum']) : null,
        );
    }
}
