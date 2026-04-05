<?php

declare(strict_types=1);

namespace WishboxCdek\Validation\Prealert\Rule;

use WishboxCdek\Request\Prealert\RegisterPrealertRequest;

final class ShipmentPointRequiredRule implements RegisterPrealertValidationRule
{
    public function validate(RegisterPrealertRequest $request): array
    {
        if (trim($request->shipmentPoint) !== '') {
            return [];
        }

        return ['shipment_point is required.'];
    }
}
