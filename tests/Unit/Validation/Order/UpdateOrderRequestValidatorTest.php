<?php

declare(strict_types=1);

namespace Tests\Unit\Validation\Order;

use PHPUnit\Framework\TestCase;
use WishboxCdek\Enum\OrderType;
use WishboxCdek\Exception\OrderValidationException;
use WishboxCdek\Request\Order\ContactDto;
use WishboxCdek\Request\Order\PackageRequestDto;
use WishboxCdek\Request\Order\PhoneDto;
use WishboxCdek\Request\Order\SenderContactDto;
use WishboxCdek\Request\Order\UpdateOrderRequest;
use WishboxCdek\Validation\Order\UpdateOrderRequestValidator;

final class UpdateOrderRequestValidatorTest extends TestCase
{
    public function test_validate_requires_sender_for_delivery(): void
    {
        $validator = new UpdateOrderRequestValidator();
        $request = UpdateOrderRequest::make(
            type: OrderType::DELIVERY,
            tariffCode: 136,
            recipient: new ContactDto(
                name: 'Recipient',
                phones: [new PhoneDto(number: '+79990000002')],
            ),
            packages: [
                new PackageRequestDto(weight: 1000),
            ],
        );

        $this->expectException(OrderValidationException::class);
        $this->expectExceptionMessage('sender is required for delivery orders.');

        $validator->validate($request);
    }

    public function test_validate_propagates_sender_errors(): void
    {
        $validator = new UpdateOrderRequestValidator();
        $request = UpdateOrderRequest::make(
            type: OrderType::INTERNET_SHOP,
            tariffCode: 136,
            recipient: new ContactDto(
                name: 'Recipient',
                phones: [new PhoneDto(number: '+79990000002')],
            ),
            packages: [
                new PackageRequestDto(weight: 1000),
            ],
        )->withSender(new SenderContactDto(
            name: '   ',
            phones: [new PhoneDto(number: '   ')],
        ));

        try {
            $validator->validate($request);
            self::fail('Expected OrderValidationException was not thrown.');
        } catch (OrderValidationException $exception) {
            self::assertSame(
                [
                    'sender.name is required.',
                    'sender.phones[0].number is required.',
                ],
                $exception->getErrors(),
            );
        }
    }
}
