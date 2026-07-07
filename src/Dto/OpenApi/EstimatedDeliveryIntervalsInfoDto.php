<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: EstimatedDeliveryIntervalsInfoDto
 *
 * Доступные интервалы доставки до создания заказа
 */
final readonly class EstimatedDeliveryIntervalsInfoDto
{
    public ?string $date;

    /**
     * @var array<int|string, mixed> of EstimatedDeliveryIntervalDto
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
