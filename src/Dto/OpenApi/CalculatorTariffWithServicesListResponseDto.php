<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: CalculatorTariffWithServicesListResponseDto
 *
 * Ответ на запрос расчета по доступным тарифам с учетом дополнительных услуг
 */
final readonly class CalculatorTariffWithServicesListResponseDto
{
    /**
     * @var array<int|string, mixed> of CalculatorTariffWithServicesResponseDto
     */
    public array $tariffCodes;

    /**
     * @var array<int|string, mixed> of ErrorDto2
     */
    public array $errors;

    /**
     * @var array<int|string, mixed> of WarningDto
     */
    public array $warnings;

    public function __construct(
        array $tariffCodes = [],
        array $errors = [],
        array $warnings = [],
    ) {
        $this->tariffCodes = $tariffCodes;
        $this->errors = $errors;
        $this->warnings = $warnings;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            tariffCodes: isset($data['tariff_codes']) && is_array($data['tariff_codes']) ? $data['tariff_codes'] : [],
            errors: isset($data['errors']) && is_array($data['errors']) ? $data['errors'] : [],
            warnings: isset($data['warnings']) && is_array($data['warnings']) ? $data['warnings'] : [],
        );
    }
}
