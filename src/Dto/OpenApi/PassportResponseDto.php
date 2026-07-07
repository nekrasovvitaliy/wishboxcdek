<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: PassportResponseDto
 *
 * Ответ на запрос получения паспортных данных
 */
final readonly class PassportResponseDto
{
    /**
     * @var array<int|string, mixed> of PassportOrderDto
     */
    public array $orders;

    /**
     * @var array<int|string, mixed> of ErrorDto2
     */
    public array $errors;

    /**
     * @var array<int|string, mixed> of WarningDto
     */
    public array $warnings;

    public function __construct(
        array $orders = [],
        array $errors = [],
        array $warnings = [],
    ) {
        $this->orders = $orders;
        $this->errors = $errors;
        $this->warnings = $warnings;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            orders: isset($data['orders']) && is_array($data['orders']) ? $data['orders'] : [],
            errors: isset($data['errors']) && is_array($data['errors']) ? $data['errors'] : [],
            warnings: isset($data['warnings']) && is_array($data['warnings']) ? $data['warnings'] : [],
        );
    }
}
