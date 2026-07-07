<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: AvailableDeliveryIntervalsInfoDto
 *
 * Доступные интервалы доставки
 */
final readonly class AvailableDeliveryIntervalsInfoDto
{
    public ?string $date;

    /**
     * @var array<int|string, mixed> of AvailableDeliveryIntervalDto
     */
    public array $timeIntervals;

    public function __construct(
        ?string $date = null,
        array $timeIntervals = [],
    ) {
        $this->date = $date;
        $this->timeIntervals = $timeIntervals;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            date: isset($data['date']) ? (string) $data['date'] : null,
            timeIntervals: isset($data['time_intervals']) && is_array($data['time_intervals']) ? $data['time_intervals'] : [],
        );
    }
}
