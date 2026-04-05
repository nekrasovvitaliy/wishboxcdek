<?php

declare(strict_types=1);

namespace WishboxCdek\Api;

use WishboxCdek\CdekClient;
use WishboxCdek\Request\Prealert\RegisterPrealertRequest;
use WishboxCdek\Response\Async\AsyncResponse;
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

        return AsyncResponse::fromArray(
            $this->client->request('POST', '/v2/prealert', [], $request->toArray())
        );
    }

    public function getByUuid(string $uuid): PrealertDetailsResponse
    {
        $this->uuidValidator->validate($uuid);

        return PrealertDetailsResponse::fromArray(
            $this->client->request('GET', '/v2/prealert/' . $uuid, [], null, [], true, false)
        );
    }
}