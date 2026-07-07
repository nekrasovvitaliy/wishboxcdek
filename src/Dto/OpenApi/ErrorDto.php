<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: ErrorDto
 *
 * Информация об ошибке
 */
final readonly class ErrorDto
{
    public ?string $error;

    public ?string $errorDescription;

    public function __construct(
        ?string $error = null,
        ?string $errorDescription = null,
    ) {
        $this->error = $error;
        $this->errorDescription = $errorDescription;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            error: isset($data['error']) ? (string) $data['error'] : null,
            errorDescription: isset($data['error_description']) ? (string) $data['error_description'] : null,
        );
    }
}
