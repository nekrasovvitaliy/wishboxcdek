<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: CalcResponseAdditionalServiceDto
 *
 * Дополнительная услуга
 */
final readonly class CalcResponseAdditionalServiceDto
{
    public mixed $code;

    public mixed $sum;

    public mixed $totalSum;

    public mixed $discountPercent;

    public mixed $discountSum;

    public mixed $vatRate;

    public mixed $vatSum;

    public function __construct(
        mixed $code = null,
        mixed $sum = null,
        mixed $totalSum = null,
        mixed $discountPercent = null,
        mixed $discountSum = null,
        mixed $vatRate = null,
        mixed $vatSum = null,
    ) {
        $this->code = $code;
        $this->sum = $sum;
        $this->totalSum = $totalSum;
        $this->discountPercent = $discountPercent;
        $this->discountSum = $discountSum;
        $this->vatRate = $vatRate;
        $this->vatSum = $vatSum;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            code: $data['code'] ?? null,
            sum: $data['sum'] ?? null,
            totalSum: $data['total_sum'] ?? null,
            discountPercent: $data['discount_percent'] ?? null,
            discountSum: $data['discount_sum'] ?? null,
            vatRate: $data['vat_rate'] ?? null,
            vatSum: $data['vat_sum'] ?? null,
        );
    }
}
