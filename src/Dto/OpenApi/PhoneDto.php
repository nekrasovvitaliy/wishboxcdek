<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: PhoneDto
 *
 * Информация о телефонах
 */
final readonly class PhoneDto
{
    public mixed $number;

    public mixed $additional;

    public function __construct(
        mixed $number = null,
        mixed $additional = null,
    ) {
        $this->number = $number;
        $this->additional = $additional;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            number: $data['number'] ?? null,
            additional: $data['additional'] ?? null,
        );
    }
}
