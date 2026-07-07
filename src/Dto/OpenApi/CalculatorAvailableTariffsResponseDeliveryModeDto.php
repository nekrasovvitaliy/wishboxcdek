<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: CalculatorAvailableTariffsResponseDeliveryModeDto
 *
 * Режим доставки
 */
final readonly class CalculatorAvailableTariffsResponseDeliveryModeDto
{
    public mixed $deliveryMode;

    public mixed $deliveryModeName;

    public mixed $tariffCode;

    public function __construct(
        mixed $deliveryMode = null,
        mixed $deliveryModeName = null,
        mixed $tariffCode = null,
    ) {
        $this->deliveryMode = $deliveryMode;
        $this->deliveryModeName = $deliveryModeName;
        $this->tariffCode = $tariffCode;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            deliveryMode: $data['delivery_mode'] ?? null,
            deliveryModeName: $data['delivery_mode_name'] ?? null,
            tariffCode: $data['tariff_code'] ?? null,
        );
    }
}
