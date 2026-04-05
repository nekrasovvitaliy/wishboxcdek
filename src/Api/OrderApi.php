<?php

declare(strict_types=1);

namespace WishboxCdek\Api;

use WishboxCdek\CdekClient;
use WishboxCdek\Request\Order\CreateClientReturnRequest;
use WishboxCdek\Request\Order\CreateOrderRefusalRequest;
use WishboxCdek\Request\Order\CreateOrderRequest;
use WishboxCdek\Request\Order\GetOrderByNumberRequest;
use WishboxCdek\Request\Order\UpdateOrderRequest;
use WishboxCdek\Response\Async\AsyncResponse;
use WishboxCdek\Response\Order\OrderDetails;
use WishboxCdek\Response\Order\OrderIntakeDto;
use WishboxCdek\Validation\Order\CreateOrderRequestValidator;
use WishboxCdek\Validation\Uuid\UuidValidator;

final class OrderApi
{
    private readonly CreateOrderRequestValidator $createOrderValidator;
    private readonly UuidValidator $uuidValidator;

    public function __construct(private readonly CdekClient $client)
    {
        $this->createOrderValidator = new CreateOrderRequestValidator();
        $this->uuidValidator = new UuidValidator();
    }

    public function getByNumber(GetOrderByNumberRequest $request): OrderDetails
    {
        return OrderDetails::fromArray(
            $this->client->request('GET', '/v2/orders', $request->toArray(), null, [], true, false)
        );
    }

    public function create(CreateOrderRequest $request): AsyncResponse
    {
        $this->createOrderValidator->validate($request);

        return AsyncResponse::fromArray(
            $this->client->request('POST', '/v2/orders', [], $request->toArray())
        );
    }

    public function update(UpdateOrderRequest $request): AsyncResponse
    {
        return AsyncResponse::fromArray(
            $this->client->request('PATCH', '/v2/orders', [], $request->toArray())
        );
    }

    public function getByUuid(string $uuid): OrderDetails
    {
        $this->uuidValidator->validate($uuid);

        return OrderDetails::fromArray(
            $this->client->request('GET', '/v2/orders/' . $uuid, [], null, [], true, false)
        );
    }

    public function delete(string $uuid): AsyncResponse
    {
        $this->uuidValidator->validate($uuid);

        return AsyncResponse::fromArray(
            $this->client->request('DELETE', '/v2/orders/' . $uuid)
        );
    }

    /**
     * @return list<OrderIntakeDto>
     */
    public function getIntakes(string $orderUuid): array
    {
        $this->uuidValidator->validate($orderUuid, 'order_uuid');

        $response = $this->client->request(
            'GET',
            '/v2/orders/' . $orderUuid . '/intakes',
            [],
            null,
            [],
            true,
            false
        );

        $intakes = [];
        foreach ($response as $intake) {
            if (is_array($intake)) {
                $intakes[] = OrderIntakeDto::fromArray($intake);
            }
        }

        return $intakes;
    }

    public function createRefusal(string $uuid, CreateOrderRefusalRequest $request): AsyncResponse
    {
        $this->uuidValidator->validate($uuid);

        return AsyncResponse::fromArray(
            $this->client->request('POST', '/v2/orders/' . $uuid . '/refusal', [], $request->toArray())
        );
    }

    public function createClientReturn(string $uuid, CreateClientReturnRequest $request): AsyncResponse
    {
        $this->uuidValidator->validate($uuid);

        return AsyncResponse::fromArray(
            $this->client->request('POST', '/v2/orders/' . $uuid . '/clientReturn', [], $request->toArray())
        );
    }
}