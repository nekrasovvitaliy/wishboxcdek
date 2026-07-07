<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: EstimatedDeliveryIntervalDto
 *
 * Доступные интервалы доставки до создания заказа
 */
final readonly class EstimatedDeliveryIntervalDto
{
    public mixed $startTime;

    public mixed $endTime;

    public mixed $agreedCount;

    public mixed $totalCount;

    public function __construct(
        mixed $startTime = null,
        mixed $endTime = null,
        mixed $agreedCount = null,
        mixed $totalCount = null,
    ) {
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->agreedCount = $agreedCount;
        $this->totalCount = $totalCount;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            startTime: $data['start_time'] ?? null,
            endTime: $data['end_time'] ?? null,
            agreedCount: $data['agreed_count'] ?? null,
            totalCount: $data['total_count'] ?? null,
        );
    }
}
