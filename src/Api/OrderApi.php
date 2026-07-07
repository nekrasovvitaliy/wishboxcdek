<?php

declare(strict_types=1);

namespace WishboxCdek\Api;

use WishboxCdek\CdekClient;
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
    public function getByNumber(GetOrderByNumberRequest $request): ResponseDtoOrderResponseDto
    {
        return $this->client->requestMapped(
            'GET',
            '/v2/orders',
            [
                200 => ResponseDtoOrderResponseDto::class,
                400 => SimplifiedResponseDto1::class,
            ],
            $request->toArray(),
            null,
            [],
            true,
            false
        );
    }

    /**
     * Creates a new order.
     */
    public function create(OrderCreateRequestDto $request): ResponseDtoRootEntityDto
    {
        $this->createOrderValidator->validate($request);

        return $this->client->requestMapped(
            'POST',
            '/v2/orders',
            [
                202 => ResponseDtoRootEntityDto::class,
                400 => ResponseDtoRootEntityDto::class,
            ],
            [],
            $request->toArray()
        );
    }

    /**
     * Updates an existing order.
     */
    public function update(OrderUpdateRequestDto $request): ResponseDtoRootEntityDto
    {
        $this->updateOrderValidator->validate($request);

        return $this->client->requestMapped(
            'PATCH',
            '/v2/orders',
            [
                202 => ResponseDtoRootEntityDto::class,
                400 => SimplifiedResponseDto1::class,
            ],
            [],
            $request->toArray()
        );
    }

    /**
     * Returns order details by order UUID.
     */
    public function getByUuid(string $uuid): ResponseDtoOrderResponseDto
    {
        $this->uuidValidator->validate($uuid);

        return $this->client->requestMapped(
            'GET',
            '/v2/orders/' . $uuid,
            [
                200 => ResponseDtoOrderResponseDto::class,
                400 => SimplifiedResponseDto1::class,
            ],
            [],
            null,
            [],
            true,
            false
        );
    }

    /**
     * Deletes an order by UUID.
     */
    public function delete(string $uuid): ResponseDtoRootEntityDto
    {
        $this->uuidValidator->validate($uuid);

        return $this->client->requestMapped(
            'DELETE',
            '/v2/orders/' . $uuid,
            [
                202 => ResponseDtoRootEntityDto::class,
                400 => SimplifiedResponseDto1::class,
            ]
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

        return $this->client->requestMapped(
            'GET',
            '/v2/orders/' . $orderUuid . '/intakes',
            [
                200 => static function ($response): array {
                    $intakes = [];
                    foreach ($response->data as $intake) {
                        if (is_array($intake)) {
                            $intakes[] = OrderIntakeDto::fromArray($intake);
                        }
                    }

                    return $intakes;
                },
                400 => SimplifiedResponseDto1::class,
            ],
            [],
            null,
            [],
            true,
            false
        );
    }

    /**
     * Creates an order refusal request.
     */
    public function createRefusal(string $uuid, CreateOrderRefusalRequest $request): AsyncResponse
    {
        $this->uuidValidator->validate($uuid);

        return $this->client->requestMapped(
            'POST',
            '/v2/orders/' . $uuid . '/refusal',
            [
                202 => AsyncResponse::class,
                400 => SimplifiedResponseDto1::class,
            ],
            [],
            $request->toArray()
        );
    }

    /**
     * Creates a client return for an order.
     */
    public function createClientReturn(string $uuid, CreateClientReturnRequest $request): AsyncResponse
    {
        $this->uuidValidator->validate($uuid);

        return $this->client->requestMapped(
            'POST',
            '/v2/orders/' . $uuid . '/clientReturn',
            [
                202 => AsyncResponse::class,
                400 => SimplifiedResponseDto1::class,
            ],
            [],
            $request->toArray()
        );
    }
}
