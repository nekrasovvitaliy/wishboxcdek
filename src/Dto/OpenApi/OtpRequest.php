<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: OtpRequest
 *
 * Запрос на генерацию OTP
 */
final readonly class OtpRequest
{
    public mixed $cdekNumber;

    public mixed $securityCode;

    public function __construct(
        mixed $cdekNumber = null,
        mixed $securityCode = null,
    ) {
        $this->cdekNumber = $cdekNumber;
        $this->securityCode = $securityCode;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            cdekNumber: $data['cdek_number'] ?? null,
            securityCode: $data['security_code'] ?? null,
        );
    }
}
