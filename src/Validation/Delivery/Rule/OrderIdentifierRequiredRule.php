<?php

declare(strict_types=1);

namespace WishboxCdek\Validation\Delivery\Rule;

use WishboxCdek\Request\Delivery\RegisterDeliveryRequest;

final class OrderIdentifierRequiredRule implements RegisterDeliveryValidationRule
{
    public function validate(RegisterDeliveryRequest $request): array
    {
        if ($request->cdekNumber !== null || $request->orderUuid !== null) {
            return [];
        }

        return ['Either cdekNumber or orderUuid is required.'];
    }
}