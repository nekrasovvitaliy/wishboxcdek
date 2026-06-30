<?php

declare(strict_types=1);

namespace Tests\Integration;

use WishboxCdek\Request\DeliveryPoint\GetDeliveryPointsRequest;
use WishboxCdek\Response\DeliveryPoint\DeliveryPointListResponse;
use WishboxCdek\Response\DeliveryPoint\OfficeDto;

final class DeliveryPointApiIntegrationTest extends CdekIntegrationTestCase
{
    public function test_get_delivery_points_returns_ten_points_from_armenia(): void
    {
        $client = $this->createClient();

        $response = $client->deliveryPoints()->getList(new GetDeliveryPointsRequest(
            countryCode: 'AM',
            size: 10,
        ));

        self::assertInstanceOf(DeliveryPointListResponse::class, $response);
        self::assertCount(10, $response);
        self::assertContainsOnlyInstancesOf(OfficeDto::class, $response);

        foreach ($response as $deliveryPoint) {
            self::assertNotSame('', $deliveryPoint->code);
            self::assertSame('AM', $deliveryPoint->location?->countryCode);
        }
    }
}
