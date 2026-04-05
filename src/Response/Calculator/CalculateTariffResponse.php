<?php

declare(strict_types=1);

namespace WishboxCdek\Response\Calculator;

use WishboxCdek\Response\Error\CdekMessage;

final readonly class CalculateTariffResponse
{
    /**
     * @param list<ServiceCalculationDto> $services
     * @param list<CdekMessage> $errors
     * @param list<CdekMessage> $warnings
     */
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
        public ?float $weightCalc = null,
        public array $services = [],
        public ?float $totalSum = null,
        public ?string $currency = null,
        public ?DeliveryDateRangeDto $deliveryDateRange = null,
        public array $errors = [],
        public array $warnings = [],
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
            weightCalc: isset($data['weight_calc']) ? (float) $data['weight_calc'] : null,
            services: array_map(
                static fn (array $item): ServiceCalculationDto => ServiceCalculationDto::fromArray($item),
                array_values(array_filter(
                    $data['services'] ?? [],
                    static fn (mixed $item): bool => is_array($item),
                )),
            ),
            totalSum: isset($data['total_sum']) ? (float) $data['total_sum'] : null,
            currency: isset($data['currency']) ? (string) $data['currency'] : null,
            deliveryDateRange: isset($data['delivery_date_range']) && is_array($data['delivery_date_range'])
                ? DeliveryDateRangeDto::fromArray($data['delivery_date_range'])
                : null,
            errors: array_map(
                static fn (array $item): CdekMessage => CdekMessage::fromArray($item),
                array_values(array_filter(
                    $data['errors'] ?? [],
                    static fn (mixed $item): bool => is_array($item),
                )),
            ),
            warnings: array_map(
                static fn (array $item): CdekMessage => CdekMessage::fromArray($item),
                array_values(array_filter(
                    $data['warnings'] ?? [],
                    static fn (mixed $item): bool => is_array($item),
                )),
            ),
        );
    }
}
