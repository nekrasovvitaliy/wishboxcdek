<?php

declare(strict_types=1);

namespace WishboxCdek\Response\Calculator;

use WishboxCdek\Response\Error\CdekMessage;

final readonly class CalculateTariffListResponse
{
    /**
     * @param list<TariffCodeDto> $tariffCodes
     * @param list<CdekMessage> $errors
     * @param list<CdekMessage> $warnings
     */
    public function __construct(
        public array $tariffCodes,
        public array $errors,
        public array $warnings,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            tariffCodes: array_map(
                static fn (array $item): TariffCodeDto => TariffCodeDto::fromArray($item),
                array_values(array_filter(
                    $data['tariff_codes'] ?? [],
                    static fn (mixed $item): bool => is_array($item),
                )),
            ),
            errors: array_map(
                static fn (array $item): CdekMessage => CdekMessage::fromArray($item),
                array_values(array_filter(
                    $data['errors'] ?? [],
                    static fn (mixed $item): bool => is_array($item),
                )),
            ),
            warnings: array_map(
                static fn (array $item): CdekMessage => CdekMessage::fromArray($item),
                array_values(array_filter(
                    $data['warnings'] ?? [],
                    static fn (mixed $item): bool => is_array($item),
                )),
            ),
        );
    }
}

