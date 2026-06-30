<?php

declare(strict_types=1);

namespace WishboxCdek\Response\DeliveryPoint;

use ArrayIterator;
use ArrayAccess;
use BadMethodCallException;
use Countable;
use IteratorAggregate;
use Traversable;
use WishboxCdek\Response\CdekResponse;

/**
 * @implements IteratorAggregate<int, OfficeDto>
 * @implements ArrayAccess<int, OfficeDto>
 */
final readonly class DeliveryPointListResponse implements ArrayAccess, Countable, IteratorAggregate
{
    /**
     * @param list<OfficeDto> $items
     */
    public function __construct(
        public array $items = [],
        public ?int $currentPage = null,
        public ?int $pageSize = null,
        public ?int $totalElements = null,
        public ?int $totalPages = null,
    ) {
    }

    public static function fromCdekResponse(CdekResponse $response): self
    {
        return new self(
            items: array_map(
                static fn (array $deliveryPoint): OfficeDto => OfficeDto::fromArray($deliveryPoint),
                $response->data,
            ),
            currentPage: self::nullableInt($response->getHeaderLine('X-Current-Page')),
            pageSize: self::nullableInt($response->getHeaderLine('X-Page-Size')),
            totalElements: self::nullableInt($response->getHeaderLine('X-Total-Elements')),
            totalPages: self::nullableInt($response->getHeaderLine('X-Total-Pages')),
        );
    }

    public function count(): int
    {
        return count($this->items);
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->items);
    }

    public function offsetExists(mixed $offset): bool
    {
        return isset($this->items[$offset]);
    }

    public function offsetGet(mixed $offset): OfficeDto
    {
        return $this->items[$offset];
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        throw new BadMethodCallException(self::class . ' is readonly.');
    }

    public function offsetUnset(mixed $offset): void
    {
        throw new BadMethodCallException(self::class . ' is readonly.');
    }

    private static function nullableInt(string $value): ?int
    {
        return $value === '' ? null : (int) $value;
    }
}
