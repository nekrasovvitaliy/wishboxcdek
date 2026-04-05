<?php

declare(strict_types=1);

namespace WishboxCdek\Validation\Delivery\Rule;

use WishboxCdek\Request\Delivery\RegisterDeliveryRequest;

final class TimeIntervalPairRule implements RegisterDeliveryValidationRule
{
    public function validate(RegisterDeliveryRequest $request): array
    {
        if (($request->timeFrom === null) === ($request->timeTo === null)) {
            return [];
        }

        return ['timeFrom and timeTo must be provided together.'];
    }
}