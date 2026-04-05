<?php

declare(strict_types=1);

namespace WishboxCdek\Response\Order;

final readonly class PackageServiceDto
{
    public function __construct(public ?string $code = null)
    {
    }

    public static function fromArray(array $data): self
    {
        return new self(code: isset($data['code']) ? (string) $data['code'] : null);
    }
}
