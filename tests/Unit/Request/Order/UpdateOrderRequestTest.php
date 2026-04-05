<?php

declare(strict_types=1);

namespace Tests\Unit\Request\Order;

use PHPUnit\Framework\TestCase;
use WishboxCdek\Enum\AdditionalOrderType;
use WishboxCdek\Enum\OrderType;
use WishboxCdek\Request\Order\AdditionalServiceRequestDto;
use WishboxCdek\Request\Order\ContactDto;
use WishboxCdek\Request\Order\DeliveryRecipientCostAdvDto;
use WishboxCdek\Request\Order\ItemRequestDto;
use WishboxCdek\Request\Order\LocationDto;
use WishboxCdek\Request\Order\MoneyDto;
use WishboxCdek\Request\Order\PackageRequestDto;
use WishboxCdek\Request\Order\PhoneDto;
use WishboxCdek\Request\Order\SellerDto;
use WishboxCdek\Request\Order\UpdateOrderRequest;

final class UpdateOrderRequestTest extends TestCase
{
    public function test_to_array_serializes_update_order_request(): void
    {
        $request = UpdateOrderRequest::make(
            type: OrderType::INTERNET_SHOP,
            tariffCode: 136,
            sender: new ContactDto(
                name: 'Wishbox Sender',
                phones: [new PhoneDto(number: '+79990000001')],
                contragentType: 'LEGAL_ENTITY',
                email: 'sender@example.com',
            ),
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
            ->withFromLocation(new LocationDto(code: 44, address: 'Sender street 1'))
            ->withToLocation(new LocationDto(code: 137, city: 'Saint Petersburg'))
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
            ->withPrint('WAYBILL')
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
}
