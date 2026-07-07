<?php

declare(strict_types=1);

namespace WishboxCdek\Api;

use WishboxCdek\CdekClient;
use WishboxCdek\Request\Registry\GetRegistriesRequest;
use WishboxCdek\Response\Error\SimplifiedResponseDto1;
use WishboxCdek\Response\Registry\RegistriesResponse;

final class RegistryApi
{
    public function __construct(private readonly CdekClient $client)
    {
    }

    public function getList(GetRegistriesRequest $request): RegistriesResponse
    {
        return $this->client->requestMapped(
            'GET',
            '/v2/registries',
            [
                200 => RegistriesResponse::class,
                400 => SimplifiedResponseDto1::class,
            ],
            $request->toArray()
        );
    }
}
