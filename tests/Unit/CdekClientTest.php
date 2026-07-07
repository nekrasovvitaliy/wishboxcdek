<?php

declare(strict_types=1);

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Tests\Support\Http\FakeHttpClient;
use Tests\Support\Http\FakeRequestFactory;
use Tests\Support\Http\FakeResponse;
use Tests\Support\Http\FakeStreamFactory;
use WishboxCdek\CdekClient;
use WishboxCdek\Exception\ApiException;
use WishboxCdek\Enum\Language;
use WishboxCdek\Enum\OrderType;
use WishboxCdek\Enum\PassportClient;
use WishboxCdek\Exception\ApiResponseException;
use WishboxCdek\Exception\CdekException;
use WishboxCdek\Exception\HttpException;
use WishboxCdek\Exception\InvalidUuidException;
use WishboxCdek\Exception\LocationValidationException;
use WishboxCdek\Exception\OrderValidationException;
use WishboxCdek\Request\DeliveryPoint\GetDeliveryPointsRequest;
use WishboxCdek\Request\Intake\CreateIntakeRequest;
use WishboxCdek\Request\Intake\GetAvailableIntakeDaysRequest;
use WishboxCdek\Request\Intake\IntakeAvailableDaysLocationDto;
use WishboxCdek\Request\Location\GetCitiesRequest;
use WishboxCdek\Request\Location\GetCityByCoordinatesRequest;
use WishboxCdek\Request\Location\GetPostalcodesRequest;
use WishboxCdek\Request\Location\GetRegionsRequest;
use WishboxCdek\Request\Location\SuggestCitiesRequest;
use WishboxCdek\Request\Order\GetOrderByNumberRequest;
use WishboxCdek\Request\Order\OrderCreateRequestDto;
use WishboxCdek\Request\Order\ItemRequestDto;
use WishboxCdek\Request\Order\MoneyDto;
use WishboxCdek\Request\Order\PackageRequestDto;
use WishboxCdek\Request\Order\PhoneDto;
use WishboxCdek\Request\Order\RecipientContactDto;
use WishboxCdek\Request\Order\RequestFromLocationDto;
use WishboxCdek\Request\Order\RequestToLocationDto;
use WishboxCdek\Request\Order\SenderContactDto;
use WishboxCdek\Request\Order\OrderUpdateRequestDto;
use WishboxCdek\Request\Print\CreateBarcodesPrintRequest;
use WishboxCdek\Request\Print\CreateOrdersPrintRequest;
use WishboxCdek\Request\Print\PrintOrderReferenceDto;
use WishboxCdek\Request\Passport\GetPassportRequest;
use WishboxCdek\Request\Registry\GetRegistriesRequest;
use WishboxCdek\Response\Async\AsyncResponse;
use WishboxCdek\Response\DeliveryPoint\OfficeDto;
use WishboxCdek\Response\Error\SimplifiedResponseDto;
use WishboxCdek\Response\Error\SimplifiedResponseDto1;
use WishboxCdek\Response\Intake\IntakeAvailableDaysResponse;
use WishboxCdek\Response\Location\CityByCoordinatesDto;
use WishboxCdek\Response\Location\PostalcodesDto;
use WishboxCdek\Response\Location\RegionDto;
use WishboxCdek\Response\Location\SuggestedCityDto;
use WishboxCdek\Response\Location\V2LocationCityDto;
use WishboxCdek\Response\Order\ResponseDtoOrderResponseDto;
use WishboxCdek\Response\Order\ResponseDtoRootEntityDto;
use WishboxCdek\Response\Order\OrderIntakeDto;
use WishboxCdek\Response\Print\PrintBarcodesResponse;
use WishboxCdek\Response\Print\PrintOrderDto;
use WishboxCdek\Response\Print\PrintOrdersResponse;
use WishboxCdek\Response\Registry\RegistriesResponse;
use WishboxCdek\Response\Passport\PassportResponse;
use WishboxCdek\Response\Print\PrintStatusDto;

