<?php

declare(strict_types=1);

namespace WishboxCdek\Response\Location;

final readonly class PostalcodesDto
{
    /**
     * @param list<string> $postalCodes
     */
    public function __construct(
        public int $code,
        public array $postalCodes,
    ) {
    }

    public static function fromArray(array $data): self
    {
        $postalCodes = array_values(array_map('strval', $data['postal_codes'] ?? []));

        return new self(
            code: (int) ($data['code'] ?? 0),
            postalCodes: $postalCodes,
        );
    }
}

