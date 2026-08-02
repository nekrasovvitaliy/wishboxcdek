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
    public ?WebhookResponseDto $entity;

    /**
     * @var list<RequestInfoDto>
     */
    public array $requests;

    public function __construct(
        ?WebhookResponseDto $entity = null,
        array $requests = [],
    ) {
        $this->entity = $entity;
        $this->requests = $requests;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            entity: isset($data['entity']) && is_array($data['entity']) ? WebhookResponseDto::fromArray($data['entity']) : null,
            requests: isset($data['requests']) && is_array($data['requests'])
                ? array_map(
                    static fn (array $request): RequestInfoDto => RequestInfoDto::fromArray($request),
                    $data['requests'],
                )
                : [],
        );
    }
}
