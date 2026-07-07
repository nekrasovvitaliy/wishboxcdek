<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: IntakeAvailableDaysResponseDto
 *
 * Ответ на запрос на получение доступных дат вызова курьера для населенных пунктов
 */
final readonly class IntakeAvailableDaysResponseDto
{
    /**
     * @var array<int|string, mixed>
     */
    public array $date;

    public mixed $allDays;

    /**
     * @var array<int|string, mixed> of ErrorDto2
     */
    public array $errors;

    /**
     * @var array<int|string, mixed> of WarningDto
     */
    public array $warnings;

    public function __construct(
        array $date = [],
        mixed $allDays = null,
        array $errors = [],
        array $warnings = [],
    ) {
        $this->date = $date;
        $this->allDays = $allDays;
        $this->errors = $errors;
        $this->warnings = $warnings;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            date: isset($data['date']) && is_array($data['date']) ? $data['date'] : [],
            allDays: $data['all_days'] ?? null,
            errors: isset($data['errors']) && is_array($data['errors']) ? $data['errors'] : [],
            warnings: isset($data['warnings']) && is_array($data['warnings']) ? $data['warnings'] : [],
        );
    }
}
