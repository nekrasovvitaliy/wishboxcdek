<?php

declare(strict_types=1);

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Tests\Support\Http\FakeHttpClient;
use Tests\Support\Http\FakeRequestFactory;
use Tests\Support\Http\FakeResponse;
use Tests\Support\Http\FakeStreamFactory;
use WishboxCdek\CdekClient;
use WishboxCdek\Exception\HttpException;
use WishboxCdek\Request\Auth\GetOAuthTokenRequest;
use WishboxCdek\Response\Auth\OAuthToken;

final class AuthApiTest extends TestCase
{
    public function test_get_oauth_token_sends_form_encoded_body(): void
    {
        $httpClient = new FakeHttpClient([
            new FakeResponse(200, '{"access_token":"token","token_type":"bearer","expires_in":3600}'),
        ]);

        $client = new CdekClient(
            $httpClient,
            new FakeRequestFactory(),
            new FakeStreamFactory(),
            ['base_url' => CdekClient::SANDBOX_BASE_URL]
        );

        $response = $client->auth()->getOAuthToken(new GetOAuthTokenRequest(
            account: 'client-id',
            password: 'client-secret',
        ));

        self::assertInstanceOf(OAuthToken::class, $response);
        self::assertSame('token', $response->accessToken);
        self::assertSame('bearer', $response->tokenType);
        self::assertSame(3600, $response->expiresIn);
        self::assertCount(1, $httpClient->requests);
        self::assertSame('POST', $httpClient->requests[0]->getMethod());
        self::assertSame('application/x-www-form-urlencoded', $httpClient->requests[0]->getHeaderLine('Content-Type'));
        self::assertStringContainsString('client_id=client-id', (string) $httpClient->requests[0]->getBody());
        self::assertStringContainsString('client_secret=client-secret', (string) $httpClient->requests[0]->getBody());
    }

    public function test_get_oauth_token_throws_http_exception_for_bad_credentials(): void
    {
        $httpClient = new FakeHttpClient([
            new FakeResponse(401, '{"error":"invalid_client","error_description":"Bad client credentials"}'),
        ]);

        $client = new CdekClient(
            $httpClient,
            new FakeRequestFactory(),
            new FakeStreamFactory(),
            ['base_url' => CdekClient::SANDBOX_BASE_URL]
        );

        try {
            $client->auth()->getOAuthToken(new GetOAuthTokenRequest(
                account: 'client-id',
                password: 'wrong-secret',
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
