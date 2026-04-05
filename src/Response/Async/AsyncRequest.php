<?php

declare(strict_types=1);

namespace WishboxCdek\Response\Async;

use WishboxCdek\Response\Error\CdekMessage;

final readonly class AsyncRequest
{
    /**
     * @param list<CdekMessage> $errors
     * @param list<CdekMessage> $warnings
     */
    public function __construct(
        public ?string $requestUuid = null,
        public ?string $type = null,
        public ?string $dateTime = null,
        public ?string $state = null,
        public array $errors = [],
        public array $warnings = [],
    ) {
    }

    public static function fromArray(array $data): self
    {
        $errors = [];
        foreach (($data['errors'] ?? []) as $error) {
            if (is_array($error)) {
                $errors[] = CdekMessage::fromArray($error);
            }
        }

        $warnings = [];
        foreach (($data['warnings'] ?? []) as $warning) {
            if (is_array($warning)) {
                $warnings[] = CdekMessage::fromArray($warning);
            }
        }

        return new self(
            requestUuid: isset($data['request_uuid']) ? (string) $data['request_uuid'] : null,
            type: isset($data['type']) ? (string) $data['type'] : null,
            dateTime: isset($data['date_time']) ? (string) $data['date_time'] : null,
            state: isset($data['state']) ? (string) $data['state'] : null,
            errors: $errors,
            warnings: $warnings,
        );
    }
}
