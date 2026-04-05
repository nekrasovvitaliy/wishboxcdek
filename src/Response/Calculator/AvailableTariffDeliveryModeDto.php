<?php

declare(strict_types=1);

namespace WishboxCdek\Response\Calculator;

final readonly class AvailableTariffDeliveryModeDto
{
    public function __construct(
        public ?int $deliveryMode = null,
        public ?string $deliveryModeName = null,
        public ?int $tariffCode = null,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            deliveryMode: isset($data['delivery_mode']) ? (int) $data['delivery_mode'] : null,
            deliveryModeName: isset($data['delivery_mode_name']) ? (string) $data['delivery_mode_name'] : null,
            tariffCode: isset($data['tariff_code']) ? (int) $data['tariff_code'] : null,
        );
    }
}
