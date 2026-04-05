<?php

declare(strict_types=1);

namespace WishboxCdek\Response\Delivery;

final readonly class EstimatedDeliveryTimeIntervalDto
{
    public function __construct(
        public ?string $startTime = null,
        public ?string $endTime = null,
        public ?int $agreedCount = null,
        public ?int $totalCount = null,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            startTime: isset($data['start_time']) ? (string) $data['start_time'] : null,
            endTime: isset($data['end_time']) ? (string) $data['end_time'] : null,
            agreedCount: isset($data['agreed_count']) ? (int) $data['agreed_count'] : null,
            totalCount: isset($data['total_count']) ? (int) $data['total_count'] : null,
        );
    }
}