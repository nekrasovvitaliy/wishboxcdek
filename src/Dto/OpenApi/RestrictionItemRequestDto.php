<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: RestrictionItemRequestDto
 *
 * Описание товара
 */
final readonly class RestrictionItemRequestDto
{
    public mixed $name;

    public mixed $amount;

    public mixed $itemId;

    public mixed $feacnCode;

    public function __construct(
        mixed $name = null,
        mixed $amount = null,
        mixed $itemId = null,
        mixed $feacnCode = null,
    ) {
        $this->name = $name;
        $this->amount = $amount;
        $this->itemId = $itemId;
        $this->feacnCode = $feacnCode;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'] ?? null,
            amount: $data['amount'] ?? null,
            itemId: $data['itemId'] ?? null,
            feacnCode: $data['feacn_code'] ?? null,
        );
    }
}
