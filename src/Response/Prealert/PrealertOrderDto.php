<?php

declare(strict_types=1);

namespace WishboxCdek\Response\Prealert;

final readonly class PrealertOrderDto
{
    /**
     * @param list<PrealertPackageDto> $packages
     */
    public function __construct(
        public ?string $orderUuid = null,
        public ?string $cdekNumber = null,
        public ?string $imNumber = null,
        public array $packages = [],
    ) {
    }

    public static function fromArray(array $data): self
    {
        $packages = [];
        foreach (($data['packages'] ?? []) as $package) {
            if (is_array($package)) {
                $packages[] = PrealertPackageDto::fromArray($package);
            }
        }

        return new self(
            orderUuid: isset($data['order_uuid']) ? (string) $data['order_uuid'] : null,
            cdekNumber: isset($data['cdek_number']) ? (string) $data['cdek_number'] : null,
            imNumber: isset($data['im_number']) ? (string) $data['im_number'] : null,
            packages: $packages,
        );
    }
}