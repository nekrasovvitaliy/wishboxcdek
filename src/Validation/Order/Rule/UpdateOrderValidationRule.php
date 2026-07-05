<?php

declare(strict_types=1);

namespace WishboxCdek\Validation\Order\Rule;

use WishboxCdek\Request\Order\OrderUpdateRequestDto;

interface UpdateOrderValidationRule
{
    /**
     * @return list<string>
     */
    public function validate(OrderUpdateRequestDto $request): array;
}
