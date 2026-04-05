<?php

declare(strict_types=1);

namespace WishboxCdek\Response\Order;

final readonly class OrderIntakePackageDto
{
    public function __construct(
        public ?string $packageId = null,
        public ?int $weight = null,
        public ?int $length = null,
        public ?int $width = null,
        public ?int $height = null,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            packageId: isset($data['package_id']) ? (string) $data['package_id'] : null,
            weight: isset($data['weight']) ? (int) $data['weight'] : null,
            length: isset($data['length']) ? (int) $data['length'] : null,
            width: isset($data['width']) ? (int) $data['width'] : null,
            height: isset($data['height']) ? (int) $data['height'] : null,
        );
    }
}

