<?php

declare(strict_types=1);

namespace Tests\Unit\Request\Order;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use WishboxCdek\Enum\AdditionalOrderType;
use WishboxCdek\Enum\OrderPrint;
use WishboxCdek\Enum\OrderType;
use WishboxCdek\Exception\OrderValidationException;
use WishboxCdek\Request\Order\OrderCreateRequestDto;
use WishboxCdek\Request\Order\DeliveryCostThresholdDto;
use WishboxCdek\Request\Order\DeliveryRecipientCostRequestDto;
use WishboxCdek\Request\Order\MoneyDto;
use WishboxCdek\Request\Order\PackageRequestDto;
use WishboxCdek\Request\Order\ItemRequestDto;
use WishboxCdek\Request\Order\PhoneDto;
use WishboxCdek\Request\Order\AdditionalServiceRequestDto;
use WishboxCdek\Request\Order\RecipientContactDto;
use WishboxCdek\Request\Order\RequestFromLocationDto;
use WishboxCdek\Request\Order\RequestToLocationDto;
use WishboxCdek\Request\Order\SenderContactDto;
use WishboxCdek\Request\Order\SellerDto;
use WishboxCdek\Validation\Order\CreateOrderRequestValidator;

final class OrderCreateRequestDtoTest extends TestCase
{
    public function test_recipient_contact_dto_rejects_non_phone_dto_items(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('RecipientContactDto expects phones to contain only WishboxCdek\Request\Order\PhoneDto instances, string given at index 0.');

        new RecipientContactDto(
            name: 'Sender',
            phones: ['+79990000001'],
        );
    }

    public function test_request_to_location_dto_requires_non_empty_address(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('RequestToLocationDto expects address to be a non-empty string.');

        new RequestToLocationDto(address: '   ');
    }

    public function test_request_to_location_dto_rejects_too_long_address(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('RequestToLocationDto expects address to be at most 255 characters long.');

        new RequestToLocationDto(address: str_repeat('a', 256));
    }

