<?php

declare(strict_types=1);

namespace WishboxCdek\Validation\Delivery\Rule;

use WishboxCdek\Request\Delivery\RegisterDeliveryRequest;

final class DeliveryPointAndToLocationExclusiveRule implements RegisterDeliveryValidationRule
{
    public function validate(RegisterDeliveryRequest $request): array
    {
        if ($request->deliveryPoint === null || $request->toLocation === null) {
            return [];
        }

        return ['deliveryPoint and toLocation cannot be used together.'];
    }
}