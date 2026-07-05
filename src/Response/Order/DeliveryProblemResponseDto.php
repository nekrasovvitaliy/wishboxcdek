<?php

declare(strict_types=1);

namespace WishboxCdek\Response\Order;

final readonly class DeliveryProblemResponseDto
{
    public function __construct(
        public ?int $code = null,
        public ?string $createDate = null,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            code: isset($data['code']) ? (int) $data['code'] : null,
            createDate: isset($data['create_date']) ? (string) $data['create_date'] : null,
        );
    }
}
