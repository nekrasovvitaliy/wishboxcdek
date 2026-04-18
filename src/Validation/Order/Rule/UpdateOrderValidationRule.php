<?php

declare(strict_types=1);

namespace WishboxCdek\Validation\Order\Rule;

use WishboxCdek\Request\Order\UpdateOrderRequest;

interface UpdateOrderValidationRule
{
    /**
     * @return list<string>
     */
    public function validate(UpdateOrderRequest $request): array;
}
