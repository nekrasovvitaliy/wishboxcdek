<?php

declare(strict_types=1);

namespace Tests\Integration;

use WishboxCdek\Request\Location\GetPostalcodesRequest;
use WishboxCdek\Response\Location\Postalcodes;

final class LocationPostalcodesIntegrationTest extends CdekIntegrationTestCase
{
    public function test_get_postalcodes_returns_data_from_cdek_sandbox(): void
    {
        $client = $this->createClient();

        $response = $client->locations()->getPostalcodes(new GetPostalcodesRequest(code: 44));

        self::assertInstanceOf(Postalcodes::class, $response);
        self::assertGreaterThanOrEqual(0, $response->code);
        self::assertIsArray($response->postalCodes);
    }
}
