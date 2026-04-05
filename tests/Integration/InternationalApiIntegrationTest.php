<?php

declare(strict_types=1);

namespace Tests\Integration;

use WishboxCdek\Request\International\CheckPackageRestrictionsRequest;
use WishboxCdek\Request\International\LocationDto;
use WishboxCdek\Request\International\RestrictionPackageItemRequestDto;
use WishboxCdek\Request\International\RestrictionPackageRequestDto;
use WishboxCdek\Response\International\PackageRestrictionsResponse;
use WishboxCdek\Response\International\RestrictionPackageDto;

final class InternationalApiIntegrationTest extends CdekIntegrationTestCase
{
    public function test_check_package_restrictions_returns_typed_response_from_sandbox(): void
    {
        $client = $this->createClient();

        $request = new CheckPackageRestrictionsRequest(
            tariffCode: 7,
            fromLocation: new LocationDto(
                code: 1,
                countryCode: 'RU',
                city: 'Moscow',
                postalCode: '101000',
                address: 'Tverskaya 1',
            ),
            toLocation: new LocationDto(
                countryCode: 'KZ',
                city: 'Almaty',
                postalCode: '050000',
                address: 'Abay 10',
            ),
            packages: [
                new RestrictionPackageRequestDto(
                    weight: 1000,
                    length: 10,
                    width: 10,
                    height: 10,
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
        self::assertNotEmpty($response->packages);
        self::assertContainsOnlyInstancesOf(RestrictionPackageDto::class, $response->packages);
        self::assertNotSame('', $response->packages[0]->packageId ?? '');
        self::assertNotNull($response->packages[0]->status?->code);
    }
}
