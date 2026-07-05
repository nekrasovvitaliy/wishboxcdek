<?php

declare(strict_types=1);

namespace WishboxCdek\Response\Order;

final readonly class DeliveryCostThresholdDto
{
    public function __construct(
        public int|float|null $threshold = null,
        public int|float|null $sum = null,
        public int|float|null $vatSum = null,
        public ?int $vatRate = null,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            threshold: isset($data['threshold']) ? (is_int($data['threshold']) ? $data['threshold'] : (float) $data['threshold']) : null,
            sum: isset($data['sum']) ? (is_int($data['sum']) ? $data['sum'] : (float) $data['sum']) : null,
            vatSum: isset($data['vat_sum']) ? (is_int($data['vat_sum']) ? $data['vat_sum'] : (float) $data['vat_sum']) : null,
            vatRate: isset($data['vat_rate']) ? (int) $data['vat_rate'] : null,
        );
    }
}
