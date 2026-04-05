<?php

declare(strict_types=1);

namespace WishboxCdek\Request\International;

use WishboxCdek\Request\RequestData;

final readonly class RestrictionPackageItemRequestDto extends RequestData
{
    public function __construct(
        public ?string $name = null,
        public ?int $amount = null,
        public ?string $itemId = null,
        public ?string $feacnCode = null,
    ) {
    }

    public function toArray(): array
    {
        return $this->normalizeArray([
            'name' => $this->name,
            'amount' => $this->amount,
            'item_id' => $this->itemId,
            'feacn_code' => $this->feacnCode,
        ]);
    }
}
