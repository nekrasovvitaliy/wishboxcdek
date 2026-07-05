<?php

declare(strict_types=1);

namespace WishboxCdek\Response\Calculator;

use WishboxCdek\Response\Error\ErrorDto2;
use WishboxCdek\Response\Error\WarningDto;

final readonly class CalculatorTariffListResponseDto
{
    /**
     * @param list<TariffCodeDto> $tariffCodes
     * @param list<ErrorDto2> $errors
     * @param list<WarningDto> $warnings
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
                static fn (array $item): ErrorDto2 => ErrorDto2::fromArray($item),
                array_values(array_filter(
                    $data['errors'] ?? [],
                    static fn (mixed $item): bool => is_array($item),
                )),
            ),
            warnings: array_map(
                static fn (array $item): WarningDto => WarningDto::fromArray($item),
                array_values(array_filter(
                    $data['warnings'] ?? [],
                    static fn (mixed $item): bool => is_array($item),
                )),
            ),
        );
    }
}
