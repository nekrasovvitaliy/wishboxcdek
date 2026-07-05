<?php

declare(strict_types=1);

namespace WishboxCdek\Response\Order;

final readonly class PackageResponseDto
{
    /**
     * @param list<ItemResponseDto> $items
     * @param list<PackageAddServiceResponseDto> $services
     */
    public function __construct(
        public ?string $number = null,
        public ?string $barcode = null,
        public ?int $weight = null,
        public ?int $length = null,
        public ?int $width = null,
        public int|float|null $weightVolume = null,
        public int|float|null $weightCalc = null,
        public ?int $height = null,
        public ?string $comment = null,
        public array $items = [],
        public array $services = [],
        public ?string $packageId = null,
    ) {
    }

    public static function fromArray(array $data): self
    {
        $items = [];
        if (isset($data['items']) && is_array($data['items'])) {
            foreach ($data['items'] as $item) {
                if (is_array($item)) {
                    $items[] = ItemResponseDto::fromArray($item);
                }
            }
        }

        $services = [];
        if (isset($data['services']) && is_array($data['services'])) {
            foreach ($data['services'] as $service) {
                if (is_array($service)) {
                    $services[] = PackageAddServiceResponseDto::fromArray($service);
                }
            }
        }

        return new self(
            number: isset($data['number']) ? (string) $data['number'] : null,
            barcode: isset($data['barcode']) ? (string) $data['barcode'] : null,
            weight: isset($data['weight']) ? (int) $data['weight'] : null,
            length: isset($data['length']) ? (int) $data['length'] : null,
            width: isset($data['width']) ? (int) $data['width'] : null,
            weightVolume: isset($data['weight_volume']) ? (is_int($data['weight_volume']) ? $data['weight_volume'] : (float) $data['weight_volume']) : null,
            weightCalc: isset($data['weight_calc']) ? (is_int($data['weight_calc']) ? $data['weight_calc'] : (float) $data['weight_calc']) : null,
            height: isset($data['height']) ? (int) $data['height'] : null,
            comment: isset($data['comment']) ? (string) $data['comment'] : null,
            items: $items,
            services: $services,
            packageId: isset($data['package_id']) ? (string) $data['package_id'] : null,
        );
    }
}
