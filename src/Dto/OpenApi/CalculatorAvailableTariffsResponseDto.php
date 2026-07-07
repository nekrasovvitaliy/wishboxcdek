<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: CalculatorAvailableTariffsResponseDto
 *
 * Ответ на запрос на получение списка всех доступных тарифов
 */
final readonly class CalculatorAvailableTariffsResponseDto
{
    /**
     * @var array<int|string, mixed> of CalculatorAvailableTariffsResponseTariffCodeDto
     */
    public array $tariffCodes;

    public function __construct(
        array $tariffCodes = [],
    ) {
        $this->tariffCodes = $tariffCodes;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            tariffCodes: isset($data['tariff_codes']) && is_array($data['tariff_codes']) ? $data['tariff_codes'] : [],
        );
    }
}
