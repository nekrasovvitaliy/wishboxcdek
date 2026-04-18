<?php

declare(strict_types=1);

namespace WishboxCdek\Validation\Order\Rule;

use WishboxCdek\Request\Order\UpdateOrderRequest;
use WishboxCdek\Validation\Order\SenderContactDtoValidator;

final class UpdateSenderValidationRule implements UpdateOrderValidationRule
{
    public function __construct(
        private readonly SenderContactDtoValidator $senderValidator,
    ) {
    }

    public function validate(UpdateOrderRequest $request): array
    {
        if ($request->sender === null) {
            return [];
        }

        return $this->senderValidator->validate($request->sender);
    }
}
