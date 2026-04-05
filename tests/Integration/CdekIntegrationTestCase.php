<?php

declare(strict_types=1);

namespace Tests\Integration;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7\HttpFactory;
use PHPUnit\Framework\TestCase;
use WishboxCdek\CdekClient;

abstract class CdekIntegrationTestCase extends TestCase
{
    protected function createClient(): CdekClient
    {
        $baseUrl = getenv('CDEK_BASE_URL') ?: CdekClient::SANDBOX_BASE_URL;
        $account = getenv('CDEK_ACCOUNT') ?: null;
        $password = getenv('CDEK_PASSWORD') ?: null;

        if ($account === null || $account === '' || $password === null || $password === '') {
            self::markTestSkipped('CDEK sandbox credentials are not configured. Set CDEK_ACCOUNT and CDEK_PASSWORD.');
        }

        $httpClient = new GuzzleClient();
        $httpFactory = new HttpFactory();

        return new CdekClient(
            $httpClient,
            $httpFactory,
            $httpFactory,
            [
                'base_url' => $baseUrl,
                'account' => $account,
                'password' => $password,
            ]
        );
    }

    protected function getAccount(): string
    {
        $account = getenv('CDEK_ACCOUNT') ?: null;

        if ($account === null || $account === '') {
            self::markTestSkipped('CDEK sandbox credentials are not configured. Set CDEK_ACCOUNT and CDEK_PASSWORD.');
        }

        return $account;
    }

    protected function getPassword(): string
    {
        $password = getenv('CDEK_PASSWORD') ?: null;

        if ($password === null || $password === '') {
            self::markTestSkipped('CDEK sandbox credentials are not configured. Set CDEK_ACCOUNT and CDEK_PASSWORD.');
        }

        return $password;
    }
}
