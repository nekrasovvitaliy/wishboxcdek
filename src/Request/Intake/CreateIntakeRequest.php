<?php

declare(strict_types=1);

namespace WishboxCdek\Request\Intake;

use WishboxCdek\Request\RequestData;

final readonly class CreateIntakeRequest extends RequestData
{
    public function __construct(public array $payload)
    {
    }

    public function toArray(): array
    {
        return $this->payload;
    }
}
