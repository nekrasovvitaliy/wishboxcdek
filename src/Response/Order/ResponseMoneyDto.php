<?php

declare(strict_types=1);

namespace WishboxCdek\Response\Order;

final readonly class ResponseMoneyDto
{
    public function __construct(
        public int|float|null $value = null,
        public int|float|null $vatSum = null,
        public ?int $vatRate = null,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            value: isset($data['value']) ? (is_int($data['value']) ? $data['value'] : (float) $data['value']) : null,
            vatSum: isset($data['vat_sum']) ? (is_int($data['vat_sum']) ? $data['vat_sum'] : (float) $data['vat_sum']) : null,
            vatRate: isset($data['vat_rate']) ? (int) $data['vat_rate'] : null,
        );
    }
}
