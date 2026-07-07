<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: ReverseValidateRequestPhoneDto
 */
final readonly class ReverseValidateRequestPhoneDto
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
