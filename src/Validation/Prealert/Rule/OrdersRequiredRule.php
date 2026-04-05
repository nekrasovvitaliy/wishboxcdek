<?php

declare(strict_types=1);

namespace WishboxCdek\Validation\Prealert\Rule;

use WishboxCdek\Request\Prealert\RegisterPrealertRequest;

final class OrdersRequiredRule implements RegisterPrealertValidationRule
{
    public function validate(RegisterPrealertRequest $request): array
    {
        if ($request->orders !== []) {
            return [];
        }

        return ['orders must not be empty.'];
    }
}
