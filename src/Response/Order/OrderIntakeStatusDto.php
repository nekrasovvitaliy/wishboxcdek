<?php

declare(strict_types=1);

namespace WishboxCdek\Response\Order;

final readonly class OrderIntakeStatusDto
{
    public function __construct(
        public ?string $code = null,
        public ?string $name = null,
        public ?string $dateTime = null,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            code: isset($data['code']) ? (string) $data['code'] : null,
            name: isset($data['name']) ? (string) $data['name'] : null,
            dateTime: isset($data['date_time']) ? (string) $data['date_time'] : null,
        );
    }
}

