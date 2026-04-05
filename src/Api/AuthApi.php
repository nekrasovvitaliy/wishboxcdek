<?php

declare(strict_types=1);

namespace WishboxCdek\Api;

use WishboxCdek\CdekClient;
use WishboxCdek\Request\Auth\GetOAuthTokenRequest;
use WishboxCdek\Response\Auth\OAuthToken;

final class AuthApi
{
    public function __construct(private readonly CdekClient $client)
    {
    }

    public function getOAuthToken(?GetOAuthTokenRequest $request = null): OAuthToken
    {
        $request ??= new GetOAuthTokenRequest(
            account: $this->client->getAccount(),
            password: $this->client->getPassword(),
        );

        return OAuthToken::fromArray(
            $this->client->requestForm('POST', '/v2/oauth/token', $request->toArray())
        );
    }
}
