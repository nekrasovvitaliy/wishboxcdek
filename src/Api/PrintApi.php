<?php

declare(strict_types=1);

namespace WishboxCdek\Api;

use WishboxCdek\CdekClient;
use WishboxCdek\Request\Print\CreateBarcodesPrintRequest;
use WishboxCdek\Request\Print\CreateOrdersPrintRequest;
use WishboxCdek\Response\Async\AsyncResponse;
use WishboxCdek\Response\Error\SimplifiedResponseDto1;
use WishboxCdek\Response\Print\PrintBarcodesResponse;
use WishboxCdek\Response\Print\PrintOrdersResponse;
use WishboxCdek\Validation\Uuid\UuidValidator;

final class PrintApi
{
    private readonly UuidValidator $uuidValidator;

    public function __construct(private readonly CdekClient $client)
    {
        $this->uuidValidator = new UuidValidator();
    }

    public function createOrders(CreateOrdersPrintRequest $request): AsyncResponse
    {
        return $this->client->requestMapped(
            'POST',
            '/v2/print/orders',
            [
                202 => AsyncResponse::class,
                400 => SimplifiedResponseDto1::class,
            ],
            [],
            $request->toArray()
        );
    }

    public function getOrdersByUuid(string $uuid): PrintOrdersResponse
    {
        $this->uuidValidator->validate($uuid);

        return $this->client->requestMapped(
            'GET',
            '/v2/print/orders/' . $uuid,
            [
                200 => PrintOrdersResponse::class,
                400 => SimplifiedResponseDto1::class,
            ],
            [],
            null,
            [],
            true,
            false
        );
    }

    public function createBarcodes(CreateBarcodesPrintRequest $request): AsyncResponse
    {
        return $this->client->requestMapped(
            'POST',
            '/v2/print/barcodes',
            [
                202 => AsyncResponse::class,
                400 => SimplifiedResponseDto1::class,
            ],
            [],
            $request->toArray()
        );
    }

    public function getBarcodesByUuid(string $uuid): PrintBarcodesResponse
    {
        $this->uuidValidator->validate($uuid);

        return $this->client->requestMapped(
            'GET',
            '/v2/print/barcodes/' . $uuid,
            [
                200 => PrintBarcodesResponse::class,
                400 => SimplifiedResponseDto1::class,
            ],
            [],
            null,
            [],
            true,
            false
        );
    }

    public function downloadBarcodesPdf(string $uuid): string
    {
        $this->uuidValidator->validate($uuid);

        return $this->client->requestBinary('GET', '/v2/print/barcodes/' . $uuid . '.pdf');
    }
}
