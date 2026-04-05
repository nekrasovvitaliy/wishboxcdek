<?php

declare(strict_types=1);

namespace WishboxCdek\Validation\Delivery;

use WishboxCdek\Exception\DeliveryValidationException;
use WishboxCdek\Request\Delivery\RegisterDeliveryRequest;
use WishboxCdek\Validation\Delivery\Rule\DateRequiredRule;
use WishboxCdek\Validation\Delivery\Rule\DeliveryPointAndToLocationExclusiveRule;
use WishboxCdek\Validation\Delivery\Rule\DeliveryTargetRequiredRule;
use WishboxCdek\Validation\Delivery\Rule\OrderIdentifierRequiredRule;
use WishboxCdek\Validation\Delivery\Rule\RegisterDeliveryValidationRule;
use WishboxCdek\Validation\Delivery\Rule\TimeIntervalPairRule;

final class RegisterDeliveryRequestValidator
{
    /**
     * @var list<RegisterDeliveryValidationRule>
     */
    private readonly array $rules;

    /**
     * @param list<RegisterDeliveryValidationRule>|null $rules
     */
    public function __construct(?array $rules = null)
    {
        $this->rules = $rules ?? [
            new OrderIdentifierRequiredRule(),
            new DateRequiredRule(),
            new DeliveryTargetRequiredRule(),
            new DeliveryPointAndToLocationExclusiveRule(),
            new TimeIntervalPairRule(),
        ];
    }

    public function validate(RegisterDeliveryRequest $request): void
    {
        $errors = [];

        foreach ($this->rules as $rule) {
            array_push($errors, ...$rule->validate($request));
        }

        if ($errors !== []) {
            throw new DeliveryValidationException($errors);
        }
    }
}