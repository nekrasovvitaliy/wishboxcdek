<?php

declare(strict_types=1);

namespace WishboxCdek\Validation\Order\Rule;

use WishboxCdek\Request\Order\OrderUpdateRequestDto;
use WishboxCdek\Validation\Order\SenderContactDtoValidator;

final class UpdateSenderValidationRule implements UpdateOrderValidationRule
{
    public function __construct(
        private readonly SenderContactDtoValidator $senderValidator,
    ) {
    }

    public function validate(OrderUpdateRequestDto $request): array
    {
        if ($request->sender === null) {
            return [];
        }

        return $this->senderValidator->validate($request->sender);
    }
}
