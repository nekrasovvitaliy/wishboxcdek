<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: PostcodesResponseDto
 *
 * Транспорт ответа на запрос на поиск индексов по коду города
 */
final readonly class PostcodesResponseDto
{
    public ?int $code;

    /**
     * @var array<int|string, mixed>
     */
    public array $postalCodes;

    public function __construct(
        ?int $code = null,
        array $postalCodes = [],
    ) {
        $this->code = $code;
        $this->postalCodes = $postalCodes;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            code: isset($data['code']) ? (int) $data['code'] : null,
            postalCodes: isset($data['postal_codes']) && is_array($data['postal_codes']) ? $data['postal_codes'] : [],
        );
    }
}
