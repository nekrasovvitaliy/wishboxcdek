<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: GetPrealertResponseDtoOrderDto
 *
 * Заказ, который планируется передать в СДЭК
 */
final readonly class GetPrealertResponseDtoOrderDto
{
    public ?string $orderUuid;

    public mixed $cdekNumber;

    public mixed $imNumber;

    /**
     * @var array<int|string, mixed> of GetPrealertResponseDtoPackageInfoDto
     */
    public array $packages;

    public function __construct(
        ?string $orderUuid = null,
        mixed $cdekNumber = null,
        mixed $imNumber = null,
        array $packages = [],
    ) {
        $this->orderUuid = $orderUuid;
        $this->cdekNumber = $cdekNumber;
        $this->imNumber = $imNumber;
        $this->packages = $packages;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            orderUuid: isset($data['order_uuid']) ? (string) $data['order_uuid'] : null,
            cdekNumber: $data['cdek_number'] ?? null,
            imNumber: $data['im_number'] ?? null,
            packages: isset($data['packages']) && is_array($data['packages']) ? $data['packages'] : [],
        );
    }
}
