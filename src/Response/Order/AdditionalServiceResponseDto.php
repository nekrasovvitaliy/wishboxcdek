<?php

declare(strict_types=1);

namespace WishboxCdek\Response\Order;

final readonly class AdditionalServiceResponseDto
{
    public function __construct(
        public ?string $code = null,
        public int|float|string|null $parameter = null,
        public int|float|null $sum = null,
        public int|float|null $totalSum = null,
        public int|float|null $discountPercent = null,
        public int|float|null $discountSum = null,
        public ?int $vatRate = null,
        public int|float|null $vatSum = null,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            code: isset($data['code']) ? (string) $data['code'] : null,
            parameter: $data['parameter'] ?? null,
            sum: isset($data['sum']) ? (is_int($data['sum']) ? $data['sum'] : (float) $data['sum']) : null,
            totalSum: isset($data['total_sum']) ? (is_int($data['total_sum']) ? $data['total_sum'] : (float) $data['total_sum']) : null,
            discountPercent: isset($data['discount_percent']) ? (is_int($data['discount_percent']) ? $data['discount_percent'] : (float) $data['discount_percent']) : null,
            discountSum: isset($data['discount_sum']) ? (is_int($data['discount_sum']) ? $data['discount_sum'] : (float) $data['discount_sum']) : null,
            vatRate: isset($data['vat_rate']) ? (int) $data['vat_rate'] : null,
            vatSum: isset($data['vat_sum']) ? (is_int($data['vat_sum']) ? $data['vat_sum'] : (float) $data['vat_sum']) : null,
        );
    }
}
