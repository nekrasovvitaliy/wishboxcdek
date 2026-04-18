<?php

declare(strict_types=1);

namespace WishboxCdek\Validation\Order\Rule;

use WishboxCdek\Enum\OrderType;
use WishboxCdek\Request\Order\UpdateOrderRequest;

final class DeliverySenderRequiredRule implements UpdateOrderValidationRule
{
    public function validate(UpdateOrderRequest $request): array
    {
        if ($request->type === OrderType::DELIVERY && $request->sender === null) {
            return ['sender is required for delivery orders.'];
        }

        return [];
    }
}
