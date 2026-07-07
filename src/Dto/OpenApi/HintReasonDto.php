<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: HintReasonDto
 *
 * Причина статуса
 */
final readonly class HintReasonDto
{
    public mixed $code;

    public mixed $name;

    public function __construct(
        mixed $code = null,
        mixed $name = null,
    ) {
        $this->code = $code;
        $this->name = $name;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            code: $data['code'] ?? null,
            name: $data['name'] ?? null,
        );
    }
}
