<?php

declare(strict_types=1);

namespace WishboxCdek\Response;

final readonly class RawCdekResponse
{
    /**
     * @param array<string, list<string>> $headers
     */
    public function __construct(
        public int $statusCode,
        public array $headers,
        public string $body,
    ) {
    }

    public function getHeaderLine(string $name): string
    {
        foreach ($this->headers as $headerName => $values) {
            if (strtolower($headerName) === strtolower($name)) {
                return implode(', ', $values);
            }
        }

        return '';
    }
}
