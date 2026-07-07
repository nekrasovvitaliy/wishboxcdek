<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: ContragentsNewTerritoriesRequest
 */
final readonly class ContragentsNewTerritoriesRequest
{
    /**
     * @var array<int|string, mixed>
     */
    public array $contragents;

    public function __construct(
        array $contragents = [],
    ) {
        $this->contragents = $contragents;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            contragents: isset($data['contragents']) && is_array($data['contragents']) ? $data['contragents'] : [],
        );
    }
}
