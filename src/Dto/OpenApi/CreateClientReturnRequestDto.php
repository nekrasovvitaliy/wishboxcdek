<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: CreateClientReturnRequestDto
 *
 * Запрос на создание клиентского возврата.
 */
final readonly class CreateClientReturnRequestDto
{
    public mixed $tariffCode;

    public function __construct(
        mixed $tariffCode = null,
    ) {
        $this->tariffCode = $tariffCode;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            tariffCode: $data['tariff_code'] ?? null,
        );
    }
}
