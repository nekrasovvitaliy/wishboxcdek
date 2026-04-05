<?php

declare(strict_types=1);

namespace WishboxCdek\Response\Passport;

use WishboxCdek\Response\Error\CdekMessage;

final readonly class PassportResponse
{
    /**
     * @param list<PassportOrderDto> $orders
     * @param list<CdekMessage> $errors
     * @param list<CdekMessage> $warnings
     */
    public function __construct(
        public array $orders = [],
        public array $errors = [],
        public array $warnings = [],
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            orders: array_map(
                static fn (array $item): PassportOrderDto => PassportOrderDto::fromArray($item),
                array_values(array_filter(
                    $data['orders'] ?? [],
                    static fn (mixed $item): bool => is_array($item),
                )),
            ),
            errors: array_map(
                static fn (array $item): CdekMessage => CdekMessage::fromArray($item),
                array_values(array_filter(
                    $data['errors'] ?? [],
                    static fn (mixed $item): bool => is_array($item),
                )),
            ),
            warnings: array_map(
                static fn (array $item): CdekMessage => CdekMessage::fromArray($item),
                array_values(array_filter(
                    $data['warnings'] ?? [],
                    static fn (mixed $item): bool => is_array($item),
                )),
            ),
        );
    }
}
