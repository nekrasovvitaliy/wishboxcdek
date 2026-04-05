<?php

declare(strict_types=1);

namespace WishboxCdek\Request\Order;

use WishboxCdek\Request\RequestData;

final readonly class CreateClientReturnRequest extends RequestData
{
    public function __construct(public array $payload)
    {
    }

    public function toArray(): array
    {
        return $this->payload;
    }
}
