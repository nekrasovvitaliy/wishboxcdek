<?php

declare(strict_types=1);

namespace WishboxCdek\Api;

use WishboxCdek\CdekClient;
use WishboxCdek\Request\Prealert\RegisterPrealertRequest;
use WishboxCdek\Response\Async\AsyncResponse;
use WishboxCdek\Response\Error\SimplifiedResponseDto1;
use WishboxCdek\Response\Prealert\PrealertDetailsResponse;
use WishboxCdek\Validation\Prealert\RegisterPrealertRequestValidator;
use WishboxCdek\Validation\Uuid\UuidValidator;

final class PrealertApi
{
    private readonly UuidValidator $uuidValidator;

    public function __construct(
        private readonly CdekClient $client,
        private readonly RegisterPrealertRequestValidator $validator = new RegisterPrealertRequestValidator(),
    ) {
        $this->uuidValidator = new UuidValidator();
    }

    public function register(RegisterPrealertRequest $request): AsyncResponse
    {
        $this->validator->validate($request);

        return $this->client->requestMapped(
            'POST',
            '/v2/prealert',
            [
                202 => AsyncResponse::class,
                400 => SimplifiedResponseDto1::class,
            ],
            [],
            $request->toArray()
        );
    }

    public function getByUuid(string $uuid): PrealertDetailsResponse
    {
        $this->uuidValidator->validate($uuid);

        return $this->client->requestMapped(
            'GET',
            '/v2/prealert/' . $uuid,
            [
                200 => PrealertDetailsResponse::class,
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
