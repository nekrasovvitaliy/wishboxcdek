<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: AvailableDeliveryIntervalsResponseDto
 *
 * Доступные интервалы доставки
 */
final readonly class AvailableDeliveryIntervalsResponseDto
{
    /**
     * @var array<int|string, mixed> of AvailableDeliveryIntervalsInfoDto
     */
    public array $dateIntervals;

    public function __construct(
        array $dateIntervals = [],
    ) {
        $this->dateIntervals = $dateIntervals;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            dateIntervals: isset($data['date_intervals']) && is_array($data['date_intervals']) ? $data['date_intervals'] : [],
        );
    }
}
