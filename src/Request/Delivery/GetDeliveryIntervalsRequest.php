<?php

declare(strict_types=1);

namespace WishboxCdek\Request\Delivery;

use WishboxCdek\Request\RequestData;

final readonly class GetDeliveryIntervalsRequest extends RequestData
{
    public function __construct(
        public ?string $cdekNumber = null,
        public ?string $orderUuid = null,
    ) {
    }

    public function toArray(): array
    {
        return $this->filterNulls([
            'cdek_number' => $this->cdekNumber,
            'order_uuid' => $this->orderUuid,
        ]);
    }
}