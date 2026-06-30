<?php

declare(strict_types=1);

namespace WishboxCdek\Request;

use InvalidArgumentException;

abstract readonly class RequestData
{
    abstract public function toArray(): array;

    protected function normalizeCountryCodes(string|array|null $countryCodes): ?string
    {
        if ($countryCodes === null) {
            return null;
        }

        if (is_string($countryCodes)) {
            $countryCodes = array_map('trim', explode(',', $countryCodes));
        }

        $countryCodes = array_values(array_filter(
            $countryCodes,
            static fn (mixed $value): bool => is_string($value) && $value !== ''
        ));

        return $countryCodes === [] ? null : implode(',', $countryCodes);
    }

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

    /**
     * @template T of object
     *
     * @param array<mixed> $items
     * @param class-string<T> $expectedClass
     * @param string $owner
     * @param string $field
     *
     * @return list<T>
     */
    protected static function validateList(array $items, string $expectedClass, string $owner, string $field): array
    {
        foreach ($items as $index => $item) {
            if (!$item instanceof $expectedClass) {
                throw new InvalidArgumentException(sprintf(
                    '%s expects %s to contain only %s instances, %s given at index %d.',
                    $owner,
                    $field,
                    $expectedClass,
                    get_debug_type($item),
                    $index
                ));
            }
        }

        return array_values($items);
    }
}
