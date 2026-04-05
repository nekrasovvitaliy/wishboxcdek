<?php

declare(strict_types=1);

namespace WishboxCdek\Request;

abstract readonly class RequestData
{
    abstract public function toArray(): array;

    protected function filterNulls(array $data): array
    {
        return array_filter(
            $data,
            static fn (mixed $value): bool => $value !== null
        );
    }

    protected function normalizeArray(array $data): array
    {
        $normalized = [];

        foreach ($data as $key => $value) {
            $value = $this->normalizeValue($value);

            if ($value === null) {
                continue;
            }

            $normalized[$key] = $value;
        }

        return $normalized;
    }

    protected function normalizeValue(mixed $value): mixed
    {
        if ($value instanceof self) {
            return $value->toArray();
        }

        if (!is_array($value)) {
            return $value;
        }

        $normalized = [];

        foreach ($value as $key => $item) {
            $item = $this->normalizeValue($item);

            if ($item === null) {
                continue;
            }

            $normalized[$key] = $item;
        }

        return $normalized;
    }
}
