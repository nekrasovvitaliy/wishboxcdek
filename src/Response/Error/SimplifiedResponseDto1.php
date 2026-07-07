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
        foreach (self::collectRows($data, 'errors') as $error) {
            $errors[] = ErrorDto2::fromArray($error);
        }

        $warnings = [];
        foreach (self::collectRows($data, 'warnings') as $warning) {
            $warnings[] = WarningDto::fromArray($warning);
        }

        return new self(
            errors: $errors,
            warnings: $warnings,
        );
    }

    /**
     * @return list<array<string, mixed>>
     */
    private static function collectRows(array $data, string $key): array
    {
        $rows = [];

        if (isset($data[$key]) && is_array($data[$key])) {
            foreach ($data[$key] as $row) {
                if (is_array($row)) {
                    $rows[] = $row;
                }
            }
        }

        if (!isset($data['requests']) || !is_array($data['requests'])) {
            return $rows;
        }

        foreach ($data['requests'] as $request) {
            if (!is_array($request) || !isset($request[$key]) || !is_array($request[$key])) {
                continue;
            }

            foreach ($request[$key] as $row) {
                if (is_array($row)) {
                    $rows[] = $row;
                }
            }
        }

        return $rows;
    }
}
