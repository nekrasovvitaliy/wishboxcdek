<?php

declare(strict_types=1);

namespace WishboxCdek\Validation\Delivery\Rule;

use WishboxCdek\Request\Delivery\RegisterDeliveryRequest;

interface RegisterDeliveryValidationRule
{
    /**
     * @return list<string>
     */
    public function validate(RegisterDeliveryRequest $request): array;
}