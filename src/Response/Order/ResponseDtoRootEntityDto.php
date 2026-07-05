<?php

declare(strict_types=1);

namespace WishboxCdek\Response\Order;

final readonly class ResponseDtoRootEntityDto
{
    /**
     * @param list<RequestDto> $requests
     * @param list<RelatedEntityDto> $relatedEntities
     */
    public function __construct(
        public ?RootEntityDto $entity = null,
        public array $requests = [],
        public array $relatedEntities = [],
    ) {
    }

    public static function fromArray(array $data): self
    {
        $requests = [];
        foreach (($data['requests'] ?? []) as $request) {
            if (is_array($request)) {
                $requests[] = RequestDto::fromArray($request);
            }
        }

        $relatedEntities = [];
        foreach (($data['related_entities'] ?? []) as $relatedEntity) {
            if (is_array($relatedEntity)) {
                $relatedEntities[] = RelatedEntityDto::fromArray($relatedEntity);
            }
        }

        return new self(
            entity: isset($data['entity']) && is_array($data['entity']) ? RootEntityDto::fromArray($data['entity']) : null,
            requests: $requests,
            relatedEntities: $relatedEntities,
        );
    }
}
