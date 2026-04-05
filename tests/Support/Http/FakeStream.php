<?php

declare(strict_types=1);

namespace Tests\Support\Http;

use Psr\Http\Message\StreamInterface;

final class FakeStream implements StreamInterface
{
    private int $position = 0;

    public function __construct(private string $content = '')
    {
    }

    public function __toString(): string
    {
        return $this->content;
    }

    public function close(): void
    {
    }

    public function detach()
    {
        return null;
    }

    public function getSize(): ?int
    {
        return strlen($this->content);
    }

    public function tell(): int
    {
        return $this->position;
    }

    public function eof(): bool
    {
        return $this->position >= strlen($this->content);
    }

    public function isSeekable(): bool
    {
        return true;
    }

    public function seek(int $offset, int $whence = SEEK_SET): void
    {
        if ($whence === SEEK_SET) {
            $this->position = $offset;
            return;
        }

        if ($whence === SEEK_CUR) {
            $this->position += $offset;
            return;
        }

        $this->position = strlen($this->content) + $offset;
    }

    public function rewind(): void
    {
        $this->position = 0;
    }

    public function isWritable(): bool
    {
        return true;
    }

    public function write(string $string): int
    {
        $this->content .= $string;
        $this->position = strlen($this->content);

        return strlen($string);
    }

    public function isReadable(): bool
    {
        return true;
    }

    public function read(int $length): string
    {
        $chunk = substr($this->content, $this->position, $length);
        $this->position += strlen($chunk);

        return $chunk;
    }

    public function getContents(): string
    {
        $chunk = substr($this->content, $this->position);
        $this->position = strlen($this->content);

        return $chunk;
    }

    public function getMetadata(?string $key = null): mixed
    {
        return $key === null ? [] : null;
    }
}