    public function test_to_array_serializes_nested_order_objects(): void
    {
        $request = OrderCreateRequestDto::make(
            tariffCode: 136,
            sender: new SenderContactDto(
                name: 'Wishbox Sender',
                phones: [
                    new PhoneDto(number: '+79990000001'),
                ],
                contragentType: 'LEGAL_ENTITY',
                email: 'sender@example.com',
            ),
            recipient: new RecipientContactDto(
                name: 'John Doe',
                phones: [
                    new PhoneDto(number: '+79990000002', additional: '123'),
                ],
                email: 'john@example.com',
            ),
            packages: [
                new PackageRequestDto(
                    number: 'PKG-1',
                    weight: 1000,
                    length: 10,
                    width: 20,
                    height: 30,
                    items: [
                        new ItemRequestDto(
                            name: 'Sneakers',
                            wareKey: 'SKU-1',
                            payment: new MoneyDto(value: 3500),
                            cost: 3500,
                            weight: 500,
                            amount: 1,
                        ),
                    ],
                ),
            ],
        )
            ->withType(OrderType::INTERNET_SHOP)
            ->withAdditionalOrderTypes([
                AdditionalOrderType::LTL,
                AdditionalOrderType::FORWARD_EXPRESS,
            ])
            ->withNumber('ORDER-1')
            ->withComment('Test order')
            ->withShipmentPoint('MSK1')
            ->withDateInvoice('2026-03-29')
            ->withShipperName('Wishbox Logistics')
            ->withShipperAddress('Sender warehouse 1')
            ->withSeller(new SellerDto(name: 'Wishbox Seller', inn: '7701234567'))
            ->withFromLocation(new RequestFromLocationDto(code: 44, address: 'Sender street 1'))
            ->withToLocation(new RequestToLocationDto(address: 'Nevsky 1', code: 137, city: 'Saint Petersburg'))
            ->withDeliveryRecipientCost(new DeliveryRecipientCostRequestDto(value: 500, vatRate: 0))
            ->withDeliveryRecipientCostAdv([
                new DeliveryCostThresholdDto(threshold: 5000, sum: 250, vatRate: 0),
            ])
            ->withServices([
                new AdditionalServiceRequestDto(code: 'TRYING_ON', parameter: 1),
            ])
            ->withIsClientReturn(false)
            ->withHasReverseOrder(true)
            ->withDeveloperKey('wishbox-dev')
            ->withPrint(OrderPrint::WAYBILL)
            ->withWidgetToken('widget-token')
            ->withDeliveryTypes([OrderType::DELIVERY]);

        self::assertSame([
            'type' => 1,
            'additional_order_types' => [2, 9],
            'number' => 'ORDER-1',
            'tariff_code' => 136,
            'comment' => 'Test order',
            'shipment_point' => 'MSK1',
            'date_invoice' => '2026-03-29',
            'shipper_name' => 'Wishbox Logistics',
            'shipper_address' => 'Sender warehouse 1',
            'delivery_recipient_cost' => [
                'value' => 500,
                'vat_rate' => 0,
            ],
            'delivery_recipient_cost_adv' => [
                [
                    'threshold' => 5000,
                    'sum' => 250,
                    'vat_rate' => 0,
                ],
            ],
            'sender' => [
                'name' => 'Wishbox Sender',
                'contragent_type' => 'LEGAL_ENTITY',
                'email' => 'sender@example.com',
                'phones' => [
                    [
                        'number' => '+79990000001',
                    ],
                ],
            ],
            'seller' => [
                'name' => 'Wishbox Seller',
                'inn' => '7701234567',
            ],
            'recipient' => [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'phones' => [
                    [
                        'number' => '+79990000002',
                        'additional' => '123',
                    ],
                ],
            ],
            'from_location' => [
                'code' => 44,
                'address' => 'Sender street 1',
            ],
            'to_location' => [
                'code' => 137,
                'city' => 'Saint Petersburg',
                'address' => 'Nevsky 1',
            ],
            'services' => [
                [
                    'code' => 'TRYING_ON',
                    'parameter' => 1,
                ],
            ],
            'packages' => [
                [
                    'number' => 'PKG-1',
                    'weight' => 1000,
                    'length' => 10,
                    'width' => 20,
                    'height' => 30,
                    'items' => [
                        [
                            'name' => 'Sneakers',
                            'ware_key' => 'SKU-1',
                            'payment' => [
                                'value' => 3500,
                            ],
                            'weight' => 500,
                            'amount' => 1,
                            'cost' => 3500,
                        ],
                    ],
                ],
            ],
            'delivery_types' => [2],
            'widgetToken' => 'widget-token',
            'is_client_return' => false,
            'has_reverse_order' => true,
            'developer_key' => 'wishbox-dev',
            'print' => 'WAYBILL',
        ], $request->toArray());
    }

    public function test_make_rejects_non_package_dto_items(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('OrderCreateRequestDto expects packages to contain only WishboxCdek\Request\Order\PackageRequestDto instances, string given at index 0.');

        OrderCreateRequestDto::make(
            tariffCode: 136,
            sender: new SenderContactDto(
                name: 'Sender',
                phones: [new PhoneDto(number: '+79990000001')],
            ),
            recipient: new RecipientContactDto(
                name: 'Recipient',
                phones: [new PhoneDto(number: '+79990000002')],
            ),
            packages: ['not-a-package'],
        );
    }

    public function test_with_additional_order_types_rejects_non_enum_items(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('OrderCreateRequestDto expects additionalOrderTypes to contain only WishboxCdek\Enum\AdditionalOrderType instances, string given at index 0.');

        OrderCreateRequestDto::make(
            tariffCode: 136,
            sender: new SenderContactDto(
                name: 'Sender',
                phones: [new PhoneDto(number: '+79990000001')],
            ),
            recipient: new RecipientContactDto(
                name: 'Recipient',
                phones: [new PhoneDto(number: '+79990000002')],
            ),
            packages: [
                new PackageRequestDto(number: 'PKG-1', weight: 1000),
            ],
        )->withAdditionalOrderTypes(['LTL']);
    }

    public function test_with_delivery_recipient_cost_adv_rejects_non_dto_items(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('OrderCreateRequestDto expects deliveryRecipientCostAdv to contain only WishboxCdek\Request\Order\DeliveryCostThresholdDto instances, string given at index 0.');

        OrderCreateRequestDto::make(
            tariffCode: 136,
            sender: new SenderContactDto(
                name: 'Sender',
                phones: [new PhoneDto(number: '+79990000001')],
            ),
            recipient: new RecipientContactDto(
                name: 'Recipient',
                phones: [new PhoneDto(number: '+79990000002')],
            ),
            packages: [
                new PackageRequestDto(number: 'PKG-1', weight: 1000),
            ],
        )->withDeliveryRecipientCostAdv(['bad-item']);
    }

