<?php

declare(strict_types=1);

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Tests\Support\Http\FakeHttpClient;
use Tests\Support\Http\FakeRequestFactory;
use Tests\Support\Http\FakeResponse;
use Tests\Support\Http\FakeStreamFactory;
use WishboxCdek\CdekClient;
use WishboxCdek\Enum\AdditionalOrderType;
use WishboxCdek\Enum\Language;
use WishboxCdek\Enum\OrderType;
use WishboxCdek\Request\Calculator\AdditionalServiceDto;
use WishboxCdek\Request\Calculator\CalcAdditionalServiceDto;
use WishboxCdek\Request\Calculator\CalcPackageResponseDto;
use WishboxCdek\Request\Calculator\CalculatorLocationDto;
use WishboxCdek\Request\Calculator\CalculatorRequestDto;
use WishboxCdek\Request\Calculator\CalculatorTariffListRequestDto;
use WishboxCdek\Request\Calculator\CalculateTariffWithServicesRequest;
use WishboxCdek\Request\Calculator\LocationDto;
use WishboxCdek\Response\Calculator\AvailableTariffCodeDto;
use WishboxCdek\Response\Calculator\AvailableTariffsResponse;
use WishboxCdek\Response\Calculator\CalculatorTariffListResponseDto;
use WishboxCdek\Response\Calculator\CalculateTariffResponse;
use WishboxCdek\Response\Calculator\ServiceCalculationDto;
use WishboxCdek\Response\Calculator\TariffCodeDto;

final class CalculatorApiTest extends TestCase
{
    public function test_calculate_tariff_list_sends_typed_request_payload(): void
    {
        $httpClient = new FakeHttpClient([
            new FakeResponse(200, '{"tariff_codes":[{"tariff_code":136,"tariff_name":"Посылка склад-склад","tariff_description":"Описание","delivery_mode":1,"delivery_sum":350,"period_min":2,"period_max":4,"calendar_min":2,"calendar_max":4,"delivery_date_range":{"min":"2022-02-02","max":"2022-02-04"}}],"errors":[{"code":"warned","additional_code":"0x01","message":"Minor issue"}],"warnings":[{"code":"warning_code","message":"Watch this"}]}'),
        ]);

        $client = new CdekClient(
            $httpClient,
            new FakeRequestFactory(),
            new FakeStreamFactory(),
            [
                'base_url' => CdekClient::SANDBOX_BASE_URL,
                'access_token' => 'test-token',
            ]
        );

        $request = new CalculatorTariffListRequestDto(
            fromLocation: new CalculatorLocationDto(
                code: 44,
                postalCode: '101000',
                countryCode: 'RU',
                city: 'Moscow',
                address: 'Tverskaya 1',
                contragentType: 'LEGAL_ENTITY',
                longitude: '37.6173',
                latitude: '55.7558',
            ),
            toLocation: new CalculatorLocationDto(
                code: 137,
                postalCode: '190000',
                countryCode: 'RU',
                city: 'Saint Petersburg',
                address: 'Nevsky 1',
                contragentType: 'LEGAL_ENTITY',
                longitude: '30.3141',
                latitude: '59.9386',
            ),
            packages: [
                new CalcPackageResponseDto(weight: 1000, length: 10, width: 20, height: 30),
            ],
            type: OrderType::INTERNET_SHOP,
            additionalOrderTypes: [
                AdditionalOrderType::LTL,
            ],
            currency: 1,
            date: '2025-03-24T14:15:22+0700',
            lang: Language::RUS,
        );

        $response = $client->calculator()->calculateTariffList($request);

        self::assertInstanceOf(CalculatorTariffListResponseDto::class, $response);
        self::assertCount(1, $response->tariffCodes);
        self::assertContainsOnlyInstancesOf(TariffCodeDto::class, $response->tariffCodes);
        self::assertSame(136, $response->tariffCodes[0]->tariffCode);
        self::assertSame('Посылка склад-склад', $response->tariffCodes[0]->tariffName);
        self::assertSame('Описание', $response->tariffCodes[0]->tariffDescription);
        self::assertSame(1, $response->tariffCodes[0]->deliveryMode);
        self::assertSame(350.0, $response->tariffCodes[0]->deliverySum);
        self::assertSame(2, $response->tariffCodes[0]->periodMin);
        self::assertSame(4, $response->tariffCodes[0]->periodMax);
        self::assertSame('2022-02-02', $response->tariffCodes[0]->deliveryDateRange?->min);
        self::assertSame('2022-02-04', $response->tariffCodes[0]->deliveryDateRange?->max);
        self::assertCount(1, $response->errors);
        self::assertSame('warned', $response->errors[0]->code);
        self::assertSame('0x01', $response->errors[0]->additionalCode);
        self::assertCount(1, $response->warnings);
        self::assertSame('warning_code', $response->warnings[0]->code);
        self::assertCount(1, $httpClient->requests);
        self::assertSame('POST', $httpClient->requests[0]->getMethod());
        self::assertSame('Bearer test-token', $httpClient->requests[0]->getHeaderLine('Authorization'));
        self::assertSame('application/json', $httpClient->requests[0]->getHeaderLine('Content-Type'));
        self::assertStringContainsString('/v2/calculator/tarifflist', (string) $httpClient->requests[0]->getUri());
        self::assertJsonStringEqualsJsonString(
            json_encode([
                'date' => '2025-03-24T14:15:22+0700',
                'type' => 1,
                'additional_order_types' => [2],
                'currency' => 1,
                'lang' => 'rus',
                'from_location' => [
                    'code' => 44,
                    'postal_code' => '101000',
                    'country_code' => 'RU',
                    'city' => 'Moscow',
                    'address' => 'Tverskaya 1',
                    'contragent_type' => 'LEGAL_ENTITY',
                    'longitude' => '37.6173',
                    'latitude' => '55.7558',
                ],
                'to_location' => [
                    'code' => 137,
                    'postal_code' => '190000',
                    'country_code' => 'RU',
                    'city' => 'Saint Petersburg',
                    'address' => 'Nevsky 1',
                    'contragent_type' => 'LEGAL_ENTITY',
                    'longitude' => '30.3141',
                    'latitude' => '59.9386',
                ],
                'packages' => [
                    [
                        'weight' => 1000,
                        'length' => 10,
                        'width' => 20,
                        'height' => 30,
                    ],
                ],
            ], JSON_THROW_ON_ERROR),
            (string) $httpClient->requests[0]->getBody()
        );
    }

