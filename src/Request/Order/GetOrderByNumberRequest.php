<?php

declare(strict_types=1);

namespace WishboxCdek\Request\Order;

use WishboxCdek\Request\RequestData;

final readonly class GetOrderByNumberRequest extends RequestData
{
    public function __construct(
        public ?string $cdekNumber = null,
        public ?string $imNumber = null
    ) {
    }

    public function toArray(): array
    {
        return $this->filterNulls([
            'cdek_number' => $this->cdekNumber,
            'im_number' => $this->imNumber,
        ]);
    }
}
