<?php

declare(strict_types=1);

namespace WishboxCdek\Response\Order;

final readonly class DelayReasonDto
{
    public function __construct(
        public ?string $createDate = null,
        public ?string $description = null,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            createDate: isset($data['create_date']) ? (string) $data['create_date'] : null,
            description: isset($data['description']) ? (string) $data['description'] : null,
        );
    }
}
