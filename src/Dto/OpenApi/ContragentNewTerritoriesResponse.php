<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: ContragentNewTerritoriesResponse
 */
final readonly class ContragentNewTerritoriesResponse
{
    public ?string $uuid;

    public ?string $created;

    public ?string $updated;

    public mixed $version;

    public ?string $contragentUuid;

    public function __construct(
        ?string $uuid = null,
        ?string $created = null,
        ?string $updated = null,
        mixed $version = null,
        ?string $contragentUuid = null,
    ) {
        $this->uuid = $uuid;
        $this->created = $created;
        $this->updated = $updated;
        $this->version = $version;
        $this->contragentUuid = $contragentUuid;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            uuid: isset($data['uuid']) ? (string) $data['uuid'] : null,
            created: isset($data['created']) ? (string) $data['created'] : null,
            updated: isset($data['updated']) ? (string) $data['updated'] : null,
            version: $data['version'] ?? null,
            contragentUuid: isset($data['contragent_uuid']) ? (string) $data['contragent_uuid'] : null,
        );
    }
}
