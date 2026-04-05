<?php

declare(strict_types=1);

namespace WishboxCdek\Response\International;

use WishboxCdek\Response\Error\CdekMessage;

final readonly class PackageRestrictionsResponse
{
    /**
     * @param list<RestrictionPackageDto> $packages
     * @param list<CdekMessage> $errors
     * @param list<CdekMessage> $warnings
     */
    public function __construct(
        public array $packages = [],
        public array $errors = [],
        public array $warnings = [],
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            packages: array_map(
                static fn (array $item): RestrictionPackageDto => RestrictionPackageDto::fromArray($item),
                array_values(array_filter(
                    $data['packages'] ?? [],
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
