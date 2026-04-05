<?php

declare(strict_types=1);

namespace WishboxCdek\Api;

use WishboxCdek\CdekClient;
use WishboxCdek\Request\International\CheckPackageRestrictionsRequest;
use WishboxCdek\Response\International\PackageRestrictionsResponse;

final class InternationalApi
{
    public function __construct(private readonly CdekClient $client)
    {
    }

    public function checkPackageRestrictions(CheckPackageRestrictionsRequest $request): PackageRestrictionsResponse
    {
        return PackageRestrictionsResponse::fromArray(
            $this->client->request('POST', '/v2/international/package/restrictions', [], $request->toArray())
        );
    }
}
