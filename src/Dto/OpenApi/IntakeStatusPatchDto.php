<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: IntakeStatusPatchDto
 *
 * Статус заявки
 */
final readonly class IntakeStatusPatchDto
{
    public mixed $code;

    public mixed $addStatus;

    public function __construct(
        mixed $code = null,
        mixed $addStatus = null,
    ) {
        $this->code = $code;
        $this->addStatus = $addStatus;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            code: $data['code'] ?? null,
            addStatus: $data['add_status'] ?? null,
        );
    }
}
