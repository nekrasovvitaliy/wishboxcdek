<?php

declare(strict_types=1);

namespace WishboxCdek\Response\Order;

final readonly class ReturnItemDetail
{
    public function __construct(
        public ?string $directOrderNumber = null,
        public ?string $directOrderUuid = null,
        public ?string $directPackageNumber = null,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            directOrderNumber: isset($data['direct_order_number']) ? (string) $data['direct_order_number'] : null,
            directOrderUuid: isset($data['direct_order_uuid']) ? (string) $data['direct_order_uuid'] : null,
            directPackageNumber: isset($data['direct_package_number']) ? (string) $data['direct_package_number'] : null,
        );
    }
}
