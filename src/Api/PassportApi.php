<?php

declare(strict_types=1);

namespace WishboxCdek\Api;

use WishboxCdek\CdekClient;
use WishboxCdek\Request\Passport\GetPassportRequest;
use WishboxCdek\Response\Error\SimplifiedResponseDto1;
use WishboxCdek\Response\Passport\PassportResponse;

final class PassportApi
{
    public function __construct(private readonly CdekClient $client)
    {
    }

    public function get(GetPassportRequest $request): PassportResponse
    {
        return $this->client->requestMapped(
            'GET',
            '/v2/passport',
            [
                200 => PassportResponse::class,
                400 => SimplifiedResponseDto1::class,
            ],
            $request->toArray()
        );
    }
}
