<?php

declare(strict_types=1);

namespace WishboxCdek\Response\Error;

final readonly class SimplifiedResponseDto1
{
    /**
     * @param list<ErrorDto2> $errors
     * @param list<WarningDto> $warnings
     */
    public function __construct(
        public array $errors = [],
        public array $warnings = [],
    ) {
    }

    public static function fromArray(array $data): self
    {
        $errors = [];
        foreach (($data['errors'] ?? []) as $error) {
            if (is_array($error)) {
                $errors[] = ErrorDto2::fromArray($error);
            }
        }

        $warnings = [];
        foreach (($data['warnings'] ?? []) as $warning) {
            if (is_array($warning)) {
                $warnings[] = WarningDto::fromArray($warning);
            }
        }

        return new self(
            errors: $errors,
            warnings: $warnings,
        );
    }
}
