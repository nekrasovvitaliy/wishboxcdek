<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: CheckResponseDto
 *
 * Ответ метода получения чеков
 */
final readonly class CheckResponseDto
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
     * @var array<int|string, mixed> of CheckInfoDto
     */
    public array $checkInfo;

    public function __construct(
        array $errors = [],
        array $warnings = [],
        array $checkInfo = [],
    ) {
        $this->errors = $errors;
        $this->warnings = $warnings;
        $this->checkInfo = $checkInfo;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            errors: isset($data['errors']) && is_array($data['errors']) ? $data['errors'] : [],
            warnings: isset($data['warnings']) && is_array($data['warnings']) ? $data['warnings'] : [],
            checkInfo: isset($data['check_info']) && is_array($data['check_info']) ? $data['check_info'] : [],
        );
    }
}
