<?php

declare(strict_types=1);

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Tests\Support\Http\FakeHttpClient;
use Tests\Support\Http\FakeRequestFactory;
use Tests\Support\Http\FakeResponse;
use Tests\Support\Http\FakeStreamFactory;
use WishboxCdek\CdekClient;
use WishboxCdek\Exception\PrealertValidationException;
use WishboxCdek\Exception\InvalidUuidException;
use WishboxCdek\Request\Prealert\PrealertOrderDto as PrealertOrderRequestDto;
use WishboxCdek\Request\Prealert\RegisterPrealertRequest;
use WishboxCdek\Response\Async\AsyncResponse;
use WishboxCdek\Response\Prealert\PrealertDetailsResponse;
use WishboxCdek\Response\Prealert\PrealertEntityDto;
use WishboxCdek\Response\Prealert\PrealertOrderDto;
use WishboxCdek\Response\Prealert\PrealertPackageDto;

final class PrealertApiTest extends TestCase
{
    public function test_register_throws_validation_exception_before_http_request(): void
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

        $request = new RegisterPrealertRequest(
            plannedDate: '',
            shipmentPoint: '',
            orders: [
                new PrealertOrderRequestDto(),
            ],
        );

        try {
            $client->prealerts()->register($request);
            self::fail('Expected PrealertValidationException to be thrown.');
        } catch (PrealertValidationException $exception) {
            self::assertSame(
                'planned_date is required.; shipment_point is required.; orders[0] must contain at least one of: order_uuid, cdek_number, im_number.',
                $exception->getMessage()
            );
            self::assertSame(
                [
                    'planned_date is required.',
                    'shipment_point is required.',
                    'orders[0] must contain at least one of: order_uuid, cdek_number, im_number.',
                ],
                $exception->getErrors()
            );
        }

        self::assertCount(0, $httpClient->requests);
    }

    public function test_register_sends_typed_request_and_returns_async_response(): void
    {
        $httpClient = new FakeHttpClient([
            new FakeResponse(202, '{"entity":{"uuid":"prealert-uuid"},"requests":[{"request_uuid":"request-uuid","type":"CREATE","date_time":"2026-04-02T10:00:00+0000","state":"ACCEPTED","errors":[],"warnings":[]}],"related_entities":[{"uuid":"related-uuid","type":"return_order","url":"https://example.test/entity","create_time":"2026-04-02T10:00:01+0000","cdek_number":"123456","date":"2026-04-03","time_from":"15:00","time_to":"18:00"}]}'),
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

        $request = new RegisterPrealertRequest(
            plannedDate: '2026-04-03T09:00:00+0000',
            shipmentPoint: 'MSK123',
            orders: [
                new PrealertOrderRequestDto(orderUuid: 'order-uuid', cdekNumber: '1000014101', imNumber: 'IM-1'),
            ],
        );

        $response = $client->prealerts()->register($request);

        self::assertInstanceOf(AsyncResponse::class, $response);
        self::assertSame('prealert-uuid', $response->entity?->uuid);
        self::assertCount(1, $response->requests);
        self::assertSame('ACCEPTED', $response->requests[0]->state);
        self::assertCount(1, $response->relatedEntities);
        self::assertSame('related-uuid', $response->relatedEntities[0]->uuid);
        self::assertCount(1, $httpClient->requests);
        self::assertSame('POST', $httpClient->requests[0]->getMethod());
        self::assertSame('Bearer test-token', $httpClient->requests[0]->getHeaderLine('Authorization'));
        self::assertSame('application/json', $httpClient->requests[0]->getHeaderLine('Content-Type'));
        self::assertStringContainsString('/v2/prealert', (string) $httpClient->requests[0]->getUri());
        self::assertJsonStringEqualsJsonString(
            json_encode([
                'planned_date' => '2026-04-03T09:00:00+0000',
                'shipment_point' => 'MSK123',
                'orders' => [
                    [
                        'order_uuid' => 'order-uuid',
                        'cdek_number' => '1000014101',
                        'im_number' => 'IM-1',
                    ],
                ],
            ], JSON_THROW_ON_ERROR),
            (string) $httpClient->requests[0]->getBody()
        );
    }

    public function test_get_by_uuid_returns_typed_prealert_response(): void
    {
        $httpClient = new FakeHttpClient([
            new FakeResponse(200, '{"entity":{"uuid":"prealert-uuid","prealert_number":"PA-100","planned_date":"2026-04-03T09:00:00+0000","shipment_point":"MSK123","closed_date":"2026-04-03T12:00:00+0000","fact_shipment_point":"MSK124","orders":[{"order_uuid":"order-uuid","cdek_number":"1000014101","im_number":"IM-1","packages":[{"package_id":"PKG-1","number":"1","status":"ACCEPTED"}]}]},"requests":[{"request_uuid":"request-uuid","type":"GET","date_time":"2026-04-02T10:01:00+0000","state":"INVALID","errors":[{"code":"validation_error","additional_code":"0x1","message":"Order issue"}],"warnings":[]}],"related_entities":[{"uuid":"related-uuid","type":"return_order","url":"https://example.test/entity","create_time":"2026-04-02T10:00:01+0000","cdek_number":"123456","date":"2026-04-03","time_from":"15:00","time_to":"18:00"}]}'),
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

        $response = $client->prealerts()->getByUuid('72753031-e66b-4146-ab8c-52179ef4020a');

        self::assertInstanceOf(PrealertDetailsResponse::class, $response);
        self::assertInstanceOf(PrealertEntityDto::class, $response->entity);
        self::assertSame('PA-100', $response->entity?->prealertNumber);
        self::assertSame('MSK123', $response->entity?->shipmentPoint);
        self::assertCount(1, $response->entity?->orders ?? []);
        self::assertContainsOnlyInstancesOf(PrealertOrderDto::class, $response->entity?->orders ?? []);
        self::assertSame('1000014101', $response->entity?->orders[0]->cdekNumber);
        self::assertCount(1, $response->entity?->orders[0]->packages);
        self::assertContainsOnlyInstancesOf(PrealertPackageDto::class, $response->entity?->orders[0]->packages);
        self::assertSame('ACCEPTED', $response->entity?->orders[0]->packages[0]->status);
        self::assertCount(1, $response->requests);
        self::assertSame('INVALID', $response->requests[0]->state);
        self::assertCount(1, $response->relatedEntities);
        self::assertSame('related-uuid', $response->relatedEntities[0]->uuid);
        self::assertCount(1, $httpClient->requests);
        self::assertSame('GET', $httpClient->requests[0]->getMethod());
        self::assertSame('Bearer test-token', $httpClient->requests[0]->getHeaderLine('Authorization'));
        self::assertStringContainsString('/v2/prealert/72753031-e66b-4146-ab8c-52179ef4020a', (string) $httpClient->requests[0]->getUri());
    }
}
