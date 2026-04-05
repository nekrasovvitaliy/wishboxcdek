<?php

declare(strict_types=1);

namespace WishboxCdek\Validation\Prealert\Rule;

use WishboxCdek\Request\Prealert\RegisterPrealertRequest;

final class OrderIdentifierRequiredRule implements RegisterPrealertValidationRule
{
    public function validate(RegisterPrealertRequest $request): array
    {
        $errors = [];

        foreach ($request->orders as $index => $order) {
            $hasIdentifier = $order->orderUuid !== null
                || $order->cdekNumber !== null
                || $order->imNumber !== null;

            if (! $hasIdentifier) {
                $errors[] = sprintf(
                    'orders[%d] must contain at least one of: order_uuid, cdek_number, im_number.',
                    $index
                );
            }
        }

        return $errors;
    }
}
