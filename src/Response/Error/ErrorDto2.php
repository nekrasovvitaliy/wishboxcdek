<?php

declare(strict_types=1);

namespace WishboxCdek\Response\Error;

final readonly class ErrorDto2
{
    public function __construct(
        public ?string $code = null,
        public ?string $additionalCode = null,
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
            additionalCode: isset($data['additional_code']) ? (string) $data['additional_code'] : null,
            message: isset($data['message']) ? (string) $data['message'] : null,
        );
    }
}
