<?php

declare(strict_types=1);

namespace WishboxCdek\Validation\Delivery\Rule;

use WishboxCdek\Request\Delivery\RegisterDeliveryRequest;

final class DeliveryTargetRequiredRule implements RegisterDeliveryValidationRule
{
    public function validate(RegisterDeliveryRequest $request): array
    {
        if ($request->deliveryPoint !== null || $request->toLocation !== null) {
            return [];
        }

        return ['Either deliveryPoint or toLocation is required.'];
    }
}