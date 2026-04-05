<?php

declare(strict_types=1);

namespace WishboxCdek\Validation\Prealert;

use WishboxCdek\Exception\PrealertValidationException;
use WishboxCdek\Request\Prealert\RegisterPrealertRequest;
use WishboxCdek\Validation\Prealert\Rule\OrderIdentifierRequiredRule;
use WishboxCdek\Validation\Prealert\Rule\OrdersRequiredRule;
use WishboxCdek\Validation\Prealert\Rule\PlannedDateRequiredRule;
use WishboxCdek\Validation\Prealert\Rule\RegisterPrealertValidationRule;
use WishboxCdek\Validation\Prealert\Rule\ShipmentPointRequiredRule;

final class RegisterPrealertRequestValidator
{
    /**
     * @var list<RegisterPrealertValidationRule>
     */
    private readonly array $rules;

    /**
     * @param list<RegisterPrealertValidationRule>|null $rules
     */
    public function __construct(?array $rules = null)
    {
        $this->rules = $rules ?? [
            new PlannedDateRequiredRule(),
            new ShipmentPointRequiredRule(),
            new OrdersRequiredRule(),
            new OrderIdentifierRequiredRule(),
        ];
    }

    public function validate(RegisterPrealertRequest $request): void
    {
        $errors = [];

        foreach ($this->rules as $rule) {
            array_push($errors, ...$rule->validate($request));
        }

        if ($errors !== []) {
            throw new PrealertValidationException($errors);
        }
    }
}
