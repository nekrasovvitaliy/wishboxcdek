<?php

declare(strict_types=1);

namespace WishboxCdek\Response\Error;

final readonly class WarningDto
{
    public function __construct(
        public ?string $code = null,
        public ?string $message = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            code: isset($data['code']) ? (string) $data['code'] : null,
            message: isset($data['message']) ? (string) $data['message'] : null,
        );
    }
}
