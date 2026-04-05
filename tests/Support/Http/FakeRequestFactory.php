<?php

declare(strict_types=1);

namespace Tests\Support\Http;

use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;

final class FakeRequestFactory implements RequestFactoryInterface
{
    public function createRequest(string $method, $uri): RequestInterface
    {
        return new FakeRequest($method, (string) $uri);
    }
}
