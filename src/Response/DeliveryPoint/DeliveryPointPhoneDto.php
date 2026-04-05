<?php

declare(strict_types=1);

namespace WishboxCdek\Response\DeliveryPoint;

final readonly class DeliveryPointPhoneDto
{
    public function __construct(
        public ?string $number = null,
        public ?string $additional = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            number: isset($data['number']) ? (string) $data['number'] : null,
            additional: isset($data['additional']) ? (string) $data['additional'] : null,
        );
    }
}
