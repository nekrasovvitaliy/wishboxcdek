<?php

declare(strict_types=1);

namespace WishboxCdek\Validation\Order;

use WishboxCdek\Exception\OrderValidationException;
use WishboxCdek\Request\Order\UpdateOrderRequest;
use WishboxCdek\Validation\Order\Rule\DeliverySenderRequiredRule;
use WishboxCdek\Validation\Order\Rule\UpdateOrderValidationRule;
use WishboxCdek\Validation\Order\Rule\UpdateSenderValidationRule;

final class UpdateOrderRequestValidator
{
    /**
     * @var list<UpdateOrderValidationRule>
     */
    private readonly array $rules;

    /**
     * @param list<UpdateOrderValidationRule>|null $rules
     */
    public function __construct(?array $rules = null)
    {
        $this->rules = $rules ?? [
            new DeliverySenderRequiredRule(),
            new UpdateSenderValidationRule(new SenderContactDtoValidator()),
        ];
    }

    public function validate(UpdateOrderRequest $request): void
    {
        $errors = [];

        foreach ($this->rules as $rule) {
            array_push($errors, ...$rule->validate($request));
        }

        if ($errors !== []) {
            throw new OrderValidationException($errors);
        }
    }
}
