<?php

declare(strict_types=1);

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Tests\Support\Http\FakeHttpClient;
use Tests\Support\Http\FakeRequestFactory;
use Tests\Support\Http\FakeResponse;
use Tests\Support\Http\FakeStreamFactory;
use WishboxCdek\CdekClient;
use WishboxCdek\Exception\DeliveryValidationException;
use WishboxCdek\Exception\InvalidUuidException;
use WishboxCdek\Enum\AdditionalOrderType;
use WishboxCdek\Request\Delivery\EstimatedDeliveryLocationDto;
use WishboxCdek\Request\Delivery\GetDeliveryIntervalsRequest;
use WishboxCdek\Request\Delivery\GetEstimatedDeliveryIntervalsRequest;
use WishboxCdek\Request\Delivery\LocationDto;
use WishboxCdek\Request\Delivery\RegisterDeliveryRequest;
use WishboxCdek\Response\Async\AsyncResponse;
use WishboxCdek\Response\Delivery\DeliveryDateIntervalDto;
use WishboxCdek\Response\Delivery\DeliveryDetailsResponse;
use WishboxCdek\Response\Delivery\DeliveryEntityDto;
use WishboxCdek\Response\Delivery\DeliveryIntervalsResponse;
use WishboxCdek\Response\Delivery\DeliveryLocationDto;
use WishboxCdek\Response\Delivery\DeliveryStatusDto;
use WishboxCdek\Response\Delivery\DeliveryTimeIntervalDto;
use WishboxCdek\Response\Delivery\EstimatedDeliveryDateIntervalDto;
use WishboxCdek\Response\Delivery\EstimatedDeliveryIntervalsResponse;
use WishboxCdek\Response\Delivery\EstimatedDeliveryTimeIntervalDto;

