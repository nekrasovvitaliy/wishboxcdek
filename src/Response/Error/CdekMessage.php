<?php

declare(strict_types=1);

namespace WishboxCdek\Response\Error;

final readonly class CdekMessage
{
    public function __construct(
        public ?string $code = null,
        public ?string $message = null,
        public ?string $additionalCode = null,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            code: isset($data['code']) ? (string) $data['code'] : null,
            message: isset($data['message']) ? (string) $data['message'] : null,
            additionalCode: isset($data['additional_code']) ? (string) $data['additional_code'] : null,
        );
    }
}
