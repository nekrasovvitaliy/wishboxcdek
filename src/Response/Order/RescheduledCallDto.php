<?php

declare(strict_types=1);

namespace WishboxCdek\Response\Order;

final readonly class RescheduledCallDto
{
    public function __construct(
        public ?string $dateTime = null,
        public ?string $dateNext = null,
        public ?string $timeNext = null,
        public ?string $comment = null,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            dateTime: isset($data['date_time']) ? (string) $data['date_time'] : null,
            dateNext: isset($data['date_next']) ? (string) $data['date_next'] : null,
            timeNext: isset($data['time_next']) ? (string) $data['time_next'] : null,
            comment: isset($data['comment']) ? (string) $data['comment'] : null,
        );
    }
}
