<?php

declare(strict_types=1);

namespace WishboxCdek\Response\Async;

final readonly class AsyncResponse
{
    /**
     * @param list<AsyncEntity> $relatedEntities
     * @param list<AsyncRequest> $requests
     */
    public function __construct(
        public ?AsyncResponseEntity $entity = null,
        public array $relatedEntities = [],
        public array $requests = [],
    ) {
    }

    public static function fromArray(array $data): self
    {
        $relatedEntities = [];
        foreach (($data['related_entities'] ?? []) as $relatedEntity) {
            if (is_array($relatedEntity)) {
                $relatedEntities[] = AsyncEntity::fromArray($relatedEntity);
            }
        }

        $requests = [];
        foreach (($data['requests'] ?? []) as $request) {
            if (is_array($request)) {
                $requests[] = AsyncRequest::fromArray($request);
            }
        }

        return new self(
            entity: isset($data['entity']) && is_array($data['entity']) ? AsyncResponseEntity::fromArray($data['entity']) : null,
            relatedEntities: $relatedEntities,
            requests: $requests,
        );
    }
}
