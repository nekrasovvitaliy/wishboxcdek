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
use WishboxCdek\Validation\Order\UpdateOrderRequestValidator;
use WishboxCdek\Validation\Uuid\UuidValidator;

final class OrderApi
{
    private readonly CreateOrderRequestValidator $createOrderValidator;
    private readonly UpdateOrderRequestValidator $updateOrderValidator;
    private readonly UuidValidator $uuidValidator;

    public function __construct(private readonly CdekClient $client)
    {
        $this->createOrderValidator = new CreateOrderRequestValidator();
        $this->updateOrderValidator = new UpdateOrderRequestValidator();
        $this->uuidValidator = new UuidValidator();
    }

    /**
     * Returns order details by CDEK order number.
     */
    public function getByNumber(GetOrderByNumberRequest $request): OrderDetails
    {
        return OrderDetails::fromArray(
            $this->client->request('GET', '/v2/orders', $request->toArray(), null, [], true, false)
        );
    }

    /**
     * Creates a new order.
     */
    public function create(CreateOrderRequest $request): AsyncResponse
    {
        $this->createOrderValidator->validate($request);

        return AsyncResponse::fromArray(
            $this->client->request('POST', '/v2/orders', [], $request->toArray())
        );
    }

    /**
     * Updates an existing order.
     */
    public function update(UpdateOrderRequest $request): AsyncResponse
    {
        $this->updateOrderValidator->validate($request);

        return AsyncResponse::fromArray(
            $this->client->request('PATCH', '/v2/orders', [], $request->toArray())
        );
    }

    /**
     * Returns order details by order UUID.
     */
    public function getByUuid(string $uuid): OrderDetails
    {
        $this->uuidValidator->validate($uuid);

        return OrderDetails::fromArray(
            $this->client->request('GET', '/v2/orders/' . $uuid, [], null, [], true, false)
        );
    }

    /**
     * Deletes an order by UUID.
     */
    public function delete(string $uuid): AsyncResponse
    {
        $this->uuidValidator->validate($uuid);

        return AsyncResponse::fromArray(
            $this->client->request('DELETE', '/v2/orders/' . $uuid)
        );
    }

    /**
     * Returns intake records linked to an order.
     *
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

    /**
     * Creates an order refusal request.
     */
    public function createRefusal(string $uuid, CreateOrderRefusalRequest $request): AsyncResponse
    {
        $this->uuidValidator->validate($uuid);

        return AsyncResponse::fromArray(
            $this->client->request('POST', '/v2/orders/' . $uuid . '/refusal', [], $request->toArray())
        );
    }

    /**
     * Creates a client return for an order.
     */
    public function createClientReturn(string $uuid, CreateClientReturnRequest $request): AsyncResponse
    {
        $this->uuidValidator->validate($uuid);

        return AsyncResponse::fromArray(
            $this->client->request('POST', '/v2/orders/' . $uuid . '/clientReturn', [], $request->toArray())
        );
    }
}
