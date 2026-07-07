<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: OfficeWorkTimeDto
 *
 * График работы офиса
 */
final readonly class OfficeWorkTimeDto
{
    public mixed $day;

    public mixed $time;

    public function __construct(
        mixed $day = null,
        mixed $time = null,
    ) {
        $this->day = $day;
        $this->time = $time;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            day: $data['day'] ?? null,
            time: $data['time'] ?? null,
        );
    }
}
