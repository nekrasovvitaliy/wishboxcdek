<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: IntakeChangeStatusDto
 *
 * DTO для изменения статуса заявки
 */
final readonly class IntakeChangeStatusDto
{
    public ?string $uuid;

    public mixed $status;

    public function __construct(
        ?string $uuid = null,
        mixed $status = null,
    ) {
        $this->uuid = $uuid;
        $this->status = $status;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            uuid: isset($data['uuid']) ? (string) $data['uuid'] : null,
            status: $data['status'] ?? null,
        );
    }
}
