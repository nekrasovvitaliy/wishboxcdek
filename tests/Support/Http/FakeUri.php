<?php

declare(strict_types=1);

namespace Tests\Support\Http;

use Psr\Http\Message\UriInterface;

final class FakeUri implements UriInterface
{
    private string $scheme = '';
    private string $host = '';
    private int $port;
    private string $path = '';
    private string $query = '';
    private string $fragment = '';
    private string $userInfo = '';

    public function __construct(string $uri)
    {
        $parts = parse_url($uri) ?: [];
        $this->scheme = (string) ($parts['scheme'] ?? '');
        $this->host = (string) ($parts['host'] ?? '');
        $this->port = (int) ($parts['port'] ?? 0);
        $this->path = (string) ($parts['path'] ?? '');
        $this->query = (string) ($parts['query'] ?? '');
        $this->fragment = (string) ($parts['fragment'] ?? '');
        if (isset($parts['user'])) {
            $this->userInfo = $parts['user'];
            if (isset($parts['pass'])) {
                $this->userInfo .= ':' . $parts['pass'];
            }
        }
    }

    public function getScheme(): string { return $this->scheme; }
    public function getAuthority(): string { return $this->host; }
    public function getUserInfo(): string { return $this->userInfo; }
    public function getHost(): string { return $this->host; }
    public function getPort(): ?int { return $this->port ?: null; }
    public function getPath(): string { return $this->path; }
    public function getQuery(): string { return $this->query; }
    public function getFragment(): string { return $this->fragment; }
    public function withScheme(string $scheme): static { $clone = clone $this; $clone->scheme = $scheme; return $clone; }
    public function withUserInfo(string $user, ?string $password = null): static { $clone = clone $this; $clone->userInfo = $password === null ? $user : $user . ':' . $password; return $clone; }
    public function withHost(string $host): static { $clone = clone $this; $clone->host = $host; return $clone; }
    public function withPort(?int $port): static { $clone = clone $this; $clone->port = $port ?? 0; return $clone; }
    public function withPath(string $path): static { $clone = clone $this; $clone->path = $path; return $clone; }
    public function withQuery(string $query): static { $clone = clone $this; $clone->query = $query; return $clone; }
    public function withFragment(string $fragment): static { $clone = clone $this; $clone->fragment = $fragment; return $clone; }
    public function __toString(): string
    {
        $uri = $this->scheme !== '' ? $this->scheme . '://' : '';
        $uri .= $this->host;
        if ($this->port !== 0) {
            $uri .= ':' . $this->port;
        }
        $uri .= $this->path;
        if ($this->query !== '') {
            $uri .= '?' . $this->query;
        }
        if ($this->fragment !== '') {
            $uri .= '#' . $this->fragment;
        }

        return $uri;
    }
}
