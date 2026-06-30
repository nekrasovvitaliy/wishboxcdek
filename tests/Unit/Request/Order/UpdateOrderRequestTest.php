<?php

declare(strict_types=1);

namespace Tests\Unit\Request\Order;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use WishboxCdek\Enum\AdditionalOrderType;
use WishboxCdek\Enum\OrderPrint;
use WishboxCdek\Enum\OrderType;
use WishboxCdek\Request\Order\AdditionalServiceRequestDto;
use WishboxCdek\Request\Order\ContactDto;
use WishboxCdek\Request\Order\DeliveryRecipientCostAdvDto;
use WishboxCdek\Request\Order\ItemRequestDto;
use WishboxCdek\Request\Order\LocationDto1;
use WishboxCdek\Request\Order\MoneyDto;
use WishboxCdek\Request\Order\PackageRequestDto;
use WishboxCdek\Request\Order\PhoneDto;
use WishboxCdek\Request\Order\SenderContactDto;
use WishboxCdek\Request\Order\SellerDto;
use WishboxCdek\Request\Order\UpdateOrderRequest;

final class UpdateOrderRequestTest extends TestCase
{
    public function test_make_allows_missing_sender_for_internet_shop(): void
    {
        $request = UpdateOrderRequest::make(
            type: OrderType::INTERNET_SHOP,
            tariffCode: 136,
            recipient: new ContactDto(
                name: 'Recipient',
                phones: [new PhoneDto(number: '+79990000002')],
            ),
            packages: [
                new PackageRequestDto(number: 'PKG-1', weight: 1000),
            ],
        )->withUuid('order-uuid');

        self::assertNull($request->sender);
        self::assertSame([
            'type' => 1,
            'uuid' => 'order-uuid',
            'tariff_code' => 136,
            'recipient' => [
                'name' => 'Recipient',
                'phones' => [
                    ['number' => '+79990000002'],
                ],
            ],
            'packages' => [
                [
                    'number' => 'PKG-1',
                    'weight' => 1000,
                ],
            ],
        ], $request->toArray());
    }

    public function test_to_array_requires_sender_for_delivery(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('WishboxCdek\Request\Order\UpdateOrderRequest expects sender to be provided for DELIVERY orders.');

        UpdateOrderRequest::make(
            type: OrderType::DELIVERY,
            tariffCode: 136,
            recipient: new ContactDto(
                name: 'Recipient',
                phones: [new PhoneDto(number: '+79990000002')],
            ),
            packages: [
                new PackageRequestDto(number: 'PKG-1', weight: 1000),
            ],
        )->withUuid('order-uuid')->toArray();
    }

    public function test_make_rejects_non_package_dto_items(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('WishboxCdek\Request\Order\UpdateOrderRequest expects packages to contain only WishboxCdek\Request\Order\PackageRequestDto instances, string given at index 0.');

        UpdateOrderRequest::make(
            type: OrderType::INTERNET_SHOP,
            tariffCode: 136,
            recipient: new ContactDto(
                name: 'Recipient',
                phones: [new PhoneDto(number: '+79990000002')],
            ),
            packages: ['not-a-package'],
        )->withUuid('order-uuid');
    }

    public function test_with_additional_order_types_rejects_non_enum_items(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('WishboxCdek\Request\Order\UpdateOrderRequest expects additionalOrderTypes to contain only WishboxCdek\Enum\AdditionalOrderType instances, string given at index 0.');

        UpdateOrderRequest::make(
            type: OrderType::INTERNET_SHOP,
            tariffCode: 136,
            recipient: new ContactDto(
                name: 'Recipient',
                phones: [new PhoneDto(number: '+79990000002')],
            ),
            packages: [
                new PackageRequestDto(number: 'PKG-1', weight: 1000),
            ],
        )->withUuid('order-uuid')->withAdditionalOrderTypes(['LTL']);
    }