    public function test_calculate_tariff_sends_typed_request_and_returns_typed_response(): void
    {
        $httpClient = new FakeHttpClient([
            new FakeResponse(200, '{"delivery_sum":450,"period_min":1,"period_max":3,"calendar_min":1,"calendar_max":3,"weight_calc":1.75,"services":[{"code":"INSURANCE","sum":50,"total_sum":55,"discount_percent":10,"discount_sum":5,"vat_rate":20,"vat_sum":9.17}],"total_sum":505,"currency":"RUB","errors":[{"code":"tariff_notice","additional_code":"0x02","message":"Minor issue"}],"warnings":[{"code":"warning_code","message":"Watch this"}],"delivery_date_range":{"min":"2022-03-01","max":"2022-03-03"}}'),
        ]);

        $client = new CdekClient(
            $httpClient,
            new FakeRequestFactory(),
            new FakeStreamFactory(),
            [
                'base_url' => CdekClient::SANDBOX_BASE_URL,
                'access_token' => 'test-token',
            ]
        );

        $request = new CalculatorRequestDto(
            tariffCode: 139,
            fromLocation: new CalculatorLocationDto(
                code: 44,
                postalCode: '101000',
                countryCode: 'RU',
                city: 'Moscow',
                address: 'Tverskaya 1',
                contragentType: 'LEGAL_ENTITY',
                longitude: '37.6173',
                latitude: '55.7558',
            ),
            toLocation: new CalculatorLocationDto(
                code: 137,
                postalCode: '190000',
                countryCode: 'RU',
                city: 'Saint Petersburg',
                address: 'Nevsky 1',
                contragentType: 'LEGAL_ENTITY',
                longitude: '30.3141',
                latitude: '59.9386',
            ),
            packages: [
                new CalcPackageResponseDto(weight: 1000, length: 10, width: 20, height: 30),
            ],
            type: OrderType::INTERNET_SHOP,
            additionalOrderTypes: [
                AdditionalOrderType::LTL,
            ],
            currency: 1,
            services: [
                new CalcAdditionalServiceDto(code: 'INSURANCE', parameter: '1000'),
            ],
            date: '2025-03-24T14:15:22+0700',
            lang: Language::RUS,
        );

        $response = $client->calculator()->calculateTariff($request);

        self::assertInstanceOf(CalculateTariffResponse::class, $response);
        self::assertSame(450.0, $response->deliverySum);
        self::assertSame(1, $response->periodMin);
        self::assertSame(3, $response->periodMax);
        self::assertSame(1, $response->calendarMin);
        self::assertSame(3, $response->calendarMax);
        self::assertSame(1.75, $response->weightCalc);
        self::assertCount(1, $response->services);
        self::assertContainsOnlyInstancesOf(ServiceCalculationDto::class, $response->services);
        self::assertSame('INSURANCE', $response->services[0]->code);
        self::assertSame(50.0, $response->services[0]->sum);
        self::assertSame(55.0, $response->services[0]->totalSum);
        self::assertSame(10.0, $response->services[0]->discountPercent);
        self::assertSame(5.0, $response->services[0]->discountSum);
        self::assertSame(20, $response->services[0]->vatRate);
        self::assertSame(9.17, $response->services[0]->vatSum);
        self::assertSame(505.0, $response->totalSum);
        self::assertSame('RUB', $response->currency);
        self::assertSame('2022-03-01', $response->deliveryDateRange?->min);
        self::assertSame('2022-03-03', $response->deliveryDateRange?->max);
        self::assertCount(1, $response->errors);
        self::assertSame('tariff_notice', $response->errors[0]->code);
        self::assertSame('0x02', $response->errors[0]->additionalCode);
        self::assertCount(1, $response->warnings);
        self::assertSame('warning_code', $response->warnings[0]->code);
        self::assertCount(1, $httpClient->requests);
        self::assertSame('POST', $httpClient->requests[0]->getMethod());
        self::assertStringContainsString('/v2/calculator/tariff', (string) $httpClient->requests[0]->getUri());
        self::assertJsonStringEqualsJsonString(
            json_encode([
                'date' => '2025-03-24T14:15:22+0700',
                'type' => 1,
                'currency' => 1,
                'lang' => 'rus',
                'tariff_code' => 139,
                'from_location' => [
                    'code' => 44,
                    'postal_code' => '101000',
                    'country_code' => 'RU',
                    'city' => 'Moscow',
                    'address' => 'Tverskaya 1',
                    'contragent_type' => 'LEGAL_ENTITY',
                    'longitude' => '37.6173',
                    'latitude' => '55.7558',
                ],
                'to_location' => [
                    'code' => 137,
                    'postal_code' => '190000',
                    'country_code' => 'RU',
                    'city' => 'Saint Petersburg',
                    'address' => 'Nevsky 1',
                    'contragent_type' => 'LEGAL_ENTITY',
                    'longitude' => '30.3141',
                    'latitude' => '59.9386',
                ],
                'services' => [
                    [
                        'code' => 'INSURANCE',
                        'parameter' => '1000',
                    ],
                ],
                'packages' => [
                    [
                        'weight' => 1000,
                        'length' => 10,
                        'width' => 20,
                        'height' => 30,
                    ],
                ],
                'additional_order_types' => [2],
            ], JSON_THROW_ON_ERROR),
            (string) $httpClient->requests[0]->getBody()
        );
    }

