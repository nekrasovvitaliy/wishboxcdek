<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: RegistriesResponseDto
 *
 * Реестры наложенных платежей
 */
final readonly class RegistriesResponseDto
{
    /**
     * @var array<int|string, mixed> of RegistryDto
     */
    public array $registries;

    /**
     * @var array<int|string, mixed> of ErrorDto2
     */
    public array $errors;

    /**
     * @var array<int|string, mixed> of WarningDto
     */
    public array $warnings;

    public function __construct(
        array $registries = [],
        array $errors = [],
        array $warnings = [],
    ) {
        $this->registries = $registries;
        $this->errors = $errors;
        $this->warnings = $warnings;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            registries: isset($data['registries']) && is_array($data['registries']) ? $data['registries'] : [],
            errors: isset($data['errors']) && is_array($data['errors']) ? $data['errors'] : [],
            warnings: isset($data['warnings']) && is_array($data['warnings']) ? $data['warnings'] : [],
        );
    }
}
