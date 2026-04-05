<?php

declare(strict_types=1);

namespace WishboxCdek\Request\Order;

use WishboxCdek\Request\RequestData;

final readonly class MoneyDto extends RequestData
{
    public function __construct(
        public int|float $value,
        public ?int $vatRate = null,
        public int|float|null $vatSum = null,
    ) {
    }

    public function toArray(): array
    {
        return $this->normalizeArray([
            'value' => $this->value,
            'vat_rate' => $this->vatRate,
            'vat_sum' => $this->vatSum,
        ]);
    }
}
