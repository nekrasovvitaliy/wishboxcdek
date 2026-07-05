<?php

declare(strict_types=1);

namespace WishboxCdek\Validation\Order\Rule;

use WishboxCdek\Request\Order\OrderCreateRequestDto;
use WishboxCdek\Support\Tariff\TariffModeResolver;

final class WarehouseTariffDeliveryPointRule implements CreateOrderValidationRule
{
    public function __construct(
        private readonly TariffModeResolver $tariffModeResolver,
    ) {
    }

    public function validate(OrderCreateRequestDto $request): array
    {
        $mode = $this->tariffModeResolver->resolve($request->tariffCode);

        if ($mode === null || !$mode->requiresDeliveryPoint()) {
            return [];
        }

        if ($request->deliveryPoint === null || trim($request->deliveryPoint) === '') {
            return [sprintf('delivery_point is required for tariff %d.', $request->tariffCode)];
        }

        return [];
    }
}
