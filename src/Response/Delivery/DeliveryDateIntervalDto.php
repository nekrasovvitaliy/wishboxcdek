<?php

declare(strict_types=1);

namespace WishboxCdek\Response\Delivery;

final readonly class DeliveryDateIntervalDto
{
    /**
     * @param list<DeliveryTimeIntervalDto> $timeIntervals
     */
    public function __construct(
        public ?string $date,
        public array $timeIntervals = [],
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            date: isset($data['date']) ? (string) $data['date'] : null,
            timeIntervals: array_map(
                static fn (array $item): DeliveryTimeIntervalDto => DeliveryTimeIntervalDto::fromArray($item),
                array_values(array_filter(
                    $data['time_intervals'] ?? [],
                    static fn (mixed $item): bool => is_array($item),
                )),
            ),
        );
    }
}