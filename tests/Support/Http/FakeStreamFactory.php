<?php

declare(strict_types=1);

namespace Tests\Support\Http;

use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;

final class FakeStreamFactory implements StreamFactoryInterface
{
    public function createStream(string $content = ''): StreamInterface
    {
        return new FakeStream($content);
    }

    public function createStreamFromFile(string $filename, string $mode = 'r'): StreamInterface
    {
        return new FakeStream((string) file_get_contents($filename));
    }

    public function createStreamFromResource($resource): StreamInterface
    {
        return new FakeStream((string) stream_get_contents($resource));
    }
}
