<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: HintStatusDto
 *
 * Статус подсказки по ограничениям
 */
final readonly class HintStatusDto
{
    public mixed $code;

    public mixed $name;

    public mixed $reason;

    public function __construct(
        mixed $code = null,
        mixed $name = null,
        mixed $reason = null,
    ) {
        $this->code = $code;
        $this->name = $name;
        $this->reason = $reason;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            code: $data['code'] ?? null,
            name: $data['name'] ?? null,
            reason: $data['reason'] ?? null,
        );
    }
}
