<?php

declare(strict_types=1);

namespace WishboxCdek\Api;

use WishboxCdek\CdekClient;
use WishboxCdek\Request\DeliveryPoint\GetDeliveryPointsRequest;
use WishboxCdek\Response\DeliveryPoint\DeliveryPointListResponse;

final readonly class DeliveryPointApi
{
    public function __construct(private CdekClient $client)
    {
    }

    public function getList(?GetDeliveryPointsRequest $request = null): DeliveryPointListResponse
    {
        $response = $this->client->requestWithHeaders('GET', '/v2/deliverypoints', ($request ?? new GetDeliveryPointsRequest())->toArray());

        return DeliveryPointListResponse::fromCdekResponse($response);
    }
}
