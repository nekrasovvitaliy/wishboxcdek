<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: OfficeWorkTimeExcDto
 */
final readonly class OfficeWorkTimeExcDto
{
    public mixed $date;

    public mixed $time;

    public mixed $isWorking;

    public function __construct(
        mixed $date = null,
        mixed $time = null,
        mixed $isWorking = null,
    ) {
        $this->date = $date;
        $this->time = $time;
        $this->isWorking = $isWorking;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            date: $data['date'] ?? null,
            time: $data['time'] ?? null,
            isWorking: $data['is_working'] ?? null,
        );
    }
}
