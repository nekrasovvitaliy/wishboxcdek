<?php

declare(strict_types=1);

namespace Tests\Integration;

use WishboxCdek\Enum\Language;
use WishboxCdek\Request\Calculator\CalcPackageResponseDto;
use WishboxCdek\Request\Calculator\CalculatorLocationDto;
use WishboxCdek\Request\Calculator\CalculatorTariffListRequestDto;
use WishboxCdek\Response\Calculator\CalculatorTariffListResponseDto;
use WishboxCdek\Response\Calculator\TariffCodeDto;

final class CalculatorApiIntegrationTest extends CdekIntegrationTestCase
{
    public function test_calculate_tariff_list_returns_typed_response(): void
    {
        $client = $this->createClient();

        $request = new CalculatorTariffListRequestDto(
            fromLocation: new CalculatorLocationDto(code: 44),
            toLocation: new CalculatorLocationDto(code: 137),
            packages: [
                new CalcPackageResponseDto(weight: 1000, length: 10, width: 10, height: 10),
            ],
            lang: Language::RUS,
        );

        $response = $client->calculator()->calculateTariffList($request);

        self::assertInstanceOf(CalculatorTariffListResponseDto::class, $response);
        self::assertNotEmpty($response->tariffCodes);
        self::assertContainsOnlyInstancesOf(TariffCodeDto::class, $response->tariffCodes);
        self::assertNotNull($response->tariffCodes[0]->tariffCode);
        self::assertNotSame('', $response->tariffCodes[0]->tariffName ?? '');
    }
}