    public function test_calculate_tariff_with_services_sends_typed_request_and_returns_typed_response(): void
    {
        $httpClient = new FakeHttpClient([
            new FakeResponse(200, '{"delivery_sum":470,"period_min":2,"period_max":4,"calendar_min":2,"calendar_max":4,"weight_calc":1.8,"services":[{"code":"TRYING_ON","sum":70,"total_sum":77,"discount_percent":0,"discount_sum":0,"vat_rate":10,"vat_sum":7}],"total_sum":547,"currency":"RUB","warnings":[{"code":"warning_code","message":"Watch this"}],"delivery_date_range":{"min":"2022-04-01","max":"2022-04-04"}}'),
        ]);

        $client = new CdekClient(
            $httpClient,
            new FakeRequestFactory(),
            new FakeStreamFactory(),
            [
                'base_url' => CdekClient::SANDBOX_BASE_URL,
                'access_token' => 'test-token',
            ]
        );

        $request = new CalculateTariffWithServicesRequest(
            fromLocation: new LocationDto(
                code: 44,
                postalCode: '101000',
                countryCode: 'RU',
                city: 'Moscow',
                address: 'Tverskaya 1',
                contragentType: 'LEGAL_ENTITY',
                longitude: '37.6173',
                latitude: '55.7558',
            ),
            toLocation: new LocationDto(
                code: 137,
                postalCode: '190000',
                countryCode: 'RU',
                city: 'Saint Petersburg',
                address: 'Nevsky 1',
                contragentType: 'LEGAL_ENTITY',
                longitude: '30.3141',
                latitude: '59.9386',
            ),
            services: [
                new AdditionalServiceDto(code: 'TRYING_ON', parameter: '1'),
            ],
            packages: [
                new CalcPackageResponseDto(weight: 1000, length: 10, width: 20, height: 30),
            ],
            type: OrderType::INTERNET_SHOP,
            additionalOrderTypes: [
                AdditionalOrderType::LTL,
            ],
            currency: 'RUB',
            date: '2025-03-24T14:15:22+0700',
            lang: Language::RUS,
        );

        $response = $client->calculator()->calculateTariffWithServices($request);

        self::assertInstanceOf(CalculateTariffResponse::class, $response);
        self::assertSame(470.0, $response->deliverySum);
        self::assertSame(1.8, $response->weightCalc);
        self::assertCount(1, $response->services);
        self::assertSame('TRYING_ON', $response->services[0]->code);
        self::assertSame(70.0, $response->services[0]->sum);
        self::assertSame(547.0, $response->totalSum);
        self::assertSame('RUB', $response->currency);
        self::assertCount(1, $response->warnings);
        self::assertSame('warning_code', $response->warnings[0]->code);
        self::assertCount(1, $httpClient->requests);
        self::assertSame('POST', $httpClient->requests[0]->getMethod());
        self::assertStringContainsString('/v2/calculator/tariffAndService', (string) $httpClient->requests[0]->getUri());
        self::assertJsonStringEqualsJsonString(
            json_encode([
                'date' => '2025-03-24T14:15:22+0700',
                'type' => 1,
                'currency' => 'RUB',
                'lang' => 'rus',
                'from_location' => [
                    'code' => 44,
                    'postal_code' => '101000',
                    'country_code' => 'RU',
                    'city' => 'Moscow',
                    'address' => 'Tverskaya 1',
                    'contragent_type' => 'LEGAL_ENTITY',
                    'longitude' => '37.6173',
                    'latitude' => '55.7558',
                ],
                'to_location' => [
                    'code' => 137,
                    'postal_code' => '190000',
                    'country_code' => 'RU',
                    'city' => 'Saint Petersburg',
                    'address' => 'Nevsky 1',
                    'contragent_type' => 'LEGAL_ENTITY',
                    'longitude' => '30.3141',
                    'latitude' => '59.9386',
                ],
                'services' => [
                    [
                        'code' => 'TRYING_ON',
                        'parameter' => '1',
                    ],
                ],
                'packages' => [
                    [
                        'weight' => 1000,
                        'length' => 10,
                        'width' => 20,
                        'height' => 30,
                    ],
                ],
                'additional_order_types' => [2],
            ], JSON_THROW_ON_ERROR),
            (string) $httpClient->requests[0]->getBody()
        );
    }

