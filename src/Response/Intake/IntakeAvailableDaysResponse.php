<?php

declare(strict_types=1);

namespace WishboxCdek\Response\Intake;

use WishboxCdek\Response\Error\CdekMessage;

final readonly class IntakeAvailableDaysResponse
{
    /**
     * @param list<string> $dates
     * @param list<CdekMessage> $errors
     * @param list<CdekMessage> $warnings
     */
    public function __construct(
        public array $dates = [],
        public ?bool $allDays = null,
        public array $errors = [],
        public array $warnings = [],
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            dates: array_values(array_filter(
                array_map(
                    static fn (mixed $item): ?string => $item === null ? null : (is_scalar($item) ? (string) $item : null),
                    $data['date'] ?? [],
                ),
                static fn (?string $item): bool => $item !== null,
            )),
            allDays: isset($data['all_days']) ? (bool) $data['all_days'] : null,
            errors: array_map(
                static fn (array $item): CdekMessage => CdekMessage::fromArray($item),
                array_values(array_filter(
                    $data['errors'] ?? [],
                    static fn (mixed $item): bool => is_array($item),
                )),
            ),
            warnings: array_map(
                static fn (array $item): CdekMessage => CdekMessage::fromArray($item),
                array_values(array_filter(
                    $data['warnings'] ?? [],
                    static fn (mixed $item): bool => is_array($item),
                )),
            ),
        );
    }
}
