<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: RestrictionHintsResponseDto
 *
 * Ответ на запрос ограничений
 */
final readonly class RestrictionHintsResponseDto
{
    /**
     * @var array<int|string, mixed> of ErrorDto2
     */
    public array $errors;

    /**
     * @var array<int|string, mixed> of WarningDto
     */
    public array $warnings;

    /**
     * @var array<int|string, mixed> of PackageHintDto
     */
    public array $packages;

    public function __construct(
        array $errors = [],
        array $warnings = [],
        array $packages = [],
    ) {
        $this->errors = $errors;
        $this->warnings = $warnings;
        $this->packages = $packages;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            errors: isset($data['errors']) && is_array($data['errors']) ? $data['errors'] : [],
            warnings: isset($data['warnings']) && is_array($data['warnings']) ? $data['warnings'] : [],
            packages: isset($data['packages']) && is_array($data['packages']) ? $data['packages'] : [],
        );
    }
}
