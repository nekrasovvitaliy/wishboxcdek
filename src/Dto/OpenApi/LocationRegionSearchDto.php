<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: LocationRegionSearchDto
 */
final readonly class LocationRegionSearchDto
{
    /**
     * @var array<int|string, mixed>
     */
    public array $countryCodes;

    public ?string $regionFiasGuid;

    public ?int $size;

    public ?int $page;

    public function __construct(
        array $countryCodes = [],
        ?string $regionFiasGuid = null,
        ?int $size = null,
        ?int $page = null,
    ) {
        $this->countryCodes = $countryCodes;
        $this->regionFiasGuid = $regionFiasGuid;
        $this->size = $size;
        $this->page = $page;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            countryCodes: isset($data['countryCodes']) && is_array($data['countryCodes']) ? $data['countryCodes'] : [],
            regionFiasGuid: isset($data['regionFiasGuid']) ? (string) $data['regionFiasGuid'] : null,
            size: isset($data['size']) ? (int) $data['size'] : null,
            page: isset($data['page']) ? (int) $data['page'] : null,
        );
    }
}
