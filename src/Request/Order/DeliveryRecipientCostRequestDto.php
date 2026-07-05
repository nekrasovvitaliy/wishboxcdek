<?php

declare(strict_types=1);

namespace WishboxCdek\Request\Order;

use WishboxCdek\Request\RequestData;

final readonly class DeliveryRecipientCostRequestDto extends RequestData
{
    public function __construct(
        public int|float $value,
        public int|float|null $vatSum = null,
        public ?int $vatRate = null,
    ) {
    }

    public function toArray(): array
    {
        return $this->normalizeArray([
            'value' => $this->value,
            'vat_sum' => $this->vatSum,
            'vat_rate' => $this->vatRate,
        ]);
    }
}
