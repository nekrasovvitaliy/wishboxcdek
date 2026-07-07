<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: IntakeAvailableDaysRequestDto
 *
 * Запрос на получение доступных дат вызова курьера для населенных пунктов
 */
final readonly class IntakeAvailableDaysRequestDto
{
    public mixed $fromLocation;

    public mixed $date;

    public function __construct(
        mixed $fromLocation = null,
        mixed $date = null,
    ) {
        $this->fromLocation = $fromLocation;
        $this->date = $date;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            fromLocation: $data['from_location'] ?? null,
            date: $data['date'] ?? null,
        );
    }
}
