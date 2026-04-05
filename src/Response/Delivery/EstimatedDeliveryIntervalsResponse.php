<?php

declare(strict_types=1);

namespace WishboxCdek\Response\Delivery;

final readonly class EstimatedDeliveryIntervalsResponse
{
    /**
     * @param list<EstimatedDeliveryDateIntervalDto> $dateIntervals
     */
    public function __construct(
        public array $dateIntervals = [],
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            dateIntervals: array_map(
                static fn (array $item): EstimatedDeliveryDateIntervalDto => EstimatedDeliveryDateIntervalDto::fromArray($item),
                array_values(array_filter(
                    $data['date_intervals'] ?? [],
                    static fn (mixed $item): bool => is_array($item),
                )),
            ),
        );
    }
}