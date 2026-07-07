<?php

declare(strict_types=1);

namespace WishboxCdek\Api;

use WishboxCdek\CdekClient;
use WishboxCdek\Request\DeliveryPoint\GetDeliveryPointsRequest;
use WishboxCdek\Response\DeliveryPoint\DeliveryPointListResponse;
use WishboxCdek\Response\Error\SimplifiedResponseDto1;

final readonly class DeliveryPointApi
{
    public function __construct(private CdekClient $client)
    {
    }

    public function getList(?GetDeliveryPointsRequest $request = null): DeliveryPointListResponse
    {
        return $this->client->requestMapped(
            'GET',
            '/v2/deliverypoints',
            [
                200 => static fn ($response): DeliveryPointListResponse => DeliveryPointListResponse::fromCdekResponse($response),
                400 => SimplifiedResponseDto1::class,
            ],
            ($request ?? new GetDeliveryPointsRequest())->toArray()
        );
    }
}
