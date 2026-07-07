<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: ClientEntity
 */
final readonly class ClientEntity
{
    public ?string $uuid;

    public ?string $createdAt;

    public mixed $deleted;

    public ?string $contractorUuid;

    public mixed $otp;

    public mixed $maxWebhooks;

    public function __construct(
        ?string $uuid = null,
        ?string $createdAt = null,
        mixed $deleted = null,
        ?string $contractorUuid = null,
        mixed $otp = null,
        mixed $maxWebhooks = null,
    ) {
        $this->uuid = $uuid;
        $this->createdAt = $createdAt;
        $this->deleted = $deleted;
        $this->contractorUuid = $contractorUuid;
        $this->otp = $otp;
        $this->maxWebhooks = $maxWebhooks;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            uuid: isset($data['uuid']) ? (string) $data['uuid'] : null,
            createdAt: isset($data['createdAt']) ? (string) $data['createdAt'] : null,
            deleted: $data['deleted'] ?? null,
            contractorUuid: isset($data['contractorUuid']) ? (string) $data['contractorUuid'] : null,
            otp: $data['otp'] ?? null,
            maxWebhooks: $data['maxWebhooks'] ?? null,
        );
    }
}
