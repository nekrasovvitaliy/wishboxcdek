<?php

declare(strict_types=1);

namespace Tests\Integration;

use Tests\Integration\Support\CreatesOrderRequests;
use WishboxCdek\Response\Async\AsyncResponse;
use WishboxCdek\Response\Order\OrderDetails;

final class OrderApiIntegrationTest extends CdekIntegrationTestCase
{
    use CreatesOrderRequests;

    public function test_create_order_returns_typed_async_response(): void
    {
        $client = $this->createClient();
        $createRequest = $this->createValidOrderRequest();

        $createResponse = $client->orders()->create($createRequest);

        self::assertInstanceOf(AsyncResponse::class, $createResponse);
        self::assertNotNull($createResponse->entity);
        self::assertNotSame('', $response->entity?->uuid ?? '');
        self::assertNotEmpty($createResponse->requests);
        self::assertNotNull($createResponse->requests[0]->requestUuid);
        self::assertContains($response->requests[0]->state, ['ACCEPTED', 'WAITING']);
    }

    public function test_get_order_by_uuid_returns_order_data(): void
    {
        $client = $this->createClient();
        $createRequest = $this->createValidOrderRequest();
        $createResponse = $client->orders()->create($createRequest);

        $orderUuid = $createResponse->entity?->uuid;

        self::assertNotNull($orderUuid);
        self::assertNotSame('', $orderUuid);

        $order = null;

        for ($attempt = 0; $attempt < 5; $attempt++) {
            $order = $client->orders()->getByUuid($orderUuid);

            if ($order->entity !== null) {
                break;
            }

            usleep(500000);
        }

        self::assertInstanceOf(OrderDetails::class, $order);
        self::assertNotNull($order->entity);
        self::assertSame($orderUuid, $order->entity?->uuid);
    }
}

