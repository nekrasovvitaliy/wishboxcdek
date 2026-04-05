<?php

declare(strict_types=1);

namespace WishboxCdek\Request\Registry;

use WishboxCdek\Request\RequestData;

final readonly class GetRegistriesRequest extends RequestData
{
    public function __construct(public string $date)
    {
    }

    public function toArray(): array
    {
        return [
            'date' => $this->date,
        ];
    }
}
