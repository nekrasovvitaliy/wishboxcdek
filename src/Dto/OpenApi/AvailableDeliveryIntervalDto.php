<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: AvailableDeliveryIntervalDto
 *
 * Доступные интервалы доставки
 */
final readonly class AvailableDeliveryIntervalDto
{
    public mixed $startTime;

    public mixed $endTime;

    public function __construct(
        mixed $startTime = null,
        mixed $endTime = null,
    ) {
        $this->startTime = $startTime;
        $this->endTime = $endTime;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            startTime: $data['start_time'] ?? null,
            endTime: $data['end_time'] ?? null,
        );
    }
}
