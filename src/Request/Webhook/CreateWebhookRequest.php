<?php

declare(strict_types=1);

namespace WishboxCdek\Request\Webhook;

use WishboxCdek\Request\RequestData;

final readonly class CreateWebhookRequest extends RequestData
{
    public function __construct(public array $payload)
    {
    }

    public function toArray(): array
    {
        return $this->payload;
    }
}
