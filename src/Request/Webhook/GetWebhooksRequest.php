<?php

declare(strict_types=1);

namespace WishboxCdek\Request\Webhook;

use WishboxCdek\Request\RequestData;

final readonly class GetWebhooksRequest extends RequestData
{
    public function __construct(
        public ?int $page = null,
        public ?int $size = null
    ) {
    }

    public function toArray(): array
    {
        return $this->filterNulls([
            'page' => $this->page,
            'size' => $this->size,
        ]);
    }
}
