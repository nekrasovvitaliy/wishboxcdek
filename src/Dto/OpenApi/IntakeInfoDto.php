<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: IntakeInfoDto
 *
 * Заявка на вызов курьера (забор груза)
 */
final readonly class IntakeInfoDto
{
    public mixed $entity;

    /**
     * @var array<int|string, mixed> of RequestDto
     */
    public array $requests;

    public function __construct(
        mixed $entity = null,
        array $requests = [],
    ) {
        $this->entity = $entity;
        $this->requests = $requests;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            entity: $data['entity'] ?? null,
            requests: isset($data['requests']) && is_array($data['requests']) ? $data['requests'] : [],
        );
    }
}
