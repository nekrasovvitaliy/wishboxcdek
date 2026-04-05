<?php

declare(strict_types=1);

namespace WishboxCdek\Response\Registry;

final readonly class RegistryDto
{
    /**
     * @param list<RegistryOrderDto> $orders
     */
    public function __construct(
        public ?string $registryNumber = null,
        public ?string $paymentDate = null,
        public int|float|null $sum = null,
        public ?string $paymentOrderNumber = null,
        public array $orders = [],
        public ?string $dateCreated = null,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            registryNumber: isset($data['registry_number']) ? (string) $data['registry_number'] : null,
            paymentDate: isset($data['payment_date']) ? (string) $data['payment_date'] : null,
            sum: isset($data['sum']) ? $data['sum'] : null,
            paymentOrderNumber: isset($data['payment_order_number']) ? (string) $data['payment_order_number'] : null,
            orders: array_map(
                static fn (array $item): RegistryOrderDto => RegistryOrderDto::fromArray($item),
                array_values(array_filter(
                    $data['orders'] ?? [],
                    static fn (mixed $item): bool => is_array($item),
                )),
            ),
            dateCreated: isset($data['date_created']) ? (string) $data['date_created'] : null,
        );
    }
}
