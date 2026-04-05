<?php

declare(strict_types=1);

namespace WishboxCdek\Request\Passport;

use WishboxCdek\Enum\PassportClient;
use WishboxCdek\Request\RequestData;

final readonly class GetPassportRequest extends RequestData
{
    public function __construct(
        public ?string $cdekNumber = null,
        public ?string $orderUuid = null,
        public ?PassportClient $client = null,
    ) {
    }

    public function toArray(): array
    {
        return $this->filterNulls([
            'cdek_number' => $this->cdekNumber,
            'order_uuid' => $this->orderUuid,
            'client' => $this->client?->value,
        ]);
    }
}
