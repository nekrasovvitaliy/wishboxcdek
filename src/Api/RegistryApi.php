<?php

declare(strict_types=1);

namespace WishboxCdek\Api;

use WishboxCdek\CdekClient;
use WishboxCdek\Request\Registry\GetRegistriesRequest;
use WishboxCdek\Response\Registry\RegistriesResponse;

final class RegistryApi
{
    public function __construct(private readonly CdekClient $client)
    {
    }

    public function getList(GetRegistriesRequest $request): RegistriesResponse
    {
        return RegistriesResponse::fromArray(
            $this->client->request('GET', '/v2/registries', $request->toArray())
        );
    }
}
