<?php

declare(strict_types=1);

namespace WishboxCdek\Api;

use WishboxCdek\CdekClient;
use WishboxCdek\Request\Delivery\GetDeliveryIntervalsRequest;
use WishboxCdek\Request\Delivery\GetEstimatedDeliveryIntervalsRequest;
use WishboxCdek\Request\Delivery\RegisterDeliveryRequest;
use WishboxCdek\Response\Async\AsyncResponse;
use WishboxCdek\Response\Delivery\DeliveryDetailsResponse;
use WishboxCdek\Response\Delivery\DeliveryIntervalsResponse;
use WishboxCdek\Response\Delivery\EstimatedDeliveryIntervalsResponse;
use WishboxCdek\Validation\Delivery\RegisterDeliveryRequestValidator;
use WishboxCdek\Validation\Uuid\UuidValidator;

final class DeliveryApi
{
    private readonly RegisterDeliveryRequestValidator $registerDeliveryValidator;
    private readonly UuidValidator $uuidValidator;

    public function __construct(private readonly CdekClient $client)
    {
        $this->registerDeliveryValidator = new RegisterDeliveryRequestValidator();
        $this->uuidValidator = new UuidValidator();
    }

    public function getIntervals(GetDeliveryIntervalsRequest $request): DeliveryIntervalsResponse
    {
        return DeliveryIntervalsResponse::fromArray(
            $this->client->request('GET', '/v2/delivery/intervals', $request->toArray())
        );
    }

    public function getEstimatedIntervals(GetEstimatedDeliveryIntervalsRequest $request): EstimatedDeliveryIntervalsResponse
    {
        return EstimatedDeliveryIntervalsResponse::fromArray(
            $this->client->request('POST', '/v2/delivery/estimatedIntervals', [], $request->toArray())
        );
    }

    public function register(RegisterDeliveryRequest $request): AsyncResponse
    {
        $this->registerDeliveryValidator->validate($request);

        return AsyncResponse::fromArray(
            $this->client->request('POST', '/v2/delivery', [], $request->toArray())
        );
    }

    public function getByUuid(string $uuid): DeliveryDetailsResponse
    {
        $this->uuidValidator->validate($uuid);

        return DeliveryDetailsResponse::fromArray(
            $this->client->request('GET', '/v2/delivery/' . $uuid, [], null, [], true, false)
        );
    }
}