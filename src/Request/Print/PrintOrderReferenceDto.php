<?php

declare(strict_types=1);

namespace WishboxCdek\Request\Print;

use WishboxCdek\Request\RequestData;

final readonly class PrintOrderReferenceDto extends RequestData
{
    public function __construct(
        public ?string $orderUuid = null,
        public ?string $cdekNumber = null,
    ) {
    }

    public function toArray(): array
    {
        return [
            'order_uuid' => $this->orderUuid,
            'cdek_number' => $this->cdekNumber,
        ];
    }
}
