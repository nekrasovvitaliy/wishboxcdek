<?php

declare(strict_types=1);

namespace WishboxCdek\Request\Order;

use WishboxCdek\Request\RequestData;

final readonly class DeliveryCostThresholdDto extends RequestData
{
    public function __construct(
        public int|float|null $threshold = null,
        public int|float|null $sum = null,
        public int|float|null $vatSum = null,
        public ?int $vatRate = null,
    ) {
    }

    public function toArray(): array
    {
        return $this->normalizeArray([
            'threshold' => $this->threshold,
            'sum' => $this->sum,
            'vat_sum' => $this->vatSum,
            'vat_rate' => $this->vatRate,
        ]);
    }
}
