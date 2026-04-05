<?php

declare(strict_types=1);

namespace WishboxCdek\Response\DeliveryPoint;

final readonly class DeliveryPointOfficeImageDto
{
    public function __construct(
        public ?int $number = null,
        public ?string $url = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            number: isset($data['number']) ? (int) $data['number'] : null,
            url: isset($data['url']) ? (string) $data['url'] : null,
        );
    }
}
