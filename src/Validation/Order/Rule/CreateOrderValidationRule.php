<?php

declare(strict_types=1);

namespace WishboxCdek\Validation\Order\Rule;

use WishboxCdek\Request\Order\CreateOrderRequest;

interface CreateOrderValidationRule
{
    /**
     * @return list<string>
     */
    public function validate(CreateOrderRequest $request): array;
}
