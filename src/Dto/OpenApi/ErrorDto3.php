<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: ErrorDto3
 *
 * Информация об ошибке
 */
final readonly class ErrorDto3
{
    public mixed $code;

    public mixed $message;

    public function __construct(
        mixed $code = null,
        mixed $message = null,
    ) {
        $this->code = $code;
        $this->message = $message;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            code: $data['code'] ?? null,
            message: $data['message'] ?? null,
        );
    }
}
