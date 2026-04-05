<?php

declare(strict_types=1);

namespace WishboxCdek\Response\International;

final readonly class RestrictionStatusDto
{
    public function __construct(
        public ?string $code = null,
        public ?string $name = null,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            code: isset($data['code']) ? (string) $data['code'] : null,
            name: isset($data['name']) ? (string) $data['name'] : null,
        );
    }
}
