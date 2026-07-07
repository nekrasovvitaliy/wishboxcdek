<?php

declare(strict_types=1);

namespace WishboxCdek\Response\Order;

use WishboxCdek\Response\Error\ErrorDto2;
use WishboxCdek\Response\Error\WarningDto;

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

    /**
     * @return list<ErrorDto2>
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
     * @return list<WarningDto>
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
        foreach ($this->requests as $request) {
            if ($request->errors !== []) {
                return true;
            }
        }

        return false;
    }
}
