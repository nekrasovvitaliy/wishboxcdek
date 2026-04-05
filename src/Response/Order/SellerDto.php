<?php

declare(strict_types=1);

namespace WishboxCdek\Response\Order;

final readonly class SellerDto
{
    public function __construct(
        public ?string $name = null,
        public ?string $inn = null,
        public ?string $phone = null,
        public ?string $ownershipForm = null,
        public ?string $address = null,
        public ?string $giisSubdivisionId = null,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            name: isset($data['name']) ? (string) $data['name'] : null,
            inn: isset($data['inn']) ? (string) $data['inn'] : null,
            phone: isset($data['phone']) ? (string) $data['phone'] : null,
            ownershipForm: isset($data['ownership_form']) ? (string) $data['ownership_form'] : null,
            address: isset($data['address']) ? (string) $data['address'] : null,
            giisSubdivisionId: isset($data['giis_subdivision_id']) ? (string) $data['giis_subdivision_id'] : null,
        );
    }
}
