<?php

declare(strict_types=1);

namespace WishboxCdek\Validation\Order\Rule;

use WishboxCdek\Request\Order\OrderCreateRequestDto;

final class PackagesNotEmptyRule implements CreateOrderValidationRule
{
    public function validate(OrderCreateRequestDto $request): array
    {
        if ($request->packages === []) {
            return ['At least one package is required.'];
        }

        return [];
    }
}
