<?php

declare(strict_types=1);

namespace Tests\Integration;

use WishboxCdek\Exception\HttpException;
use WishboxCdek\Request\Auth\GetOAuthTokenRequest;

final class AuthApiIntegrationTest extends CdekIntegrationTestCase
{
    public function test_get_oauth_token_throws_http_exception_for_wrong_password(): void
    {
        $client = $this->createClient();
        $wrongPassword = $this->getPassword() . '-wrong';

        try {
            $client->auth()->getOAuthToken(new GetOAuthTokenRequest(
                account: $this->getAccount(),
                password: $wrongPassword,
            ));
            self::fail('Expected HttpException was not thrown.');
        } catch (HttpException $exception) {
            self::assertSame(401, $exception->getStatusCode());
            self::assertSame('Bad client credentials', $exception->getMessage());
            self::assertCount(1, $exception->getErrors());
            self::assertSame('invalid_client', $exception->getErrors()[0]->code);
            self::assertSame('Bad client credentials', $exception->getErrors()[0]->message);
        }
    }
}
