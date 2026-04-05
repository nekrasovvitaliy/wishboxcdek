<?php

declare(strict_types=1);

namespace WishboxCdek\Response\Async;

final readonly class AsyncResponseEntity
{
    public function __construct(public ?string $uuid = null)
    {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            uuid: isset($data['uuid']) ? (string) $data['uuid'] : null,
        );
    }
}
