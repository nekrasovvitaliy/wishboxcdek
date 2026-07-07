<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: RequestInfoDto
 *
 * Информация о запросе
 */
final readonly class RequestInfoDto
{
    public ?string $requestUuid;

    public mixed $type;

    public ?string $dateTime;

    public mixed $state;

    /**
     * @var array<int|string, mixed> of ErrorDto3
     */
    public array $errors;

    public function __construct(
        ?string $requestUuid = null,
        mixed $type = null,
        ?string $dateTime = null,
        mixed $state = null,
        array $errors = [],
    ) {
        $this->requestUuid = $requestUuid;
        $this->type = $type;
        $this->dateTime = $dateTime;
        $this->state = $state;
        $this->errors = $errors;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            requestUuid: isset($data['request_uuid']) ? (string) $data['request_uuid'] : null,
            type: $data['type'] ?? null,
            dateTime: isset($data['date_time']) ? (string) $data['date_time'] : null,
            state: $data['state'] ?? null,
            errors: isset($data['errors']) && is_array($data['errors']) ? $data['errors'] : [],
        );
    }
}
