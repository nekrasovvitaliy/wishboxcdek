<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: CalculatorAvailableTariffsResponseAdditionalOrderTypesParamDto
 *
 * Доп. типы заказа, применимые к тарифу
 */
final readonly class CalculatorAvailableTariffsResponseAdditionalOrderTypesParamDto
{
    public mixed $withoutAdditionalOrderType;

    /**
     * @var array<int|string, mixed>
     */
    public array $additionalOrderTypes;

    public function __construct(
        mixed $withoutAdditionalOrderType = null,
        array $additionalOrderTypes = [],
    ) {
        $this->withoutAdditionalOrderType = $withoutAdditionalOrderType;
        $this->additionalOrderTypes = $additionalOrderTypes;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            withoutAdditionalOrderType: $data['without_additional_order_type'] ?? null,
            additionalOrderTypes: isset($data['additional_order_types']) && is_array($data['additional_order_types']) ? $data['additional_order_types'] : [],
        );
    }
}
