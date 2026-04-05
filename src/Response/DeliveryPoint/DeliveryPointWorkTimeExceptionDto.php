<?php

declare(strict_types=1);

namespace WishboxCdek\Response\DeliveryPoint;

final readonly class DeliveryPointWorkTimeExceptionDto
{
    public function __construct(
        public ?string $dateStart = null,
        public ?string $dateEnd = null,
        public ?string $timeStart = null,
        public ?string $timeEnd = null,
        public ?bool $isWorking = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            dateStart: isset($data['date_start']) ? (string) $data['date_start'] : null,
            dateEnd: isset($data['date_end']) ? (string) $data['date_end'] : null,
            timeStart: isset($data['time_start']) ? (string) $data['time_start'] : null,
            timeEnd: isset($data['time_end']) ? (string) $data['time_end'] : null,
            isWorking: isset($data['is_working']) ? (bool) $data['is_working'] : null,
        );
    }
}