    public function test_get_available_tariffs_returns_typed_response(): void
    {
        $httpClient = new FakeHttpClient([
            new FakeResponse(200, '{"tariff_codes":[{"tariff_name":"Посылка","weight_min":0,"weight_max":30,"weight_calc_max":35,"length_min":10,"length_max":100,"width_min":10,"width_max":80,"height_min":5,"height_max":60,"order_types":[null],"payer_contragent_type":[null],"sender_contragent_type":[null],"recipient_contragent_type":[null],"delivery_modes":[{"delivery_mode":null,"delivery_mode_name":null,"tariff_code":null}],"additional_order_types_param":{"without_additional_order_type":null,"additional_order_types":[null]}}]}'),
        ]);

        $client = new CdekClient(
            $httpClient,
            new FakeRequestFactory(),
            new FakeStreamFactory(),
            [
                'base_url' => CdekClient::SANDBOX_BASE_URL,
                'access_token' => 'test-token',
            ]
        );

        $response = $client->calculator()->getAvailableTariffs();

        self::assertInstanceOf(AvailableTariffsResponse::class, $response);
        self::assertCount(1, $response->tariffCodes);
        self::assertContainsOnlyInstancesOf(AvailableTariffCodeDto::class, $response->tariffCodes);
        self::assertSame('Посылка', $response->tariffCodes[0]->tariffName);
        self::assertSame(0.0, $response->tariffCodes[0]->weightMin);
        self::assertSame(30.0, $response->tariffCodes[0]->weightMax);
        self::assertSame(35.0, $response->tariffCodes[0]->weightCalcMax);
        self::assertSame([null], $response->tariffCodes[0]->orderTypes);
        self::assertSame([null], $response->tariffCodes[0]->payerContragentType);
        self::assertSame([null], $response->tariffCodes[0]->senderContragentType);
        self::assertSame([null], $response->tariffCodes[0]->recipientContragentType);
        self::assertCount(1, $response->tariffCodes[0]->deliveryModes);
        self::assertNull($response->tariffCodes[0]->deliveryModes[0]->deliveryMode);
        self::assertNull($response->tariffCodes[0]->deliveryModes[0]->deliveryModeName);
        self::assertNull($response->tariffCodes[0]->deliveryModes[0]->tariffCode);
        self::assertNotNull($response->tariffCodes[0]->additionalOrderTypesParam);
        self::assertNull($response->tariffCodes[0]->additionalOrderTypesParam?->withoutAdditionalOrderType);
        self::assertSame([null], $response->tariffCodes[0]->additionalOrderTypesParam?->additionalOrderTypes);
        self::assertCount(1, $httpClient->requests);
        self::assertSame('GET', $httpClient->requests[0]->getMethod());
        self::assertStringContainsString('/v2/calculator/alltariffs', (string) $httpClient->requests[0]->getUri());
    }
}
