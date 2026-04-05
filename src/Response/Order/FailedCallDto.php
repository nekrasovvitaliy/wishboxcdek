<?php

declare(strict_types=1);

namespace WishboxCdek\Response\Order;

final readonly class FailedCallDto
{
    public function __construct(
        public ?string $dateTime = null,
        public ?int $reasonCode = null,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            dateTime: isset($data['date_time']) ? (string) $data['date_time'] : null,
            reasonCode: isset($data['reason_code']) ? (int) $data['reason_code'] : null,
        );
    }
}
