<?php

declare(strict_types=1);

namespace WishboxCdek\Request\Webhook;

use WishboxCdek\Request\RequestData;

final readonly class CreateWebhookRequestDto extends RequestData
{
    public function __construct(
        public string $type,
        public string $url,
    ) {
    }

    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'url' => $this->url,
        ];
    }
}
