<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: ResponseDtoWebhookResponseDto
 *
 * Ответ на запрос
 */
final readonly class ResponseDtoWebhookResponseDto
{
    public mixed $entity;

    /**
     * @var array<int|string, mixed> of RequestInfoDto
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
