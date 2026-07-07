<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: OtpEntity
 */
final readonly class OtpEntity
{
    public ?string $uuid;

    public ?string $createdAt;

    public mixed $url;

    public mixed $length;

    public mixed $ttlSeconds;

    public function __construct(
        ?string $uuid = null,
        ?string $createdAt = null,
        mixed $url = null,
        mixed $length = null,
        mixed $ttlSeconds = null,
    ) {
        $this->uuid = $uuid;
        $this->createdAt = $createdAt;
        $this->url = $url;
        $this->length = $length;
        $this->ttlSeconds = $ttlSeconds;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            uuid: isset($data['uuid']) ? (string) $data['uuid'] : null,
            createdAt: isset($data['createdAt']) ? (string) $data['createdAt'] : null,
            url: $data['url'] ?? null,
            length: $data['length'] ?? null,
            ttlSeconds: $data['ttlSeconds'] ?? null,
        );
    }
}
