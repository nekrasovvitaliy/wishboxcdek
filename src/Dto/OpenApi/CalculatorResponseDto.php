<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: CalculatorResponseDto
 *
 * Ответ на расчет по коду тарифа
 */
final readonly class CalculatorResponseDto
{
    public mixed $deliverySum;

    public mixed $periodMin;

    public mixed $periodMax;

    public mixed $calendarMin;

    public mixed $calendarMax;

    public mixed $weightCalc;

    /**
     * @var array<int|string, mixed> of CalcResponseAdditionalServiceDto
     */
    public array $services;

    public mixed $totalSum;

    public mixed $currency;

    /**
     * @var array<int|string, mixed> of ErrorDto2
     */
    public array $errors;

    /**
     * @var array<int|string, mixed> of WarningDto
     */
    public array $warnings;

    public mixed $deliveryDateRange;

    public function __construct(
        mixed $deliverySum = null,
        mixed $periodMin = null,
        mixed $periodMax = null,
        mixed $calendarMin = null,
        mixed $calendarMax = null,
        mixed $weightCalc = null,
        array $services = [],
        mixed $totalSum = null,
        mixed $currency = null,
        array $errors = [],
        array $warnings = [],
        mixed $deliveryDateRange = null,
    ) {
        $this->deliverySum = $deliverySum;
        $this->periodMin = $periodMin;
        $this->periodMax = $periodMax;
        $this->calendarMin = $calendarMin;
        $this->calendarMax = $calendarMax;
        $this->weightCalc = $weightCalc;
        $this->services = $services;
        $this->totalSum = $totalSum;
        $this->currency = $currency;
        $this->errors = $errors;
        $this->warnings = $warnings;
        $this->deliveryDateRange = $deliveryDateRange;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            deliverySum: $data['delivery_sum'] ?? null,
            periodMin: $data['period_min'] ?? null,
            periodMax: $data['period_max'] ?? null,
            calendarMin: $data['calendar_min'] ?? null,
            calendarMax: $data['calendar_max'] ?? null,
            weightCalc: $data['weight_calc'] ?? null,
            services: isset($data['services']) && is_array($data['services']) ? $data['services'] : [],
            totalSum: $data['total_sum'] ?? null,
            currency: $data['currency'] ?? null,
            errors: isset($data['errors']) && is_array($data['errors']) ? $data['errors'] : [],
            warnings: isset($data['warnings']) && is_array($data['warnings']) ? $data['warnings'] : [],
            deliveryDateRange: $data['delivery_date_range'] ?? null,
        );
    }
}
