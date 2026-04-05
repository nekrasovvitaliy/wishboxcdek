<?php

declare(strict_types=1);

namespace WishboxCdek\Api;

use WishboxCdek\CdekClient;
use WishboxCdek\Request\Passport\GetPassportRequest;
use WishboxCdek\Response\Passport\PassportResponse;

final class PassportApi
{
    public function __construct(private readonly CdekClient $client)
    {
    }

    public function get(GetPassportRequest $request): PassportResponse
    {
        return PassportResponse::fromArray(
            $this->client->request('GET', '/v2/passport', $request->toArray())
        );
    }
}
