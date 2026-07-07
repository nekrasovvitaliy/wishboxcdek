<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: AlertParamDto
 *
 * Дополнительный параметр ошибки
 */
final readonly class AlertParamDto
{
    public mixed $field;

    public mixed $value;

    public function __construct(
        mixed $field = null,
        mixed $value = null,
    ) {
        $this->field = $field;
        $this->value = $value;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            field: $data['field'] ?? null,
            value: $data['value'] ?? null,
        );
    }
}
