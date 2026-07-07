<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: PaymentInfoDto
 *
 * Информация о сумме по чеку
 */
final readonly class PaymentInfoDto
{
    public mixed $sum;

    public mixed $type;

    public function __construct(
        mixed $sum = null,
        mixed $type = null,
    ) {
        $this->sum = $sum;
        $this->type = $type;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            sum: $data['sum'] ?? null,
            type: $data['type'] ?? null,
        );
    }
}
