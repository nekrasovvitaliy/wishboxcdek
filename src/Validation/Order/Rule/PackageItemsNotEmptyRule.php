<?php

declare(strict_types=1);

namespace WishboxCdek\Validation\Order\Rule;

use WishboxCdek\Request\Order\CreateOrderRequest;
use WishboxCdek\Request\Order\PackageRequestDto;

final class PackageItemsNotEmptyRule implements CreateOrderValidationRule
{
    public function validate(CreateOrderRequest $request): array
    {
        $errors = [];

        foreach ($request->packages as $index => $package) {
            if (!$package instanceof PackageRequestDto) {
                continue;
            }

            if ($package->items === []) {
                $errors[] = sprintf('packages[%d].items must not be empty.', $index);
            }
        }

        return $errors;
    }
}

