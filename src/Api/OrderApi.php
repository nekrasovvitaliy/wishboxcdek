<?php

declare(strict_types=1);

namespace WishboxCdek\Api;

use WishboxCdek\CdekClient;
use WishboxCdek\Exception\HttpException;
use WishboxCdek\Request\Order\CreateClientReturnRequest;
use WishboxCdek\Request\Order\CreateOrderRefusalRequest;
use WishboxCdek\Request\Order\OrderCreateRequestDto;
use WishboxCdek\Request\Order\GetOrderByNumberRequest;
use WishboxCdek\Request\Order\OrderUpdateRequestDto;
use WishboxCdek\Response\Error\SimplifiedResponseDto1;
use WishboxCdek\Response\Order\ResponseDtoOrderResponseDto;
use WishboxCdek\Response\Order\ResponseDtoRootEntityDto;
use WishboxCdek\Response\Async\AsyncResponse;
use WishboxCdek\Response\Order\OrderIntakeDto;
use WishboxCdek\Validation\Order\CreateOrderRequestValidator;
use WishboxCdek\Validation\Order\UpdateOrderRequestValidator;
use WishboxCdek\Validation\Uuid\UuidValidator;

final readonly class OrderApi
{
    private CreateOrderRequestValidator $createOrderValidator;
    private UpdateOrderRequestValidator $updateOrderValidator;
    private UuidValidator $uuidValidator;

    public function __construct(private CdekClient $client)
    {
        $this->createOrderValidator = new CreateOrderRequestValidator();
        $this->updateOrderValidator = new UpdateOrderRequestValidator();
        $this->uuidValidator = new UuidValidator();
    }

    /**
     * Returns order details by CDEK order number.
     */
    public function getByNumber(GetOrderByNumberRequest $request): ResponseDtoOrderResponseDto|SimplifiedResponseDto1
    {
        try {
            return ResponseDtoOrderResponseDto::fromArray(
                $this->client->request('GET', '/v2/orders', $request->toArray(), null, [], true, false)
            );
        } catch (HttpException $exception) {
            if ($exception->getStatusCode() !== 400) {
                throw $exception;
            }

            return SimplifiedResponseDto1::fromArray($exception->getResponse());
        }
    }

    /**
     * Creates a new order.
     */
    public function create(OrderCreateRequestDto $request): ResponseDtoRootEntityDto|SimplifiedResponseDto1
    {
        $this->createOrderValidator->validate($request);

        try {
            return ResponseDtoRootEntityDto::fromArray(
                $this->client->request('POST', '/v2/orders', [], $request->toArray())
            );
        } catch (HttpException $exception) {
            if ($exception->getStatusCode() !== 400) {
                throw $exception;
            }

            return SimplifiedResponseDto1::fromArray($exception->getResponse());
        }
    }

    /**
     * Updates an existing order.
     */
    public function update(OrderUpdateRequestDto $request): ResponseDtoRootEntityDto|SimplifiedResponseDto1
    {
        $this->updateOrderValidator->validate($request);

        try {
            return ResponseDtoRootEntityDto::fromArray(
                $this->client->request('PATCH', '/v2/orders', [], $request->toArray())
            );
        } catch (HttpException $exception) {
            if ($exception->getStatusCode() !== 400) {
                throw $exception;
            }

            return SimplifiedResponseDto1::fromArray($exception->getResponse());
        }
    }

    /**
     * Returns order details by order UUID.
     */
    public function getByUuid(string $uuid): ResponseDtoOrderResponseDto|SimplifiedResponseDto1
    {
        $this->uuidValidator->validate($uuid);

        try {
            return ResponseDtoOrderResponseDto::fromArray(
                $this->client->request('GET', '/v2/orders/' . $uuid, [], null, [], true, false)
            );
        } catch (HttpException $exception) {
            if ($exception->getStatusCode() !== 400) {
                throw $exception;
            }

            return SimplifiedResponseDto1::fromArray($exception->getResponse());
        }
    }

    /**
     * Deletes an order by UUID.
     */
    public function delete(string $uuid): ResponseDtoRootEntityDto|SimplifiedResponseDto1
    {
        $this->uuidValidator->validate($uuid);

        try {
            return ResponseDtoRootEntityDto::fromArray(
                $this->client->request('DELETE', '/v2/orders/' . $uuid)
            );
        } catch (HttpException $exception) {
            if ($exception->getStatusCode() !== 400) {
                throw $exception;
            }

            return SimplifiedResponseDto1::fromArray($exception->getResponse());
        }
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
