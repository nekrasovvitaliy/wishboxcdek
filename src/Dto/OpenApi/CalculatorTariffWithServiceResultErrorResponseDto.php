<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: CalculatorTariffWithServiceResultErrorResponseDto
 *
 * Дополнительная услуга
 */
final readonly class CalculatorTariffWithServiceResultErrorResponseDto
{
    public mixed $code;

    public mixed $additionalCode;

    public mixed $message;

    public function __construct(
        mixed $code = null,
        mixed $additionalCode = null,
        mixed $message = null,
    ) {
        $this->code = $code;
        $this->additionalCode = $additionalCode;
        $this->message = $message;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            code: $data['code'] ?? null,
            additionalCode: $data['additional_code'] ?? null,
            message: $data['message'] ?? null,
        );
    }
}
