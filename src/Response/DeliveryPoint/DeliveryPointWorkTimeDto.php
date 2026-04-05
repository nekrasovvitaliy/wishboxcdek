<?php

declare(strict_types=1);

namespace WishboxCdek\Response\DeliveryPoint;

final readonly class DeliveryPointWorkTimeDto
{
    public function __construct(
        public ?int $day = null,
        public ?string $time = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            day: isset($data['day']) ? (int) $data['day'] : null,
            time: isset($data['time']) ? (string) $data['time'] : null,
        );
    }
}
