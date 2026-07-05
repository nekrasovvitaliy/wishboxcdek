<?php

declare(strict_types=1);

namespace WishboxCdek\Validation\Order\Rule;

use WishboxCdek\Request\Order\OrderCreateRequestDto;
use WishboxCdek\Support\Tariff\TariffModeResolver;

final class DoorTariffAddressRule implements CreateOrderValidationRule
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
            return [];
        }

        if (trim($request->toLocation->address) === '') {
            return [sprintf('to_location.address is required for tariff %d.', $request->tariffCode)];
        }

        return [];
    }
}
