<?php

declare(strict_types=1);

namespace Tests\Integration\Support;

use WishboxCdek\Request\Order\CreateOrderRequest;
use WishboxCdek\Request\Order\ContactDto;
use WishboxCdek\Request\Order\MoneyDto;
use WishboxCdek\Request\Order\PackageRequestDto;
use WishboxCdek\Request\Order\ItemRequestDto;
use WishboxCdek\Request\Order\PhoneDto;
use WishboxCdek\Request\Order\RequestFromLocationDto;
use WishboxCdek\Request\Order\RequestToLocationDto;
use WishboxCdek\Request\Order\SenderContactDto;

trait CreatesOrderRequests
{
    protected function createValidOrderRequest(): CreateOrderRequest
    {
        return CreateOrderRequest::make(
            tariffCode: 137,
            sender: new SenderContactDto(
                name: 'Wishbox Sender',
                phones: [
                    new PhoneDto(number: '+79990000001'),
                ],
            ),
            recipient: new ContactDto(
                name: 'Wishbox Recipient',
                phones: [
                    new PhoneDto(number: '+79990000002'),
                ],
            ),
            packages: [
                new PackageRequestDto(
                    number: 'PKG-1',
                    weight: 1000,
                    length: 10,
                    width: 10,
                    height: 10,
                    items: [
                        new ItemRequestDto(
                            name: 'Integration test item',
                            wareKey: 'WB-TEST-SKU-1',
                            payment: new MoneyDto(value: 1000),
                            cost: 1000,
                            weight: 1000,
                            amount: 1,
                        ),
                    ],
                ),
            ],
        )
            ->withNumber('WB-IT-' . date('YmdHis') . '-' . random_int(1000, 9999))
            ->withComment('Integration test order')
            ->withFromLocation(new RequestFromLocationDto(code: 44))
            ->withToLocation(new RequestToLocationDto(
                code: 137,
                address: 'Pushkina 1',
            ));
    }
}






