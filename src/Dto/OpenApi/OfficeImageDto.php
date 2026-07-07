<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: OfficeImageDto
 *
 * Фото офиса
 */
final readonly class OfficeImageDto
{
    public mixed $number;

    public mixed $url;

    public function __construct(
        mixed $number = null,
        mixed $url = null,
    ) {
        $this->number = $number;
        $this->url = $url;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            number: $data['number'] ?? null,
            url: $data['url'] ?? null,
        );
    }
}
