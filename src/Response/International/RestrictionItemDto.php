<?php

declare(strict_types=1);

namespace WishboxCdek\Response\International;

final readonly class RestrictionItemDto
{
    public function __construct(
        public ?string $itemId = null,
        public ?string $feacnCode = null,
        public ?RestrictionStatusDto $status = null,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            itemId: isset($data['item_id']) ? (string) $data['item_id'] : null,
            feacnCode: isset($data['feacn_code']) ? (string) $data['feacn_code'] : null,
            status: isset($data['status']) && is_array($data['status'])
                ? RestrictionStatusDto::fromArray($data['status'])
                : null,
        );
    }
}