    public function test_with_services_rejects_non_dto_items(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('OrderCreateRequestDto expects services to contain only WishboxCdek\Request\Order\AdditionalServiceRequestDto instances, string given at index 0.');

        OrderCreateRequestDto::make(
            tariffCode: 136,
            sender: new SenderContactDto(
                name: 'Sender',
                phones: [new PhoneDto(number: '+79990000001')],
            ),
            recipient: new RecipientContactDto(
                name: 'Recipient',
                phones: [new PhoneDto(number: '+79990000002')],
            ),
            packages: [
                new PackageRequestDto(number: 'PKG-1', weight: 1000),
            ],
        )->withServices(['bad-service']);
    }

    public function test_validator_requires_delivery_point_for_warehouse_tariff(): void
    {
        $validator = new CreateOrderRequestValidator();
        $request = OrderCreateRequestDto::make(
            tariffCode: 136,
            sender: new SenderContactDto(
                name: 'Sender',
                phones: [new PhoneDto(number: '+79990000001')],
            ),
            recipient: new RecipientContactDto(
                name: 'Recipient',
                phones: [new PhoneDto(number: '+79990000002')],
            ),
            packages: [
                new PackageRequestDto(
                    number: 'PKG-1',
                    weight: 1000,
                    items: [
                        new ItemRequestDto(
                            name: 'Item',
                            wareKey: 'SKU-1',
                            payment: new MoneyDto(value: 1000),
                            cost: 1000,
                            weight: 1000,
                            amount: 1,
                        ),
                    ],
                ),
            ],
        )
            ->withToLocation(new RequestToLocationDto(address: 'Pushkina 1', code: 137));

        try {
            $validator->validate($request);
            self::fail('Expected OrderValidationException was not thrown.');
        } catch (OrderValidationException $exception) {
            self::assertSame('delivery_point is required for tariff 136.', $exception->getMessage());
            self::assertSame(['delivery_point is required for tariff 136.'], $exception->getErrors());
        }
    }

    public function test_validator_requires_to_location_for_door_tariff(): void
    {
        $validator = new CreateOrderRequestValidator();
        $request = OrderCreateRequestDto::make(
            tariffCode: 137,
            sender: new SenderContactDto(
                name: 'Sender',
                phones: [new PhoneDto(number: '+79990000001')],
            ),
            recipient: new RecipientContactDto(
                name: 'Recipient',
                phones: [new PhoneDto(number: '+79990000002')],
            ),
            packages: [
                new PackageRequestDto(
                    number: 'PKG-1',
                    weight: 1000,
                    items: [
                        new ItemRequestDto(
                            name: 'Item',
                            wareKey: 'SKU-1',
                            payment: new MoneyDto(value: 1000),
                            cost: 1000,
                            weight: 1000,
                            amount: 1,
                        ),
                    ],
                ),
            ],
        );

        try {
            $validator->validate($request);
            self::fail('Expected OrderValidationException was not thrown.');
        } catch (OrderValidationException $exception) {
            self::assertSame('to_location is required.', $exception->getMessage());
            self::assertSame(['to_location is required.'], $exception->getErrors());
        }
    }

    public function test_validator_requires_package_items(): void
    {
        $validator = new CreateOrderRequestValidator();
        $request = OrderCreateRequestDto::make(
            tariffCode: 139,
            sender: new SenderContactDto(
                name: 'Sender',
                phones: [new PhoneDto(number: '+79990000001')],
            ),
            recipient: new RecipientContactDto(
                name: 'Recipient',
                phones: [new PhoneDto(number: '+79990000002')],
            ),
            packages: [
                new PackageRequestDto(number: 'PKG-1', weight: 1000),
            ],
        )
            ->withToLocation(new RequestToLocationDto(address: 'Pushkina 1', code: 137));

        try {
            $validator->validate($request);
            self::fail('Expected OrderValidationException was not thrown.');
        } catch (OrderValidationException $exception) {
            self::assertSame('packages[0].items must not be empty.', $exception->getMessage());
            self::assertSame(['packages[0].items must not be empty.'], $exception->getErrors());
        }
    }
}




