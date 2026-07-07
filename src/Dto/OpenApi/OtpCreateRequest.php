<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: OtpCreateRequest
 *
 * Запрос на добавление информации об OTP
 */
final readonly class OtpCreateRequest
{
    public ?string $clientContractorUuid;

    public mixed $url;

    public mixed $length;

    public mixed $ttlSeconds;

    public function __construct(
        ?string $clientContractorUuid = null,
        mixed $url = null,
        mixed $length = null,
        mixed $ttlSeconds = null,
    ) {
        $this->clientContractorUuid = $clientContractorUuid;
        $this->url = $url;
        $this->length = $length;
        $this->ttlSeconds = $ttlSeconds;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            clientContractorUuid: isset($data['clientContractorUuid']) ? (string) $data['clientContractorUuid'] : null,
            url: $data['url'] ?? null,
            length: $data['length'] ?? null,
            ttlSeconds: $data['ttlSeconds'] ?? null,
        );
    }
}
