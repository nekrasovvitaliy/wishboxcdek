<?php

declare(strict_types=1);

namespace WishboxCdek\Response\Delivery;

final readonly class EstimatedDeliveryDateIntervalDto
{
    /**
     * @param list<EstimatedDeliveryTimeIntervalDto> $timeIntervals
     */
    public function __construct(
        public ?string $date = null,
        public array $timeIntervals = [],
    ) {
    }

    public static function fromArray(array $data): self
    {
        $timeIntervals = [];
        foreach (($data['time_intervals'] ?? []) as $interval) {
            if (is_array($interval)) {
                $timeIntervals[] = EstimatedDeliveryTimeIntervalDto::fromArray($interval);
            }
        }

        return new self(
            date: isset($data['date']) ? (string) $data['date'] : null,
            timeIntervals: $timeIntervals,
        );
    }
}