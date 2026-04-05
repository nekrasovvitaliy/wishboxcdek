<?php

declare(strict_types=1);

namespace WishboxCdek\Response\Calculator;

final readonly class DeliveryDateRangeDto
{
    public function __construct(
        public ?string $min = null,
        public ?string $max = null,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            min: isset($data['min']) ? (string) $data['min'] : null,
            max: isset($data['max']) ? (string) $data['max'] : null,
        );
    }
}
