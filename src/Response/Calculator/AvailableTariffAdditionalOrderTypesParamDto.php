<?php

declare(strict_types=1);

namespace WishboxCdek\Response\Calculator;

final readonly class AvailableTariffAdditionalOrderTypesParamDto
{
    /**
     * @param list<?int> $additionalOrderTypes
     */
    public function __construct(
        public ?bool $withoutAdditionalOrderType = null,
        public array $additionalOrderTypes = [],
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            withoutAdditionalOrderType: array_key_exists('without_additional_order_type', $data)
                ? ($data['without_additional_order_type'] === null ? null : (bool) $data['without_additional_order_type'])
                : null,
            additionalOrderTypes: array_values(array_map(
                static fn (mixed $item): ?int => $item === null ? null : (int) $item,
                $data['additional_order_types'] ?? [],
            )),
        );
    }
}
