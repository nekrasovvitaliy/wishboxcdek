<?php

declare(strict_types=1);

namespace Tests\Unit\Request\DeliveryPoint;

use PHPUnit\Framework\TestCase;
use WishboxCdek\Enum\Language;
use WishboxCdek\Request\DeliveryPoint\GetDeliveryPointsRequest;

final class GetDeliveryPointsRequestTest extends TestCase
{
    public function test_to_array_serializes_delivery_point_lang_enum(): void
    {
        $request = new GetDeliveryPointsRequest(
            cityCode: 44,
            haveCash: true,
            size: 10,
            lang: Language::ENG,
        );

        self::assertSame([
            'city_code' => 44,
            'have_cash' => true,
            'size' => 10,
            'lang' => 'eng',
        ], $request->toArray());
    }

    public function test_to_array_omits_lang_when_not_provided(): void
    {
        $request = new GetDeliveryPointsRequest(cityCode: 44);

        self::assertSame([
            'city_code' => 44,
        ], $request->toArray());
    }
}



