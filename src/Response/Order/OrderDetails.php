<?php

declare(strict_types=1);

namespace WishboxCdek\Response\Order;

use WishboxCdek\Response\Async\AsyncEntity;
use WishboxCdek\Response\Async\AsyncRequest;
use WishboxCdek\Response\Error\CdekMessage;

final readonly class OrderDetails
{
    /**
     * @param list<AsyncRequest> $requests
     * @param list<AsyncEntity> $relatedEntities
     */
    public function __construct(
        public ?OrderEntity $entity = null,
        public array $requests = [],
        public array $relatedEntities = [],
    ) {
    }

    /**
     * @return list<CdekMessage>
     */
    public function getErrors(): array
    {
        $errors = [];

        foreach ($this->requests as $request) {
            foreach ($request->errors as $error) {
                $errors[] = $error;
            }
        }

        return $errors;
    }

    /**
     * @return list<CdekMessage>
     */
    public function getWarnings(): array
    {
        $warnings = [];

        foreach ($this->requests as $request) {
            foreach ($request->warnings as $warning) {
                $warnings[] = $warning;
            }
        }

        return $warnings;
    }

    public function hasErrors(): bool
    {
        return $this->getErrors() !== [];
    }

    public static function fromArray(array $data): self
    {
        $requests = [];

        if (isset($data['requests']) && is_array($data['requests'])) {
            foreach ($data['requests'] as $request) {
                if (is_array($request)) {
                    $requests[] = AsyncRequest::fromArray($request);
                }
            }
        }

        $relatedEntities = [];

        if (isset($data['related_entities']) && is_array($data['related_entities'])) {
            foreach ($data['related_entities'] as $entity) {
                if (is_array($entity)) {
                    $relatedEntities[] = AsyncEntity::fromArray($entity);
                }
            }
        }

        return new self(
            entity: isset($data['entity']) && is_array($data['entity']) ? OrderEntity::fromArray($data['entity']) : null,
            requests: $requests,
            relatedEntities: $relatedEntities,
        );
    }
}
