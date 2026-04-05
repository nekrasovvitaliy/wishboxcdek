<?php

declare(strict_types=1);

namespace WishboxCdek\Validation\Prealert\Rule;

use WishboxCdek\Request\Prealert\RegisterPrealertRequest;

final class PlannedDateRequiredRule implements RegisterPrealertValidationRule
{
    public function validate(RegisterPrealertRequest $request): array
    {
        if (trim($request->plannedDate) !== '') {
            return [];
        }

        return ['planned_date is required.'];
    }
}
