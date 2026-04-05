<?php

declare(strict_types=1);

namespace WishboxCdek\Response\Calculator;

final readonly class TariffCodeDto
{
    public function __construct(
        public ?int $tariffCode = null,
        public ?string $tariffName = null,
        public ?string $tariffDescription = null,
        public ?int $deliveryMode = null,
        public ?float $deliverySum = null,
        public ?int $periodMin = null,
        public ?int $periodMax = null,
        public ?int $calendarMin = null,
        public ?int $calendarMax = null,
        public ?DeliveryDateRangeDto $deliveryDateRange = null,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            tariffCode: isset($data['tariff_code']) ? (int) $data['tariff_code'] : null,
            tariffName: isset($data['tariff_name']) ? (string) $data['tariff_name'] : null,
            tariffDescription: isset($data['tariff_description']) ? (string) $data['tariff_description'] : null,
            deliveryMode: isset($data['delivery_mode']) ? (int) $data['delivery_mode'] : null,
            deliverySum: isset($data['delivery_sum']) ? (float) $data['delivery_sum'] : null,
            periodMin: isset($data['period_min']) ? (int) $data['period_min'] : null,
            periodMax: isset($data['period_max']) ? (int) $data['period_max'] : null,
            calendarMin: isset($data['calendar_min']) ? (int) $data['calendar_min'] : null,
            calendarMax: isset($data['calendar_max']) ? (int) $data['calendar_max'] : null,
            deliveryDateRange: isset($data['delivery_date_range']) && is_array($data['delivery_date_range'])
                ? DeliveryDateRangeDto::fromArray($data['delivery_date_range'])
                : null,
        );
    }
}
