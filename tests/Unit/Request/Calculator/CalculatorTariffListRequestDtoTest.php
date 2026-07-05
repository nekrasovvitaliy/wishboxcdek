<?php

declare(strict_types=1);

namespace Tests\Unit\Request\Calculator;

use PHPUnit\Framework\TestCase;
use WishboxCdek\Enum\AdditionalOrderType;
use WishboxCdek\Enum\Language;
use WishboxCdek\Enum\OrderType;
use WishboxCdek\Request\Calculator\CalcPackageRequestDto;
use WishboxCdek\Request\Calculator\CalculatorLocationDto;
use WishboxCdek\Request\Calculator\CalculatorTariffListRequestDto;

final class CalculatorTariffListRequestDtoTest extends TestCase
{
    public function test_to_array_serializes_calculator_lang_enum(): void
    {
        $request = new CalculatorTariffListRequestDto(
            fromLocation: new CalculatorLocationDto(code: 44),
            toLocation: new CalculatorLocationDto(code: 137),
            packages: [
                new CalcPackageRequestDto(weight: 1000, length: 10, width: 20, height: 30),
            ],
            type: OrderType::INTERNET_SHOP,
            additionalOrderTypes: [AdditionalOrderType::LTL],
            currency: 1,
            date: '2025-03-24T14:15:22+0700',
            lang: Language::ENG,
            shipmentPoint: 'MSK123',
            deliveryPoint: 'SPB456',
        );

        self::assertSame([
            'date' => '2025-03-24T14:15:22+0700',
            'type' => 1,
            'additional_order_types' => [2],
            'currency' => 1,
            'lang' => 'eng',
            'shipment_point' => 'MSK123',
            'delivery_point' => 'SPB456',
            'from_location' => [
                'code' => 44,
            ],
            'to_location' => [
                'code' => 137,
            ],
            'packages' => [
                [
                    'weight' => 1000,
                    'length' => 10,
                    'width' => 20,
                    'height' => 30,
                ],
            ],
        ], $request->toArray());
    }

    public function test_to_array_omits_lang_when_not_provided(): void
    {
        $request = new CalculatorTariffListRequestDto(
            fromLocation: new CalculatorLocationDto(code: 44),
            toLocation: new CalculatorLocationDto(code: 137),
            packages: [new CalcPackageRequestDto(weight: 1000)],
        );

        self::assertArrayNotHasKey('lang', $request->toArray());
    }
}
