<?php

declare(strict_types=1);

namespace WishboxCdek\Validation\Order\Rule;

use WishboxCdek\Request\Order\OrderCreateRequestDto;
use WishboxCdek\Support\Tariff\TariffModeResolver;

final class DoorTariffToLocationRequiredRule implements CreateOrderValidationRule
{
    public function __construct(
        private readonly TariffModeResolver $tariffModeResolver,
    ) {
    }

    public function validate(OrderCreateRequestDto $request): array
    {
        $mode = $this->tariffModeResolver->resolve($request->tariffCode);

        if ($mode === null || !$mode->requiresToLocationAddress()) {
            return [];
        }

        if ($request->toLocation === null) {
            return [sprintf('to_location is required for tariff %d.', $request->tariffCode)];
        }

        return [];
    }
}
