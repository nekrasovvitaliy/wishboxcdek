<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: ItemHintDto
 *
 * Описание ограничений по товарам
 */
final readonly class ItemHintDto
{
    public mixed $itemId;

    public mixed $feacnCode;

    public mixed $status;

    /**
     * @var array<int|string, mixed>
     */
    public array $limitations;

    /**
     * @var array<int|string, mixed>
     */
    public array $documents;

    public function __construct(
        mixed $itemId = null,
        mixed $feacnCode = null,
        mixed $status = null,
        array $limitations = [],
        array $documents = [],
    ) {
        $this->itemId = $itemId;
        $this->feacnCode = $feacnCode;
        $this->status = $status;
        $this->limitations = $limitations;
        $this->documents = $documents;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            itemId: $data['item_id'] ?? null,
            feacnCode: $data['feacn_code'] ?? null,
            status: $data['status'] ?? null,
            limitations: isset($data['limitations']) && is_array($data['limitations']) ? $data['limitations'] : [],
            documents: isset($data['documents']) && is_array($data['documents']) ? $data['documents'] : [],
        );
    }
}
