<?php

declare(strict_types=1);

namespace WishboxCdek\Response\Prealert;

final readonly class PrealertPackageDto
{
    public function __construct(
        public ?string $packageId = null,
        public ?string $number = null,
        public ?string $status = null,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            packageId: isset($data['package_id']) ? (string) $data['package_id'] : null,
            number: isset($data['number']) ? (string) $data['number'] : null,
            status: isset($data['status']) ? (string) $data['status'] : null,
        );
    }
}