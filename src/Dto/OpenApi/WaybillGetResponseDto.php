<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: WaybillGetResponseDto
 *
 * Ответ на получение квитанции к заказу
 */
final readonly class WaybillGetResponseDto
{
    public mixed $entity;

    /**
     * @var array<int|string, mixed> of RequestDto
     */
    public array $requests;

    /**
     * @var array<int|string, mixed> of RelatedEntityDto
     */
    public array $relatedEntities;

    public function __construct(
        mixed $entity = null,
        array $requests = [],
        array $relatedEntities = [],
    ) {
        $this->entity = $entity;
        $this->requests = $requests;
        $this->relatedEntities = $relatedEntities;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            entity: $data['entity'] ?? null,
            requests: isset($data['requests']) && is_array($data['requests']) ? $data['requests'] : [],
            relatedEntities: isset($data['related_entities']) && is_array($data['related_entities']) ? $data['related_entities'] : [],
        );
    }
}
