<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: OtpResponse
 *
 * Ответ на запрос к методам OTP
 */
final readonly class OtpResponse
{
    public mixed $length;

    public mixed $ttlSeconds;

    public function __construct(
        mixed $length = null,
        mixed $ttlSeconds = null,
    ) {
        $this->length = $length;
        $this->ttlSeconds = $ttlSeconds;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            length: $data['length'] ?? null,
            ttlSeconds: $data['ttlSeconds'] ?? null,
        );
    }
}
