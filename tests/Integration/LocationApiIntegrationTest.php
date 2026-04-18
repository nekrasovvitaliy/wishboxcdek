<?php

declare(strict_types=1);

namespace Tests\Integration;

use WishboxCdek\Request\Location\GetCitiesRequest;
use WishboxCdek\Request\Location\GetRegionsRequest;
use WishboxCdek\Response\Location\CityDto;
use WishboxCdek\Response\Location\RegionDto;

final class LocationApiIntegrationTest extends CdekIntegrationTestCase
{
    public function test_get_regions_returns_data_from_cdek_sandbox(): void
    {
        $client = $this->createClient();

        $response = $client->locations()->getRegions(new GetRegionsRequest(
            countryCodes: 'RU',
            size: 10,
        ));

        self::assertIsArray($response);
        self::assertNotEmpty($response);
        self::assertContainsOnlyInstancesOf(RegionDto::class, $response);
        self::assertNotSame('', $response[0]->region);
    }

    public function test_get_cities_returns_data_from_cdek_sandbox(): void
    {
        $client = $this->createClient();

        $response = $client->locations()->getCities(new GetCitiesRequest(
            countryCodes: 'RU,KZ,BY',
            size: 10,
        ));

        self::assertIsArray($response);
        self::assertNotEmpty($response);
        self::assertContainsOnlyInstancesOf(CityDto::class, $response);
        self::assertNotSame('', $response[0]->city);
        self::assertContains($response[0]->countryCode, ['RU', 'KZ']);
    }
}
