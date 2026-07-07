<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: PhotoResponseDto
 *
 * Ответ на получение списка заказов с готовыми фото
 */
final readonly class PhotoResponseDto
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
     * @var array<int|string, mixed> of PhotoReadyOrderDto
     */
    public array $orders;

    public function __construct(
        array $errors = [],
        array $warnings = [],
        array $orders = [],
    ) {
        $this->errors = $errors;
        $this->warnings = $warnings;
        $this->orders = $orders;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            errors: isset($data['errors']) && is_array($data['errors']) ? $data['errors'] : [],
            warnings: isset($data['warnings']) && is_array($data['warnings']) ? $data['warnings'] : [],
            orders: isset($data['orders']) && is_array($data['orders']) ? $data['orders'] : [],
        );
    }
}
