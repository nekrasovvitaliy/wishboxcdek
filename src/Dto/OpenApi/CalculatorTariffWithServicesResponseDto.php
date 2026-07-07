<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: CalculatorTariffWithServicesResponseDto
 */
final readonly class CalculatorTariffWithServicesResponseDto
{
    public mixed $tariffCode;

    public mixed $status;

    public mixed $result;

    public function __construct(
        mixed $tariffCode = null,
        mixed $status = null,
        mixed $result = null,
    ) {
        $this->tariffCode = $tariffCode;
        $this->status = $status;
        $this->result = $result;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            tariffCode: $data['tariff_code'] ?? null,
            status: $data['status'] ?? null,
            result: $data['result'] ?? null,
        );
    }
}
