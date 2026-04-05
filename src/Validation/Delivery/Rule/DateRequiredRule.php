<?php

declare(strict_types=1);

namespace WishboxCdek\Validation\Delivery\Rule;

use WishboxCdek\Request\Delivery\RegisterDeliveryRequest;

final class DateRequiredRule implements RegisterDeliveryValidationRule
{
    public function validate(RegisterDeliveryRequest $request): array
    {
        return $request->date === null ? ['date is required.'] : [];
    }
}