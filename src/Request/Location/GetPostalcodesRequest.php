<?php

declare(strict_types=1);

namespace WishboxCdek\Request\Location;

use WishboxCdek\Request\RequestData;

final readonly class GetPostalcodesRequest extends RequestData
{
    public function __construct(public int $code)
    {
    }

    public function toArray(): array
    {
        return [
            'code' => $this->code,
        ];
    }
}
