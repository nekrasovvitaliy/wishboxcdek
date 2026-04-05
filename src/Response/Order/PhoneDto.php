<?php

declare(strict_types=1);

namespace WishboxCdek\Response\Order;

final readonly class PhoneDto
{
    public function __construct(
        public ?string $number = null,
        public ?string $additional = null,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            number: isset($data['number']) ? (string) $data['number'] : null,
            additional: isset($data['additional']) ? (string) $data['additional'] : null,
        );
    }
}
