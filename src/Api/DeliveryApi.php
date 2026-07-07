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
use WishboxCdek\Response\Error\SimplifiedResponseDto1;
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
        return $this->client->requestMapped(
            'GET',
            '/v2/delivery/intervals',
            [
                200 => DeliveryIntervalsResponse::class,
                400 => SimplifiedResponseDto1::class,
            ],
            $request->toArray()
        );
    }

    public function getEstimatedIntervals(GetEstimatedDeliveryIntervalsRequest $request): EstimatedDeliveryIntervalsResponse
    {
        return $this->client->requestMapped(
            'POST',
            '/v2/delivery/estimatedIntervals',
            [
                200 => EstimatedDeliveryIntervalsResponse::class,
                400 => SimplifiedResponseDto1::class,
            ],
            [],
            $request->toArray()
        );
    }

    public function register(RegisterDeliveryRequest $request): AsyncResponse
    {
        $this->registerDeliveryValidator->validate($request);

        return $this->client->requestMapped(
            'POST',
            '/v2/delivery',
            [
                202 => AsyncResponse::class,
                400 => SimplifiedResponseDto1::class,
            ],
            [],
            $request->toArray()
        );
    }

    public function getByUuid(string $uuid): DeliveryDetailsResponse
    {
        $this->uuidValidator->validate($uuid);

        return $this->client->requestMapped(
            'GET',
            '/v2/delivery/' . $uuid,
            [
                200 => DeliveryDetailsResponse::class,
                400 => SimplifiedResponseDto1::class,
            ],
            [],
            null,
            [],
            true,
            false
        );
    }
}
