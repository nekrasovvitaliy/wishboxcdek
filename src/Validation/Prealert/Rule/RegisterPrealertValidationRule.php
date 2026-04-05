<?php

declare(strict_types=1);

namespace WishboxCdek\Validation\Prealert\Rule;

use WishboxCdek\Request\Prealert\RegisterPrealertRequest;

interface RegisterPrealertValidationRule
{
    /**
     * @return list<string>
     */
    public function validate(RegisterPrealertRequest $request): array;
}
