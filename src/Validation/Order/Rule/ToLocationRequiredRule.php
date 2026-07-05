<?php

declare(strict_types=1);

namespace WishboxCdek\Validation\Order\Rule;

use WishboxCdek\Request\Order\OrderCreateRequestDto;

final class ToLocationRequiredRule implements CreateOrderValidationRule
{
    public function validate(OrderCreateRequestDto $request): array
    {
        if ($request->toLocation === null) {
            return ['to_location is required.'];
        }

        return [];
    }
}
