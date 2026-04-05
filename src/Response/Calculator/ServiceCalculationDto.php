<?php

declare(strict_types=1);

namespace WishboxCdek\Response\Calculator;

final readonly class ServiceCalculationDto
{
    public function __construct(
        public ?string $code = null,
        public ?float $sum = null,
        public ?float $totalSum = null,
        public ?float $discountPercent = null,
        public ?float $discountSum = null,
        public ?int $vatRate = null,
        public ?float $vatSum = null,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            code: isset($data['code']) ? (string) $data['code'] : null,
            sum: isset($data['sum']) ? (float) $data['sum'] : null,
            totalSum: isset($data['total_sum']) ? (float) $data['total_sum'] : null,
            discountPercent: isset($data['discount_percent']) ? (float) $data['discount_percent'] : null,
            discountSum: isset($data['discount_sum']) ? (float) $data['discount_sum'] : null,
            vatRate: isset($data['vat_rate']) ? (int) $data['vat_rate'] : null,
            vatSum: isset($data['vat_sum']) ? (float) $data['vat_sum'] : null,
        );
    }
}
