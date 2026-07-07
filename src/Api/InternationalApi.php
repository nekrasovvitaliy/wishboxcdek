<?php

declare(strict_types=1);

namespace WishboxCdek\Api;

use WishboxCdek\CdekClient;
use WishboxCdek\Request\International\CheckPackageRestrictionsRequest;
use WishboxCdek\Response\Error\SimplifiedResponseDto1;
use WishboxCdek\Response\International\PackageRestrictionsResponse;

final class InternationalApi
{
    public function __construct(private readonly CdekClient $client)
    {
    }

    public function checkPackageRestrictions(CheckPackageRestrictionsRequest $request): PackageRestrictionsResponse
    {
        return $this->client->requestMapped(
            'POST',
            '/v2/international/package/restrictions',
            [
                200 => PackageRestrictionsResponse::class,
                400 => SimplifiedResponseDto1::class,
            ],
            [],
            $request->toArray()
        );
    }
}
