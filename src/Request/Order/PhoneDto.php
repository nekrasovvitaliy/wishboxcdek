<?php

declare(strict_types=1);

namespace WishboxCdek\Request\Order;

use WishboxCdek\Request\RequestData;

final readonly class PhoneDto extends RequestData
{
    public function __construct(
        public string $number,
        public ?string $additional = null,
        public array $extra = [],
    ) {
    }

    public function toArray(): array
    {
        return $this->normalizeArray([
            'number' => $this->number,
            'additional' => $this->additional,
            ...$this->extra,
        ]);
    }
}
