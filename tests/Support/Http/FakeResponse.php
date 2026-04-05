<?php

declare(strict_types=1);

namespace Tests\Support\Http;

use Psr\Http\Message\ResponseInterface;

final class FakeResponse extends FakeMessage implements ResponseInterface
{
    public function __construct(
        private int $statusCode = 200,
        string $body = ''
    ) {
        $this->body = new FakeStream($body);
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function withStatus(int $code, string $reasonPhrase = ''): static
    {
        $clone = clone $this;
        $clone->statusCode = $code;

        return $clone;
    }

    public function getReasonPhrase(): string
    {
        return '';
    }
}
