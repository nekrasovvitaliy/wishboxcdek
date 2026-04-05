<?php

declare(strict_types=1);

namespace WishboxCdek\Validation\Order\Rule;

use WishboxCdek\Request\Order\CreateOrderRequest;

final class ToLocationRequiredRule implements CreateOrderValidationRule
{
    public function validate(CreateOrderRequest $request): array
    {
        if ($request->toLocation === null) {
            return ['to_location is required.'];
        }

        return [];
    }
}
