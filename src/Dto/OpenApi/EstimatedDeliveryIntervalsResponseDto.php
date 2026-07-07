<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: EstimatedDeliveryIntervalsResponseDto
 *
 * Ответ на получение интервалов доставки до создания заказа
 */
final readonly class EstimatedDeliveryIntervalsResponseDto
{
    /**
     * @var array<int|string, mixed> of EstimatedDeliveryIntervalsInfoDto
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
