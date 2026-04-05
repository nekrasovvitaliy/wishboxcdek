<?php

declare(strict_types=1);

namespace WishboxCdek\Request\Prealert;

use WishboxCdek\Request\RequestData;

final readonly class PrealertOrderDto extends RequestData
{
    public function __construct(
        public ?string $orderUuid = null,
        public ?string $cdekNumber = null,
        public ?string $imNumber = null,
    ) {
    }

    public function toArray(): array
    {
        return $this->normalizeArray([
            'order_uuid' => $this->orderUuid,
            'cdek_number' => $this->cdekNumber,
            'im_number' => $this->imNumber,
        ]);
    }
}