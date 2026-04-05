<?php

declare(strict_types=1);

namespace Tests\Unit\Request\Calculator;

use PHPUnit\Framework\TestCase;
use WishboxCdek\Enum\AdditionalOrderType;
use WishboxCdek\Enum\Language;
use WishboxCdek\Enum\OrderType;
use WishboxCdek\Request\Calculator\CalculateTariffListRequest;
use WishboxCdek\Request\Calculator\LocationDto;
use WishboxCdek\Request\Calculator\PackageDto;

final class CalculateTariffListRequestTest extends TestCase
{
    public function test_to_array_serializes_calculator_lang_enum(): void
    {
        $request = new CalculateTariffListRequest(
            fromLocation: new LocationDto(code: 44),
            toLocation: new LocationDto(code: 137),
            packages: [
                new PackageDto(weight: 1000, length: 10, width: 20, height: 30),
            ],
            type: OrderType::INTERNET_SHOP,
            additionalOrderTypes: [AdditionalOrderType::LTL],
            currency: 'RUB',
            date: '2025-03-24T14:15:22+0700',
            lang: Language::ENG,
        );

        self::assertSame([
            'date' => '2025-03-24T14:15:22+0700',
            'type' => 1,
            'additional_order_types' => [2],
            'currency' => 'RUB',
            'lang' => 'eng',
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
        $request = new CalculateTariffListRequest(
            fromLocation: new LocationDto(code: 44),
            toLocation: new LocationDto(code: 137),
            packages: [new PackageDto(weight: 1000)],
        );

        self::assertArrayNotHasKey('lang', $request->toArray());
    }
}



