<?php

declare(strict_types=1);

namespace WishboxCdek\Response;

final readonly class CdekResponse
{
    /**
     * @param array<string, mixed> $data
     * @param array<string, list<string>> $headers
     */
    public function __construct(
        public array $data,
        public array $headers = [],
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
