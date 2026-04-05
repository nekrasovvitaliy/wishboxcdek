<?php

declare(strict_types=1);

namespace WishboxCdek\Api;

use WishboxCdek\CdekClient;
use WishboxCdek\Request\DeliveryPoint\GetDeliveryPointsRequest;
use WishboxCdek\Response\DeliveryPoint\DeliveryPointDto;

final class DeliveryPointApi
{
    public function __construct(private readonly CdekClient $client)
    {
    }

    /**
     * @return list<DeliveryPointDto>
     */
    public function getList(?GetDeliveryPointsRequest $request = null): array
    {
        $response = $this->client->request('GET', '/v2/deliverypoints', ($request ?? new GetDeliveryPointsRequest())->toArray());

        return array_map(
            static fn (array $deliveryPoint): DeliveryPointDto => DeliveryPointDto::fromArray($deliveryPoint),
            $response,
        );
    }
}
