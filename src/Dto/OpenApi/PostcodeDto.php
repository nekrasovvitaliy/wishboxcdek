<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: PostcodeDto
 *
 * Ответ на запрос получения списка почтовых индексов
 */
final readonly class PostcodeDto
{
    public mixed $code;

    /**
     * @var array<int|string, mixed>
     */
    public array $postalCodes;

    public function __construct(
        mixed $code = null,
        array $postalCodes = [],
    ) {
        $this->code = $code;
        $this->postalCodes = $postalCodes;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            code: $data['code'] ?? null,
            postalCodes: isset($data['postal_codes']) && is_array($data['postal_codes']) ? $data['postal_codes'] : [],
        );
    }
}
