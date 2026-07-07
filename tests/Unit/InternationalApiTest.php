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
use WishboxCdek\Request\International\CheckPackageRestrictionsRequest;
use WishboxCdek\Request\International\LocationDto;
use WishboxCdek\Request\International\RestrictionPackageItemRequestDto;
use WishboxCdek\Request\International\RestrictionPackageRequestDto;
use WishboxCdek\Response\International\PackageRestrictionsResponse;
use WishboxCdek\Response\International\RestrictionItemDto;
use WishboxCdek\Response\International\RestrictionPackageDto;
use WishboxCdek\Response\Error\SimplifiedResponseDto1;

final class InternationalApiTest extends TestCase
{
    public function test_check_package_restrictions_sends_typed_request_payload(): void
    {
        $httpClient = new FakeHttpClient([
            new FakeResponse(200, '{"packages":[{"package_id":"PKG-1","status":{"code":"ALLOWED","name":"Allowed"},"items":[{"item_id":"ITEM-1","feacn_code":"8517130000","status":{"code":"ALLOWED","name":"Allowed"}}]}]}'),
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

        $request = new CheckPackageRestrictionsRequest(
            tariffCode: 7,
            fromLocation: new LocationDto(
                code: 44,
                city: 'Moscow',
                countryCode: 'RU',
                address: 'Tverskaya 1',
                postalCode: '101000',
            ),
            toLocation: new LocationDto(
                code: 137,
                city: 'Almaty',
                countryCode: 'KZ',
                address: 'Abay 10',
                postalCode: '050000',
            ),
            packages: [
                new RestrictionPackageRequestDto(
                    weight: 1000,
                    length: 10,
                    width: 20,
                    height: 30,
                    items: [
                        new RestrictionPackageItemRequestDto(
                            name: 'Phone',
                            amount: 1,
                            itemId: 'ITEM-1',
                            feacnCode: '8517130000',
                        ),
                    ],
                    packageId: 'PKG-1',
                ),
            ],
        );

        $response = $client->international()->checkPackageRestrictions($request);

        self::assertInstanceOf(PackageRestrictionsResponse::class, $response);
        self::assertCount(1, $response->packages);
        self::assertContainsOnlyInstancesOf(RestrictionPackageDto::class, $response->packages);
        self::assertSame('PKG-1', $response->packages[0]->packageId);
        self::assertSame('ALLOWED', $response->packages[0]->status?->code);
        self::assertSame('Allowed', $response->packages[0]->status?->name);
        self::assertCount(1, $response->packages[0]->items);
        self::assertContainsOnlyInstancesOf(RestrictionItemDto::class, $response->packages[0]->items);
        self::assertSame('ITEM-1', $response->packages[0]->items[0]->itemId);
        self::assertSame('8517130000', $response->packages[0]->items[0]->feacnCode);
        self::assertSame('ALLOWED', $response->packages[0]->items[0]->status?->code);
        self::assertSame('Allowed', $response->packages[0]->items[0]->status?->name);
        self::assertSame([], $response->errors);
        self::assertSame([], $response->warnings);
        self::assertCount(1, $httpClient->requests);
        self::assertSame('POST', $httpClient->requests[0]->getMethod());
        self::assertSame('Bearer test-token', $httpClient->requests[0]->getHeaderLine('Authorization'));
        self::assertSame('application/json', $httpClient->requests[0]->getHeaderLine('Content-Type'));
        self::assertStringContainsString('/v2/international/package/restrictions', (string) $httpClient->requests[0]->getUri());
        self::assertJsonStringEqualsJsonString(
            json_encode([
                'tariff_code' => 7,
                'from_location' => [
                    'code' => 44,
                    'city' => 'Moscow',
                    'country_code' => 'RU',
                    'address' => 'Tverskaya 1',
                    'postal_code' => '101000',
                ],
                'to_location' => [
                    'code' => 137,
                    'city' => 'Almaty',
                    'country_code' => 'KZ',
                    'address' => 'Abay 10',
                    'postal_code' => '050000',
                ],
                'packages' => [
                    [
                        'weight' => 1000,
                        'length' => 10,
                        'width' => 20,
                        'height' => 30,
                        'items' => [
                            [
                                'name' => 'Phone',
                                'amount' => 1,
                                'item_id' => 'ITEM-1',
                                'feacn_code' => '8517130000',
                            ],
                        ],
                        'package_id' => 'PKG-1',
                    ],
                ],
            ], JSON_THROW_ON_ERROR),
            (string) $httpClient->requests[0]->getBody()
        );
    }

    public function test_package_restrictions_response_hydrates_errors_and_warnings(): void
    {
        $response = PackageRestrictionsResponse::fromArray([
            'errors' => [
                [
                    'code' => 'v2_sender_location_not_recognized',
                    'message' => 'Sender location is not recognized. Check your input data and try to provide more details such as: code, postal code, location name, FIAS code, or region name',
                ],
            ],
            'warnings' => [
                [
                    'code' => 'warning_code',
                    'message' => 'Check data',
                ],
            ],
        ]);

        self::assertSame([], $response->packages);
        self::assertCount(1, $response->errors);
        self::assertSame('v2_sender_location_not_recognized', $response->errors[0]->code);
        self::assertSame('Sender location is not recognized. Check your input data and try to provide more details such as: code, postal code, location name, FIAS code, or region name', $response->errors[0]->message);
        self::assertNull($response->errors[0]->additionalCode);
        self::assertCount(1, $response->warnings);
        self::assertSame('warning_code', $response->warnings[0]->code);
        self::assertSame('Check data', $response->warnings[0]->message);
    }

    public function test_check_package_restrictions_returns_simplified_response_for_bad_request(): void
    {
        $httpClient = new FakeHttpClient([
            new FakeResponse(400, '{"errors":[{"code":"v2_field_is_empty","additional_code":"0x1","message":"[packages] is empty"}]}'),
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

        $request = new CheckPackageRestrictionsRequest(
            tariffCode: 7,
            fromLocation: new LocationDto(code: 44),
            toLocation: new LocationDto(code: 137),
            packages: [],
        );

        try {
            $client->international()->checkPackageRestrictions($request);
            self::fail('Expected ApiException was not thrown.');
        } catch (ApiException $exception) {
            self::assertSame(400, $exception->getStatusCode());
            $response = $exception->getResponse();
        }

        self::assertInstanceOf(SimplifiedResponseDto1::class, $response);
        self::assertCount(1, $response->errors);
        self::assertSame('v2_field_is_empty', $response->errors[0]->code);
        self::assertSame('0x1', $response->errors[0]->additionalCode);
        self::assertSame('[packages] is empty', $response->errors[0]->message);
    }
}
