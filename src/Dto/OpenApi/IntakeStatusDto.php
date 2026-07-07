<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: IntakeStatusDto
 *
 * Информация о состоянии заявки
 */
final readonly class IntakeStatusDto
{
    public mixed $code;

    public mixed $name;

    public ?string $dateTime;

    public function __construct(
        mixed $code = null,
        mixed $name = null,
        ?string $dateTime = null,
    ) {
        $this->code = $code;
        $this->name = $name;
        $this->dateTime = $dateTime;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            code: $data['code'] ?? null,
            name: $data['name'] ?? null,
            dateTime: isset($data['date_time']) ? (string) $data['date_time'] : null,
        );
    }
}
