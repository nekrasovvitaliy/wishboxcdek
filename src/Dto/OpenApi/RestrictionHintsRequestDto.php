<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: RestrictionHintsRequestDto
 *
 * Запрос на проверку ограничений по международным заказам
 */
final readonly class RestrictionHintsRequestDto
{
    public mixed $tariffCode;

    public mixed $fromLocation;

    public mixed $toLocation;

    /**
     * @var array<int|string, mixed> of RestrictionPackageRequestDto
     */
    public array $packages;

    public function __construct(
        mixed $tariffCode = null,
        mixed $fromLocation = null,
        mixed $toLocation = null,
        array $packages = [],
    ) {
        $this->tariffCode = $tariffCode;
        $this->fromLocation = $fromLocation;
        $this->toLocation = $toLocation;
        $this->packages = $packages;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            tariffCode: $data['tariff_code'] ?? null,
            fromLocation: $data['from_location'] ?? null,
            toLocation: $data['to_location'] ?? null,
            packages: isset($data['packages']) && is_array($data['packages']) ? $data['packages'] : [],
        );
    }
}
