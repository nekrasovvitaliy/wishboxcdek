<?php

declare(strict_types=1);

namespace WishboxCdek\Request\Order;

use WishboxCdek\Request\RequestData;

final readonly class SellerDto extends RequestData
{
    public function __construct(
        public ?string $name = null,
        public ?string $inn = null,
        public ?string $phone = null,
        public ?string $ownershipForm = null,
        public ?string $address = null,
    ) {
    }

    public function toArray(): array
    {
        return $this->normalizeArray([
            'name' => $this->name,
            'inn' => $this->inn,
            'phone' => $this->phone,
            'ownership_form' => $this->ownershipForm,
            'address' => $this->address,
        ]);
    }
}