    public function test_with_delivery_recipient_cost_adv_rejects_non_dto_items(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('WishboxCdek\Request\Order\UpdateOrderRequest expects deliveryRecipientCostAdv to contain only WishboxCdek\Request\Order\DeliveryRecipientCostAdvDto instances, string given at index 0.');

        UpdateOrderRequest::make(
            type: OrderType::INTERNET_SHOP,
            tariffCode: 136,
            recipient: new ContactDto(
                name: 'Recipient',
                phones: [new PhoneDto(number: '+79990000002')],
            ),
            packages: [
                new PackageRequestDto(number: 'PKG-1', weight: 1000),
            ],
        )->withUuid('order-uuid')->withDeliveryRecipientCostAdv(['bad-item']);
    }

    public function test_with_services_rejects_non_dto_items(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('WishboxCdek\Request\Order\UpdateOrderRequest expects services to contain only WishboxCdek\Request\Order\AdditionalServiceRequestDto instances, string given at index 0.');

        UpdateOrderRequest::make(
            type: OrderType::INTERNET_SHOP,
            tariffCode: 136,
            recipient: new ContactDto(
                name: 'Recipient',
                phones: [new PhoneDto(number: '+79990000002')],
            ),
            packages: [
                new PackageRequestDto(number: 'PKG-1', weight: 1000),
            ],
        )->withUuid('order-uuid')->withServices(['bad-service']);
    }

    public function test_to_array_serializes_update_order_request(): void
    {
        $request = UpdateOrderRequest::make(
            type: OrderType::INTERNET_SHOP,
            tariffCode: 136,
            recipient: new ContactDto(
                name: 'John Doe',
                phones: [new PhoneDto(number: '+79990000002', additional: '123')],
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
            ->withSender(new SenderContactDto(
                name: 'Wishbox Sender',
                phones: [new PhoneDto(number: '+79990000001')],
                contragentType: 'LEGAL_ENTITY',
                email: 'sender@example.com',
            ))
            ->withUuid('order-uuid')
            ->withCdekNumber('1234567890')
            ->withAdditionalOrderTypes([
                AdditionalOrderType::LTL,
                AdditionalOrderType::FORWARD_EXPRESS,
            ])
            ->withNumber('ORDER-1')
            ->withComment('Update order')
            ->withShipmentPoint('MSK1')
            ->withDateInvoice('2026-03-29')
            ->withShipperName('Wishbox Logistics')
            ->withShipperAddress('Sender warehouse 1')
            ->withSeller(new SellerDto(name: 'Wishbox Seller', inn: '7701234567'))
            ->withFromLocation(new LocationDto1(code: 44, address: 'Sender street 1'))
            ->withToLocation(new LocationDto1(code: 137, city: 'Saint Petersburg'))
            ->withDeliveryRecipientCost(new MoneyDto(value: 500, vatRate: 0))
            ->withDeliveryRecipientCostAdv([
                new DeliveryRecipientCostAdvDto(threshold: 5000, sum: 250, vatRate: 0),
            ])
            ->withServices([
                new AdditionalServiceRequestDto(code: 'TRYING_ON', parameter: 1),
            ])
            ->withIsClientReturn(false)
            ->withHasReverseOrder(true)
            ->withDeveloperKey('wishbox-dev')
            ->withPrint(OrderPrint::WAYBILL)
            ->withWidgetToken('widget-token');

        self::assertSame([
            'uuid' => 'order-uuid',
            'type' => 1,
            'cdek_number' => '1234567890',
            'additional_order_types' => [2, 9],
            'number' => 'ORDER-1',
            'tariff_code' => 136,
            'comment' => 'Update order',
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
                    ['number' => '+79990000001'],
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
            'is_client_return' => false,
            'has_reverse_order' => true,
            'developer_key' => 'wishbox-dev',
            'print' => 'WAYBILL',
            'widget_token' => 'widget-token',
        ], $request->toArray());
    }

    public function test_to_array_requires_uuid_or_cdek_number(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('WishboxCdek\Request\Order\UpdateOrderRequest expects uuid or cdekNumber to be provided.');

        UpdateOrderRequest::make(
            type: OrderType::INTERNET_SHOP,
            tariffCode: 136,
            recipient: new ContactDto(
                name: 'Recipient',
                phones: [new PhoneDto(number: '+79990000002')],
            ),
            packages: [
                new PackageRequestDto(number: 'PKG-1', weight: 1000),
            ],
        )->toArray();
    }
}
