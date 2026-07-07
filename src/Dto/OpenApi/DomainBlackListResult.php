<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: DomainBlackListResult
 */
final readonly class DomainBlackListResult
{
    public ?string $uuid;

    public ?string $createdAt;

    public ?string $updatedAt;

    public mixed $deleted;

    public mixed $domain;

    public mixed $ip;

    public function __construct(
        ?string $uuid = null,
        ?string $createdAt = null,
        ?string $updatedAt = null,
        mixed $deleted = null,
        mixed $domain = null,
        mixed $ip = null,
    ) {
        $this->uuid = $uuid;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->deleted = $deleted;
        $this->domain = $domain;
        $this->ip = $ip;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            uuid: isset($data['uuid']) ? (string) $data['uuid'] : null,
            createdAt: isset($data['createdAt']) ? (string) $data['createdAt'] : null,
            updatedAt: isset($data['updatedAt']) ? (string) $data['updatedAt'] : null,
            deleted: $data['deleted'] ?? null,
            domain: $data['domain'] ?? null,
            ip: $data['ip'] ?? null,
        );
    }
}