final class DeliveryApiTest extends TestCase
{
    public function test_get_intervals_returns_typed_response(): void
    {
        $httpClient = new FakeHttpClient([
            new FakeResponse(200, '{"date_intervals":[{"date":"2026-04-02","time_intervals":[{"start_time":"09:00","end_time":"12:00"},{"start_time":"14:00","end_time":"18:00"}]}]}'),
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

        $request = new GetDeliveryIntervalsRequest(orderUuid: '72753031-e66b-4146-ab8c-52179ef4020a');

        $response = $client->delivery()->getIntervals($request);

        self::assertInstanceOf(DeliveryIntervalsResponse::class, $response);
        self::assertCount(1, $response->dateIntervals);
        self::assertContainsOnlyInstancesOf(DeliveryDateIntervalDto::class, $response->dateIntervals);
        self::assertSame('2026-04-02', $response->dateIntervals[0]->date);
        self::assertCount(2, $response->dateIntervals[0]->timeIntervals);
        self::assertContainsOnlyInstancesOf(DeliveryTimeIntervalDto::class, $response->dateIntervals[0]->timeIntervals);
        self::assertSame('09:00', $response->dateIntervals[0]->timeIntervals[0]->startTime);
        self::assertSame('12:00', $response->dateIntervals[0]->timeIntervals[0]->endTime);
        self::assertSame('14:00', $response->dateIntervals[0]->timeIntervals[1]->startTime);
        self::assertSame('18:00', $response->dateIntervals[0]->timeIntervals[1]->endTime);
        self::assertCount(1, $httpClient->requests);
        self::assertSame('GET', $httpClient->requests[0]->getMethod());
        self::assertSame('Bearer test-token', $httpClient->requests[0]->getHeaderLine('Authorization'));
        self::assertStringContainsString('/v2/delivery/intervals', (string) $httpClient->requests[0]->getUri());
        self::assertStringContainsString('order_uuid=72753031-e66b-4146-ab8c-52179ef4020a', (string) $httpClient->requests[0]->getUri());
    }

    
    public function test_get_estimated_intervals_returns_typed_response(): void
    {
        $httpClient = new FakeHttpClient([
            new FakeResponse(200, '{"date_intervals":[{"date":"2026-04-03","time_intervals":[{"start_time":"10:00","end_time":"12:00","agreed_count":3,"total_count":10},{"start_time":"12:00","end_time":"14:00","agreed_count":5,"total_count":12}]}]}'),
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

        $request = new GetEstimatedDeliveryIntervalsRequest(
            dateTime: '2021-08-03T13:08:49Z',
            fromLocation: new EstimatedDeliveryLocationDto(city: 'Moscow', address: 'Lenina 1'),
            toLocation: new EstimatedDeliveryLocationDto(code: 44, city: 'Moscow', address: 'Tverskaya 1'),
            tariffCode: 137,
            additionalOrderTypes: [AdditionalOrderType::LTL],
        );

        $response = $client->delivery()->getEstimatedIntervals($request);

        self::assertInstanceOf(EstimatedDeliveryIntervalsResponse::class, $response);
        self::assertCount(1, $response->dateIntervals);
        self::assertContainsOnlyInstancesOf(EstimatedDeliveryDateIntervalDto::class, $response->dateIntervals);
        self::assertSame('2026-04-03', $response->dateIntervals[0]->date);
        self::assertCount(2, $response->dateIntervals[0]->timeIntervals);
        self::assertContainsOnlyInstancesOf(EstimatedDeliveryTimeIntervalDto::class, $response->dateIntervals[0]->timeIntervals);
        self::assertSame('10:00', $response->dateIntervals[0]->timeIntervals[0]->startTime);
        self::assertSame('12:00', $response->dateIntervals[0]->timeIntervals[0]->endTime);
        self::assertSame(3, $response->dateIntervals[0]->timeIntervals[0]->agreedCount);
        self::assertSame(10, $response->dateIntervals[0]->timeIntervals[0]->totalCount);
        self::assertCount(1, $httpClient->requests);
        self::assertSame('POST', $httpClient->requests[0]->getMethod());
        self::assertSame('Bearer test-token', $httpClient->requests[0]->getHeaderLine('Authorization'));
        self::assertSame('application/json', $httpClient->requests[0]->getHeaderLine('Content-Type'));
        self::assertStringContainsString('/v2/delivery/estimatedIntervals', (string) $httpClient->requests[0]->getUri());
        self::assertJsonStringEqualsJsonString(
            json_encode([
                'date_time' => '2021-08-03T13:08:49Z',
                'from_location' => [
                    'city' => 'Moscow',
                    'address' => 'Lenina 1',
                ],
                'to_location' => [
                    'code' => 44,
                    'city' => 'Moscow',
                    'address' => 'Tverskaya 1',
                ],
                'tariff_code' => 137,
                'additional_order_types' => [2],
            ], JSON_THROW_ON_ERROR),
            (string) $httpClient->requests[0]->getBody()
        );
    }
    public function test_register_sends_typed_request_and_returns_async_response(): void
    {
        $httpClient = new FakeHttpClient([
            new FakeResponse(202, '{"entity":{"uuid":"delivery-uuid"},"requests":[{"request_uuid":"request-uuid","type":"CREATE","date_time":"2026-04-01T10:00:00+0000","state":"ACCEPTED","errors":[],"warnings":[]}],"related_entities":[{"uuid":"related-uuid","type":"return_order","url":"https://example.test/entity","create_time":"2026-04-01T10:00:01+0000","cdek_number":"123456","date":"2026-04-02","time_from":"15:00","time_to":"18:00"}]}'),
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

        $request = new RegisterDeliveryRequest(
            cdekNumber: '1000014101',
            date: '2026-04-02',
            timeFrom: '09:00',
            timeTo: '18:00',
            comment: 'Call before delivery',
            deliveryPoint: 'MSK93',
        );

        $response = $client->delivery()->register($request);

        self::assertInstanceOf(AsyncResponse::class, $response);
        self::assertSame('delivery-uuid', $response->entity?->uuid);
        self::assertCount(1, $response->requests);
        self::assertSame('CREATE', $response->requests[0]->type);
        self::assertSame('ACCEPTED', $response->requests[0]->state);
        self::assertSame([], $response->requests[0]->errors);
        self::assertSame([], $response->requests[0]->warnings);
        self::assertCount(1, $response->relatedEntities);
        self::assertSame('related-uuid', $response->relatedEntities[0]->uuid);
        self::assertSame('123456', $response->relatedEntities[0]->cdekNumber);
        self::assertCount(1, $httpClient->requests);
        self::assertSame('POST', $httpClient->requests[0]->getMethod());
        self::assertSame('Bearer test-token', $httpClient->requests[0]->getHeaderLine('Authorization'));
        self::assertSame('application/json', $httpClient->requests[0]->getHeaderLine('Content-Type'));
        self::assertStringContainsString('/v2/delivery', (string) $httpClient->requests[0]->getUri());
        self::assertJsonStringEqualsJsonString(
            json_encode([
                'cdek_number' => '1000014101',
                'date' => '2026-04-02',
                'time_from' => '09:00',
                'time_to' => '18:00',
                'comment' => 'Call before delivery',
                'delivery_point' => 'MSK93',
            ], JSON_THROW_ON_ERROR),
            (string) $httpClient->requests[0]->getBody()
        );
    }

    public function test_register_throws_delivery_validation_exception_for_invalid_request(): void
    {
        $client = new CdekClient(
            new FakeHttpClient([]),
            new FakeRequestFactory(),
            new FakeStreamFactory(),
            [
                'base_url' => CdekClient::SANDBOX_BASE_URL,
                'access_token' => 'test-token',
            ]
        );

        $request = new RegisterDeliveryRequest(
            timeFrom: '09:00',
            toLocation: new LocationDto(code: 44, city: 'Moscow'),
            deliveryPoint: 'MSK93',
        );

        try {
            $client->delivery()->register($request);
            self::fail('Expected DeliveryValidationException was not thrown.');
        } catch (DeliveryValidationException $exception) {
            self::assertSame(
                'Either cdekNumber or orderUuid is required.; date is required.; deliveryPoint and toLocation cannot be used together.; timeFrom and timeTo must be provided together.',
                $exception->getMessage()
            );
            self::assertSame([
                'Either cdekNumber or orderUuid is required.',
                'date is required.',
                'deliveryPoint and toLocation cannot be used together.',
                'timeFrom and timeTo must be provided together.',
            ], $exception->getErrors());
        }
    }

    public function test_get_by_uuid_returns_typed_delivery_details_response(): void
    {
        $httpClient = new FakeHttpClient([
            new FakeResponse(200, '{"entity":{"cdek_number":"1000014101","order_uuid":"72753031-e66b-4146-ab8c-52179ef4020a","date":"2026-04-02","time_from":"09:00","time_to":"18:00","comment":"Leave at concierge","delivery_point":"MSK93","to_location":{"code":44,"city_uuid":"7e8f36ba-d937-4ce4-8d53-e44177db6469","city":"Moscow","fias_guid":"0c5b2444-70a0-4932-980c-b4dc0d3f02b5","kladr_code":"7700000000000","country_code":"RU","country":"Russia","region":"Moscow","region_code":77,"fias_region_guid":"0c5b2444-70a0-4932-980c-b4dc0d3f02b5","kladr_region_code":"7700000000000","sub_region":"Central","longitude":37.6173,"latitude":55.7558,"address":"Tverskaya 1","postal_code":"101000"},"uuid":"delivery-uuid","statuses":[{"code":"CREATED","name":"Created","date_time":"2026-04-01T10:00:00+0000"}],"source":"LK"},"requests":[{"request_uuid":"request-uuid","type":"GET","date_time":"2026-04-01T10:01:00+0000","state":"INVALID","errors":[{"code":"validation_error","additional_code":"0x1","message":"Phone is invalid"}],"warnings":[]}],"related_entities":[{"uuid":"related-uuid","type":"return_order","url":"https://example.test/entity","create_time":"2026-04-01T10:00:01+0000","cdek_number":"123456","date":"2026-04-02","time_from":"15:00","time_to":"18:00"}]}'),
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

        $response = $client->delivery()->getByUuid('72753031-e66b-4146-ab8c-52179ef4020a');

        self::assertInstanceOf(DeliveryDetailsResponse::class, $response);
        self::assertInstanceOf(DeliveryEntityDto::class, $response->entity);
        self::assertSame('1000014101', $response->entity?->cdekNumber);
        self::assertSame('delivery-uuid', $response->entity?->uuid);
        self::assertSame('MSK93', $response->entity?->deliveryPoint);
        self::assertSame('LK', $response->entity?->source);
        self::assertCount(1, $response->entity?->statuses ?? []);
        self::assertContainsOnlyInstancesOf(DeliveryStatusDto::class, $response->entity?->statuses ?? []);
        self::assertSame('CREATED', $response->entity?->statuses[0]->code);
        self::assertInstanceOf(DeliveryLocationDto::class, $response->entity?->toLocation);
        self::assertSame('Moscow', $response->entity?->toLocation?->city);
        self::assertSame('Tverskaya 1', $response->entity?->toLocation?->address);
        self::assertCount(1, $response->requests);
        self::assertSame('INVALID', $response->requests[0]->state);
        self::assertCount(1, $response->requests[0]->errors);
        self::assertSame('validation_error', $response->requests[0]->errors[0]->code);
        self::assertCount(1, $response->relatedEntities);
        self::assertSame('related-uuid', $response->relatedEntities[0]->uuid);
        self::assertCount(1, $httpClient->requests);
        self::assertSame('GET', $httpClient->requests[0]->getMethod());
        self::assertSame('Bearer test-token', $httpClient->requests[0]->getHeaderLine('Authorization'));
        self::assertStringContainsString('/v2/delivery/72753031-e66b-4146-ab8c-52179ef4020a', (string) $httpClient->requests[0]->getUri());
    }
}