<?php

declare(strict_types=1);

namespace WishboxCdek\Response\Delivery;

final readonly class DeliveryTimeIntervalDto
{
    public function __construct(
        public ?string $startTime,
        public ?string $endTime,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            startTime: isset($data['start_time']) ? (string) $data['start_time'] : null,
            endTime: isset($data['end_time']) ? (string) $data['end_time'] : null,
        );
    }
}