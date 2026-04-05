<?php

declare(strict_types=1);

namespace WishboxCdek\Response\Passport;

final readonly class PassportOrderDto
{
    /**
     * @param list<PassportStatusDto> $passport
     */
    public function __construct(
        public ?string $orderUuid = null,
        public ?string $cdekNumber = null,
        public array $passport = [],
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            orderUuid: isset($data['order_uuid']) ? (string) $data['order_uuid'] : null,
            cdekNumber: isset($data['cdek_number']) ? (string) $data['cdek_number'] : null,
            passport: array_map(
                static fn (array $item): PassportStatusDto => PassportStatusDto::fromArray($item),
                array_values(array_filter(
                    $data['passport'] ?? [],
                    static fn (mixed $item): bool => is_array($item),
                )),
            ),
        );
    }
}
