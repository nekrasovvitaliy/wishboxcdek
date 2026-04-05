<?php

declare(strict_types=1);

namespace Tests\Support\Http;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\UriInterface;

final class FakeRequest extends FakeMessage implements RequestInterface
{
    public function __construct(
        private string $method,
        string $uri
    ) {
        $this->body = new FakeStream();
        $this->uri = new FakeUri($uri);
    }

    private UriInterface $uri;

    public function getRequestTarget(): string
    {
        $path = $this->uri->getPath();
        $query = $this->uri->getQuery();

        return $query === '' ? $path : $path . '?' . $query;
    }

    public function withRequestTarget(string $requestTarget): static
    {
        return clone $this;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function withMethod(string $method): static
    {
        $clone = clone $this;
        $clone->method = $method;

        return $clone;
    }

    public function getUri(): UriInterface
    {
        return $this->uri;
    }

    public function withUri(UriInterface $uri, bool $preserveHost = false): static
    {
        $clone = clone $this;
        $clone->uri = $uri;

        return $clone;
    }
}