final class CdekClientTest extends TestCase
{
    public function test_locations_request_builds_query_and_authorization_header(): void
    {
        $httpClient = new FakeHttpClient([
            new FakeResponse(200, '[{"country_code":"RU","country":"Russia","region":"Moscow","region_code":77}]'),
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

        $response = $client->locations()->getRegions(new GetRegionsRequest(countryCodes: 'RU', size: 100, lang: Language::ENG));

        self::assertCount(1, $response);
        self::assertContainsOnlyInstancesOf(RegionDto::class, $response);
        self::assertSame('Moscow', $response[0]->region);
        self::assertSame(77, $response[0]->regionCode);
        self::assertCount(1, $httpClient->requests);
        self::assertSame('GET', $httpClient->requests[0]->getMethod());
        self::assertSame('Bearer test-token', $httpClient->requests[0]->getHeaderLine('Authorization'));
        self::assertStringContainsString('/v2/location/regions?country_codes=RU&size=100&lang=eng', (string) $httpClient->requests[0]->getUri());

    }

    public function test_get_regions_allows_missing_optional_region_code(): void
    {
        $httpClient = new FakeHttpClient([
            new FakeResponse(200, '[{"country_code":"RU","country":"Russia","region":"Moscow"}]'),
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

        $response = $client->locations()->getRegions(new GetRegionsRequest(countryCodes: 'RU'));

        self::assertCount(1, $response);
        self::assertNull($response[0]->regionCode);
    }

    public function test_registries_returns_typed_response(): void
    {
        $httpClient = new FakeHttpClient([
            new FakeResponse(200, '{"registries":[{"registry_number":"REG-1","payment_date":"2024-05-21","sum":1500.5,"payment_order_number":"PO-42","orders":[{"cdek_number":"1000014101","transfer_sum":1000.5,"payment_sum":1200.5,"total_sum_without_agent":1300.5,"agent_commission_sum":100,"basis_type":1}],"date_created":"2024-05-22T10:00:00+03:00"}],"warnings":[{"code":"WARN-REG-1","message":"Partial data"}]}'),
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

        $response = $client->registries()->getList(new GetRegistriesRequest('2024-05-21'));

        self::assertInstanceOf(RegistriesResponse::class, $response);
        self::assertCount(1, $response->registries);
        self::assertSame('REG-1', $response->registries[0]->registryNumber);
        self::assertSame('2024-05-21', $response->registries[0]->paymentDate);
        self::assertSame(1500.5, $response->registries[0]->sum);
        self::assertSame('PO-42', $response->registries[0]->paymentOrderNumber);
        self::assertCount(1, $response->registries[0]->orders);
        self::assertSame('1000014101', $response->registries[0]->orders[0]->cdekNumber);
        self::assertSame(1000.5, $response->registries[0]->orders[0]->transferSum);
        self::assertSame(1, $response->registries[0]->orders[0]->basisType);
        self::assertCount(1, $response->warnings);
        self::assertSame('WARN-REG-1', $response->warnings[0]->code);
        self::assertCount(1, $httpClient->requests);
        self::assertSame('GET', $httpClient->requests[0]->getMethod());

        self::assertStringContainsString('/v2/registries?date=2024-05-21', (string) $httpClient->requests[0]->getUri());
    }
    public function test_passport_returns_typed_response(): void
    {
        $httpClient = new FakeHttpClient([
            new FakeResponse(200, '{"orders":[{"order_uuid":"72753031-e66b-4146-ab8c-52179ef4020a","cdek_number":"1000014101","passport":[{"client":"SENDER","passport_requirements_satisfied":true},{"client":"RECEIVER","passport_requirements_satisfied":false}]}],"warnings":[{"code":"WARN-PASS-1","message":"Receiver passport missing"}]}'),
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

        $response = $client->passport()->get(new GetPassportRequest(
            orderUuid: '72753031-e66b-4146-ab8c-52179ef4020a',
            client: PassportClient::SENDER,
        ));

        self::assertInstanceOf(PassportResponse::class, $response);
        self::assertCount(1, $response->orders);
        self::assertSame('72753031-e66b-4146-ab8c-52179ef4020a', $response->orders[0]->orderUuid);
        self::assertSame('1000014101', $response->orders[0]->cdekNumber);
        self::assertCount(2, $response->orders[0]->passport);
        self::assertSame('SENDER', $response->orders[0]->passport[0]->client);
        self::assertTrue($response->orders[0]->passport[0]->passportRequirementsSatisfied ?? false);
        self::assertFalse($response->orders[0]->passport[1]->passportRequirementsSatisfied ?? true);
        self::assertCount(1, $response->warnings);
        self::assertSame('WARN-PASS-1', $response->warnings[0]->code);
        self::assertCount(1, $httpClient->requests);
        self::assertSame('GET', $httpClient->requests[0]->getMethod());
        self::assertStringContainsString('/v2/passport?order_uuid=72753031-e66b-4146-ab8c-52179ef4020a&client=SENDER', (string) $httpClient->requests[0]->getUri());
    }


    public function test_delivery_points_returns_typed_objects(): void
    {
        $httpClient = new FakeHttpClient([
            new FakeResponse(200, '[{"code":"MSK123","uuid":"delivery-point-uuid","name":"Pickup point","address_comment":"Business center","nearest_station":"Belorussky Station","nearest_metro_station":"Belorusskaya","work_time":"Mon-Fri 10:00-20:00","phones":[{"number":"+74950000000","additional":"123"}],"email":"point@example.com","note":"Entrance from yard","type":null,"owner_code":"CDEK","take_only":null,"is_handout":null,"is_reception":null,"is_dressing_room":null,"is_marketplace":null,"is_ltl":null,"have_cashless":null,"have_cash":null,"have_fast_payment_system":null,"allowed_cod":null,"site":"https://cdek.ru","office_image_list":[{"number":null,"url":"https://cdn.example.com/office.jpg"}],"work_time_list":[{"day":null,"time":"10:00/20:00"}],"work_time_exception_list":[{"date_start":"2020-01-01","date_end":"2020-02-02","time_start":"09:00","time_end":"18:00","is_working":false}],"weight_min":null,"weight_max":null,"dimensions":[{"width":null,"height":null,"depth":null}],"errors":[{"code":null,"additional_code":null,"message":null}],"warnings":[{"code":null,"message":null}],"location":{"country_code":"RU","region_code":null,"region":"Moscow","city_code":null,"city":"Moscow","fias_guid":null,"postal_code":"101000","longitude":null,"latitude":null,"address":"Tverskaya 1","address_full":"101000, Russia, Moscow, Tverskaya 1","city_uuid":null},"distance":null,"ltl_acceptance_partners":null,"ltl_issuance_partners":null,"fulfillment":null}]'),
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

        $response = $client->deliveryPoints()->getList(new GetDeliveryPointsRequest(cityCode: 44, haveCash: true, size: 10));

        self::assertCount(1, $response);
        self::assertContainsOnlyInstancesOf(OfficeDto::class, $response);
        self::assertSame('MSK123', $response[0]->code);
        self::assertSame('delivery-point-uuid', $response[0]->uuid);
        self::assertSame('Pickup point', $response[0]->name);
        self::assertSame('Mon-Fri 10:00-20:00', $response[0]->workTime);
        self::assertCount(1, $response[0]->phones);
        self::assertSame('+74950000000', $response[0]->phones[0]->number);
        self::assertSame('Moscow', $response[0]->location?->city);
        self::assertNull($response[0]->location?->cityCode);
        self::assertSame('101000', $response[0]->location?->postalCode);
        self::assertNull($response[0]->haveFastPaymentSystem);
        self::assertNull($response[0]->weightMin);
        self::assertNull($response[0]->weightMax);
        self::assertCount(1, $response[0]->workTimeList);
        self::assertNull($response[0]->workTimeList[0]->day);
        self::assertCount(1, $response[0]->workTimeExceptionList);
        self::assertFalse($response[0]->workTimeExceptionList[0]->isWorking ?? true);
        self::assertCount(1, $response[0]->dimensions);
        self::assertNull($response[0]->dimensions[0]->width);
        self::assertNull($response[0]->distance);
        self::assertNull($response[0]->ltlAcceptancePartners);
        self::assertNull($response[0]->ltlIssuancePartners);
        self::assertNull($response[0]->haveCash);
        self::assertCount(1, $httpClient->requests);
        self::assertCount(1, $httpClient->requests);
        self::assertSame('GET', $httpClient->requests[0]->getMethod());
        self::assertStringContainsString('/v2/deliverypoints?city_code=44&have_cash=1&size=10', (string) $httpClient->requests[0]->getUri());
    }

    public function test_delivery_points_uses_single_country_code_filter(): void
    {
        $httpClient = new FakeHttpClient([
            new FakeResponse(200, '[]'),
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

        $client->deliveryPoints()->getList(new GetDeliveryPointsRequest(
            countryCode: 'AM',
            size: 10,
        ));

        self::assertCount(1, $httpClient->requests);
        self::assertStringContainsString('/v2/deliverypoints?country_code=AM&size=10', (string) $httpClient->requests[0]->getUri());
    }

    public function test_suggest_cities_returns_typed_objects(): void
    {
        $httpClient = new FakeHttpClient([
            new FakeResponse(200, '[{"city_uuid":"061925d2-e3ae-4fc4-b824-0a1be89f77be","code":44,"full_name":"Moscow, Russia","country_code":"RU"}]'),
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

        $response = $client->locations()->suggestCities(new SuggestCitiesRequest(name: 'Mos', countryCode: 'RU'));

        self::assertCount(1, $response);
        self::assertContainsOnlyInstancesOf(SuggestedCityDto::class, $response);
        self::assertSame('061925d2-e3ae-4fc4-b824-0a1be89f77be', $response[0]->cityUuid);
        self::assertSame(44, $response[0]->code);
        self::assertSame('Moscow, Russia', $response[0]->fullName);
        self::assertSame('RU', $response[0]->countryCode);
        self::assertCount(1, $httpClient->requests);
        self::assertSame('GET', $httpClient->requests[0]->getMethod());
        self::assertStringContainsString('/v2/location/suggest/cities?name=Mos&country_code=RU', (string) $httpClient->requests[0]->getUri());
    }


    public function test_get_city_by_coordinates_returns_typed_object(): void
    {
        $httpClient = new FakeHttpClient([
            new FakeResponse(200, '{"code":44,"city_uuid":"061925d2-e3ae-4fc4-b824-0a1be89f77be","city":"Moscow","fias_guid":"d37bb109-5355-46b0-ac51-7b6911a53fac"}'),
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

        $response = $client->locations()->getCityByCoordinates(new GetCityByCoordinatesRequest(longitude: 37.6173, latitude: 55.7558));

        self::assertInstanceOf(CityByCoordinatesDto::class, $response);
        self::assertSame(44, $response->code);
        self::assertSame('061925d2-e3ae-4fc4-b824-0a1be89f77be', $response->cityUuid);
        self::assertSame('Moscow', $response->city);
        self::assertSame('d37bb109-5355-46b0-ac51-7b6911a53fac', $response->fiasGuid);
        self::assertCount(1, $httpClient->requests);
        self::assertSame('GET', $httpClient->requests[0]->getMethod());
        self::assertStringContainsString('/v2/location/coordinates?longitude=37.6173&latitude=55.7558', (string) $httpClient->requests[0]->getUri());
    }

    public function test_get_cities_returns_typed_objects(): void
    {
        $httpClient = new FakeHttpClient([
            new FakeResponse(200, '[{"code":44,"city_uuid":"061925d2-e3ae-4fc4-b824-0a1be89f77be","city":"Moscow","country_code":"RU","country":"Russia","region":"Moscow","region_code":77,"postal_code":"101000"}]'),
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

        $response = $client->locations()->getCities(new GetCitiesRequest(
            countryCodes: 'RU',
            regionCode: 77,
            kladrRegionCode: '7700000000000',
            fiasRegionGuid: '88d7b0d4-3671-4e5a-bafc-b9556aa1b2e8',
            kladrCode: '7700000000000',
            fiasGuid: 'd37bb109-5355-46b0-ac51-7b6911a53fac',
            city: 'Moscow',
            size: 10,
            lang: Language::ENG,
        ));

        self::assertCount(1, $response);
        self::assertContainsOnlyInstancesOf(V2LocationCityDto::class, $response);
        self::assertSame(44, $response[0]->code);
        self::assertSame('061925d2-e3ae-4fc4-b824-0a1be89f77be', $response[0]->cityUuid);
        self::assertSame('Moscow', $response[0]->city);
        self::assertSame('RU', $response[0]->countryCode);
        self::assertSame('Russia', $response[0]->country);
        self::assertSame('Moscow', $response[0]->region);
        self::assertSame(77, $response[0]->regionCode);
        self::assertSame('101000', $response[0]->postalCode);
        self::assertCount(1, $httpClient->requests);
        self::assertSame('GET', $httpClient->requests[0]->getMethod());
        self::assertStringContainsString('/v2/location/cities?country_codes=RU&region_code=77&kladr_region_code=7700000000000&fias_region_guid=88d7b0d4-3671-4e5a-bafc-b9556aa1b2e8&kladr_code=7700000000000&fias_guid=d37bb109-5355-46b0-ac51-7b6911a53fac&city=Moscow&size=10&lang=eng', (string) $httpClient->requests[0]->getUri());
    }

    public function test_get_cities_throws_location_validation_exception_for_invalid_request(): void
    {
        $httpClient = new FakeHttpClient([]);

        $client = new CdekClient(
            $httpClient,
            new FakeRequestFactory(),
            new FakeStreamFactory(),
            [
                'base_url' => CdekClient::SANDBOX_BASE_URL,
                'access_token' => 'test-token',
            ]
        );

        try {
            $client->locations()->getCities(new GetCitiesRequest(
                countryCodes: 'RU,XXX',
                fiasGuid: 'not-a-uuid',
                page: -1,
            ));
            self::fail('Expected LocationValidationException was not thrown.');
        } catch (LocationValidationException $exception) {
            self::assertSame(
                [
                    'countryCodes contains invalid country code "XXX".',
                    'page must be greater than or equal to 0.',
                    'fiasGuid must be a valid UUID.',
                ],
                $exception->getErrors()
            );
            self::assertCount(0, $httpClient->requests);
        }
    }
    public function test_postalcodes_request_builds_code_query_and_returns_object(): void
    {
        $httpClient = new FakeHttpClient([
            new FakeResponse(200, '{"code":44,"postal_codes":["630000","630001"]}'),
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

        $response = $client->locations()->getPostalcodes(new GetPostalcodesRequest(code: 44));

        self::assertInstanceOf(PostalcodesDto::class, $response);
        self::assertSame(44, $response->code);
        self::assertSame(['630000', '630001'], $response->postalCodes);
        self::assertCount(1, $httpClient->requests);
        self::assertSame('GET', $httpClient->requests[0]->getMethod());
        self::assertSame('Bearer test-token', $httpClient->requests[0]->getHeaderLine('Authorization'));
        self::assertStringContainsString('/v2/location/postalcodes?code=44', (string) $httpClient->requests[0]->getUri());
    }

    public function test_client_fetches_token_automatically_before_authenticated_request(): void
    {
        $httpClient = new FakeHttpClient([
            new FakeResponse(200, '{"access_token":"auto-token","token_type":"bearer","expires_in":3600,"scope":"all","jti":"token-id"}'),
            new FakeResponse(200, '[{"country_code":"RU","country":"Russia","region":"Moscow","region_code":77}]'),
        ]);

        $client = new CdekClient(
            $httpClient,
            new FakeRequestFactory(),
            new FakeStreamFactory(),
            [
                'base_url' => CdekClient::SANDBOX_BASE_URL,
                'account' => 'account-id',
                'password' => 'secret',
            ]
        );

        $regions = $client->locations()->getRegions(new GetRegionsRequest(countryCodes: 'RU'));

        self::assertCount(1, $regions);
        self::assertContainsOnlyInstancesOf(RegionDto::class, $regions);
        self::assertCount(2, $httpClient->requests);
        self::assertSame('POST', $httpClient->requests[0]->getMethod());
        self::assertStringContainsString('/v2/oauth/token', (string) $httpClient->requests[0]->getUri());
        self::assertSame('GET', $httpClient->requests[1]->getMethod());
        self::assertSame('Bearer auto-token', $httpClient->requests[1]->getHeaderLine('Authorization'));
    }

    public function test_create_order_sends_json_payload_built_from_request_objects(): void
    {
        $httpClient = new FakeHttpClient([
            new FakeResponse(202, '{"entity":{"uuid":"test-order"},"requests":[{"request_uuid":"req-1","type":"CREATE","date_time":"2019-08-24T14:15:22Z","state":"ACCEPTED"}]}'),
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

        $response = $client->orders()->create(
            OrderCreateRequestDto::make(
                tariffCode: 139,
                sender: new SenderContactDto(
                    name: 'Wishbox Sender',
                    phones: [
                        new PhoneDto(number: '+79990000001'),
                    ],
                ),
                recipient: new RecipientContactDto(
                    name: 'John Doe',
                    phones: [
                        new PhoneDto(number: '+79990000002'),
                    ],
                ),
                packages: [
                    new PackageRequestDto(
                        number: 'PKG-1',
                        weight: 1000,
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
                ->withFromLocation(new RequestFromLocationDto(code: 44))
                ->withToLocation(new RequestToLocationDto(code: 137, address: 'Pushkina 1'))
                ->withNumber('ORDER-1')
        );

        self::assertInstanceOf(ResponseDtoRootEntityDto::class, $response);
        self::assertSame('test-order', $response->entity?->uuid);
        self::assertCount(1, $response->requests);
        self::assertSame('req-1', $response->requests[0]->requestUuid);
        self::assertSame('CREATE', $response->requests[0]->type);
        self::assertSame('ACCEPTED', $response->requests[0]->state);
        self::assertCount(1, $httpClient->requests);
        self::assertSame('POST', $httpClient->requests[0]->getMethod());
        self::assertSame('Bearer test-token', $httpClient->requests[0]->getHeaderLine('Authorization'));
        self::assertSame('application/json', $httpClient->requests[0]->getHeaderLine('Content-Type'));
        self::assertJsonStringEqualsJsonString(
            json_encode([
                'type' => 1,
                'number' => 'ORDER-1',
                'tariff_code' => 139,
                'sender' => [
                    'name' => 'Wishbox Sender',
                    'phones' => [
                        ['number' => '+79990000001'],
                    ],
                ],
                'recipient' => [
                    'name' => 'John Doe',
                    'phones' => [
                        ['number' => '+79990000002'],
                    ],
                ],
                'from_location' => [
                    'code' => 44,
                ],
                'to_location' => [
                    'code' => 137,
                    'address' => 'Pushkina 1',
                ],
                'packages' => [
                    [
                        'number' => 'PKG-1',
                        'weight' => 1000,
                        'items' => [
                            [
                                'name' => 'Sneakers',
                                'ware_key' => 'SKU-1',
                                'payment' => [
                                    'value' => 3500,
                                ],
                                'cost' => 3500,
                                'weight' => 500,
                                'amount' => 1,
                            ],
                        ],
                    ],
                ],
            ], JSON_THROW_ON_ERROR),
            (string) $httpClient->requests[0]->getBody()
        );
    }

    public function test_create_order_throws_validation_exception_before_http_request(): void
    {
        $httpClient = new FakeHttpClient([]);

        $client = new CdekClient(
            $httpClient,
            new FakeRequestFactory(),
            new FakeStreamFactory(),
            [
                'base_url' => CdekClient::SANDBOX_BASE_URL,
                'access_token' => 'test-token',
            ]
        );

        try {
            $client->orders()->create(
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
                    packages: [new PackageRequestDto(number: 'PKG-1', weight: 1000)],
                )
                    ->withToLocation(new RequestToLocationDto(address: 'Pushkina 1', code: 137))
            );
            self::fail('Expected OrderValidationException was not thrown.');
        } catch (OrderValidationException $exception) {
            self::assertSame('packages[0].items must not be empty.; delivery_point is required for tariff 136.', $exception->getMessage());
            self::assertSame([
                'packages[0].items must not be empty.',
                'delivery_point is required for tariff 136.',
            ], $exception->getErrors());
            self::assertCount(0, $httpClient->requests);
        }
    }

    public function test_create_order_throws_api_exception_with_root_entity_response_for_bad_request(): void
    {
        $httpClient = new FakeHttpClient([
            new FakeResponse(400, '{"requests":[{"type":"CREATE","date_time":"2026-07-06T07:46:27+0000","state":"INVALID","errors":[{"code":"v2_field_is_empty","message":"[packages[0].items[0].ware_key] is empty"}],"warnings":[{"code":"warn_create","message":"Create warning"}]}],"related_entities":[]}'),
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

        try {
            $client->orders()->create(
                OrderCreateRequestDto::make(
                    tariffCode: 139,
                    sender: new SenderContactDto(
                        name: 'Wishbox Sender',
                        phones: [new PhoneDto(number: '+79990000001')],
                    ),
                    recipient: new RecipientContactDto(
                        name: 'John Doe',
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
                    ->withToLocation(new RequestToLocationDto(code: 137, address: 'Pushkina 1'))
            );
            self::fail('Expected ApiException was not thrown.');
        } catch (ApiException $exception) {
            self::assertSame(400, $exception->getStatusCode());
            $response = $exception->getResponse();
        }

        self::assertInstanceOf(ResponseDtoRootEntityDto::class, $response);
        self::assertTrue($response->hasErrors());
        self::assertCount(1, $response->getErrors());
        self::assertSame('v2_field_is_empty', $response->getErrors()[0]->code);
        self::assertNull($response->getErrors()[0]->additionalCode);
        self::assertSame('[packages[0].items[0].ware_key] is empty', $response->getErrors()[0]->message);
        self::assertCount(1, $response->getWarnings());
        self::assertSame('warn_create', $response->getWarnings()[0]->code);
    }

    public function test_update_order_throws_validation_exception_before_http_request(): void
    {
        $httpClient = new FakeHttpClient([]);

        $client = new CdekClient(
            $httpClient,
            new FakeRequestFactory(),
            new FakeStreamFactory(),
            [
                'base_url' => CdekClient::SANDBOX_BASE_URL,
                'access_token' => 'test-token',
            ]
        );

        try {
            $client->orders()->update(
                OrderUpdateRequestDto::make(
                    type: OrderType::DELIVERY,
                    tariffCode: 136,
                    recipient: new RecipientContactDto(
                        name: 'Recipient',
                        phones: [new PhoneDto(number: '+79990000002')],
                    ),
                    packages: [new PackageRequestDto(number: 'PKG-1', weight: 1000)],
                )->withUuid('order-uuid')
            );
            self::fail('Expected OrderValidationException was not thrown.');
        } catch (OrderValidationException $exception) {
            self::assertSame('sender is required for delivery orders.', $exception->getMessage());
            self::assertSame(['sender is required for delivery orders.'], $exception->getErrors());
            self::assertCount(0, $httpClient->requests);
        }
    }

    public function test_update_order_returns_root_entity_response_for_accepted_response(): void
    {
        $httpClient = new FakeHttpClient([
            new FakeResponse(202, '{"entity":{"uuid":"updated-order"},"requests":[{"request_uuid":"req-update-1","type":"UPDATE","state":"ACCEPTED"}]}'),
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

        $response = $client->orders()->update(
            OrderUpdateRequestDto::make(
                type: OrderType::INTERNET_SHOP,
                tariffCode: 136,
                recipient: new RecipientContactDto(
                    name: 'Recipient',
                    phones: [new PhoneDto(number: '+79990000002')],
                ),
                packages: [new PackageRequestDto(number: 'PKG-1', weight: 1000)],
            )->withUuid('order-uuid')
        );

        self::assertInstanceOf(ResponseDtoRootEntityDto::class, $response);
        self::assertSame('updated-order', $response->entity?->uuid);
        self::assertSame('req-update-1', $response->requests[0]->requestUuid);
        self::assertSame('ACCEPTED', $response->requests[0]->state);
        self::assertSame('PATCH', $httpClient->requests[0]->getMethod());
    }

    public function test_update_order_returns_simplified_response_for_bad_request(): void
    {
        $httpClient = new FakeHttpClient([
            new FakeResponse(400, '{"errors":[{"code":"v2_bad_request","additional_code":"0x0002","message":"Bad update"}],"warnings":[{"code":"warn_update","message":"Update warning"}]}'),
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

        try {
            $client->orders()->update(
                OrderUpdateRequestDto::make(
                    type: OrderType::INTERNET_SHOP,
                    tariffCode: 136,
                    recipient: new RecipientContactDto(
                        name: 'Recipient',
                        phones: [new PhoneDto(number: '+79990000002')],
                    ),
                    packages: [new PackageRequestDto(number: 'PKG-1', weight: 1000)],
                )->withUuid('order-uuid')
            );
            self::fail('Expected ApiException was not thrown.');
        } catch (ApiException $exception) {
            self::assertSame(400, $exception->getStatusCode());
            $response = $exception->getResponse();
        }

        self::assertInstanceOf(SimplifiedResponseDto1::class, $response);
        self::assertCount(1, $response->errors);
        self::assertSame('v2_bad_request', $response->errors[0]->code);
        self::assertSame('0x0002', $response->errors[0]->additionalCode);
        self::assertSame('Bad update', $response->errors[0]->message);
        self::assertCount(1, $response->warnings);
        self::assertSame('warn_update', $response->warnings[0]->code);
    }

    public function test_get_order_by_uuid_returns_typed_order_details(): void
    {
        $httpClient = new FakeHttpClient([
            new FakeResponse(200, '{"entity":{"uuid":"order-uuid","cdek_number":"1234567890","number":"ORDER-1","tariff_code":136,"developer_key":"wishbox-dev","additional_order_types":[2,9],"sender":{"name":"Sender","phones":[{"number":"+79990000001"}]},"packages":[{"number":"PKG-1","weight":1000,"items":[{"name":"Item","ware_key":"SKU-1","cost":1000,"weight":500,"amount":1}]}],"statuses":[{"code":"CREATED","name":"Created","date_time":"2026-04-01T10:00:00+0000"}]},"requests":[{"request_uuid":"req-order-1","state":"ACCEPTED"}],"related_entities":[{"uuid":"related-uuid","type":"return_order","cdek_number":"9876543210","time_from":"15:00","time_to":"18:00"}]}'),
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

        $response = $client->orders()->getByUuid('72753031-e66b-4146-ab8c-52179ef4020a');

        self::assertInstanceOf(ResponseDtoOrderResponseDto::class, $response);
        self::assertSame('order-uuid', $response->entity?->uuid);
        self::assertSame('1234567890', $response->entity?->cdekNumber);
        self::assertSame('ORDER-1', $response->entity?->number);
        self::assertSame(136, $response->entity?->tariffCode);
        self::assertSame('wishbox-dev', $response->entity?->developerKey);
        self::assertCount(1, $response->entity?->statuses);
        self::assertSame('CREATED', $response->entity?->statuses[0]->code);
        self::assertCount(1, $response->requests);
        self::assertSame('req-order-1', $response->requests[0]->requestUuid);
        self::assertSame('ACCEPTED', $response->requests[0]->state);
        self::assertCount(1, $httpClient->requests);
        self::assertSame('GET', $httpClient->requests[0]->getMethod());
        self::assertStringContainsString('/v2/orders/72753031-e66b-4146-ab8c-52179ef4020a', (string) $httpClient->requests[0]->getUri());
    }

    public function test_get_order_by_number_returns_typed_order_details_without_throwing_business_errors(): void
    {
        $httpClient = new FakeHttpClient([
            new FakeResponse(200, '{"entity":{"uuid":"order-uuid","number":"ORDER-1"},"requests":[{"request_uuid":"req-order-1","state":"INVALID","errors":[{"code":"recipient_invalid_phone","message":"Invalid phone"}]}]}'),
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

        $response = $client->orders()->getByNumber(new GetOrderByNumberRequest(imNumber: 'ORDER-1'));

        self::assertInstanceOf(ResponseDtoOrderResponseDto::class, $response);
        self::assertSame('order-uuid', $response->entity?->uuid);
        self::assertSame('ORDER-1', $response->entity?->number);
        self::assertTrue($response->hasErrors());
        self::assertCount(1, $response->getErrors());
        self::assertSame('recipient_invalid_phone', $response->getErrors()[0]->code);
        self::assertStringContainsString('/v2/orders?im_number=ORDER-1', (string) $httpClient->requests[0]->getUri());
    }

    public function test_get_order_by_number_returns_simplified_response_for_bad_request(): void
    {
        $httpClient = new FakeHttpClient([
            new FakeResponse(400, '{"errors":[{"code":"v2_entity_not_found","additional_code":"0x0001","message":"Order not found"}],"warnings":[{"code":"warn_1","message":"Warning"}]}'),
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

        try {
            $client->orders()->getByNumber(new GetOrderByNumberRequest(imNumber: 'ORDER-404'));
            self::fail('Expected ApiException was not thrown.');
        } catch (ApiException $exception) {
            self::assertSame(400, $exception->getStatusCode());
            $response = $exception->getResponse();
        }

        self::assertInstanceOf(SimplifiedResponseDto1::class, $response);
        self::assertCount(1, $response->errors);
        self::assertSame('v2_entity_not_found', $response->errors[0]->code);
        self::assertSame('0x0001', $response->errors[0]->additionalCode);
        self::assertSame('Order not found', $response->errors[0]->message);
        self::assertCount(1, $response->warnings);
        self::assertSame('warn_1', $response->warnings[0]->code);
    }

    public function test_delete_order_returns_root_entity_response(): void
    {
        $httpClient = new FakeHttpClient([
            new FakeResponse(202, '{"entity":{"uuid":"deleted-order-uuid"},"requests":[{"request_uuid":"req-delete-1","type":"DELETE","state":"ACCEPTED"}]}'),
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

        $response = $client->orders()->delete('72753031-e66b-4146-ab8c-52179ef4020a');

        self::assertInstanceOf(ResponseDtoRootEntityDto::class, $response);
        self::assertSame('deleted-order-uuid', $response->entity?->uuid);
        self::assertSame('DELETE', $response->requests[0]->type);
        self::assertSame('ACCEPTED', $response->requests[0]->state);
        self::assertCount(1, $httpClient->requests);
        self::assertSame('DELETE', $httpClient->requests[0]->getMethod());
        self::assertStringContainsString('/v2/orders/72753031-e66b-4146-ab8c-52179ef4020a', (string) $httpClient->requests[0]->getUri());
    }

    public function test_delete_order_returns_simplified_response_for_bad_request(): void
    {
        $httpClient = new FakeHttpClient([
            new FakeResponse(400, '{"errors":[{"code":"v2_bad_request","additional_code":"0x0004","message":"Bad delete"}],"warnings":[{"code":"warn_delete","message":"Delete warning"}]}'),
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

        try {
            $client->orders()->delete('72753031-e66b-4146-ab8c-52179ef4020a');
            self::fail('Expected ApiException was not thrown.');
        } catch (ApiException $exception) {
            self::assertSame(400, $exception->getStatusCode());
            $response = $exception->getResponse();
        }

        self::assertInstanceOf(SimplifiedResponseDto1::class, $response);
        self::assertCount(1, $response->errors);
        self::assertSame('v2_bad_request', $response->errors[0]->code);
        self::assertSame('0x0004', $response->errors[0]->additionalCode);
        self::assertSame('Bad delete', $response->errors[0]->message);
        self::assertCount(1, $response->warnings);
        self::assertSame('warn_delete', $response->warnings[0]->code);
    }

    public function test_get_order_intakes_returns_typed_objects(): void
    {
        $httpClient = new FakeHttpClient([
            new FakeResponse(200, '[{"uuid":"intake-uuid","cdek_number":"123456","order_uuid":"order-uuid","intake_date":"2026-03-31","intake_number":"INT-1","intake_time_from":"09:00","intake_time_to":"18:00","lunch_time_from":"14:00","lunch_time_to":"15:00","name":"Pickup order","weight":1000,"length":10,"width":20,"height":30,"comment":"Call before arrival","courier_power_of_attorney":true,"courier_identity_card":false,"sender":{"name":"Sender","phones":[{"number":"+79990000001"}]},"from_location":{"city":"Moscow","address":"Sender street 1"},"to_location":{"city":"Saint Petersburg","address":"Recipient street 1"},"need_call":true,"statuses":[{"code":"CREATED","name":"Created","date_time":"2026-03-31T10:00:00+0000"}],"packages":[{"package_id":"pkg-1","weight":1000,"length":10,"width":20,"height":30}]}]'),
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

        $response = $client->orders()->getIntakes('72753031-e66b-4146-ab8c-52179ef4020a');

        self::assertCount(1, $response);
        self::assertContainsOnlyInstancesOf(OrderIntakeDto::class, $response);
        self::assertSame('intake-uuid', $response[0]->uuid);
        self::assertSame('123456', $response[0]->cdekNumber);
        self::assertSame('order-uuid', $response[0]->orderUuid);
        self::assertSame('Pickup order', $response[0]->name);
        self::assertSame('Sender', $response[0]->sender?->name);
        self::assertSame('Moscow', $response[0]->fromLocation?->city);
        self::assertSame('Saint Petersburg', $response[0]->toLocation?->city);
        self::assertTrue($response[0]->needCall ?? false);
        self::assertCount(1, $response[0]->statuses);
        self::assertSame('CREATED', $response[0]->statuses[0]->code);
        self::assertCount(1, $response[0]->packages);
        self::assertSame('pkg-1', $response[0]->packages[0]->packageId);
        self::assertCount(1, $httpClient->requests);
        self::assertSame('GET', $httpClient->requests[0]->getMethod());
        self::assertStringContainsString('/v2/orders/72753031-e66b-4146-ab8c-52179ef4020a/intakes', (string) $httpClient->requests[0]->getUri());
    }

    public function test_uuid_path_methods_throw_invalid_uuid_exception_before_http_request(): void
    {
        $httpClient = new FakeHttpClient();

        $client = new CdekClient(
            $httpClient,
            new FakeRequestFactory(),
            new FakeStreamFactory(),
            [
                'base_url' => CdekClient::SANDBOX_BASE_URL,
                'access_token' => 'test-token',
            ]
        );

        $actions = [
            ['action' => static fn (CdekClient $client) => $client->orders()->getByUuid('order-uuid'), 'message' => 'uuid must be a valid UUID.'],
            ['action' => static fn (CdekClient $client) => $client->orders()->delete('order-uuid'), 'message' => 'uuid must be a valid UUID.'],
            ['action' => static fn (CdekClient $client) => $client->orders()->getIntakes('order-uuid'), 'message' => 'order_uuid must be a valid UUID.'],
            ['action' => static fn (CdekClient $client) => $client->prints()->getOrdersByUuid('print-orders-uuid'), 'message' => 'uuid must be a valid UUID.'],
            ['action' => static fn (CdekClient $client) => $client->prints()->getBarcodesByUuid('print-barcodes-uuid'), 'message' => 'uuid must be a valid UUID.'],
            ['action' => static fn (CdekClient $client) => $client->prints()->downloadBarcodesPdf('print-barcodes-uuid'), 'message' => 'uuid must be a valid UUID.'],
            ['action' => static fn (CdekClient $client) => $client->intakes()->getByUuid('intake-uuid'), 'message' => 'uuid must be a valid UUID.'],
            ['action' => static fn (CdekClient $client) => $client->intakes()->delete('intake-uuid'), 'message' => 'uuid must be a valid UUID.'],
        ];

        foreach ($actions as $action) {
            try {
                $action['action']($client);
                self::fail('Expected InvalidUuidException was not thrown.');
            } catch (InvalidUuidException $exception) {
                self::assertSame($action['message'], $exception->getMessage());
            }
        }

        self::assertCount(0, $httpClient->requests);

    }
    public function test_get_available_intake_days_builds_typed_request_body(): void
    {
        $httpClient = new FakeHttpClient([
            new FakeResponse(200, '{"date":["2026-04-18","2026-04-19"],"all_days":false,"warnings":[{"code":"WARN-1","message":"Limited schedule"}]}'),
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

        $response = $client->intakes()->getAvailableDays(new GetAvailableIntakeDaysRequest(
            fromLocation: new IntakeAvailableDaysLocationDto(
                code: 44,
                city: 'Moscow',
                countryCode: 'RU',
                postalCode: '101000',
                address: 'Red Square, 1',
            ),
            date: '2026-04-18',
        ));

        self::assertInstanceOf(IntakeAvailableDaysResponse::class, $response);
        self::assertSame(['2026-04-18', '2026-04-19'], $response->dates);
        self::assertFalse($response->allDays ?? true);
        self::assertCount(1, $response->warnings);
        self::assertSame('WARN-1', $response->warnings[0]->code);
        self::assertCount(1, $httpClient->requests);
        self::assertSame('POST', $httpClient->requests[0]->getMethod());
        self::assertStringContainsString('/v2/intakes/availableDays', (string) $httpClient->requests[0]->getUri());
        self::assertJsonStringEqualsJsonString(
            json_encode([
                'from_location' => [
                    'code' => 44,
                    'city' => 'Moscow',
                    'country_code' => 'RU',
                    'postal_code' => '101000',
                    'address' => 'Red Square, 1',
                ],
                'date' => '2026-04-18',
            ], JSON_THROW_ON_ERROR),
            (string) $httpClient->requests[0]->getBody()
        );
    }

    public function test_create_intake_returns_typed_async_response(): void
    {
        $httpClient = new FakeHttpClient([
            new FakeResponse(202, '{"entity":{"uuid":"intake-uuid"},"requests":[{"request_uuid":"req-intake-1","type":"CREATE","state":"ACCEPTED"}]}'),
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

        $response = $client->intakes()->create(new CreateIntakeRequest([
            'order_uuid' => 'order-uuid',
            'intake_date' => '2026-03-30',
            'intake_time_from' => '10:00',
            'intake_time_to' => '14:00',
        ]));

        self::assertInstanceOf(AsyncResponse::class, $response);
        self::assertSame('intake-uuid', $response->entity?->uuid);
        self::assertSame('ACCEPTED', $response->requests[0]->state);
        self::assertCount(1, $httpClient->requests);
        self::assertSame('POST', $httpClient->requests[0]->getMethod());
        self::assertStringContainsString('/v2/intakes', (string) $httpClient->requests[0]->getUri());
        self::assertJsonStringEqualsJsonString(
            json_encode([
                'order_uuid' => 'order-uuid',
                'intake_date' => '2026-03-30',
                'intake_time_from' => '10:00',
                'intake_time_to' => '14:00',
            ], JSON_THROW_ON_ERROR),
            (string) $httpClient->requests[0]->getBody()
        );
    }

    public function test_get_intake_by_uuid_returns_typed_intake(): void
    {
        $httpClient = new FakeHttpClient([
            new FakeResponse(200, '{"uuid":"intake-uuid","cdek_number":"1234567890","order_uuid":"order-uuid","intake_date":"2026-03-31","intake_time_from":"10:00","intake_time_to":"14:00","name":"John Doe","weight":5000,"length":30,"width":20,"height":10,"comment":"Call on arrival","need_call":true,"courier_power_of_attorney":true,"courier_identity_card":false,"packages":[{"package_id":"PKG-1","weight":3000,"length":20,"width":15,"height":10},{"package_id":"PKG-2","weight":2000,"length":10,"width":5,"height":5}],"statuses":[{"code":"CREATED","name":"Created","date_time":"2026-03-30T10:00:00+03:00"}],"from_location":{"code":44,"city":"Moscow","address":"Red Square, 1"},"to_location":{"code":137,"city":"Saint Petersburg","address":"Nevsky, 10"},"sender":{"company":"Sender LLC","name":"Alice","email":"alice@example.com","phones":[{"number":"+79990000000"}]}}'),
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

        $response = $client->intakes()->getByUuid('72753031-e66b-4146-ab8c-52179ef4020a');

        self::assertInstanceOf(OrderIntakeDto::class, $response);
        self::assertSame('intake-uuid', $response->uuid);
        self::assertSame('1234567890', $response->cdekNumber);
        self::assertSame('order-uuid', $response->orderUuid);
        self::assertSame('John Doe', $response->name);
        self::assertTrue($response->needCall);
        self::assertSame('Moscow', $response->fromLocation?->city);
        self::assertSame('Saint Petersburg', $response->toLocation?->city);
        self::assertSame('Sender LLC', $response->sender?->company);
        self::assertSame('Alice', $response->sender?->name);
        self::assertCount(1, $response->sender?->phones ?? []);
        self::assertSame('+79990000000', $response->sender?->phones[0]->number);
        self::assertCount(2, $response->packages);
        self::assertSame('PKG-1', $response->packages[0]->packageId);
        self::assertCount(1, $response->statuses);
        self::assertSame('CREATED', $response->statuses[0]->code);
        self::assertCount(1, $httpClient->requests);
        self::assertSame('GET', $httpClient->requests[0]->getMethod());
        self::assertStringContainsString('/v2/intakes/72753031-e66b-4146-ab8c-52179ef4020a', (string) $httpClient->requests[0]->getUri());
    }

    public function test_delete_intake_returns_typed_async_response(): void
    {
        $httpClient = new FakeHttpClient([
            new FakeResponse(200, '{"entity":{"uuid":"deleted-intake-uuid"},"requests":[{"request_uuid":"req-delete-intake-1","type":"DELETE","state":"ACCEPTED"}]}'),
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

        $response = $client->intakes()->delete('72753031-e66b-4146-ab8c-52179ef4020a');

        self::assertInstanceOf(AsyncResponse::class, $response);
        self::assertSame('deleted-intake-uuid', $response->entity?->uuid);
        self::assertSame('DELETE', $response->requests[0]->type);
        self::assertSame('ACCEPTED', $response->requests[0]->state);
        self::assertCount(1, $httpClient->requests);
        self::assertSame('DELETE', $httpClient->requests[0]->getMethod());
        self::assertStringContainsString('/v2/intakes/72753031-e66b-4146-ab8c-52179ef4020a', (string) $httpClient->requests[0]->getUri());
    }

    public function test_create_orders_print_returns_typed_async_response(): void
    {
        $httpClient = new FakeHttpClient([
            new FakeResponse(202, '{"entity":{"uuid":"print-orders-uuid"},"requests":[{"request_uuid":"req-print-1","type":"CREATE","state":"ACCEPTED"}]}'),
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

        $response = $client->prints()->createOrders(new CreateOrdersPrintRequest(
            orders: [
                new PrintOrderReferenceDto(orderUuid: 'order-uuid'),
            ],
            copyCount: 2,
        ));

        self::assertInstanceOf(AsyncResponse::class, $response);
        self::assertSame('print-orders-uuid', $response->entity?->uuid);
        self::assertSame('ACCEPTED', $response->requests[0]->state);
        self::assertCount(1, $httpClient->requests);
        self::assertSame('POST', $httpClient->requests[0]->getMethod());
        self::assertStringContainsString('/v2/print/orders', (string) $httpClient->requests[0]->getUri());
    }

    public function test_create_barcodes_print_returns_typed_async_response(): void
    {
        $httpClient = new FakeHttpClient([
            new FakeResponse(202, '{"entity":{"uuid":"print-barcodes-uuid"},"requests":[{"request_uuid":"req-barcode-1","type":"CREATE","state":"ACCEPTED"}]}'),
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
        $response = $client->prints()->createBarcodes(new CreateBarcodesPrintRequest(
            orders: [
                new PrintOrderReferenceDto(orderUuid: 'order-uuid'),
            ],
            copyCount: 1,
        ));

        self::assertInstanceOf(AsyncResponse::class, $response);
        self::assertSame('print-barcodes-uuid', $response->entity?->uuid);
        self::assertSame('ACCEPTED', $response->requests[0]->state);
        self::assertCount(1, $httpClient->requests);
        self::assertSame('POST', $httpClient->requests[0]->getMethod());
        self::assertStringContainsString('/v2/print/barcodes', (string) $httpClient->requests[0]->getUri());
    }

    public function test_get_barcodes_print_by_uuid_returns_typed_response(): void
    {
        $httpClient = new FakeHttpClient([
            new FakeResponse(200, '{"entity":{"uuid":null},"requests":[{"request_uuid":null,"type":null,"date_time":null,"state":"READY","errors":[{"code":null,"additional_code":null,"message":null}],"warnings":[{"code":null,"message":null}]}],"related_entities":[{"uuid":null,"type":"return_order","url":"https://example.test/related","create_time":null,"cdek_number":"123456","date":null,"time_from":"15:00","time_to":"15:00"}]}'),
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

        $response = $client->prints()->getBarcodesByUuid('72753031-e66b-4146-ab8c-52179ef4020a');

        self::assertInstanceOf(PrintBarcodesResponse::class, $response);
        self::assertNull($response->entity?->uuid);
        self::assertCount(1, $response->requests);
        self::assertSame('READY', $response->requests[0]->state);
        self::assertCount(1, $response->requests[0]->errors);
        self::assertNull($response->requests[0]->errors[0]->code);
        self::assertCount(1, $response->requests[0]->warnings);
        self::assertNull($response->requests[0]->warnings[0]->message);
        self::assertCount(1, $response->relatedEntities);
        self::assertSame('return_order', $response->relatedEntities[0]->type);
        self::assertSame('123456', $response->relatedEntities[0]->cdekNumber);
        self::assertSame('15:00', $response->relatedEntities[0]->timeFrom);
        self::assertSame('15:00', $response->relatedEntities[0]->timeTo);
        self::assertCount(1, $httpClient->requests);
        self::assertSame('GET', $httpClient->requests[0]->getMethod());
        self::assertStringContainsString('/v2/print/barcodes/72753031-e66b-4146-ab8c-52179ef4020a', (string) $httpClient->requests[0]->getUri());
    }
    public function test_download_barcodes_pdf_returns_raw_pdf_body(): void
    {
        $httpClient = new FakeHttpClient([
            new FakeResponse(200, '%PDF-1.4 fake pdf body'),
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

        $response = $client->prints()->downloadBarcodesPdf('72753031-e66b-4146-ab8c-52179ef4020a');

        self::assertSame('%PDF-1.4 fake pdf body', $response);
        self::assertCount(1, $httpClient->requests);
        self::assertSame('GET', $httpClient->requests[0]->getMethod());
        self::assertSame('application/pdf', $httpClient->requests[0]->getHeaderLine('Accept'));
        self::assertStringContainsString('/v2/print/barcodes/72753031-e66b-4146-ab8c-52179ef4020a.pdf', (string) $httpClient->requests[0]->getUri());
    }

    public function test_send_raw_request_returns_status_headers_and_body_without_decoding(): void
    {
        $httpClient = new FakeHttpClient([
            (new FakeResponse(418, 'plain text error'))
                ->withHeader('X-Trace-Id', 'trace-1'),
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

        $response = $client->sendRawRequest('POST', '/v2/raw', ['foo' => 'bar'], ['hello' => 'world']);

        self::assertSame(418, $response->statusCode);
        self::assertSame('plain text error', $response->body);
        self::assertSame('trace-1', $response->getHeaderLine('X-Trace-Id'));
        self::assertCount(1, $httpClient->requests);
        self::assertSame('POST', $httpClient->requests[0]->getMethod());
        self::assertSame('application/json', $httpClient->requests[0]->getHeaderLine('Accept'));
        self::assertSame('application/json', $httpClient->requests[0]->getHeaderLine('Content-Type'));
        self::assertSame('Bearer test-token', $httpClient->requests[0]->getHeaderLine('Authorization'));
        self::assertStringContainsString('/v2/raw?foo=bar', (string) $httpClient->requests[0]->getUri());
        self::assertJsonStringEqualsJsonString(
            '{"hello":"world"}',
            (string) $httpClient->requests[0]->getBody()
        );
    }

    public function test_location_bad_request_returns_simplified_error_response(): void
    {
        $httpClient = new FakeHttpClient([
            new FakeResponse(400, '{"errors":[{"code":"bad_request","additional_code":"0x01","message":"Top level error"}],"warnings":[{"code":"warn_1","message":"Top level warning"}]}'),
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

        try {
            $client->locations()->getRegions(new GetRegionsRequest(countryCodes: 'RU'));
            self::fail('Expected ApiException was not thrown.');
        } catch (ApiException $exception) {
            self::assertSame(400, $exception->getStatusCode());
            $response = $exception->getResponse();
        }

        self::assertInstanceOf(SimplifiedResponseDto::class, $response);
        self::assertCount(1, $response->errors);
        self::assertSame('bad_request', $response->errors[0]->code);
        self::assertSame('Top level error', $response->errors[0]->message);
    }

    public function test_location_bad_request_collects_nested_request_errors(): void
    {
        $httpClient = new FakeHttpClient([
            new FakeResponse(400, '{"requests":[{"errors":[{"code":"v2_field_is_empty","additional_code":"0x1E0EBE20","message":"[code] is empty"}],"warnings":[{"code":"warn_nested","message":"Nested warning"}]}]}'),
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

        try {
            $client->locations()->getPostalcodes(new GetPostalcodesRequest(code: 44));
            self::fail('Expected ApiException was not thrown.');
        } catch (ApiException $exception) {
            self::assertSame(400, $exception->getStatusCode());
            $response = $exception->getResponse();
        }

        self::assertInstanceOf(SimplifiedResponseDto::class, $response);
        self::assertCount(1, $response->errors);
        self::assertSame('v2_field_is_empty', $response->errors[0]->code);
        self::assertSame('[code] is empty', $response->errors[0]->message);
    }

    public function test_successful_async_response_with_accepted_state_does_not_throw(): void
    {
        $httpClient = new FakeHttpClient([
            new FakeResponse(202, '{"entity":{"uuid":"order-uuid"},"requests":[{"request_uuid":"req-1","state":"ACCEPTED"}]}'),
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

        $response = $client->orders()->create(
            OrderCreateRequestDto::make(
                tariffCode: 139,
                sender: new SenderContactDto(
                    name: 'Wishbox Sender',
                    phones: [new PhoneDto(number: '+79990000001')],
                ),
                recipient: new RecipientContactDto(
                    name: 'John Doe',
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
                ->withToLocation(new RequestToLocationDto(code: 137, address: 'Pushkina 1'))
        );

        self::assertSame('order-uuid', $response->entity?->uuid);
        self::assertSame('ACCEPTED', $response->requests[0]->state);
    }

    public function test_api_response_exception_is_thrown_for_async_business_errors(): void
    {
        $httpClient = new FakeHttpClient([
            new FakeResponse(200, '{"requests":[{"request_uuid":"req-1","state":"INVALID","errors":[{"code":"error_validate_im_dep_number_has_already_had_integration","message":"Order already exists"}],"warnings":[{"code":"warn_nested","message":"Nested warning"}]}]}'),
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

        try {
            $client->orders()->create(
                OrderCreateRequestDto::make(
                    tariffCode: 139,
                    sender: new SenderContactDto(
                        name: 'Wishbox Sender',
                        phones: [new PhoneDto(number: '+79990000001')],
                    ),
                    recipient: new RecipientContactDto(
                        name: 'John Doe',
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
                    ->withToLocation(new RequestToLocationDto(code: 137, address: 'Pushkina 1'))
            );
            self::fail('Expected ApiResponseException was not thrown.');
        } catch (ApiResponseException $exception) {
            self::assertSame('Order already exists', $exception->getMessage());
            self::assertSame(['INVALID'], $exception->getRequestStates());
            self::assertCount(1, $exception->getErrors());
            self::assertCount(1, $exception->getWarnings());
            self::assertSame('error_validate_im_dep_number_has_already_had_integration', $exception->getErrors()[0]->code);
            self::assertSame('Nested warning', $exception->getWarnings()[0]->message);
        }
    }
}
