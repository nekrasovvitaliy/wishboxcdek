<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: OfficeWorkTimeExceptionDto
 *
 * Исключения в графике работы офиса
 */
final readonly class OfficeWorkTimeExceptionDto
{
    public ?string $dateStart;

    public ?string $dateEnd;

    public mixed $timeStart;

    public mixed $timeEnd;

    public mixed $isWorking;

    public function __construct(
        ?string $dateStart = null,
        ?string $dateEnd = null,
        mixed $timeStart = null,
        mixed $timeEnd = null,
        mixed $isWorking = null,
    ) {
        $this->dateStart = $dateStart;
        $this->dateEnd = $dateEnd;
        $this->timeStart = $timeStart;
        $this->timeEnd = $timeEnd;
        $this->isWorking = $isWorking;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            dateStart: isset($data['date_start']) ? (string) $data['date_start'] : null,
            dateEnd: isset($data['date_end']) ? (string) $data['date_end'] : null,
            timeStart: $data['time_start'] ?? null,
            timeEnd: $data['time_end'] ?? null,
            isWorking: $data['is_working'] ?? null,
        );
    }
}
