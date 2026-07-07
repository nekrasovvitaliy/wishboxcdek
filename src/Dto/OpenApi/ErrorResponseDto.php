<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: ErrorResponseDto
 *
 * Стандартный формат ответа контроллера в случае ошибки
 */
final readonly class ErrorResponseDto
{
    /**
     * @var array<int|string, mixed> of AlertDto
     */
    public array $alerts;

    public function __construct(
        array $alerts = [],
    ) {
        $this->alerts = $alerts;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            alerts: isset($data['alerts']) && is_array($data['alerts']) ? $data['alerts'] : [],
        );
    }
}
