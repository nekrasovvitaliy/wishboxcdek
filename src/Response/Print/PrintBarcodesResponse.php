<?php

declare(strict_types=1);

namespace WishboxCdek\Response\Print;

use WishboxCdek\Response\Async\AsyncEntity;
use WishboxCdek\Response\Async\AsyncRequest;

final readonly class PrintBarcodesResponse
{
    /**
     * @param list<AsyncRequest> $requests
     * @param list<AsyncEntity> $relatedEntities
     */
    public function __construct(
        public ?PrintBarcodesEntityDto $entity = null,
        public array $requests = [],
        public array $relatedEntities = [],
    ) {
    }

    public static function fromArray(array $data): self
    {
        $requests = [];
        foreach (($data['requests'] ?? []) as $request) {
            if (is_array($request)) {
                $requests[] = AsyncRequest::fromArray($request);
            }
        }

        $relatedEntities = [];
        foreach (($data['related_entities'] ?? []) as $relatedEntity) {
            if (is_array($relatedEntity)) {
                $relatedEntities[] = AsyncEntity::fromArray($relatedEntity);
            }
        }

        return new self(
            entity: isset($data['entity']) && is_array($data['entity']) ? PrintBarcodesEntityDto::fromArray($data['entity']) : null,
            requests: $requests,
            relatedEntities: $relatedEntities,
        );
    }
}