<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: LocationSearchResponseDto
 *
 * Ответ на запрос получения списка населенных пунктов
 */
final readonly class LocationSearchResponseDto
{
    /**
     * @var array<int|string, mixed> of LocationDto1
     */
    public array $result;

    public mixed $scrollId;

    public function __construct(
        array $result = [],
        mixed $scrollId = null,
    ) {
        $this->result = $result;
        $this->scrollId = $scrollId;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            result: isset($data['result']) && is_array($data['result']) ? $data['result'] : [],
            scrollId: $data['scrollId'] ?? null,
        );
    }
}
