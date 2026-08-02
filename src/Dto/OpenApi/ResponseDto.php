<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: ResponseDto
 *
 * Ответ на запрос
 */
final readonly class ResponseDto
{
    public mixed $entity;

    /**
     * @var list<RequestInfoDto>
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
            requests: isset($data['requests']) && is_array($data['requests'])
                ? array_map(
                    static fn (array $request): RequestInfoDto => RequestInfoDto::fromArray($request),
                    $data['requests'],
                )
                : [],
        );
    }
}
