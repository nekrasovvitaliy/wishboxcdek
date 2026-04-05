<?php

declare(strict_types=1);

namespace WishboxCdek\Request\Order;

use WishboxCdek\Request\RequestData;

final readonly class AdditionalServiceRequestDto extends RequestData
{
    public function __construct(
        public string $code,
        public int|float|string|null $parameter = null,
        public int|float|null $sum = null,
        public array $extra = [],
    ) {
    }

    public function toArray(): array
    {
        return $this->normalizeArray([
            'code' => $this->code,
            'parameter' => $this->parameter,
            'sum' => $this->sum,
            ...$this->extra,
        ]);
    }
}
