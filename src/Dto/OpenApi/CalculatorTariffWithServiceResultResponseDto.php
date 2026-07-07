<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: CalculatorTariffWithServiceResultResponseDto
 */
final readonly class CalculatorTariffWithServiceResultResponseDto
{
    public mixed $deliverySum;

    public mixed $periodMin;

    public mixed $periodMax;

    public mixed $calendarMin;

    public mixed $calendarMax;

    public mixed $deliveryDateRange;

    public mixed $weightCalc;

    /**
     * @var array<int|string, mixed> of CalcResponseAdditionalServiceDto
     */
    public array $services;

    public mixed $totalSum;

    public mixed $currency;

    /**
     * @var array<int|string, mixed> of CalculatorTariffWithServiceResultErrorResponseDto
     */
    public array $errors;

    public function __construct(
        mixed $deliverySum = null,
        mixed $periodMin = null,
        mixed $periodMax = null,
        mixed $calendarMin = null,
        mixed $calendarMax = null,
        mixed $deliveryDateRange = null,
        mixed $weightCalc = null,
        array $services = [],
        mixed $totalSum = null,
        mixed $currency = null,
        array $errors = [],
    ) {
        $this->deliverySum = $deliverySum;
        $this->periodMin = $periodMin;
        $this->periodMax = $periodMax;
        $this->calendarMin = $calendarMin;
        $this->calendarMax = $calendarMax;
        $this->deliveryDateRange = $deliveryDateRange;
        $this->weightCalc = $weightCalc;
        $this->services = $services;
        $this->totalSum = $totalSum;
        $this->currency = $currency;
        $this->errors = $errors;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            deliverySum: $data['delivery_sum'] ?? null,
            periodMin: $data['period_min'] ?? null,
            periodMax: $data['period_max'] ?? null,
            calendarMin: $data['calendar_min'] ?? null,
            calendarMax: $data['calendar_max'] ?? null,
            deliveryDateRange: $data['delivery_date_range'] ?? null,
            weightCalc: $data['weight_calc'] ?? null,
            services: isset($data['services']) && is_array($data['services']) ? $data['services'] : [],
            totalSum: $data['total_sum'] ?? null,
            currency: $data['currency'] ?? null,
            errors: isset($data['errors']) && is_array($data['errors']) ? $data['errors'] : [],
        );
    }
}
