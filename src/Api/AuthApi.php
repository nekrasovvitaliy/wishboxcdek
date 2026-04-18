<?php

declare(strict_types=1);

namespace WishboxCdek\Api;

use WishboxCdek\CdekClient;
use WishboxCdek\Exception\CdekException;
use WishboxCdek\Request\Auth\GetOAuthTokenRequest;
use WishboxCdek\Response\Auth\OAuthToken;

final class AuthApi
{
    public function __construct(private readonly CdekClient $client)
    {
    }

    public function getOAuthToken(?GetOAuthTokenRequest $request = null): OAuthToken
    {
        if ($request === null) {
            $account = $this->client->getAccount();
            $password = $this->client->getPassword();

            if ($account === null || $password === null) {
                throw new CdekException('CDEK account credentials are missing.');
            }

            $request = new GetOAuthTokenRequest(
                account: $account,
                password: $password,
            );
        }

        return OAuthToken::fromArray(
            $this->client->requestForm('POST', '/v2/oauth/token', $request->toArray())
        );
    }
}
