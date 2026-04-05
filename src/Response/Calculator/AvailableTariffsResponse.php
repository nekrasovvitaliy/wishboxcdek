<?php

declare(strict_types=1);

namespace WishboxCdek\Response\Calculator;

final readonly class AvailableTariffsResponse
{
    /**
     * @param list<AvailableTariffCodeDto> $tariffCodes
     */
    public function __construct(public array $tariffCodes)
    {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            tariffCodes: array_map(
                static fn (array $item): AvailableTariffCodeDto => AvailableTariffCodeDto::fromArray($item),
                array_values(array_filter(
                    $data['tariff_codes'] ?? [],
                    static fn (mixed $item): bool => is_array($item),
                )),
            ),
        );
    }
}
